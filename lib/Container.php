<?php

/* Class dependency resolver - used to resolve classes using reflection (Dependency injection) */
class Container {
    protected $aClasses = [];

    /**
     * Finds an entry of the container by its identifier and returns it.
     *
     * @param $tName
     * @return mixed Entry.
     */
    public function get($tName) {
        if (!isset($this->aClasses[$tName])) {
            $this->set($tName);
        }

        return $this->resolve($tName);
    }

    /**
     * Returns true if the container can return an entry for the given identifier.
     * Returns false otherwise.
     *
     * `has($id)` returning true does not mean that `get($id)` will not throw an exception.
     * It does however mean that `get($id)` will not throw a `NotFoundExceptionInterface`.
     *
     * @param $tName
     * @return void
     */
    public function set($tName) {
        $this->aClasses[$tName] = $tName;
    }

    public function resolve($tName) {
        $oRefClass = new ReflectionClass($tName);
        $oConstructor = $oRefClass->getConstructor();

        if (!$oConstructor) {
            return $oRefClass->newInstance();
        }

        $oConstructorParams = $oConstructor->getParameters();

        $oClassDependencies = $this->resolveDependencies($oConstructorParams);

        return $oRefClass->newInstanceArgs($oClassDependencies);
    }

    private function resolveDependencies($aParams) {
        $aDependencies = [];

        foreach ($aParams as $aParam) {
            $aDependencyClass = $aParam->getClass();

            if (!$aDependencyClass) {
                if ($aParam->isDefaultValueAvailable()) {
                    array_push($aDependencies, $aParam->getDefaultValue());
                } else {
                    throw new \Exception("Unable to resolve class dependency {$aParam->name}");
                }
            } else {
                $aDependencies[] = $this->get($aDependencyClass->name);
            }
        }

        return $aDependencies;
    }
}
