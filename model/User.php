<?php

namespace startup\model;

class User extends Model {
    protected $tTableName = 'users';

    public function checkRememberToken($tUsername, $tToken) {
        return !!$this->findWhere([
            ['username', '=', $tUsername],
            ['remember_me', '=', $tToken],
        ]);
    }

    public function saveRememberToken($tUsername, $tPasswordToken) {
        return $this->update(['remember_me' => $tPasswordToken], [['username', '=', $tUsername]]);
    }

    public function getByUsername($tUsername) {
        $aUsers = $this->findWhere([['username', '=', $tUsername]]);

        return !empty($aUsers) ? $aUsers[0] : false;
    }

    public function createUser($tUsername, $tPassword) {
        return $this->insert(['username' => $tUsername, 'password' => $tPassword]);
    }

    public function allUsers() {
        return $this->all(['id', 'username']);
    }
}
