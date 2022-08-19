<?php
/**
 * ConfigClassException.php
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

namespace InitPHP\Framework\Exception;

class ConfigClassException extends FrameworkException
{
    public function __construct($class = "")
    {
        $message = 'Configuration class "\\App\\Configs\\' . $class . '" not found.';
        parent::__construct($message, 0, null);
    }
}
