<?php

namespace startup\view;

class LoginView extends LayoutView {
    private static $login = 'LoginView::Login';
    private static $logout = 'LoginView::Logout';
    private static $name = 'LoginView::UserName';
    private static $password = 'LoginView::Password';
    private static $cookieName = 'LoginView::CookieName';
    private static $cookiePassword = 'LoginView::CookiePassword';
    private static $keep = 'LoginView::KeepMeLoggedIn';
    private static $messageId = 'LoginView::Message';
    private static $registerButton = 'LoginView::RegisterButton';
    private static $logoutMessage = 'LoginView::LogoutMessage';
    private static $loginErrorMessageId = 'LoginView::LoginErrorMessageId';
    private static $welcomeMessage = 'LoginView::WelcomeMessage';

    protected function view() {
        return '
            <div>
              ' .
            flash(RegisterView::getRegisterMessageId()) .
            flash(self::getLogoutMessageId()) .
            flash(self::getLoginErrorMessageId())
            . '
            </div>
			<form method="post" action="login" > 
			<h2>Not logged in</h2>
				<fieldset>
					<legend>Login - enter Username and password</legend>
					<div>
                        <label for="' . self::$name . '">Username :</label>
                        <input type="text" id="' . self::$name . '" name="' . self::$name . '" value="' . $this->getRequestUserName() . '" />
                        <span>' . flash('username') . '</span>
                    </div>
                    
                    <div>
                        <label for="' . self::$password . '">Password :</label>
                        <input type="password" id="' . self::$password . '" name="' . self::$password . '" />
                        <span>' . flash('password') . '</span>
                    </div>

					<label for="' . self::$keep . '">Keep me logged in  :</label>
					<input type="checkbox" id="' . self::$keep . '" name="' . self::$keep . '" />
					
					<input type="submit" name="' . self::$login . '" value="login" />
				</fieldset>
			</form>
            <a href="register">Register a new user</a>
		';
    }

    public function getNameId(): string {
        return self::$name;
    }

    public function getPasswordId(): string {
        return self::$password;
    }

    public function getRememberMeId(): string {
        return self::$keep;
    }

    public static function getCookieNameId(): string {
        return self::$cookieName;
    }

    public static function getCookiePasswordId(): string {
        return self::$cookiePassword;
    }

    public static function getLoginErrorMessageId(): string {
        return self::$loginErrorMessageId;
    }

    public static function getWelcomeMessageId() {
        return self::$welcomeMessage;
    }

    private function getRequestUserName(): string {
        return strip_tags($_POST['LoginView::UserName'] ?? $_COOKIE[self::$cookieName] ?? '');
    }

    private function getRequestPassword(): string {
        return strip_tags($_POST['LoginView::Password'] ?? $_COOKIE[self::$cookieName] ?? '');
    }

    public static function getLogoutMessageId() {
        return self::$logoutMessage;
    }
}
