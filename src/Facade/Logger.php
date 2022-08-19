<?php
/**
 * Logger.php
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

use Psr\Log\LoggerInterface;

/**
 * @mixin \InitPHP\Framework\Logger\Logger
 * @method static void emergency(string $message, array $context = array())
 * @method static void alert(string $message, array $context = array())
 * @method static void critical(string $message, array $context = array())
 * @method static void error(string $message, array $context = array())
 * @method static void warning(string $message, array $context = array())
 * @method static void notice(string $message, array $context = array())
 * @method static void info(string $message, array $context = array())
 * @method static void debug(string $message, array $context = array())
 * @method static void log(string $level, string $message, array $context = array())
 */
class Logger
{

    private static LoggerInterface $loggerInstance;

    private static function getLoggerInstance(): LoggerInterface
    {
        if(!isset(self::$loggerInstance)){
            self::$loggerInstance = new \InitPHP\Framework\Logger\Logger();
        }
        return self::$loggerInstance;
    }

    public function __call($name, $arguments)
    {
        return self::getLoggerInstance()->{$name}(...$arguments);
    }

    public static function __callStatic($name, $arguments)
    {
        return self::getLoggerInstance()->{$name}(...$arguments);
    }

}
