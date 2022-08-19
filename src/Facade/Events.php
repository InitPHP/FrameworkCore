<?php
/**
 * Events.php
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

use InitPHP\Events\Event;

/**
 * @mixin Event
 * @method static bool trigger(string $name, ...$arguments)
 * @method static void on(string $name, callable $callback, int $priority = Event::PRIORITY_LOW)
 * @method static bool getSimulate()
 * @method static Event setSimulate(bool $simulate = false)
 * @method static bool getDebugMode()
 * @method static Event setDebugMode(bool $debugMode = false)
 * @method static array getDebug()
 */
class Events
{
    public const PRIORITY_LOW = Event::PRIORITY_LOW;
    public const PRIORITY_NORMAL = Event::PRIORITY_NORMAL;
    public const PRIORITY_HIGH = Event::PRIORITY_HIGH;

    private static Event $eventInstance;

    private static function getEventInstance(): Event
    {
        if(!isset(self::$eventInstance)){
            self::$eventInstance = new Event();
        }
        return self::$eventInstance;
    }

    public function __call($name, $arguments)
    {
        return self::getEventInstance()->{$name}(...$arguments);
    }

    public static function __callStatic($name, $arguments)
    {
        return self::getEventInstance()->{$name}(...$arguments);
    }

}
