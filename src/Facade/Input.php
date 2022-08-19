<?php
/**
 * Input.php
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
 * @mixin \InitPHP\Input\Inputs
 * @method static mixed get(string $key, mixed $default = null, ?array $validation = null)
 * @method static mixed getPost(string $key, mixed $default = null, ?array $validation = null)
 * @method static mixed getRaw(string $key, mixed $default = null, ?array $validation = null)
 * @method static mixed getPostRaw(string $key, mixed $default = null, ?array $validation = null)
 * @method static mixed getRawPost(string $key, mixed $default = null, ?array $validation = null)
 * @method static mixed raw(string $key, mixed $default = null, ?array $validation = null)
 * @method static mixed rawGet(string $key, mixed $default = null, ?array $validation = null)
 * @method static mixed rawPost(string $key, mixed $default = null, ?array $validation = null)
 * @method static mixed rawGetPost(string $key, mixed $default = null, ?array $validation = null)
 * @method static mixed rawPostGet(string $key, mixed $default = null, ?array $validation = null)
 * @method static mixed post(string $key, mixed $default = null, ?array $validation = null)
 * @method static mixed postGet(string $key, mixed $default = null, ?array $validation = null)
 * @method static mixed postRaw(string $key, mixed $default = null, ?array $validation = null)
 * @method static mixed postGetRaw(string $key, mixed $default = null, ?array $validation = null)
 * @method static mixed postRawGet(string $key, mixed $default = null, ?array $validation = null))
 * @method static bool hasGet(string $key)
 * @method static bool hasRaw(string $key)
 * @method static bool hasPost(string $key)
 */
class Input
{

    private static \InitPHP\Input\Inputs $inputInstance;

    private static function getInputInstance(): \InitPHP\Input\Inputs
    {
        if(!isset(self::$inputInstance)){
            self::$inputInstance = new \InitPHP\Input\Inputs();
        }
        return self::$inputInstance;
    }

    public function __call($name, $arguments)
    {
        return self::getInputInstance()->{$name}(...$arguments);
    }

    public static function __callStatic($name, $arguments)
    {
        return self::getInputInstance()->{$name}(...$arguments);
    }

}
