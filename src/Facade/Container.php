<?php
/**
 * Container.php
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
 * @mixin \InitPHP\Container\Container
 * @method static void set(string $id, $concrete = null)
 * @method static object get(string $id)
 * @method static bool has(string $id)
 */
class Container
{

    private static \InitPHP\Container\Container $containerInstance;

    private static function getContainerInstance(): \InitPHP\Container\Container
    {
        if(!isset(self::$containerInstance)){
            self::$containerInstance = new \InitPHP\Container\Container();
        }
        return self::$containerInstance;
    }

    public function __call($name, $arguments)
    {
        return self::getContainerInstance()->{$name}(...$arguments);
    }

    public static function __callStatic($name, $arguments)
    {
        return self::getContainerInstance()->{$name}(...$arguments);
    }

}
