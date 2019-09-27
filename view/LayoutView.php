<?php


class LayoutView {

  public function render($isLoggedIn, LoginView $v, DateTimeView $dtv, RegisterView $rv, $tMessage = '', $bRegister = false) {
    $res = $bRegister ? $rv->response($tMessage) : $v->response($tMessage, $isLoggedIn, $bRegister);
    echo '<!DOCTYPE html>
      <html>
        <head>
          <meta charset="utf-8">
          <title>Login Example</title>
        </head>
        <body>
          <h1>Assignment 2</h1>
          ' . $this->renderIsLoggedIn($isLoggedIn) . '
          
          <div class="container">
              ' . $res . '
              
              ' . $dtv->show() . '
          </div>
         </body>
      </html>
    ';
  }

  private function renderIsLoggedIn($isLoggedIn) {
    if ($isLoggedIn) {
      return '<h2>Logged in</h2>';
    }
    else {
      return '<h2>Not logged in</h2>';
    }
  }
}
