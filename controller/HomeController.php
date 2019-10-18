<?php

namespace startup\controller;

use startup\model\Message;
use startup\model\User;
use startup\service\Auth;
use startup\view\HomeView;

class HomeController {
    /* Route GET / */
    public function index(Auth $oAuth, HomeView $oHomeView, Message $oMessage, User $oUser) {
        if (!$oAuth->isAuthenticated()) {
            redirect('login');
        }

        $aAllUsers  = $oUser->allUsers();
        $aAllMessages = $oMessage->allMessages();

        $aAllMessages = array_reduce(array_keys($aAllMessages), function($aReduced, $iIndex) use ($aAllMessages, $aAllUsers) {
            $aReduced[$iIndex] = $aAllMessages[$iIndex];

            $iUserIndex = array_search($aAllMessages[$iIndex]['author_id'], array_column($aAllUsers, 'id'));

            if (!isset($aAllUsers[$iUserIndex])) {
                $aReduced[$iIndex]['author'] = 'unknown';
            } else {
                $aReduced[$iIndex]['author'] = $aAllUsers[$iUserIndex]['username'];
            }

            return $aReduced;
        }, []);


        $oHomeView->setMessages($aAllMessages);
        return $oHomeView->render();
    }
}
