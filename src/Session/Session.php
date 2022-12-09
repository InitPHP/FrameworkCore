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

use \InitPHP\Framework\Exception\{ConfigClassException, FrameworkException};
use \InitPHP\Framework\Facade\Container;

class Session extends \InitPHP\Sessions\Session
{

    public function __construct()
    {
        if(!\class_exists('\\App\\Configs\\Session')){
            throw new ConfigClassException('Session');
        }

        /** @var \InitPHP\Framework\Base\Config $config */
        $config = Container::get('\\App\\Configs\\Session');

        if ($config->get('enable', FALSE) === TRUE && $this->isStarted() === FALSE) {

            $adapter = $config->get('adapter');

            if (\is_string($adapter)) {
                if (\class_exists($adapter)) {
                    $adapterArguments = $config->get('adapterArguments', []);
                    $adapterObj = new $adapter(...$adapterArguments);
                } else {
                    throw new FrameworkException();
                }
            } else {
                $adapterObj = null;
            }

            self::createImmutable($adapterObj)->start($config->get('configuration', []));
        }
    }

}
