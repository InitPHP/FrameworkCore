<?php
/**
 * Stack.php
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

namespace InitPHP\Framework\Stack;

use InitPHP\Framework\Stack\Exception\StackException;

class Stack
{

    private array $stack = [];

    private bool $isOverwrite = true;

    public function __construct(bool $isOverwrite = true)
    {
        $this->isOverwrite = $isOverwrite;
    }

    public function set(string $id, $value)
    {
        if($this->isOverwrite === FALSE && isset($this->stack[$id])){
            throw new StackException('"' . $id . '" id stack has already been created.');
        }
        $this->stack[$id] = $value;
    }

    public function get(string $id, $default = null)
    {
        return $this->stack[$id] ?? $default;
    }

    public function has(string $id): bool
    {
        return isset($this->stack[$id]);
    }

}
