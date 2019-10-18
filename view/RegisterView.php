<?php

namespace startup\view;

class RegisterView extends LayoutView {
    private static $name = 'RegisterView::UserName';
    private static $newPassword1 = 'RegisterView::Password';
    private static $newPassword2 = 'RegisterView::PasswordRepeat';
    private static $register = 'RegisterView::Register';
    private static $tUserNameMessage = 'RegisterView::UsernameMessage';
    private static $tPasswordMessage = 'RegisterView::PasswordMessage';
    private static $tRegisterMessage = 'RegisterView::RegisterMessage';

    protected function view() {
        return '<form method="post" action="register"> 
				<fieldset>
					<legend>Register - enter a username and a password</legend>
                    <div>				
                        <label for="' . self::getNameId() . '">Username :</label>
                        <input type="text" id="' . self::getNameId() . '" name="' . self::getNameId() . '" value="' . $this->getRequestUserName() . '" />
                         ' . flash(self::getUsernameMessageId()) . '
                     </div>
                    <div>
                        <label for="' . self::getNewPasswordId() . '">Password :</label>
                        <input type="password" id="' . self::getNewPasswordId() . '" name="' . self::getNewPasswordId() . '" />

                        <label for="' . self::getNewPasswordRepeatId() . '">Repeat password :</label>
                        <input type="password" id="' . self::getNewPasswordRepeatId() . '" name="' . self::getNewPasswordRepeatId() . '" />
                         ' . flash(self::getPasswordMessageId()) . '
                    </div>
					<input type="submit" name="' . self::getRegisterId() . '" value="register" />
					<a href="/">Back to login</a>
				</fieldset>
			</form>';
    }

	//CREATE GET-FUNCTIONS TO FETCH REQUEST VARIABLES
	public function getRequestUserName(): string {
		return strip_tags($_POST[self::getNameId()] ?? '');
	}

	public function getRequestPassword(): string {
		return strip_tags($_POST[self::getNewPasswordId()] ?? '');
	}

	public function getRequestPasswordRepeat(): string {
		return strip_tags($_POST[self::getNewPasswordRepeatId()] ?? '');
	}

    public static function getNameId(): string {
        return self::$name;
    }

    public static function getNewPasswordId(): string {
        return self::$newPassword1;
    }

    public static function getNewPasswordRepeatId(): string {
        return self::$newPassword2;
    }

    public static function getRegisterId(): string {
        return self::$register;
    }

    public static function getUsernameMessageId(): string {
        return self::$tUserNameMessage;
    }

    public static function getPasswordMessageId(): string {
        return self::$tPasswordMessage;
    }

    public static function getRegisterMessageId(): string {
        return self::$tRegisterMessage;
    }
}
