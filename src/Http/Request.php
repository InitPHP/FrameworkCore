<?php
/**
 * Request.php
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

class Request extends \InitPHP\HTTP\Request
{

    public function __construct()
    {
        $version = '1.1';

        $method = ($_SERVER['REQUEST_METHOD'] ?? 'GET');

        $uri = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http')
            . '://'
            . ($_SERVER['SERVER_NAME'] ?? 'localhost')
            . (isset($_SERVER['SERVER_PORT']) && !\in_array($_SERVER['SERVER_PORT'], [80, 443]) ? ':' . $_SERVER['SERVER_PORT'] : '')
            . ($_SERVER['REQUEST_URI'] ?? '/');

        $headers = \function_exists('apache_request_headers') ? \apache_request_headers() : [];
        if($headers === FALSE){
            $headers = [];
        }

        $body = @\file_get_contents('php://input');
        if($body === FALSE){
            $body = '';
        }
        $body = new Stream(\trim($body));

        parent::__construct($method, $uri, $headers, $body, $version);
    }

}
