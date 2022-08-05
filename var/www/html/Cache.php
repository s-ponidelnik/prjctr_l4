<?php

/**
 * prjctr l4 cache
 */
final class Cache
{
    /** @var Redis $_redis */
    private Redis $_redis;

    /** @var PDO */
    private PDO $_mysql;

    /** @var int default TTL */
    private const TTL=20;
    /**
     * initialize redis and mysql
     */
    public function __construct()
    {
        $this->_mysql = new PDO('mysql:host=prjctr_l4_mysql;dbname=prjctr_l4', 'root', 'root');
        $this->_redis = new Redis();
        $this->_redis->connect('prjctr_l4_redis', 6379);
    }

    /**
     * @param $key
     * @param $ttl
     * @param int $beta
     * @return string|null
     */
    public function probEarlyExpCache($key, $ttl=null, int $beta = 1): ?string
    {
        $value = null;
        $cache_value = $this->_redis->get($key);
        if ($cache_value) {
            if (!$ttl){
                $ttl=self::TTL;
            }
            $data = explode("|", $cache_value);
            $value = $data[0];
            $delta = (float)$data[1];
            $expire = (float)$data[2];
        }
        if (!$cache_value || (time() - $delta * $beta * log(rand(0, 1)) >= $expire)) {
            $start = time();
            $value = $this->getByIndex($key);
            $delta = time() - $start;
            $expire = time() + $ttl;

            $cache_value = $value . "|" . $delta . "|" . $expire;
            $this->_redis->set($key, $cache_value, $ttl);
        }
        return $value;
    }

    /**
     * @param string $key
     * @param $ttl
     * @return false|mixed|Redis|string
     */
    public function simpleCache(string $key,$ttl=null): mixed
    {
        $value = $this->_redis->get($key);
        if (!$value){
            $value = $this->getByIndex($key);
            $this->_redis->set($key,$value,$ttl ?? self::TTL);
        }
        return $value;
    }

    /**
     * @param $key
     * @return string
     */
    public function getByIndex($key): string
    {
        usleep(10000);//fake slowly select query
        print '<h3>database</h3>';
        return $this->_mysql->query('SELECT v FROM prjctr WHERE k="'.$key.'" LIMIT 1')->fetchColumn();

    }

    /**
     * @return void
     */
    public function flushAll(): void
    {
        $this->_redis->flushAll();
    }
}