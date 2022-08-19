<?php
/**
 * Session.php
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

namespace InitPHP\Framework\Session;

use InitPHP\Framework\Exception\ConfigClassException;
use InitPHP\Framework\Facade\Container;

class Session extends \InitPHP\Sessions\Session
{

    public function __construct()
    {
        if(!\class_exists('\\App\\Configs\\Session')){
            throw new ConfigClassException('Session');
        }

        /** @var \InitPHP\Framework\Base\Config $config */
        $config = Container::get('\\App\\Configs\\Session');

        if($config->get('enable', FALSE) === TRUE && $this->isStarted() === FALSE){
            $this->start($config->get('configuration', []));
        }
        parent::__construct();
    }

}
