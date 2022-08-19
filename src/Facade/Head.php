<?php
/**
 * Head.php
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
 * @mixin \InitPHP\Framework\Viewer\Head
 * @method static string get()
 * @method static \InitPHP\Framework\Viewer\Head set(string $title, string $description = '', string|string[] $keywords = [])
 * @method static \InitPHP\Framework\Viewer\Head add_meta(string|array $meta)
 */
class Head
{

    private static \InitPHP\Framework\Viewer\Head $headInstance;

    private static function getHeadInstance(): \InitPHP\Framework\Viewer\Head
    {
        if(!isset(self::$headInstance)){
            self::$headInstance = new \InitPHP\Framework\Viewer\Head();
        }
        return self::$headInstance;
    }

    public function __call($name, $arguments)
    {
        return self::getHeadInstance()->{$name}(...$arguments);
    }

    public static function __callStatic($name, $arguments)
    {
        return self::getHeadInstance()->{$name}(...$arguments);
    }

}
