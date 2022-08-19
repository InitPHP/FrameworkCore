<?php
/**
 * Array_helper.php
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

if(!\function_exists('is_assoc')){
    function is_assoc($value, bool $strict = false, bool $nested = false): bool
    {
        if(!\is_array($value) || $value === array()){
            return false;
        }
        if($nested === FALSE){
            $min = $strict === FALSE ? 0 : (\count($value) - 1);
            return \count(\array_filter(\array_keys($value), 'is_string')) > $min;
        }
        foreach ($value as $key => $val) {
            if(!\is_string($key)){
                return false;
            }
            if(!\is_array($val)){
                continue;
            }
            if(\is_assoc($val, $strict, true) === FALSE){
                return false;
            }
        }
        return true;
    }
}

