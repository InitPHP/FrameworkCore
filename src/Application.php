<?php
/**
 * Application.php
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

namespace InitPHP\Framework;

use InitPHP\Framework\Exception\FrameworkException;
use InitPHP\Framework\Facade\Events;
use InitPHP\HTTP\Emitter;

class Application
{

    protected const IMPERATIVE_CONSTANTS = [
        'BASE_DIR', 'APP_DIR', 'PUBLIC_DIR'
    ];

    protected const FRAMEWORK_CONSTANTS = [
        'CORE_DIR'                  => __DIR__ . \DIRECTORY_SEPARATOR,
        'FRAMEWORK_VERSION'         => '2.0',
    ];

    public static function boot()
    {
        Events::trigger('boot_before', []);
        foreach (self::IMPERATIVE_CONSTANTS as $const) {
            if(!\defined($const)){
                throw new FrameworkException('The "' . $const . '" constant must be defined.');
            }
        }

        foreach (self::FRAMEWORK_CONSTANTS as $name => $value) {
            if(!\defined($name)){
                \define($name, $value);
            }
        }

        if(\file_exists(\BASE_DIR . '.env.php')){
            \InitPHP\Dotenv\Dotenv::create(\BASE_DIR . '.env.php');
        }else{
            $path = \BASE_DIR . '.env';
            if(\file_exists($path)){
                \InitPHP\Dotenv\Dotenv::create($path);
            }
        }

        $autoloadClass = '\\App\\Configs\\Autoload';
        if(\class_exists($autoloadClass)){
            /** @var \InitPHP\Framework\Base\Config $autoload */
            $autoload = \InitPHP\Framework\Facade\Container::get($autoloadClass);

            $configs = $autoload->get('configs', []);
            if(!empty($configs)){
                foreach ($configs as $config) {
                    \InitPHP\Config\Config::setClass($config);
                }
            }
            unset($configs);

            $helpers = $autoload->get('helpers', []);
            if(!empty($helpers)){
                \helper(...$helpers);
            }
            unset($helpers);
        }

        if(\env('ENVIRONMENT', \config('base.environment', null)) === 'development'){
            \error_reporting(\E_ALL);
            \ini_set('display_errors', '1');
            $whoops = new \Whoops\Run;
            $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
            $whoops->register();
        }else{
            \error_reporting(0);
        }

        if(\class_exists("\\App\\Configs\\Database")){
            new \InitPHP\Framework\Database\Database();
        }

        if(($timezone = \config('base.timezone', null)) !== null){
            \date_default_timezone_set($timezone);
        }
        unset($timezone);

    }

    public static function run()
    {
        Events::trigger('before_emitter', []);
        $res = \InitPHP\Framework\Facade\Route::dispatch();
        $emit = new Emitter;
        $emit->emit($res);
        Events::trigger('after_emitter', []);
    }

}
