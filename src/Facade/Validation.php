<?php
/**
 * Validation.php
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
 * @mixin \InitPHP\Validation\Validation
 * @method static \InitPHP\Validation\Validation setData(array $data = [])
 * @method static \InitPHP\Validation\Validation mergeData(array $data = [])
 * @method static \InitPHP\Validation\Validation clear()
 * @method static \InitPHP\Validation\Validation pattern(string $name, string $pattern = '[\w]+')
 * @method static \InitPHP\Validation\Validation rule(string|string[] $key, string|callable|string[]|callable[] $rule, null|string $err = null)
 * @method static bool validation()
 * @method static bool isValid()
 * @method static \InitPHP\Validation\Validation setError(string $error, array $context = [])
 * @method static string[] getError()
 * @method static \InitPHP\Validation\Validation setLocaleDir(string $dir = __DIR__ . '/languages/')
 * @method static \InitPHP\Validation\Validation setLocale(string $locale = 'en')
 * @method static \InitPHP\Validation\Validation setLocaleArray(array $assoc)
 * @method static \InitPHP\Validation\Validation labels(array $assoc)
 */
class Validation
{

    private static \InitPHP\Validation\Validation $validationInstance;

    private static function getValidationInstance(): \InitPHP\Validation\Validation
    {
        if(!isset(self::$validationInstance)){
            self::$validationInstance = new \InitPHP\Validation\Validation();
        }
        return self::$validationInstance;
    }

    public function __call($name, $arguments)
    {
        return self::getValidationInstance()->{$name}(...$arguments);
    }

    public static function __callStatic($name, $arguments)
    {
        return self::getValidationInstance()->{$name}(...$arguments);
    }

    public static function with(): \InitPHP\Validation\Validation
    {
        return clone self::getValidationInstance();
    }

}
