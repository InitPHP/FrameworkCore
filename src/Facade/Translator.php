<?php
/**
 * Translator.php
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
 * @mixin \InitPHP\Framework\Translator\Translator
 * @method static \InitPHP\Framework\Translator\Translator setDir(string $dir)
 * @method static \InitPHP\Framework\Translator\Translator setDefault(string $default)
 * @method static \InitPHP\Framework\Translator\Translator useFile()
 * @method static \InitPHP\Framework\Translator\Translator useDirectory()
 * @method static \InitPHP\Framework\Translator\Translator change(string $current)
 * @method static string|null getCurrent()
 * @method static string _r(string $key, null|string $default = null, array $context = [])
 * @method static void _e(string $key, null|string $default = null, array $context = [])
 */
class Translator
{

    private static \InitPHP\Framework\Translator\Translator $translatorInstance;

    private static function getTranslatorInstance(): \InitPHP\Framework\Translator\Translator
    {
        if(!isset(self::$translatorInstance)){
            self::$translatorInstance = new \InitPHP\Framework\Translator\Translator();
        }
        return self::$translatorInstance;
    }

    public function __call($name, $arguments)
    {
        return self::getTranslatorInstance()->{$name}(...$arguments);
    }

    public static function __callStatic($name, $arguments)
    {
        return self::getTranslatorInstance()->{$name}(...$arguments);
    }

}
