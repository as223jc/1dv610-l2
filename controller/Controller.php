<?php

class Controller {
    private $oLoginView;

    public function __construct(LoginView $oLoginView) {
        $this->oLoginView = $oLoginView;
    }

    public function index() {
        $this->oLoginView->response();
    }
}
