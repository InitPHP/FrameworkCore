<?php
/**
 * Router.php
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

namespace InitPHP\Framework\Http;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class Router extends \InitPHP\Router\Router
{

    public function __construct(RequestInterface $request, ResponseInterface $response)
    {
        $configs = [
            'paths'             => [
                'controller'        => \APP_DIR . 'Controllers/',
                'middleware'        => \APP_DIR . 'Middlewares/',
            ],
            'namespaces'        => [
                'controller'        => '\\App\\Controllers',
                'middleware'        => '\\App\\Middlewares',
            ],
            'base_path'         => \env('BASE_PATH', '/'),
            'variable_method'   => \env('VARIABLE_METHOD', false),
        ];

        parent::__construct($request, $response, $configs);
    }

}
