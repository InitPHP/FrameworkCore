<?php
/**
 * DB.php
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

use InitPHP\Framework\Database\Database;

/**
 * @mixin Database
 */
class DB
{

    private static Database $databaseInstance;

    private static function getDatabaseInstance(): Database
    {
        if(!isset(self::$databaseInstance)){
            self::$databaseInstance = new Database();
        }
        return self::$databaseInstance;
    }

    public function __call($name, $arguments)
    {
        return self::getDatabaseInstance()->{$name}(...$arguments);
    }

    public static function __callStatic($name, $arguments)
    {
        return self::getDatabaseInstance()->{$name}(...$arguments);
    }

}
