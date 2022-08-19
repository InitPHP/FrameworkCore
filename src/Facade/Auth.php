<?php
/**
 * Auth.php
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

use InitPHP\Auth\Segment;
use InitPHP\Framework\Exception\ConfigClassException;

/**
 * @mixin Segment
 * @mixin \InitPHP\Auth\AdapterInterface
 * @method static mixed get(string $key, $default = null)
 * @method static \InitPHP\Auth\AdapterInterface set(string $key, $value)
 * @method static \InitPHP\Auth\AdapterInterface collective(array $data)
 * @method static bool has(string $key)
 * @method static \InitPHP\Auth\AdapterInterface remove(string ...$key)
 * @method static bool destroy();
 */
class Auth
{
    public const COOKIE = Segment::ADAPTER_COOKIE;
    public const SESSION = Segment::ADAPTER_SESSION;

    private static Segment $segmentInstance;

    private static function getSegmentInstance(): Segment
    {
        if(!isset(self::$segmentInstance)){
            if(!\class_exists('\\App\\Configs\\Auth')){
                throw new ConfigClassException('Auth');
            }
            /** @var \InitPHP\Framework\Base\Config $config */
            $config = Container::get('\\App\\Configs\\Auth');
            self::$segmentInstance = Segment::create(
                $config->get('name', 'auth'),
                $config->get('adapter', self::SESSION),
                $config->get('options', [])
            );
        }
        return self::$segmentInstance;
    }

    public function __call($name, $arguments)
    {
        return self::getSegmentInstance()->{$name}(...$arguments);
    }

    public static function __callStatic($name, $arguments)
    {
        return self::getSegmentInstance()->{$name}(...$arguments);
    }

}
