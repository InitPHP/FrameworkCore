<?php
/**
 * Response.php
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

class Response extends \InitPHP\HTTP\Response
{

    public function __construct()
    {
        parent::__construct(200, [], new Stream(), '1.1', null);
    }

    public function withJSON(array $data): Response
    {
        /** @var Response $res */
        $res = $this->withHeader('Content-Type', 'application/json')
                    ->withBody(new Stream(\json_encode($data)));
        return $res;
    }

}
