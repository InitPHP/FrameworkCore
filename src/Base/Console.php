<?php
/**
 * Console.php
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

abstract class Console
{

    protected \InitPHP\Console\Console $console;

    public function __construct(\InitPHP\Console\Console $console)
    {
        $this->console = $console;
    }

    abstract public function register(): \InitPHP\Console\Console;

}
