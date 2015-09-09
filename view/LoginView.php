<?php

namespace view;

use model\LoginModel;
use model\Validation;

require_once("./model/LoginModel.php");
require_once("./model/Validation.php");
require_once("CookieStorage.php");


class LoginView {
	private static $login = 'LoginView::Login';
	private static $logout = 'LoginView::Logout';
	private static $name = 'LoginView::UserName';
	private static $password = 'LoginView::Password';
	private static $cookieName = 'LoginView::CookieName';
	private static $cookiePassword = 'LoginView::CookiePassword';
	private static $keep = 'LoginView::KeepMeLoggedIn';
	private static $messageId = 'LoginView::Message';
	private static $cookieMessage = 'Login::ViewCookieMessage';

	private $loginModel;
	private $validate;
	private $cookieStorage;

	private $loginMessage = "";

	public function __construct(LoginModel $loginModel)
	{
		$this->loginModel = $loginModel;
		$this->validate = new Validation();
		$this->cookieStorage = new CookieStorage();
	}

	public function didUserTryToLogin()
	{
		return isset($_POST[self::$login]);
	}

	public function didUserTryToLogout()
	{
		return isset($_POST[self::$logout]);
	}

	public function getUsername()
	{
		if($this->didUserTryToLogin()){
			return $_POST[self::$name];
		}
		return "";
	}

	public function getPassword()
	{
		if($this->didUserTryToLogin())
		{
			return $_POST[self::$password];
		}
		return "";

	}

	public function showLoginMessage($loggedIn)
	{
		if($loggedIn){
			$this->loginMessage = "Welcome";
		}
		else if($this->didUserTryToLogout())
		{
			$this->loginMessage = "Bye bye!";
		}
		else
		{
			if($this->getUsername() == "")
			{
				$this->loginMessage = "Username is missing";
			}
			else if($this->getPassword() == "")
			{
				$this->loginMessage = "Password is missing";
			}
			else
			{
				$this->loginMessage = "Wrong name or password";
			}

		}
		$this->cookieStorage->save(self::$cookieMessage, $this->loginMessage);
	}



	/**
	 * Create HTTP response
	 *
	 * Should be called after a login attempt has been determined
	 *
	 * @return String  BUT writes to standard output and cookies!
	 */
	public function response()
	{
		$message = '';

		if($this->didUserTryToLogin() || $this->didUserTryToLogout() )
		{
			$this->cookieStorage->save(self::$cookieName, $_POST[self::$name]);
			header('Location: ' . $_SERVER["PHP_SELF"]);
		}
		$message = $this->cookieStorage->load(self::$cookieMessage);

		if($this->loginModel->isUserLoggedIn())
		{
			return $this->generateLogoutButtonHTML($message);
		}
		return  $this->generateLoginFormHTML($message);
	}

	/**
	* Generate HTML code on the output buffer for the logout button
	* @param $message, String output message
	* @return  String, BUT writes to standard output!
	*/
	private function generateLogoutButtonHTML($message)
	{
		return '
			<form  method="post" >
				<p id="' . self::$messageId . '">' . $message .'</p>
				<input type="submit" name="' . self::$logout . '" value="logout"/>
			</form>
		';
	}
	
	/**
	* Generate HTML code on the output buffer for the logout button
	* @param $message, String output message
	* @return  String, BUT writes to standard output!
	*/
	private function generateLoginFormHTML($message)
	{
		return '
			<form method="post" > 
				<fieldset>
					<legend>Login - enter Username and password</legend>
					<p id="' . self::$messageId . '">' . $message . '</p>
					
					<label for="' . self::$name . '">Username :</label>
					<input type="text" id="' . self::$name . '" name="' . self::$name . '" value="' . $this->getRequestUserName() . '" />

					<label for="' . self::$password . '">Password :</label>
					<input type="password" id="' . self::$password . '" name="' . self::$password . '" />

					<label for="' . self::$keep . '">Keep me logged in  :</label>
					<input type="checkbox" id="' . self::$keep . '" name="' . self::$keep . '" />
					
					<input type="submit" name="' . self::$login . '" value="login" />
				</fieldset>
			</form>
		';

	}

	//CREATE GET-FUNCTIONS TO FETCH REQUEST VARIABLES
	private function getRequestUserName()
	{
		if(isset($_POST[self::$name]))
		{
			return ($_POST[self::$name]);
		}
		return "";

	}
	
}