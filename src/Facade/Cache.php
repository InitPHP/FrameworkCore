<?php
/**
 * Cache.php
 *
 * This file is part of FrameworkCore.
 *
 * @author     Muhammet ŞAFAK <info@muhammetsafak.com.tr>
 * @copyright  Copyright © 2022 Muhammet ŞAFAK
 * @license    ./LICENSE  MIT
 * @version    2.0
 * @link       https://www.muhammetsafak.com.tr
 */

declare(strict_types=1);

namespace InitPHP\Framework\Facade;

use InitPHP\Cache\CacheInterface;

/**
 * @mixin \InitPHP\Framework\Cache\Cache
 * @method static CacheInterface useRedis()
 * @method static CacheInterface useMemcache()
 * @method static CacheInterface useWinCache()
 * @method static CacheInterface useFile()
 * @method static bool has(string $key)
 * @method static mixed get(string $key, mixed $default = null)
 * @method static bool set(string $key, mixed $value, null|int|\DateInterval $ttl = null)
 * @method static bool delete(string $key)
 * @method static bool clear()
 * @method static iterable getMultiple(iterable $keys, mixed $default = null)
 * @method static bool setMultiple(iterable $values, null|int|\DateInterval $ttl = null)
 * @method static bool deleteMultiple(iterable $keys)
 * @method static int increment(string $name, int $offset = 1)
 * @method static int decrement(string $name, int $offset = 1)
 */
class Cache
{

    private static CacheInterface $cacheInstance;

    private static function getCacheInstance(): CacheInterface
    {
        if(!isset(self::$cacheInstance)){
            self::$cacheInstance = new \InitPHP\Framework\Cache\Cache();
        }
        return self::$cacheInstance;
    }

    public function __call($name, $arguments)
    {
        return self::getCacheInstance()->{$name}(...$arguments);
    }

    public static function __callStatic($name, $arguments)
    {
        return self::getCacheInstance()->{$name}(...$arguments);
    }

}
