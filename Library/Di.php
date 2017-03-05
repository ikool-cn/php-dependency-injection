<?php
namespace Library;

class Di
{
    private static $container = [];
    private static $sharedNames = [];
    private static $serviceContainer = [];

    public function set($serviceName, $definition, $share = false)
    {
        self::$container[$serviceName] = $definition;
        self::$sharedNames[$serviceName] = $share;
    }

    public function setShared($serviceName, $definition)
    {
        return $this->set($serviceName, $definition, true);
    }

    public function get($serviceName)
    {
        if (!isset(self::$container[$serviceName])) {
            throw new \Exception("service $serviceName not found");
        }

        if (self::$sharedNames[$serviceName] === true) {
            if (!isset(self::$serviceContainer[$serviceName])) {
                self::$serviceContainer[$serviceName] = $this->resolve($serviceName);
            }
            return self::$serviceContainer[$serviceName];
        }

        return $this->resolve($serviceName);
    }

    protected function resolve($serviceName)
    {
        $definition = self::$container[$serviceName];
        $type = gettype($definition);
        switch ($type) {
            case 'string':
                $obj = new $definition;
                break;
            case 'object':
                if ($definition instanceof \Closure) {
                    $obj = $definition();
                } else {
                    $obj = $definition;
                }
                break;
            default:
                $obj = null;
                break;
        }
        return $obj;
    }


    function __get($serviceName)
    {
        if (isset(self::$container[$serviceName])) {
            return $this->get($serviceName);
        }

        $trace = debug_backtrace();
        trigger_error(
            'Undefined property via __get(): ' . $serviceName .
            ' in ' . $trace[0]['file'] .
            ' on line ' . $trace[0]['line'],
            E_USER_NOTICE);
        return null;
    }
}