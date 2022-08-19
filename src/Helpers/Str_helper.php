<?php
/**
 * Str_helper.php
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

const RANDOM_STR_DEFAULT = 0;
const RANDOM_STR_MD5 = 1;
const RANDOM_STR_SHA1 = 2;
const RANDOM_STR_CRYPTO = 3;
const RANDOM_STR_ALPHA = 4;
const RANDOM_STR_NUM = 6;
const RANDOM_STR_NOZERO = 7;

if(!\function_exists('slug')){
    function slug(string $text, string $divider = '-'): string
    {
        $text = \preg_replace('~[^\pL\d]+~u', $divider, $text);
        $text = \iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        $text = \preg_replace('~[^-\w]+~', '', $text);
        $text = \trim($text, $divider . " \t\n\r\0\x0B");
        $text = \preg_replace('~-+~', $divider, $text);
        $text = \strtolower($text);
        return !empty($text) ? $text : 'n-a';
    }
}

if(!\function_exists('random_str')){
    function random_str(int $len = 15, int $type = \RANDOM_STR_DEFAULT): string
    {
        switch ($type) {
            case \RANDOM_STR_DEFAULT:
                $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                return \substr(\str_shuffle(\str_repeat($pool, (int) \ceil($len / \strlen($pool)))), 0, $len);
            case \RANDOM_STR_ALPHA:
                $pool = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                return \substr(\str_shuffle(\str_repeat($pool, (int) \ceil($len / \strlen($pool)))), 0, $len);
            case \RANDOM_STR_NUM:
                $pool = '0123456789';
                return \substr(\str_shuffle(\str_repeat($pool, (int) \ceil($len / \strlen($pool)))), 0, $len);
            case \RANDOM_STR_NOZERO:
                $pool = '123456789';
                return \substr(\str_shuffle(\str_repeat($pool, (int) \ceil($len / \strlen($pool)))), 0, $len);
            case \RANDOM_STR_MD5:
                return \md5(\uniqid((string)\mt_rand(), true));
            case \RANDOM_STR_SHA1:
                return \sha1(\uniqid((string)\mt_rand(), true));
            case \RANDOM_STR_CRYPTO:
                return \bin2hex(\random_bytes(($len / 2)));
        }
        return (string)\mt_rand();
    }
}
