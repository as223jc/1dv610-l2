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
    private static $newPassword1 = 'LoginView::newPassword1';
    private static $newPassword2 = 'LoginView::newPassword2';
    private static $registerButton = 'LoginView::RegisterButton';
    private static $register = 'LoginView::Register';


    /**
     * Create HTTP response
     *
     * Should be called after a login attempt has been determined
     *
     * @param $tMessage
     * @param $isLoggedIn
     * @param $bRegister
     * @return  String
     */
	public function response($tMessage, $isLoggedIn, $bRegister) {
        $response = '';
	    if (!$isLoggedIn) {
            $response = $bRegister ? $this->generateRegisterFormHTML($tMessage) :
                $this->generateLoginFormHTML($tMessage);

            $response .= !$bRegister ? $this->generateRegisterButtonHTML() : '';
        }
		$response .= $isLoggedIn ? $this->generateLogoutButtonHTML($tMessage) : '';

		return $response;
	}

	/**
	* Generate HTML code on the output buffer for the logout button
	* @param $message, String output message
	* @return  String
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
	* @return  String
	*/
	private function generateRegisterButtonHTML() {
		return '
			<form  method="post" >
				<button name="' . self::$registerButton . '" value="true">register</button>
			</form>
		';
	}

	/**
	* Generate HTML code on the output buffer for the logout button
	* @param $message, String output message
	* @return  String
	*/
	private function generateLoginFormHTML($message) {
		return '
			<form method="post" > 
				<fieldset>
					<legend>Login - enter Username and password</legend>
					<p id="' . self::$messageId . '">' . $message . '</p>
					
					<label for="' . self::$name . '">Username :</label>
					<input type="text" id="' . self::$name . '" name="' . self::$name . '" value="" />

					<label for="' . self::$password . '">Password :</label>
					<input type="password" id="' . self::$password . '" name="' . self::$password . '" />

					<label for="' . self::$keep . '">Keep me logged in  :</label>
					<input type="checkbox" id="' . self::$keep . '" name="' . self::$keep . '" />
					
					<input type="submit" name="' . self::$login . '" value="login" />
				</fieldset>
			</form>
		';
	}

	/**
	* Generate HTML code on the output buffer for the register form
     * @param $message, String output message
     * @return  String
	*/
	private function generateRegisterFormHTML($message) {
		return '
			<form method="post" > 
				<fieldset>
					<legend>Register - enter a username and a password</legend>
					<p id="' . self::$messageId . '">' . $message . '</p>
					
					<label for="' . self::$name . '">Username :</label>
					<input type="text" id="' . self::$name . '" name="' . self::$name . '" value="" />

					<label for="' . self::$newPassword1 . '">Password :</label>
					<input type="password" id="' . self::$newPassword1 . '" name="' . self::$newPassword1 . '" />

					<label for="' . self::$newPassword2 . '">Repeat password :</label>
					<input type="password" id="' . self::$newPassword2 . '" name="' . self::$newPassword2 . '" />

					<input type="submit" name="' . self::$register . '" value="register" />
				</fieldset>
			</form>
		';
	}

	//CREATE GET-FUNCTIONS TO FETCH REQUEST VARIABLES
	private function getRequestUserName() {
		//RETURN REQUEST VARIABLE: USERNAME
	}

}
