<?php
/**
 * Database.php
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

namespace InitPHP\Framework\Database;

use InitPHP\Database\DB;
use InitPHP\Framework\Exception\ConfigClassException;
use InitPHP\Framework\Exception\FrameworkException;
use InitPHP\Framework\Facade\Container;

/**
 * @mixin DB
 */
class Database
{

    private DB $db;

    public function __construct()
    {
        if(!\class_exists('\\App\\Configs\\Database')){
            throw new ConfigClassException('Database');
        }

        /** @var \InitPHP\Framework\Base\Config $config */
        $config = Container::get('\\App\\Configs\\Database');

        if($config->get('enable', false) === TRUE){
            $this->db = new DB($config->get('default', []));

            if($config->get('isGlobal', false) === TRUE){
                $this->db->getConnection()->connectionAsGlobal();
            }
        }

    }

    public function __call($name, $arguments)
    {
        if(!isset($this->db)){
            throw new FrameworkException('Database connection is not active.');
        }
        return $this->db->{$name}(...$arguments);
    }

}
