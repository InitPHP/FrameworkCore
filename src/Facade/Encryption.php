<?php
/**
 * Encryption.php
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

use \InitPHP\Encryption\{Encrypt, HandlerInterface};
use \InitPHP\Framework\Exception\{ConfigClassException, FrameworkException};

/**
 * @mixin HandlerInterface
 * @method static string encrypt(mixed $data, array $options = [])
 * @method static mixed decrypt(string $data, array $options = [])
 */
class Encryption
{

    public const SODIUM = 1;
    public const OPENSSL = 0;

    private static HandlerInterface $handlerInstance;

    private static function getHandlerInstance(): HandlerInterface
    {
        if(!isset(self::$handlerInstance)){
            if(!\class_exists('\\App\\Configs\\Encryption')){
                throw new ConfigClassException('Encryption');
            }
            /** @var \InitPHP\Framework\Base\Config $config */
            $config = Container::get('\\App\\Configs\\Encryption');

            $handler = $config->get('handler', self::OPENSSL);
            switch ($handler) {
                case self::OPENSSL:
                    $handler = \InitPHP\Encryption\OpenSSL::class;
                    break;
                case self::SODIUM:
                    $handler = \InitPHP\Encryption\Sodium::class;
                    break;
                default:
                    if(!\is_string($handler) || !\class_exists($handler)){
                        throw new FrameworkException('Invalid handler reported for encryption.');
                    }
            }

            self::$handlerInstance = Encrypt::create($handler, $config->get('options'));
        }
        return self::$handlerInstance;
    }

    public function __call($name, $arguments)
    {
        return self::getHandlerInstance()->{$name}(...$arguments);
    }

    public static function __callStatic($name, $arguments)
    {
        return self::getHandlerInstance()->{$name}(...$arguments);
    }


}
