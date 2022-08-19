<?php
/**
 * Normalizer.php
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

namespace InitPHP\Framework\Uploader;

final class Normalizer
{

    private array $normalized = [];

    public function __construct(string $key)
    {
        $this->boot($key);
    }

    public function normalized(): array
    {
        return $this->normalized;
    }

    private function boot(string $name)
    {
        $files = $_FILES[$name] ?? null;
        if($files === null){
            return;
        }
        if(!isset($files['name'])){
            return;
        }
        if(\is_string($files['name'])){
            $this->normalized[] = $files;
            return;
        }

        $indexs = \array_keys($files['name']);
        $keys = \array_keys($files);
        foreach ($indexs as $i) {
            $file = [];
            foreach ($keys as $key) {
                $file[$key] = $files[$key][$i];
            }
            $this->normalized[] = $file;
        }
    }

}
