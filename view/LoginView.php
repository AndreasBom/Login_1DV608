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

	/**
	 * @return string
	 * @throws Exception if value of cookie returns null
	 */
	public function getSavedUsername()
	{
		if($this->cookieStorage->load(self::$cookieName) == null)
		{
			throw new \Exception("No cookie with that name");
		}

		return $this->cookieStorage->load(self::$cookieName);
	}

	/**
	 * @return string
	 * @throws Exception if value of cookie returns null
	 */
	public function getSavedPasswordString()
	{
		if($this->cookieStorage->load(self::$cookiePassword) == null)
		{
			throw new \Exception("No cookie with that name");
		}

		return $this->cookieStorage->load(self::$cookiePassword);
	}


	/**
	 * @return bool
	 */
	public function rememberMe()
	{
		//$this->cookieStorage->save(self::$keep, true);
		return isset($_POST[self::$keep]);
	}


	public function loginWithSavedCredentials()
	{
		try
		{
			if($this->cookieStorage->load(self::$cookieName) && $this->cookieStorage->load(self::$cookiePassword))
			{
				return true;
			}
			return false;
		}
		catch (\exception\InvalidCookieException $ex)
		{
			return $ex;
		}


	}

	public function getUserIp()
	{
		if($_SERVER['REMOTE_ADDR'] === null || $_SERVER['REMOTE_ADDR'] === "")
		{
			throw new exception\ReturningNullException("Ip address is null or empty");
		}

		return $_SERVER['REMOTE_ADDR'];
	}

	public function getUserBrowser()
	{
		if($_SERVER['HTTP_USER_AGENT'] === null || $_SERVER['HTTP_USER_AGENT'] === "")
		{
			throw new \exception\ReturningNullException("BrowserInformation is null or empty");
		}

		return $_SERVER['HTTP_USER_AGENT'];
	}


	public function saveCredentials($username, $passwordString)
	{
		//save username
		$this->cookieStorage->save(self::$cookieName, $username);
		//save password string
		$this->cookieStorage->save(self::$cookiePassword, $passwordString);
	}

	public function deleteCredentials()
	{
		$this->cookieStorage->loadAndRemove(self::$cookieName);
		$this->cookieStorage->loadAndRemove(self::$cookiePassword);
		//$this->cookieStorage->loadAndRemove(self::$keep);
	}

	public function errorHandling()
	{

	}

	/**
	 * @param $loggedIn
	 */
	public function showMessage($loggedIn)
	{
		if($loggedIn)
		{
			if($this->rememberMe())
			{
				$message = "Welcome and you will be remembered";
			}
			/*try
			{
				$this->loginWithSavedCredentials();

			}
			catch (\exception\InvalidCookieException $ex)
			{
				$message = "Wrong information in cookies";
			}*/
			elseif($this->loginWithSavedCredentials())
			{
				$message = $this->loginWithSavedCredentials();
			}
			else
			{
				$message = "Welcome";
			}

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