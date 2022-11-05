<?php
/**
 * Init_helper.php
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

if(!\function_exists('env')){
    function env(string $name, $default = null)
    {
        return \InitPHP\Dotenv\Dotenv::get($name, $default);
    }
}

if(!\function_exists('config')){
    function config(string $key, $default = null)
    {
        return \InitPHP\Config\Config::get($key, $default);
    }
}

if(!\function_exists('trans')){
    function trans(string $key, ?string $default = null, array $context = []): string
    {
        return \InitPHP\Framework\Facade\Translator::_r($key, $default, $context);
    }
}

if(!\function_exists('language_change')){
    function language_change(string $lang): \InitPHP\Framework\Translator\Translator
    {
        return \InitPHP\Framework\Facade\Translator::change($lang);
    }
}

if(!\function_exists('language_current')){
    function language_current() : ?string
    {
        return \InitPHP\Framework\Facade\Translator::getCurrent();
    }
}

if(!\function_exists('redirect')){
    function redirect(?string $url = null, int $second = 0, int $status = 302): \Psr\Http\Message\ResponseInterface
    {
        if(empty($url)){
            $url = \config('base.base_url', '/');
        }
        if($status > 399 || $status < 300){
            $status = 302;
        }
        return new \InitPHP\HTTP\RedirectResponse($url, $status, $second);
    }
}

if(!\function_exists('route')){
    function route(string $name, array $arguments = []): string
    {
        return \InitPHP\Framework\Facade\Route::route($name, $arguments);
    }
}

if(!\function_exists('view')){
    /**
     * @param string|string[] $view
     * @param array|object $data
     * @return string
     */
    function view($view, $data = []): string
    {
        return \InitPHP\Framework\Facade\Load::view($view, $data);
    }
}

if(!\function_exists('view_require')){
    function view_require(string ...$views)
    {
        \InitPHP\Framework\Facade\Viewer::require(...$views);
    }
}

if(!\function_exists('view_cell')){
    function view_cell(string $library, string $method, $data = [], ?int $cache_ttl = null, ?string $cache_name = null): ?string
    {
        if($cache_ttl === null){
            return \InitPHP\Framework\Facade\Viewer::cell($library, $method, $data);
        }
        if($cache_ttl < 1){
            throw new \InitPHP\Framework\Viewer\Exception\ViewerInvalidArgumentException('Cache duration of view cells (' . $method . ') cannot be 0 or a negative number.');
        }
        if(empty($cache_name)){
            $cache_name = 'view_cell_' . \md5($library . $method) . '.cache';
        }
        $res = \InitPHP\Framework\Facade\Cache::get($cache_name, null);
        if($res === null){
            $res = \InitPHP\Framework\Facade\Viewer::cell($library, $method, $data);
            \InitPHP\Framework\Facade\Cache::set($cache_name, $res, $cache_ttl);
        }
        return $res;
    }
}

if(!\function_exists('view_data')){
    function view_data(?string $key, $default = null)
    {
        return \InitPHP\Framework\Facade\Viewer::getData($key, $default);
    }
}

if(!\function_exists('helper')){
    function helper(string ...$helper): void
    {
        \InitPHP\Framework\Facade\Load::helper(...$helper);
    }
}

if(!\function_exists('set_head')){
    /**
     * @param string $title
     * @param string $description
     * @param string|string[] $keywords
     * @return \InitPHP\Framework\Viewer\Head
     */
    function set_head(string $title, string $description = '', $keywords = ''): \InitPHP\Framework\Viewer\Head
    {
        return \InitPHP\Framework\Facade\Head::set($title, $description, $keywords);
    }
}

if(!\function_exists('get_head')){
    function get_head(): string
    {
        $head = \InitPHP\Framework\Facade\Head::get();
        \ob_start(function ($tmp) use ($head) {
            $head .= $tmp;
        });
        \InitPHP\Events\Events::trigger('get_head', []);
        \ob_end_clean();
        return $head;
    }
}

if(!\function_exists('esc')){
    /**
     * @param string[]|string $data
     * @param string $context
     * @param string|null $encoding
     * @return string[]|string
     * @throws Exception
     */
    function esc($data, string $context = 'html', ?string $encoding = null)
    {
        return \InitPHP\Escaper\Esc::esc($data, $context, $encoding);
    }
}

if(!\function_exists('isCLI')){
    /**
     * Betiğin bir CLI tarafından mı çalıştırıldığı bilgisini verir.
     *
     * @return bool
     */
    function isCLI(): bool
    {
        return \defined('PHP_SAPI') && !\in_array(\PHP_SAPI, ['cli', 'phpdbg'], true);
    }
}

if(!\function_exists('dump')){
    /**
     * Verilen değerleri dump eder.
     *
     * Eğer InitPHP ya da Symfony Dumperlarını bulursa bunlarla dump eder bulamazsa en basic şekilde dump yapar.
     * @param mixed ...$values
     * @return void
     */
    function dump(...$values): void
    {
        if(\class_exists("\InitPHP\VarDumper\VarDumper")){
            foreach ($values as $value) {
                \InitPHP\VarDumper\VarDumper::newInstance($value)->dump();
            }
            return;
        }
        if(\class_exists("\Symfony\Component\VarDumper\VarDumper")){
            foreach ($values as $value) {
                \Symfony\Component\VarDumper\VarDumper::dump($value);
            }
            return;
        }

        $before = $after = \PHP_EOL;
        if(isCLI()){
            $before .= '<pre style="color: #F1F1F1; background: #222; border: 1px solid #111; padding: 8px; margin: 8px; border-radius: 2px; overflow: auto;">';
            $after .= '</pre>';
        }
        foreach ($values as $value) {
            echo $before;
            \var_dump($value);
            echo $after;
        }
    }
}

if(!\function_exists('dd')){
    /**
     * Verilen değerleri dump() eder. Ve belleği boşaltıp, betiği sonlandırır.
     *
     * @param mixed ...$values
     * @return void
     */
    function dd(...$values): void
    {
        dump(...$values);
        if(\ob_get_level() > 0){
            $content = \ob_get_contents();
            \ob_get_flush();
            echo $content;
        }
        die();
    }
}
