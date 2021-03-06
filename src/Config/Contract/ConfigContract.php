<?php namespace Poet\Framework\Config\Contract;
interface ConfigContract {

    public function has($key);

    public function get($key,$default=null);

    public function all();

    public function set($key,$value=null);

    public function prepend($key,$value);

    public function push($key,$value);

}