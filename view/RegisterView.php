<?php
/**
 * Created by PhpStorm.
 * User: Andreas
 * Date: 2015-09-30
 * Time: 20:40
 */

namespace view;
require_once('IView.php');



class RegisterView implements IView
{

    private static $messageId = "RegisterView::Message";
    private static $name = "RegisterView::UserName";
    private static $password = "RegisterView::Password";
    private static $repeatPassword = "RegisterView::PasswordRepeat";
    private static $register = "RegisterView::RegisterUser";
    private static $SessionUserName = "RegisterView::SessionUsername";

    private $message;
    private $SessionUsername;


    public function didUserTryToRegister()
    {
        return isset($_POST[self::$register]);
    }

    public function getUsername()
    {
        if(isset($_POST[self::$name]))
        {
            $_SESSION[self::$SessionUserName] = $_POST[self::$name];

            return $_POST[self::$name];
        }
        return null;
    }

    public function getPassword()
    {
        if(isset($_POST[self::$password]))
        {
            return $_POST[self::$password];
        }
        return null;

    }

    public function getRepeatPassword()
    {
        if(isset($_POST[self::$repeatPassword]))
        {
            return $_POST[self::$repeatPassword];
        }
        return null;

    }

    public function message($string)
    {

        $this->message = $string;
    }


    public function response()
    {
        $message = $this->message;

        $response = $this->generateRegistrationFormHTML($message);

        return $response;
    }

    private function generateRegistrationFormHTML($message) {
        return '
            <h2>Register new user</h2>
			<form method="post" class="form">
				<fieldset>
					<legend>Register a new user - Write Username and password</legend>
					<p id="' . self::$messageId . '">' . $message . '</p>

					<label for="' . self::$name . '">Username :</label>
					<input type="text" class="input" id="' . self::$name . '" name="' . self::$name . '" value="'. $this->getRequestUserName() .'"  />

					<label for="' . self::$password . '">Password :</label>
					<input type="password" class="input" id="' . self::$password . '" name="' . self::$password . '" />

					<label for="' . self::$repeatPassword . '">Repeat password :</label>
					<input type="password" class="input" id="' . self::$repeatPassword . '" name="' . self::$repeatPassword . '" />

					<input type="submit" class="btn" name="' . self::$register . '" value="Register" />
				</fieldset>
			</form>
		';
    }

    private function getRequestUserName() {
        //RETURN REQUEST VARIABLE: USERNAME
        if(isset($_SESSION[self::$SessionUserName])){
            return strip_tags($_SESSION[self::$SessionUserName]);
        }
        return '';
    }


}