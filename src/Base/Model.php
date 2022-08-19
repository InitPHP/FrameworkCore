<?php
/**
 * Model.php
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

namespace InitPHP\Framework\Base;

use InitPHP\Database\Exceptions\ModelException;
use InitPHP\Framework\Facade\Container;

class Model extends \InitPHP\Database\Model
{

    public function __construct()
    {
        if(empty($this->getProperty('connection', null))){
            if(!\class_exists('\\App\\Configs\\Database')){
                throw new ModelException('Configuration class \\App\\Configs\\Database not found.');
            }
            /** @var \InitPHP\Framework\Base\Config $config */
            $config = Container::get('\\App\\Configs\\Database');
            $connection = $config->get('default', []);
            unset($config);
            if(
                isset($connection['dsn']) && \is_string($connection['dsn'])
                && isset($connection['username']) && \is_string($connection['username'])
                && isset($connection['password']) && \is_string($connection['password'])
            ){
                $this->connection = $connection;
            }
        }
        parent::__construct();
    }

}
