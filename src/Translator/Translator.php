<?php
/**
 * Translator.php
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

namespace InitPHP\Framework\Translator;

class Translator extends \InitPHP\Translator\Translator
{

    public function __construct()
    {
        parent::__construct();
        $this->useDirectory()
            ->setDir(\APP_DIR . 'Languages/');
        $default = \config('base.default_language');
        if($default !== null){
            $this->setDefault($default);
        }
    }

    public function getCurrent(): ?string
    {
        return $this->current ?? ($this->default ?? null);
    }

}
