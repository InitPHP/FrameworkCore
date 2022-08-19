<?php
/**
 * CacheStack.php
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

use InitPHP\Framework\Stack\Stack;

/**
 * @mixin Stack
 * @method static void set(string $id, $value)
 * @method static mixed get(string $id, $default = null)
 * @method static bool has(string $id)
 */
class CacheStack
{

    private static Stack $stackInstance;

    private static function getStackInstance(): Stack
    {
        if(!isset(self::$stackInstance)){
            self::$stackInstance = new Stack(false);
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
