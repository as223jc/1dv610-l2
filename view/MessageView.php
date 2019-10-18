<?php

namespace startup\view;

class MessageView extends LayoutView {
    private static $messageTitle = 'MessageView::MessageTitle';
    private static $messageBody = 'MessageView::MessageBody';
    private static $messageId = 'MessageView::MessageId';
    private $aMessage;

    public function setMessage($aMessage) {
        $this->aMessage = $aMessage;
    }
    protected function view() {
        return '<form action="updateMessage" method="post">
        <div>
            <div>
                  <input type="text" name="' . self::$messageTitle . '" placeholder="Enter a title" value="' . $this->aMessage['title'] . '">
            </div>
            <br>
            <div>
                  <textarea name="' . self::$messageBody . '" placeholder="Enter a message">' . $this->aMessage['message'] . '</textarea>
            </div>
            <br>
            <div>
                <button>Save</button>
                <input type="hidden" name="'. self::$messageId .'" value="' . $this->aMessage['id'] . '">
            </div>
        </div>
</form>
        <br>
        <br>
			<a href="/">Back to home</a>
            </div>';
    }

    public static function getMessageTitleId() {
        return self::$messageTitle;
    }

    public static function getMessageBodyId() {
        return self::$messageBody;
    }

    public static function getMessageIdId() {
        return self::$messageId;
    }
}
