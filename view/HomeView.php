<?php

namespace startup\view;

class HomeView extends LayoutView {
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
     * Generate HTML code on the output buffer for the logout button
     * @param $message, String output message
     * @return  String
     */
    private function generateLogoutButtonHTML($message): string {
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
    private function generateRegisterButtonHTML(): string {
        return '
			<a href="?register">Register a new user</a>
		';
    }

    /**
     * Generate HTML code on the output buffer for the logout button
     * @param $message, String output message
     * @return  String
     */
    private function generateLoginFormHTML($message): string {
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

    private function getRequestUserName(): string {
        return strip_tags($_POST['LoginView::UserName'] ?? $_COOKIE[self::$cookieName] ?? '');
    }

    private function getRequestPassword(): string {
        return strip_tags($_POST['LoginView::Password'] ?? $_COOKIE[self::$cookieName] ?? '');
    }

    protected function view() {
        return '
            <div>
              <h3>Welcome user!</h3>
			<form  method="post" action="logout">
				<p id="' . self::$messageId . '">' . '$message' .'</p>
				<input type="submit" name="' . self::$logout . '" value="logout"/>
			</form>
            </div>
        ';
    }
}
