<?php
/**
 * Session.php
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

/**
 * @mixin \InitPHP\Framework\Session\Session
 * @method static string getName()
 * @method static \InitPHP\Framework\Session\Session setName(string $name)
 * @method static bool isStarted()
 * @method static bool start(array $options = [])
 * @method static bool regenerateId(bool $deleteOldSession = false)
 * @method static string getID()
 * @method static bool setID(string $sessionId)
 * @method static array all()
 * @method static bool destroy()
 * @method static bool flush()
 * @method static bool has(string $key)
 * @method static mixed get(string $key, mixed $default = null)
 * @method static mixed pull(string $key, mixed $default = null)
 * @method static \InitPHP\Framework\Session\Session set(string $key, mixed $value, null|int $ttl = null)
 * @method static mixed push(string $key, mixed $value, null|int $ttl = null)
 * @method static \InitPHP\Framework\Session\Session setAssoc(array $assoc, null|int $ttl = null)
 * @method static \InitPHP\Framework\Session\Session remove(string ...$key)
 */
class Session
{

    private static \InitPHP\Framework\Session\Session $sessionInstance;

    private static function getSessionInstance(): \InitPHP\Framework\Session\Session
    {
        if(!isset(self::$sessionInstance)){
            self::$sessionInstance = new \InitPHP\Framework\Session\Session();
        }
        return self::$sessionInstance;
    }

    public function __call($name, $arguments)
    {
        return self::getSessionInstance()->{$name}(...$arguments);
    }

    public static function __callStatic($name, $arguments)
    {
        return self::getSessionInstance()->{$name}(...$arguments);
    }

}
