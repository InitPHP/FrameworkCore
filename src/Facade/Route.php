<?php
/**
 * Route.php
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

use InitPHP\Framework\Http\Request;
use InitPHP\Framework\Http\Response;
use InitPHP\Framework\Http\Router;

/**
 * @mixin \InitPHP\Framework\Http\Router
 * @method static \InitPHP\Framework\Http\Router middleware(string[]|string|\Closure[]|\Closure$middleware, int $position = Route::POSITION_BOTH)
 * @method static \InitPHP\Framework\Http\Router name(string $name)
 * @method static string route(string $name, array $arguments = [])
 * @method static \InitPHP\Framework\Http\Router add(string|string[] $methods, string $path, string|\Closure|array$execute, array $options = [])
 * @method static \InitPHP\Framework\Http\Router get(string $path, string|\Closure|array $execute, array $options = [])
 * @method static \InitPHP\Framework\Http\Router post(string $path, string|\Closure|array $execute, array $options = [])
 * @method static \InitPHP\Framework\Http\Router put(string $path, string|\Closure|array $execute, array $options = [])
 * @method static \InitPHP\Framework\Http\Router delete(string $path, string|\Closure|array $execute, array $options = [])
 * @method static \InitPHP\Framework\Http\Router options(string $path, string|\Closure|array $execute, array $options = [])
 * @method static \InitPHP\Framework\Http\Router patch(string $path, string|\Closure|array $execute, array $options = [])
 * @method static \InitPHP\Framework\Http\Router head(string $path, string|\Closure|array $execute, array $options = [])
 * @method static \InitPHP\Framework\Http\Router any(string $path, string|\Closure|array $execute, array $options = [])
 * @method static void group(string $prefix, \Closure $group, array $options = [])
 * @method static void domain(string $domain, \Closure $group, array $options = [])
 * @method static void port(int $port, \Closure $group, array $options = [])
 * @method static void ip(string|string[] $ip, \Closure $group, array $options = [])
 * @method static void controller(string $controller, string $prefix = '')
 * @method static void error_404(string|\Closure|array $execute, array $options = [])
 * @method static \InitPHP\Framework\Http\Router pattern(string $key, string $pattern)
 * @method static \InitPHP\Framework\Http\Router where(string $key, string $pattern)
 * @method static \Psr\Http\Message\ResponseInterface dispatch()
 */
class Route
{
    public const POSITION_BOTH = \InitPHP\Router\Router::BOTH;
    public const POSITION_BEFORE = \InitPHP\Router\Router::BEFORE;
    public const POSITION_AFTER = \InitPHP\Router\Router::AFTER;

    private static Router $routerInstance;

    private static function getRouterInstance(): Router
    {
        if(!isset(self::$routerInstance)){
            self::$routerInstance = new Router(new Request(), new Response());
        }
        return self::$routerInstance;
    }

    public function __call($name, $arguments)
    {
        return self::getRouterInstance()->{$name}(...$arguments);
    }

    public static function __callStatic($name, $arguments)
    {
        return self::getRouterInstance()->{$name}(...$arguments);
    }

}
