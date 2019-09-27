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
    private static $registerButton = 'LoginView::RegisterButton';


    /**
     * Create HTTP response
     *
     * Should be called after a login attempt has been determined
     *
     * @param $tMessage
     * @param $isLoggedIn
     * @return  String
     */
    public function response($tMessage, $isLoggedIn) {
        return !$isLoggedIn
            ? $this->generateLoginFormHTML($tMessage) . $this->generateRegisterButtonHTML()
            : $this->generateLogoutButtonHTML($tMessage);
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
				<button name="' . self::$registerButton . '" value="true">Register a new user</button>
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

    private function getRequestUserName() {
        return $_POST['LoginView::UserName'] ?? '';
    }

}
