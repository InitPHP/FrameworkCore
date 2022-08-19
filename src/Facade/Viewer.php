<?php
/**
 * Viewer.php
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
 * @mixin \InitPHP\Framework\Viewer\Viewer
 * @method static \InitPHP\Framework\Viewer\Viewer setData(array|object $data)
 * @method static mixed getData(null|string $key, mixed $default = null)
 * @method static \InitPHP\Framework\Viewer\Viewer setViews(string ...$views)
 * @method static \InitPHP\Framework\Viewer\Viewer setDir(string $dir)
 * @method static \InitPHP\Framework\Viewer\Viewer withDir(string $dir)
 * @method static void require(string ...$views)
 * @method static \InitPHP\Framework\Viewer\Viewer view(string|string[] $views, array|object $data)
 * @method static string cell(string $library, string $method, array|object $data = [])
 */
class Viewer
{

    private static \InitPHP\Framework\Viewer\Viewer $viewerInstance;

    private static function getViewerInstance(): \InitPHP\Framework\Viewer\Viewer
    {
        if(!isset(self::$viewerInstance)){
            self::$viewerInstance = new \InitPHP\Framework\Viewer\Viewer();
        }
        return self::$viewerInstance;
    }

    public function __toString()
    {
        return self::getViewerInstance()->__toString();
    }

    public function __call($name, $arguments)
    {
        return self::getViewerInstance()->{$name}(...$arguments);
    }

    public static function __callStatic($name, $arguments)
    {
        return self::getViewerInstance()->{$name}(...$arguments);
    }

}
