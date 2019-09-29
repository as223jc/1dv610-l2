<?php

class Router {
    public function __construct() {

    }

    private $routes = [
        'GET' => [],
        'POST' => [],
    ];

    public function get($tRoute, $tEndPoint) {
        $this->routes['GET'][$tRoute] = $tEndPoint;
    }

    public function post($tRoute, $tEndPoint) {
        $this->routes['POST'][$tRoute] = $tEndPoint;
    }

    public function matchRoute(Request $oRequest) {
        $tRequestedRoute = $oRequest->getRoute();
        $tRequestedMethod = $oRequest->getMethod();

        if (!array_key_exists($tRequestedMethod, $this->routes)) {
            throw new \Exception("Bad HTTP Method: $tRequestedMethod");
        }

        if (!array_key_exists($tRequestedRoute, $this->routes[$tRequestedMethod])) {
            throw new \Exception("Could not match route: $tRequestedMethod $tRequestedRoute");
        }

        if (!array_key_exists($tRequestedRoute, $this->routes[$tRequestedMethod])) {
            throw new \Exception("Could not find route: $tRequestedMethod $tRequestedRoute");
        }

        /* Check if route resolver is a callback function */
        if (is_callable($this->routes[$tRequestedMethod][$tRequestedRoute])) {
            return $this->routes[$tRequestedMethod][$tRequestedRoute]();
        }

        /* Not a callback function, assuming its a controller@method resolver
        * Check if route resolver is a callback function
        */
        [$tClass, $tMethod] = explode('@', $this->routes[$tRequestedMethod][$tRequestedRoute]);

        /* Try to instantiate a reflection class of the supplied class
        * @throws \ReflectionException if the class does not exist.
        */
//        $oRefClass = new ReflectionClass($tClass);
        $oClass = createClass($tClass);
        $oMethod = new ReflectionMethod($oClass, $tMethod);


        $routeParameters = $oMethod->getParameters();
        foreach ($oMethod->getParameters() as $index => $parameter) {
            $class = $parameter->getClass();

            if ($class !== null) {
                $instance = createClass($class->name);
                array_splice($routeParameters, $index, 0, [ $instance ]);
            }
        }

        return $oClass->$tMethod(...$routeParameters);

        /* Check if class has supplied method */
//        if (!$oRefClass->hasMethod($tMethod)) {
//            throw new \Exception("Method $tMethod not found in class $tClass");
//        }
//
//        $oRefClass->getMethod($tMethod)->invoke(new $tClass);


//        $oMethod = new ReflectionMethod($tClass, $tMethod);
//        foreach ($oMethod->getParameters() as $index => $parameter) {
//            $class = $parameter->getClass();
//
//            if ($class !== null) {
////                $instance = build($class->name);
////                array_splice($routeParameters, $index, 0, [ $instance ]);
//            }
//        }
//
//        $controller->callAction($tMethod, $routeParameters);
    }

//    public function __call($tMethod, $aArguments) {
//        [$tRoute, $callback] = $aArguments;
//        if ($tMethod === $this->tRequestMethod && $tRoute === $this->tRequestRoute)
//            $callback();
////        die(print_r([$tMethod,$aArguments,$this->tRequestRoute, $this->tRequestMethod]));
//    }

    private function resolve($tClass) {

    }
}
