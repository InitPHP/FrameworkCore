<?php
/**
 * Stack.php
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
 * @mixin \InitPHP\Framework\Stack\Stack
 * @method static void set(string $id, $value)
 * @method static mixed get(string $id, $default = null)
 * @method static bool has(string $id)
 */
class Stack
{
    private static \InitPHP\Framework\Stack\Stack $stackInstance;

    private static function getStackInstance(): \InitPHP\Framework\Stack\Stack
    {
        if(!isset(self::$stackInstance)){
            self::$stackInstance = new \InitPHP\Framework\Stack\Stack(true);
        }
        return self::$stackInstance;
    }

    public function __call($name, $arguments)
    {
        return self::getStackInstance()->{$name}(...$arguments);
    }

    public static function __callStatic($name, $arguments)
    {
        return self::getStackInstance()->{$name}(...$arguments);
    }

}
