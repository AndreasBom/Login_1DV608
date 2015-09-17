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


<<<<<<< HEAD
	private $loginModel;
	private $cookieStorage;



	public function __construct(\model\LoginModel $model)
	{
		$this->loginModel = $model;
		$this->cookieStorage = new \view\CookieStorage();
	}

	/**
	 * @return bool
	 */
	public function didUserTryToLoggin()
	{
		return isset($_POST[self::$login]);
	}

	/**
	 * @return bool
	 */
	public function didUserLogout()
	{
		return isset($_POST[self::$logout]);
	}

	/**
	 * @return string
	 */
	public function getUsername()
	{
		if(isset($_POST[self::$name]))
		{
			return trim($_POST[self::$name]);
		}

		return "";
	}

	/**
	 * @return string
	 */
	public function getPassword()
	{
		if(isset($_POST[self::$password]))
		{
			return $_POST[self::$password];
		}

		return "";
	}


	/**
	 * @param $loggedIn
	 */
	public function showMessage($loggedIn)
	{
		if($loggedIn){
			$message = "Welcome";
		}
		else if($this->didUserLogout())
		{
			$message = "Bye bye!";
		}
		else
		{
			if($this->getUsername() == "")
			{
				$message = "Username is missing";
			}
			else if($this->getPassword() == "")
			{
				$message = "Password is missing";
			}
			else
			{
				$message = "Wrong name or password";
			}
		}

		$this->cookieStorage->save(self::$messageId, $message);
	}



=======
>>>>>>> origin/master

	/**
	 * Create HTTP response
	 *
	 * Should be called after a login attempt has been determined
	 *
<<<<<<< HEAD
	 * @return  string BUT writes to standard output and cookies!
	 */
	public function response() {

		$message = '';

<<<<<<< HEAD
		if($this->preventDoublePosts() == false)
		{
			$message = $this->cookieStorage->loadAndRemove(self::$messageId);
=======

		//Checks if user has pressed the loginButton and a POST is preformed
		if(isset($_POST[self::$login])) {

			//Correct username and password
			if ($this->loginModel->correctLoginCredidentials($_POST[self::$name], $_POST[self::$password])) {
				$message = "<p>Welcome</p>";
				$this->cookie->save(self::$cookieName);
			}
			//Validates that no field is empty
			else {
				if($this->validate->RequiredFieldValidator($_POST[self::$name]) == false){
					$message = "<p>Username is missing</p>";
				}else if($this->validate->RequiredFieldValidator($_POST[self::$password]) == false){
					$message = "<p>Password is missing</p>";
				}
				//Incorrect username or password
				else{
					$message = "<p>Wrong name or password</p>";
				}
			}
>>>>>>> Branch2
		}

		//Show login or logout form
		if($this->loginModel->isUserLoggedIn() == false)
		{
			$response = $this->generateLoginFormHTML($message);
		}
		else
		{
			$response = $this->generateLogoutButtonHTML($message);
		}


		return $response;
=======
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
>>>>>>> origin/master
	}

	/**
	* Generate HTML code on the output buffer for the logout button
	* @param $message, String output message
<<<<<<< HEAD
	* @return  string, BUT writes to standard output!
=======
	* @return  String, BUT writes to standard output!
>>>>>>> origin/master
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
<<<<<<< HEAD
	* @return  string, BUT writes to standard output!
=======
	* @return  String, BUT writes to standard output!
>>>>>>> origin/master
	*/
	private function generateLoginFormHTML($message)
	{
		return '
			<form method="post" > 
				<fieldset>
					<legend>Login - enter Username and password</legend>
					<p id="' . self::$messageId . '">' . $message . '</p>
					
					<label for="' . self::$name . '">Username :</label>
<<<<<<< HEAD
					<input type="text" id="' . self::$name . '" name="' . self::$name . '" value="'. $this->getRequestUserName() .'" />
=======
					<input type="text" id="' . self::$name . '" name="' . self::$name . '" value="' . $this->getRequestUserName() . '" />
>>>>>>> origin/master

					<label for="' . self::$password . '">Password :</label>
					<input type="password" id="' . self::$password . '" name="' . self::$password . '" />

					<label for="' . self::$keep . '">Keep me logged in  :</label>
					<input type="checkbox" id="' . self::$keep . '" name="' . self::$keep . '" />
					
					<input type="submit" name="' . self::$login . '" value="login" />
				</fieldset>
			</form>
		';

	}

<<<<<<< HEAD
	private function preventDoublePosts()
	{
		if($_POST)
		{
			header("Location: " . $_SERVER["PHP_SELF"]);
			true;
		}

		return false;
	}
	
	//CREATE GET-FUNCTIONS TO FETCH REQUEST VARIABLES
	private function getRequestUserName() {
		//RETURN REQUEST VARIABLE: USERNAME

		return $this->loginModel->getUsernameInSession();
=======
	//CREATE GET-FUNCTIONS TO FETCH REQUEST VARIABLES
	private function getRequestUserName()
	{
		/*if(isset($_POST[self::$name]))
		{
			return ($_POST[self::$name]);
		}
		return "";*/

		return $this->cookieStorage->load(self::$cookieName);
>>>>>>> origin/master
	}
	
}