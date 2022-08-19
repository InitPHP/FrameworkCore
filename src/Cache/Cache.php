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

namespace InitPHP\Framework\Cache;

use InitPHP\Cache\CacheInterface;
use InitPHP\Framework\Base\Config;
use \InitPHP\Framework\Cache\Exception\{CacheException, CacheInvalidArgumentException};
use \InitPHP\Framework\Facade\{Container, CacheStack};
use InitPHP\Framework\Exception\ConfigClassException;

class Cache implements CacheInterface
{

    public const FILE = 0;
    public const REDIS = 1;
    public const MEMCACHE = 2;
    public const WINCACHE = 3;

    private Config $config;

    private CacheInterface $cache;

    public function __construct(?int $handler = null)
    {
        if(!\class_exists('\\App\\Configs\\Cache')){
            throw new ConfigClassException('Cache');
        }
        $this->config = Container::get('\\App\\Configs\\Cache');
        if($handler === null){
            $handler = $this->config->get('default', self::FILE);
        }
        switch ($handler) {
            case self::FILE:
                $this->cache = \InitPHP\Cache\Cache::create(\InitPHP\Cache\Handler\File::class, [
                    'path'      => $this->config->get('file.dir', \BASE_DIR . 'Writable/')
                ]);
                break;
            case self::REDIS:
                $handler = $this->config->get('redis.handler', \InitPHP\Cache\Handler\Redis::class);
                $this->cache = \InitPHP\Cache\Cache::create($handler, $this->config->get('redis', [
                    'prefix'    => 'cache_',
                    'host'      => '127.0.0.1',
                    'password'  => null,
                    'port'      => 6379,
                    'timeout'   => 0,
                    'database'  => 0
                ]));
                break;
            case self::MEMCACHE:
                $handler = $this->config->get('memcache.handler', \InitPHP\Cache\Handler\Memcache::class);
                $this->cache = \InitPHP\Cache\Cache::create($handler, $this->config->get('memcache', [
                    'prefix'        => 'cache_',
                    'host'          => '127.0.0.1',
                    'port'          => 11211,
                    'weight'        => 1,
                    'raw'           => false,
                    'default_ttl'   => 60,
                ]));
                break;
            case self::WINCACHE:
                $handler = $this->config->get('wincache.handler', \InitPHP\Cache\Handler\Wincache::class);
                $this->cache = \InitPHP\Cache\Cache::create($handler, $this->config->get('wincache', [
                    'prefix'        => 'cache_',
                    'default_ttl'   => 60,
                ]));
                break;
            default:
                throw new CacheInvalidArgumentException("An invalid cache handler has been identified.");
        }
    }

    public function useRedis(): CacheInterface
    {
        $cache = CacheStack::get('redis');
        if($cache === null){
            $cache = new self(self::REDIS);
            CacheStack::set('redis', $cache);
        }
        return $cache;
    }

    public function useMemcache(): CacheInterface
    {
        $cache = CacheStack::get('memcache');
        if($cache === null){
            $cache = new self(self::MEMCACHE);
            CacheStack::set('memcache', $cache);
        }
        return $cache;
    }

    public function useFile(): CacheInterface
    {
        $cache = CacheStack::get('file');
        if($cache === null){
            $cache = new self(self::FILE);
            CacheStack::set('file', $cache);
        }
        return $cache;
    }

    public function useWinCache(): CacheInterface
    {
        $cache = CacheStack::get('winCache');
        if($cache === null){
            $cache = new self(self::WINCACHE);
            CacheStack::set('winCache', $cache);
        }
        return $cache;
    }

    /**
     * @inheritDoc
     */
    public function get($key, $default = null)
    {
        return $this->cache->get($key, $default);
    }

    /**
     * @inheritDoc
     */
    public function set($key, $value, $ttl = null)
    {
        return $this->cache->set($key, $value, $ttl);
    }

    /**
     * @inheritDoc
     */
    public function clear()
    {
        return $this->cache->clear();
    }

    /**
     * @inheritDoc
     */
    public function getMultiple($keys, $default = null)
    {
        return $this->cache->getMultiple($keys, $default);
    }

    /**
     * @inheritDoc
     */
    public function deleteMultiple($keys)
    {
        return $this->cache->deleteMultiple($keys);
    }

    /**
     * @inheritDoc
     */
    public function setOptions($options = [])
    {
        return $this->cache->setOptions($options);
    }

    /**
     * @inheritDoc
     */
    public function increment($name, $offset = 1)
    {
        return $this->cache->increment($name, $offset);
    }

    /**
     * @inheritDoc
     */
    public function decrement($name, $offset = 1)
    {
        return $this->cache->decrement($name, $offset);
    }

    /**
     * @inheritDoc
     */
    public function delete($key)
    {
        return $this->cache->delete($key);
    }

    /**
     * @inheritDoc
     */
    public function setMultiple($values, $ttl = null)
    {
        return $this->cache->setMultiple($values, $ttl);
    }

    /**
     * @inheritDoc
     */
    public function has($key): bool
    {
        return $this->cache->has($key);
    }

}
