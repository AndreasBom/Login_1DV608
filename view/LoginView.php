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

	private $loginModel;
	private $validate;
	private $cookie;

	public function __construct(LoginModel $loginModel)
	{
		$this->loginModel = $loginModel;
		$this->validate = new Validation();
		$this->cookie = new CookieStorage();
	}


	/**
	 * Create HTTP response
	 *
	 * Should be called after a login attempt has been determined
	 *
	 * @return  void BUT writes to standard output and cookies!
	 */
	public function response() {
		$message = '';



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
		}

		if($this->loginModel->userIsLoggedIn == false){
			$response = $this->generateLoginFormHTML($message);

		}else{
			$response = $this->generateLogoutButtonHTML($message);
		}

		//
		return $response;
	}

	/**
	* Generate HTML code on the output buffer for the logout button
	* @param $message, String output message
	* @return  void, BUT writes to standard output!
	*/
	private function generateLogoutButtonHTML($message) {
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
	* @return  void, BUT writes to standard output!
	*/
	private function generateLoginFormHTML($message) {
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
	private function getRequestUserName() {
		if(isset($_POST[self::$name])){
			return ($_POST[self::$name]);
		}
		return "";

	}
	
}