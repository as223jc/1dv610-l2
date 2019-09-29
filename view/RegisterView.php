<?php

namespace startup\view;

class RegisterView extends LayoutView {
    private static $name = 'RegisterView::UserName';
    private static $newPassword1 = 'RegisterView::Password';
    private static $newPassword2 = 'RegisterView::PasswordRepeat';
    private static $register = 'RegisterView::Register';
    private static $messageId = 'RegisterView::Message';


    /**
     * Create HTTP response
     *
     * Should be called after a login attempt has been determined
     *
     * @param $tMessage
     * @return  String
     */
	public function response($tMessage): string {
        return $this->generateRegisterFormHTML($tMessage)
            . $this->generateBackToLoginButtonHTML($tMessage);
	}

	/**
	* Generate HTML code on the output buffer for the logout button
	* @param $message, String output message
	* @return  String
	*/
	private function generateBackToLoginButtonHTML($message): string {
		return '<a href=".">Back to login</a>';
	}

	/**
	* Generate HTML code on the output buffer for the register form
     * @param $message, String output message
     * @return  String
	*/
	private function generateRegisterFormHTML($message): string {
		return '
			<form method="post" > 
				<fieldset>
					<legend>Register - enter a username and a password</legend>
					<p id="' . self::$messageId . '">' . $message . '</p>
					
					<label for="' . self::$name . '">Username :</label>
					<input type="text" id="' . self::$name . '" name="' . self::$name . '" value="' . $this->getRequestUserName() . '" />

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
	private function getRequestUserName(): string {
		return strip_tags($_POST['RegisterView::UserName'] ?? '');
	}

	//CREATE GET-FUNCTIONS TO FETCH REQUEST VARIABLES
	private function getRequestPassword(): string {
		return strip_tags($_POST['RegisterView::Password'] ?? '');
	}

	//CREATE GET-FUNCTIONS TO FETCH REQUEST VARIABLES
	private function getRequestPasswordRepeat(): string {
		return strip_tags($_POST['RegisterView::PasswordRepeat'] ?? '');
	}

    protected function view() {
        // TODO: Implement view() method.
    }
}
