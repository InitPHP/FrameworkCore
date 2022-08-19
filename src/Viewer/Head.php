<?php
/**
 * Head.php
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

namespace InitPHP\Framework\Viewer;

use InitPHP\Framework\Viewer\Exception\ViewerInvalidArgumentException;

class Head
{

    private string $title = 'Undefined';

    private array $meta_tags = [];

    /**
     * Head HTML Code Generate
     *
     * @return string
     */
    public function get(): string
    {
        return '<title>' . $this->title . '</title>'
            . $this->meta_tag_generator();
    }

    /**
     * @param string $title
     * @param string $description
     * @param string|string[] $keywords
     * @return $this
     * @throws ViewerInvalidArgumentException <p>$keywords string array ya da string değilse.</p>
     */
    public function set(string $title, string $description = '', $keywords = []): self
    {
        $title = \trim($title);
        if($title !== ''){
            $this->title = $title;
        }
        if($description !== ''){
            $this->meta_tags[] = [
                'name'      => 'description',
                'content'   => $description,
            ];
        }
        if(empty($keywords)){
            return $this;
        }
        if(\is_string($keywords)){
            $keywords = \explode(',', $keywords);
        }
        if(!\is_array($keywords)){
            throw new ViewerInvalidArgumentException("The \$keywords parameter can be just a string or an array.");
        }
        foreach ($keywords as &$keyword) {
            $keyword = \trim((string)$keyword);
        }
        $keywords = \array_unique($keywords);
        $this->meta_tags[] = [
            'name'      => 'keywords',
            'content'   => \implode(', ', $keywords)
        ];
        return $this;
    }

    /**
     * Eklenecek bir meta etiketi tanımlar.
     *
     * @param string|array $meta <p>String ise doğrudan html olarak import edilir. Dizi ise ilişkisel bir dizi olmalıdır.</p>
     * @return $this
     * @throws ViewerInvalidArgumentException <p>String ya da Assoc Array değilse.</p>
     */
    public function add_meta($meta): self
    {
        if(\is_string($meta)){
            $this->meta_tags[] = $meta;
            return $this;
        }
        if(\is_assoc($meta, true)){
            $this->meta_tags[] = $meta;
            return $this;
        }
        throw new ViewerInvalidArgumentException("\$meta can be a string or an associative array.");
    }

    private function meta_tag_generator(): string
    {
        if(empty($this->meta_tags)){
            return '';
        }
        $res = ' ' . \PHP_EOL;
        foreach ($this->meta_tags as $meta_tag) {
            if(\is_string($meta_tag)){
                $res .= $meta_tag . ' ' . \PHP_EOL;
                continue;
            }
            $meta = [];
            foreach ($meta_tag as $key => $value) {
                $meta[] = $key . '="' . \str_replace('"', '&quot;', $value) . '"';
            }
            $res .= '<meta ' . \implode(' ', $meta) . ' /> ' . \PHP_EOL;
        }
        return $res;
    }

}
