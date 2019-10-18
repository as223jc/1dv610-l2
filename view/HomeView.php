<?php

namespace startup\view;

class HomeView extends LayoutView {
    private static $messageTitle = 'HomeView::MessageTitle';
    private static $messageBody = 'HomeView::MessageBody';
    private $aMessages;

    public function setMessages($aMessages) {
        $this->aMessages = $aMessages;
    }

    private function getMessagesHtml() {
        $tRet = '';

        foreach ($this->aMessages as $aMessage) {
            $tRet .= "
            <div>
                <fieldset>
                    <div>
                        <p>{$aMessage['title']}</p>
                        <p>{$aMessage['message']}</p>
                        <small>{$aMessage['author']}, {$aMessage['created_at']}</small>
                        <div>
                            <form action='editMessage' method='post'>
                              <input type='hidden' name='id' value='{$aMessage['id']}'>
                              <button>edit</button>
                            </form>
                            <form action='deleteMessage' method='post'>
                                <input type='hidden' name='id' value='{$aMessage['id']}'>
                                <button>delete</button>
                            </form>
                        </div>
                    </div>            
                </fieldset>
            <div>
            ";
        }

        return $tRet;
    }

    protected function view() {
        return '
            <div>
                <h2>Logged in</h2>
                <h3>Welcome user!</h3>
                ' . flash(LoginView::getWelcomeMessageId()) . '
                ' . flash('messageFeedback') . '
                <h4>All messages</h4>
                ' . $this->getMessagesHtml() . '
            </div>
            <br>
            <form action="message" method="post">
                <p>New message</p>
                <div>
                    <div>
                      <input type="text" name="' . self::getMessageTitleId() . '" placeholder="Enter a title">
                    </div>
                    <br>
                    <div>
                      <textarea name="' . self::getMessageBodyId() . '" placeholder="Enter a message"></textarea>
                    </div>
                    <br>
                    <div>
                      <input type="submit" value="Skicka">
                    </div>
                </div>
            </form>
            <br>
            <form  method="post" action="logout">
              <input type="submit" value="logout"/>
            </form>
        ';
    }

    public static function getMessageTitleId() {
        return self::$messageTitle;
    }

    public static function getMessageBodyId() {
        return self::$messageBody;
    }
}
