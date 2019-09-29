<?php

namespace startup\controller;

use startup\service\Auth;
use startup\view\HomeView;

class HomeController {
    public function index(Auth $oAuth, HomeView $oHomeView) {
        if (!$oAuth->isAuthenticated()) {
            redirect('login');
        }

        return $oHomeView->render();
    }
}
