<?php
/**
 * Cookie.php
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

namespace InitPHP\Framework\Cookie;

use InitPHP\Framework\Base\Config;
use InitPHP\Framework\Cookie\Exception\CookieException;
use InitPHP\Framework\Exception\ConfigClassException;
use InitPHP\Framework\Facade\Container;

/**
 * @property-read ?\InitPHP\Cookies\Cookie $*
 */
class Cookie
{

    private Config $config;

    private static array $cookies = [];

    public function __construct()
    {
        if(!\class_exists('\\App\\Configs\\Cookie')){
            throw new ConfigClassException('Cookie');
        }
        /** @var Config $config */
        $config = Container::get('\\App\\Configs\\Cookie');
        $this->config = $config;
        $this->boot();
    }

    public function __isset($name)
    {
        $name = \strtolower($name);
        return isset(self::$cookies[$name]);
    }

    public function __get($name)
    {
        return $this->get($name);
    }

    public function get(string $name): ?\InitPHP\Cookies\Cookie
    {
        $name = \strtolower($name);
        return self::$cookies[$name] ?? null;
    }

    public function create(string $name): \InitPHP\Cookies\Cookie
    {
        $name = \strtolower($name);
        if(isset(self::$cookies[$name])){
            return self::$cookies[$name];
        }
        $salt = $this->config->get('salt');
        if(empty($salt)){
            throw new CookieException('"\\App\\Configs\\Cookie->salt" cannot be empty.');
        }
        return self::$cookies[$name] = new \InitPHP\Cookies\Cookie($name, $salt, $this->config->get('options', []));
    }

    private function boot()
    {
        if(!empty(self::$cookies)){
            return;
        }
        if($this->config->get('enable', false) !== TRUE){
            return;
        }
        $cookies = $this->config->get('cookies', []);
        if(!\is_array($cookies)){
            throw new CookieException('The "\\App\\Configs\\Cookie()->cookies" property must be a string array.');
        }
        if(empty($cookies)){
            return;
        }
        $salt = $this->config->get('salt');
        if(empty($salt)){
            throw new CookieException('"\\App\\Configs\\Cookie()->salt" cannot be empty.');
        }
        $options = $this->config->get('options', []);
        $cookies = \array_unique($cookies);
        foreach ($cookies as $cookie) {
            $lowercase = \strtolower($cookie);
            self::$cookies[$lowercase] = new \InitPHP\Cookies\Cookie($cookie, $salt, $options);
        }
    }

}
