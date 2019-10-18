<?php

namespace startup\controller;

use Request;
use startup\model\Message;
use startup\service\Auth;
use startup\view\HomeView;
use startup\view\MessageView;

/* Resource (CRUD) controller for Messages */
class MessageController {
    private $oMessageView;

    public function __construct(MessageView $oMessageView) {
        $this->oMessageView = $oMessageView;
    }

    /*
     * Retrieve a single message
     * route POST /editMessage
    */
    public function edit(Request $oRequest, Message $oMessage) {
        $aMessage = $oMessage->findByPk($oRequest->id);

        if(!$oMessage) {
            throw new \Exception('Error! Message not found');
        }

        $this->oMessageView->setMessage($aMessage);
        return $this->oMessageView->render();
    }

    /*
     * Store a message
     * route POST /message
    */
    public function create(Request $oRequest, Message $oMessage, Auth $oAuth) {
        $aUser = $oAuth->getAuthenticatedUser();
        $tTitle = $oRequest->{HomeView::getMessageTitleId()};
        $tMessage = $oRequest->{HomeView::getMessageBodyId()};

        if(empty($tTitle)) {
            flash('messageFeedback', 'Title must not be empty');
            redirect('/');
        }

        if(empty($tMessage)) {
            flash('messageFeedback', 'Message must not be empty');
            redirect('/');
        }

        if(!$aUser) {
            flash('messageFeedback', 'User unauthorized');
            redirect('/');
        }

        $bCreated = $oMessage->createMessage([
            'author_id' => $aUser['id'],
            'title' => $tTitle,
            'message' => $tMessage,
        ]);

        if($bCreated) {
            flash('messageFeedback', 'Message created successfully');
        } else {
            flash('messageFeedback', 'Message could not be created');
        }

        redirect('/');
    }

    /*
     * Update a message
     * route POST /updateMessage
    */
    public function update(Request $oRequest, Message $oMessage) {
        $bUpdated = $oMessage->update([
            'title' => $oRequest->{MessageView::getMessageTitleId()},
            'message' => $oRequest->{MessageView::getMessageBodyId()}], [
            ['id', '=', $oRequest->{MessageView::getMessageIdId()}]
        ]);

        if (!$bUpdated) {
            flash('messageFeedback', 'Something went wrong. Could not update message');
        } else {
            flash('messageFeedback', 'Successfully updated message');
        }

        redirect('/');
    }

    /*
     * Delete a message
     * route POST /deleteMessage
    */
    public function delete(Request $oRequest, Message $oMessage) {
        $bDeleted = $oMessage->deleteMessage($oRequest->id);

        if (!$bDeleted) {
            flash('messageFeedback', 'Something went wrong. Could not delete message');
        } else {
            flash('messageFeedback', 'Successfully deleted message');
        }

        redirect('/');
    }
}
