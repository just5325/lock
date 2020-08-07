<?php

namespace Lock;

use Lock\Factory\Factory;

/**
 * 方便ide索引
 *
 * @method $this lock(Callback $closure, $lock_val)
 * @method $this locks(Callback $closure, $lock_val)
 * @method $this queueLock(Callback $closure,array $lock_val, $max_queue_process = 100, $timeout = 60)
 * @method $this queueLocks(Callback $closure,array $lock_val, $max_queue_process = 100, $timeout = 60)
 * @method $this isActionAllowed($key, $period, $max_count)
 *
 */
class Lock implements LockContextInterface
{
    private static $single;
    private $many;

    /**
     * Lock constructor.
     * @param array $config
     * @param array $params
     * @throws LockException
     */
    public function __construct($config = [], $params = [])
    {
        $this->manyInstance($config, $params);
    }

    /**
     * 单例
     * @param $name
     * @param $arguments
     * @throws LockException
     * @return mixed
     */
    public static function __callStatic($name, $arguments)
    {
        $single = self::singleInstance();

        return call_user_func_array([$single, $name], $arguments);
    }

    /**
     * 实例化调用
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        return call_user_func_array([$this->many, $name], $arguments);
    }

    /**
     * 单例工厂
     * @return Factory
     * @throws LockException
     */
    private static function singleInstance()
    {
        if (empty(self::$single)){
            self::$single = new Factory();
        }

        return self::$single;
    }

    /**
     * 多例工厂
     * @param $config
     * @param $params
     * @return Factory
     * @throws LockException
     */
    private function manyInstance($config, $params)
    {
        if (empty($this->many)){
            $this->many = new Factory($config, $params);
        }

        return $this->many;
    }

    private function __clone(){}
    private function __wakeup(){}
}
