<?php
/**
 * Permission.php
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
 * @mixin \InitPHP\Auth\Permission
 * @method static array getPermission()
 * @method static bool is(string ...$permission_name)
 * @method static int push(string ...$permissions)
 * @method static int remove(string ...$permissions)
 * @method static bool is_*()
 */
class Permission
{

    private static \InitPHP\Auth\Permission $permissionInstance;

    private static function getPermissionInstance(): \InitPHP\Auth\Permission
    {
        if(!isset(self::$permissionInstance)){
            self::$permissionInstance = new \InitPHP\Auth\Permission();
        }
        return self::$permissionInstance;
    }

    public function __call($name, $arguments)
    {
        return self::getPermissionInstance()->{$name}(...$arguments);
    }

    public static function __callStatic($name, $arguments)
    {
        return self::getPermissionInstance()->{$name}(...$arguments);
    }

}
