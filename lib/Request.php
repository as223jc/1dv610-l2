<?php

class Request {
    private $aServer;
    private $tRequestRoute;

    public function __construct() {
        $this->aServer = $_SERVER;
    }

    /* Allows anything from the $_SERVER global to be retrieved directly from the request */
    public function __get($name) {
        if(array_key_exists($name, $this->all())) {
            return $this->all()[$name];
        }
        return null;
    }

    /*
    * Returns requested route
    * Since we are rewriting current route for pretty url (e.g. index.php?login to /login), the first
    * GET param is the requested route
    */
    public function getRoute() {
        return explode('&', $this->aServer['QUERY_STRING'])[0];
    }

    /* Returns HTTP Method used in current request */
    public function getMethod() {
        return $this->aServer['REQUEST_METHOD'];
    }

    /*
    * Returns array with all parameters, GET or POST
    * Or, when optional parameter used, returns key value if found, else null
    */
    public function all($key = null) {
        $aParams = array_merge($this->get(), $this->post());

        if ($key) {
            return $aParams[$key] ?? null;
        }

        return $aParams;
    }

    /*
    * Returns array with all GET parameters
    * Or, when optional parameter used, returns key value if found, else null
    */
    public function get($key = null) {
        /* Since we are using the first GET param to determine route, we exclude it from the request */
        $aGetParameters = explode('&', $this->aServer['QUERY_STRING']);
        array_splice($aGetParameters, 0, 1);

        $aGetParams = [];

        foreach ($aGetParameters as $tParam) {
            [$tParamKey, $tParamValue] = explode('=', urldecode($tParam));
            $aGetParams[$tParamKey] = $tParamValue;
        }

        if ($key) {
            return $aGetParameters[$key] ?? null;
        }

        return $aGetParams;
    }

    /*
    * Returns array with all GET parameters
    * Or, when optional parameter used, returns key value if found, else null
    */
    public function post($key = null) {
        if ($key) {
            return $_POST[$key] ?? null;
        }

        return $_POST;
    }

    public function __call($name, $arguments) {
        dd($name, $arguments);
        // TODO: Implement __call() method.
    }
}
