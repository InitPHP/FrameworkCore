<?php
/**
 * Load.php
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

namespace InitPHP\Framework\Load;

use \InitPHP\Framework\Base\{Config, Entity, Model};
use InitPHP\Framework\Facade\Container;
use InitPHP\Framework\Load\Exception\LoadException;

class Load
{

    public function config(string $config): Config
    {
        if(!\class_exists($config)){
            $config = '\\App\\Configs\\' . $config;
            if(!\class_exists($config)){
                throw new LoadException('"' . $config . '" config class not found.');
            }
        }
        $configObj = Container::get($config);
        if(!($configObj instanceof Config)){
            throw new LoadException('The "' . $config . '" class should extends the "\\InitPHP\\Framework\\Base\\Config" class.');
        }
        return $configObj;
    }

    public function entity(string $entity): Entity
    {
        if(!\class_exists($entity)){
            $entity = '\\App\\Entities\\' . $entity;
            if(!\class_exists($entity)){
                throw new LoadException('"' . $entity . '" entity class not found.');
            }
        }
        $entityObj = Container::get($entity);
        if(!($entityObj instanceof Entity)){
            throw new LoadException('The "' . $entity . '" class should extends the "\\InitPHP\\Framework\\Base\\Entity" class.');
        }
        return $entityObj;
    }

    public function helper(string ...$helpers): bool
    {
        foreach ($helpers as $helper) {
            if(!\str_ends_with($helper, '.php')){
                if(!\str_ends_with($helper, '_helper')){
                    $helper .= '_helper';
                }
                $helper .= '.php';
            }
            $path = \CORE_DIR . 'Helpers/' . $helper;
            if(\is_file($path)){
                require_once $path;
                continue;
            }
            $path = \APP_DIR . 'Helpers/' . $helper;
            if(\is_file($path)){
                require_once $path;
                continue;
            }
            throw new LoadException('Helper "' . $path . '" file not found.');
        }
        return true;
    }

    public function language(string $lang): bool
    {
        \InitPHP\Framework\Facade\Translator::change($lang);
        return true;
    }

    public function library(string $library): object
    {
        if(!\class_exists($library)){
            $library = '\\App\\Libraries\\' . $library;
            if(!\class_exists($library)){
                throw new LoadException('"' . $library . '" library class not found.');
            }
        }
        return Container::get($library);
    }

    public function model(string $model): Model
    {
        if(!\class_exists($model)){
            $model = '\\App\\Models\\' . $model;
            if(!\class_exists($model)){
                throw new LoadException('"' . $model . '" model class not found.');
            }
        }
        $modelObj = Container::get($model);
        if(!($modelObj instanceof Model)){
            throw new LoadException('The "' . $model . '" class should extends the "\\InitPHP\\Framework\\Base\\Model" class.');
        }
        return $modelObj;
    }

    public function view($view, $data): string
    {
        if(\is_string($view)){
            $view = [$view];
        }
        return \InitPHP\Framework\Facade\Viewer::setData($data)
            ->setViews(...$view)
            ->__toString();
    }

}
