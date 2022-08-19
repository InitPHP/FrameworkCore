<?php
/**
 * Cookie.php
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
 * @mixin \InitPHP\Framework\Cookie\Cookie
 * @method static \InitPHP\Cookies\Cookie|null get(string $name);
 * @method static \InitPHP\Cookies\Cookie create(string $name)
 */
class Cookie
{

    private static \InitPHP\Framework\Cookie\Cookie $cookieInstance;

    private static function getCookieInstance(): \InitPHP\Framework\Cookie\Cookie
    {
        if(!isset(self::$cookieInstance)){
            self::$cookieInstance = new \InitPHP\Framework\Cookie\Cookie();
        }
        return self::$cookieInstance;
    }

    public function __call($name, $arguments)
    {
        return self::getCookieInstance()->{$name}(...$arguments);
    }

    public static function __callStatic($name, $arguments)
    {
        return self::getCookieInstance()->{$name}(...$arguments);
    }

}
