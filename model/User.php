<?php

class User {
    public $oDB;

    public function __construct($oDB) {
        $this->oDB = $oDB;
    }

    public function getByUsername($tUsername) {
        $stmt = $this->oDB->prepare('SELECT * FROM users WHERE username = ?');
        $stmt->execute([$tUsername]);
        return $stmt->fetch();
    }

    public function createUser($tUsername, $tPassword) {
        $stmt = $this->oDB->prepare('INSERT INTO users (username, password) VALUES (?, ?)');
        return $stmt->execute([$tUsername, $tPassword]);
    }
}
