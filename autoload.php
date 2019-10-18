<?php

spl_autoload_register(function ()  {
    foreach (['./controller/', './service/', './lib/', './model/', './view/'] as $tDir) {
        if ($oHandle = opendir($tDir)) {
            while (($tFile = readdir($oHandle)) !== false) {
                if ($tFile != "."
                    && $tFile != ".."
                    && preg_match('/\.php/', $tFile) === 1) {
                    require_once($tDir . $tFile);
                }
            }
        }
    }
});
