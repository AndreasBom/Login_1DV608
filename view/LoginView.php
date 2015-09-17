<?php

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


	public function autoLogin()
	{
		if($this->cookieStorage->load(self::$cookieName) && $this->cookieStorage->load(self::$cookiePassword))
		{
			return true;
		}

		return false;
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




	/**
	 * Create HTTP response
	 *
	 * Should be called after a login attempt has been determined
	 *
	 * @return  string BUT writes to standard output and cookies!
	 */
	public function response() {

		$message = '';

		if($this->preventDoublePosts() == false)
		{
			$message = $this->cookieStorage->loadAndRemove(self::$messageId);
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
	}

	/**
	* Generate HTML code on the output buffer for the logout button
	* @param $message, String output message
	* @return  string, BUT writes to standard output!
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
	* @return  string, BUT writes to standard output!
	*/
	private function generateLoginFormHTML($message) {
		return '
			<form method="post" > 
				<fieldset>
					<legend>Login - enter Username and password</legend>
					<p id="' . self::$messageId . '">' . $message . '</p>
					
					<label for="' . self::$name . '">Username :</label>
					<input type="text" id="' . self::$name . '" name="' . self::$name . '" value="'. $this->getRequestUserName() .'" />

					<label for="' . self::$password . '">Password :</label>
					<input type="password" id="' . self::$password . '" name="' . self::$password . '" />

					<label for="' . self::$keep . '">Keep me logged in  :</label>
					<input type="checkbox" id="' . self::$keep . '" name="' . self::$keep . '" />
					
					<input type="submit" name="' . self::$login . '" value="login" />
				</fieldset>
			</form>
		';
	}

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
	}
	
}