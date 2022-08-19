<?php
/**
 * Logger.php
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

namespace InitPHP\Framework\Logger;

use InitPHP\Framework\Exception\ConfigClassException;
use InitPHP\Framework\Facade\Container;
use InitPHP\Framework\Logger\Exception\LoggerException;
use Psr\Log\LoggerInterface;

class Logger implements LoggerInterface
{

    /** @var LoggerInterface[] */
    private array $loggers = [];

    public function __construct()
    {
        if(!\class_exists('\\App\\Configs\\Logger')){
            throw new ConfigClassException('Logger');
        }
        /** @var \InitPHP\Framework\Base\Config $config */
        $config = Container::get('\\App\\Configs\\Logger');
        $loggers = [];
        if($config->get('file.enable', false) !== FALSE){
            $path = $config->get('file.path', \APP_DIR . 'Logs/{year}_{month}_{day}.log');
            $loggers[] = new \InitPHP\Logger\FileLogger($path);
        }

        $pdo_handler_options = $config->get('pdo', []);
        if(isset($pdo_handler_options['enable']) && $pdo_handler_options['enable'] !== FALSE){
            if(
                !isset($pdo_handler_options['dsn'])
                || !isset($pdo_handler_options['username'])
                || !isset($pdo_handler_options['password'])
                || !isset($pdo_handler_options['table'])
            ){
                throw new LoggerException('PDOLogger cannot be installed due to incomplete configuration.');
            }
            try {
                $pdo = new \PDO($pdo_handler_options['dsn'], $pdo_handler_options['username'], $pdo_handler_options['password']);
            }catch (\PDOException $e) {
                throw new LoggerException('PDO Logger Connection Error : ' . $e->getMessage(), (int)$e->getCode());
            }
            $loggers[] = new \InitPHP\Logger\PDOLogger($pdo, $pdo_handler_options['table']);
        }
        $others = $config->get('others', []);
        if(!\is_array($others)){
            throw new LoggerException('\\App\\Configs\\Logger()->others property must be an array.');
        }
        foreach ($others as $loggerClass) {
            if(!\is_string($loggerClass)){
                throw new LoggerException('\\App\\Configs\\Logger()->others property must be an string array');
            }
            if(!\class_exists($loggerClass)){
                throw new LoggerException('Class "' . $loggerClass . '" not found.');
            }
            $loggerInstance = Container::get($loggerClass);
            if(!($loggerInstance instanceof LoggerInterface)){
                throw new LoggerException('The "' . $loggerClass . '" class must implement the \\Psr\\Log\\LoggerInterface.');
            }
            $loggers[] = $loggerInstance;
        }
        $this->loggers = $loggers;
    }

    /**
     * @inheritDoc
     */
    public function emergency($message, array $context = array())
    {
        foreach ($this->loggers as $logger) {
            $logger->emergency($message, $context);
        }
    }

    /**
     * @inheritDoc
     */
    public function alert($message, array $context = array())
    {
        foreach ($this->loggers as $logger) {
            $logger->alert($message, $context);
        }
    }

    /**
     * @inheritDoc
     */
    public function critical($message, array $context = array())
    {
        foreach ($this->loggers as $logger) {
            $logger->critical($message, $context);
        }
    }

    /**
     * @inheritDoc
     */
    public function error($message, array $context = array())
    {
        foreach ($this->loggers as $logger) {
            $logger->error($message, $context);
        }
    }

    /**
     * @inheritDoc
     */
    public function warning($message, array $context = array())
    {
        foreach ($this->loggers as $logger) {
            $logger->warning($message, $context);
        }
    }

    /**
     * @inheritDoc
     */
    public function notice($message, array $context = array())
    {
        foreach ($this->loggers as $logger) {
            $logger->notice($message, $context);
        }
    }

    /**
     * @inheritDoc
     */
    public function info($message, array $context = array())
    {
        foreach ($this->loggers as $logger) {
            $logger->info($message, $context);
        }
    }

    /**
     * @inheritDoc
     */
    public function debug($message, array $context = array())
    {
        foreach ($this->loggers as $logger) {
            $logger->debug($message, $context);
        }
    }

    /**
     * @inheritDoc
     */
    public function log($level, $message, array $context = array())
    {
        foreach ($this->loggers as $logger) {
            $logger->log($level, $message, $context);
        }
    }
}