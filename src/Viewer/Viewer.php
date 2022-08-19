<?php
/**
 * Viewer.php
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

use InitPHP\Framework\Facade\Container;
use InitPHP\Framework\Viewer\Exception\ViewerException;
use InitPHP\Framework\Viewer\Exception\ViewerInvalidArgumentException;

class Viewer
{

    private string $dir;

    private array $views = [];

    private array $data = [];

    private string $content = '';

    public function __construct()
    {
        $this->dir = \APP_DIR . 'Views/';
    }

    public function __destruct()
    {
        unset($this->dir, $this->views, $this->data, $this->content);
    }

    public function __toString(): string
    {
        return $this->handler();
    }

    public function setData($data): self
    {
        if(\is_object($data)){
            $data = \get_object_vars($data);
        }
        if(!\is_array($data)){
            throw new ViewerInvalidArgumentException('$data can be just an array or an object.');
        }
        if(!empty($data)){
            $this->data = \array_merge($this->data, $data);
        }
        return $this;
    }

    public function getData(?string $key, $default = null)
    {
        if($key === null){
            return $this->data;
        }
        return $this->data[$key] ?? $default;
    }

    public function setViews(string ...$views): self
    {
        $this->views = \array_merge($this->views, $views);
        return $this;
    }

    public function setDir(string $dir): self
    {
        if(!is_dir($dir)){
            throw new ViewerInvalidArgumentException('The "' . $dir . '" directory could not be found.');
        }
        $this->dir = \rtrim($dir, '/\\') . \DIRECTORY_SEPARATOR;
        return $this;
    }

    public function with(): Viewer
    {
        $with = clone $this;
        return $with;
    }

    public function require(string ...$views)
    {
        if(!empty($this->data)){
            \extract($this->data);
        }
        foreach ($views as $view) {
            $path = $this->get_path($view);
            if(!\is_file($path)){
                throw new ViewerException('"' . $path . '" view file not found.');
            }
            require $path;
        }
    }

    public function view($views, $data): self
    {
        if(empty($views)){
            throw new ViewerException("Views ar not empty.");
        }
        if (\is_array($views)) {
            foreach ($views as $view) {
                if(!\is_string($view)){
                    throw new ViewerException("Views can be a string or an array of strings.");
                }
            }
        }elseif(\is_string($views)){
            $views = [$views];
        }else{
            throw new ViewerException("Views can be a string or an array of strings.");
        }
        return $this->with()
            ->setData($data)
            ->setViews(...$views);
    }

    public function cell(string $library, string $method, $data = []): string
    {
        if(!\class_exists($library)){
            throw new ViewerException('Class "' . $library . '" not found.');
        }
        if(!\method_exists($library, $method)){
            throw new ViewerException('The "' . $library . '" class does not have an "' . $method . '" method.');
        }
        if(\is_object($data)){
            $data = \get_object_vars($data);
        }
        if(!\is_array($data)){
            throw new ViewerInvalidArgumentException('$data can be just an array or an object.');
        }

        $library = Container::get($library);

        $with = clone $this;
        $with->content = '';
        $with->views = [];
        $with->data = [];
        \ob_start(function ($tmp) use ($with) {
            $with->content .= $tmp;
        });
        $content = \call_user_func_array([$library, $method], [$data]);
        echo (string)$content;
        \ob_end_clean();
        return $with->handler();
    }

    protected function handler(): string
    {
        $views = [];
        foreach ($this->views as $view) {
            $path = $this->get_path($view);
            if(!\is_file($path)){
                throw new ViewerException('"' . $path . '" view file not found.');
            }
            $views[] = $path;
        }
        $this->views = [];

        if(!empty($this->data)){
            $data = $this->data;
            \extract($data);
        }

        \ob_start(function ($tmp) {
            $this->content .= $tmp;
        });
        foreach ($views as $view) {
            require $view;
        }
        unset($views);
        \ob_end_clean();
        $content = $this->content;
        $this->data = [];
        return $content;
    }

    private function get_path(string $view): string
    {
        if(!\str_ends_with($view, '.php')){
            $view .= '.php';
        }
        return $this->dir . \ltrim($view, '/\\');
    }

}
