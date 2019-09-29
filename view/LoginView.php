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


    /**
     * Create HTTP response
     *
     * Should be called after a login attempt has been determined
     *
     * @param $tMessage
     * @param $isLoggedIn
     * @return  String
     */
//    public function response($tMessage, $isLoggedIn): string {
//        return !$isLoggedIn
//            ? $this->generateLoginFormHTML($tMessage) . $this->generateRegisterButtonHTML()
//            : $this->generateLogoutButtonHTML($tMessage);
//    }

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
			<a href="register">Register a new user</a>
		';
    }

    /**
     * Generate HTML code on the output buffer for the logout button
     * @param $message, String output message
     * @return  String
     */
    private function generateLoginFormHTML($message): string {
        return '
			<form method="post" action="login" > 
				<fieldset>
					<legend>Login - enter Username and password</legend>
					<p id="' . self::$messageId . '">' . $message . '</p>
					
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
		';
    }

    private function getRequestUserName(): string {
        return strip_tags($_POST['LoginView::UserName'] ?? $_COOKIE[self::$cookieName] ?? '');
    }

    private function getRequestPassword(): string {
        return strip_tags($_POST['LoginView::Password'] ?? $_COOKIE[self::$cookieName] ?? '');
    }

    protected function view() {
        return $this->generateLoginFormHTML('') . $this->generateRegisterButtonHTML();
//
//        return '
//			<form method="post" action="login" >
//				<fieldset>
//					<legend>Login - enter Username and password</legend>
//					<p id="' . self::$messageId . '">' . $message . '</p>
//
//					<label for="' . self::$name . '">Username :</label>
//					<input type="text" id="' . self::$name . '" name="' . self::$name . '" value="' . $this->getRequestUserName() . '" />
//
//					<label for="' . self::$password . '">Password :</label>
//					<input type="password" id="' . self::$password . '" name="' . self::$password . '" />
//
//					<label for="' . self::$keep . '">Keep me logged in  :</label>
//					<input type="checkbox" id="' . self::$keep . '" name="' . self::$keep . '" />
//
//					<input type="submit" name="' . self::$login . '" value="login" />
//				</fieldset>
//			</form>
//		';
//
//       return '
//        ' . $this->renderIsLoggedIn($bIsLoggedIn) . '
//
//          <div class="container">
//              ' . $v->response($tMessage, 0) . '
//
//              ' . $this->dtv->show() . '
//          </div>';
    }

    private function renderIsLoggedIn($isLoggedIn) {
        if ($isLoggedIn) {
            return '<h2>Logged in</h2>';
        }
        else {
            return '<h2>Not logged in</h2>';
        }
    }
}
