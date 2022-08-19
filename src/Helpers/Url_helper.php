<?php
/**
 * Url_helper.php
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

if(!\function_exists('base_url')){
    function base_url(?string $path = null): string
    {
        $base_url = \config('base.base_url', '');
        if($path === null || $path == '/'){
            return $base_url;
        }
        return \rtrim($base_url, "/")
            . '/' . \ltrim($path, "/");
    }
}

if(!\function_exists('current_url')){
    /**
     * @param int|null $component
     * @return array|int|string|null
     */
    function current_url(?int $component = null)
    {
        $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http')
            . '://'
            . ($_SERVER['SERVER_NAME'] ?? 'localhost')
            . (isset($_SERVER['SERVER_PORT']) && !\in_array($_SERVER['SERVER_PORT'], [80, 443], true) ? ':' . $_SERVER['SERVER_PORT'] : '')
            . ($_SERVER['REQUEST_URI'] ?? '/');
        if($component === null){
            return $url;
        }
        $parse = \parse_url($url, $component);
        if($parse === null || $parse === FALSE){
            return null;
        }
        return $parse;
    }
}
