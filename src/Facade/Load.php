<?php
/**
 * Load.php
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
 * @mixin \InitPHP\Framework\Load\Load
 * @method static \InitPHP\Framework\Base\Config config(string $config)
 * @method static \InitPHP\Framework\Base\Entity entity(string $entity)
 * @method static void helper(string ...$helpers)
 * @method static void language(string $change)
 * @method static object library(string $library)
 * @method static \InitPHP\Framework\Base\Model model(string $model)
 * @method static string view(string|string[] $view, array|object $data)
 */
class Load
{

    private static \InitPHP\Framework\Load\Load $loadInstance;

    private static function getLoadInstance(): \InitPHP\Framework\Load\Load
    {
        if(!isset(self::$loadInstance)){
            self::$loadInstance = new \InitPHP\Framework\Load\Load();
        }
        return self::$loadInstance;
    }

    public function __call($name, $arguments)
    {
        return self::getLoadInstance()->{$name}(...$arguments);
    }

    public static function __callStatic($name, $arguments)
    {
        return self::getLoadInstance()->{$name}(...$arguments);
    }

}
