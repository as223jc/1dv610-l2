<?php

/* !!! For some unknown reason, I absolutely could not import file if it was called "LayoutView" */

namespace startup\view;

abstract class LayoutView {
    private $dtv;

    public function __construct(DateTimeView $dtv) {
        $this->dtv = $dtv;
    }

    public function render() {
        return "<!DOCTYPE html>
      <html lang='sv'>
        <head>
          <meta charset='utf-8'>
          <title>Login Example</title>
        </head>
        <body>
          <h1>Assignment 3</h1>
         {$this->view()}
         {$this->dtv->show()}
         </body>
      </html>
    ";
    }

    abstract protected function view();
}
