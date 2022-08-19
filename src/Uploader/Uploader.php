<?php
/**
 * Uploader.php
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

use InitPHP\Framework\Base\Config;
use InitPHP\Framework\Exception\ConfigClassException;
use InitPHP\Framework\Facade\Container;
use \InitPHP\Framework\Uploader\Exception\{UploadException, UploadNotFoundException};
use Verot\Upload\Upload;

class Uploader
{

    private Config $config;

    /** @var Upload[] */
    private array $upload = [];

    private array $options = [];

    /** @var string[] */
    private array $file = [];

    /** @var string[] */
    private array $path = [];

    /** @var string[] */
    private array $url = [];

    /** @var string[] */
    private array $error = [];

    public function __construct(string $key)
    {
        if(!\class_exists('\\App\\Configs\\Upload')){
            throw new ConfigClassException('Upload');
        }
        /** @var Config $config */
        $config = Container::get('\\App\\Configs\\Upload');
        $this->config = $config;

        $uploads = (new Normalizer($key))->normalized();
        if(empty($uploads)){
            throw new UploadNotFoundException('"' . $key . '" upload file not found.');
        }
        $locale = $this->config->get('language', 'en_GB');
        foreach ($uploads as $upload) {
            $this->upload[] = new Upload($upload, $locale);
        }

        $allowed = $this->config->get('allowed', null);
        if(!empty($allowed)){
            $this->options['allowed'] = $allowed;
        }
    }

    public function __destruct()
    {
        foreach ($this->upload as $upload) {
            $upload->clean();
        }
        unset($this->config,
            $this->upload,
            $this->options,
            $this->path,
            $this->file,
            $this->url);
    }

    public function __set($name, $value)
    {
        return $this->options[$name] = $value;
    }

    public function with(): Uploader
    {
        return clone $this;
    }

    public function flush(): self
    {
        $this->options = [];
        return $this;
    }

    public function allowed(array $mimes): self
    {
        $this->options['allowed'] = $mimes;
        return $this;
    }

    public function onlyImages(): self
    {
        $this->options['allowed'] = ['image/*'];
        return $this;
    }

    public function rename(string $name): self
    {
        $this->options['file_new_name_body'] = $name;
        return $this;
    }

    public function prefix(?string $prefix = null): self
    {
        if($prefix === null){
            if(isset($this->options['file_name_body_pre'])){
                unset($this->options['file_name_body_pre']);
            }
        }else{
            $this->options['file_name_body_pre'] = $prefix;
        }
        return $this;
    }

    public function resize(?int $width, ?int $height = null, ?bool $crop = null): self
    {
        if($width === null && $height === null){
            return $this;
        }
        if($crop !== null){
            $this->options['image_ratio_crop'] = $crop;
        }
        $this->options['image_resize'] = true;
        if($width === null){
            $this->options['image_ratio_x'] = true;
        }else{
            $this->options['image_x'] = $width;
        }
        if($height === null){
            $this->options['image_ratio_y'] = true;
        }else{
            $this->options['image_y'] = $height;
        }

        return $this;
    }

    public function convert(string $extension): self
    {
        $this->options['image_convert'] = $extension;
        return $this;
    }

    public function option(string $key, $value): self
    {
        $this->options[$key] = $value;
        return $this;
    }

    public function options(array $options): self
    {
        foreach ($options as $key => $value) {
            $this->options[$key] = $value;
        }
        return $this;
    }

    public function to(?string $dir = null): bool
    {
        if(empty($this->upload)){
            return false;
        }

        $path = $this->config->get('dir', \PUBLIC_DIR . 'uploads/')
            . (empty($dir) ? '' : \ltrim($dir, '\\/'));

        $url = \rtrim($this->config->get('base_url', 'uploads'), '/')
            . ($dir === null ? '' : '/' . \trim($dir, '/'))
            . '/';

        $results = [];

        foreach ($this->upload as $upload) {
            foreach ($this->options as $key => $value) {
                $upload->{$key} = $value;
            }

            if($upload->uploaded){
                $upload->process($path);
                $res = $upload->uploaded;
                $results[] = $res;
                if($res){
                    $this->file[] = $upload->file_dst_name;
                    $this->path[] = $upload->file_dst_path;
                    $this->url[] = $url . $upload->file_dst_name;
                    continue;
                }
            }
            if(isset($upload->error) && !empty($upload->error)){
                $this->error[] = $upload->error;
            }
        }
        foreach ($results as $result) {
            if($result === FALSE){
                return false;
            }
        }
        return true;
    }

    public function isError(): bool
    {
        return !empty($this->error);
    }

    /**
     * @return string[]
     */
    public function getError(): array
    {
        return $this->error;
    }

    /**
     * @return string|string[]|null
     */
    public function getName()
    {
        if(empty($this->file)){
            return null;
        }
        if(\count($this->file) === 1){
            return $this->file[0];
        }
        return $this->file;
    }

    /**
     * @return string|string[]|null
     */
    public function getPath()
    {
        if(empty($this->path)){
            return null;
        }
        if(\count($this->path) === 1){
            return $this->path[0];
        }
        return $this->path;
    }

    /**
     * @return string|string[]|null
     */
    public function getUrl()
    {
        if(empty($this->url)){
            return null;
        }
        if(\count($this->url) === 1){
            return $this->url[0];
        }
        return $this->url;
    }

}
