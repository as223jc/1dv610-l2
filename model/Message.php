<?php

namespace startup\model;

class Message extends Model {
    protected $tTableName = 'messages';

    public function allMessages() {
        return $this->all(['id', 'author_id', 'title', 'message', 'created_at']);
    }

    public function createMessage($aMessage) {
        return $this->insert($aMessage);
    }

    public function getByUsername($tUsername) {
        $aUsers = $this->findWhere([['username', '=', $tUsername]]);

        return !empty($aUsers) ? $aUsers[0] : false;
    }

    public function createUser($tUsername, $tPassword) {
        return $this->insert(['username' => $tUsername, 'password' => $tPassword]);
    }

    public function deleteMessage(int $iId) {
        return $this->delete([[
            $this->tPrimaryKey, '=', $iId
        ]]);
    }
}
