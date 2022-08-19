<?php
/**
 * Stream.php
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

namespace InitPHP\Framework\Http;

class Stream extends \InitPHP\HTTP\Stream
{

    public function __construct($body = '')
    {
        parent::__construct($body, null);
    }

}
