<?php
/**
 * Mailer.php
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

namespace InitPHP\Framework\Facade;

/**
 * @mixin \InitPHP\Mailer\Mailer
 * @method static \InitPHP\Mailer\Mailer clear(bool $clearAttachments = false)
 * @method static \InitPHP\Mailer\Mailer setHeader(string $header, string $value)
 * @method static \InitPHP\Mailer\Mailer setFrom(string $from, string $name = '', ?string $returnPath = null)
 * @method static \InitPHP\Mailer\Mailer setReplyTo(string $replyTo, string $name = '')
 * @method static \InitPHP\Mailer\Mailer setTo(string|string[] $to)
 * @method static \InitPHP\Mailer\Mailer setCC(string $cc)
 * @method static \InitPHP\Mailer\Mailer setBCC(string $bcc, ?int $limit = null)
 * @method static \InitPHP\Mailer\Mailer setSubject(string $subject)
 * @method static \InitPHP\Mailer\Mailer setMessage(string $body)
 * @method static \InitPHP\Mailer\Mailer setAttachmentCID(string $fileName)
 * @method static \InitPHP\Mailer\Mailer setAltMessage(string $str)
 * @method static \InitPHP\Mailer\Mailer setMailType(string $type = 'text')
 * @method static \InitPHP\Mailer\Mailer setWordWrap(bool $wordWrap = true)
 * @method static \InitPHP\Mailer\Mailer setProtocol(string $protocol = 'mail')
 * @method static \InitPHP\Mailer\Mailer setPriority(int $n = 3)
 * @method static \InitPHP\Mailer\Mailer setNewline(string $newLine = PHP_EOL)
 * @method static \InitPHP\Mailer\Mailer setCRLF(string $CRLF = PHP_EOL)
 * @method static \InitPHP\Mailer\Mailer|false attach(string $file, string $disposition = '', ?string $newName = null, ?string $mime = null)
 * @method static string getMessageID()
 * @method static bool validateEmail(array $mails)
 * @method static bool isValidEmail(string $mail)
 * @method static string|string[] cleanEmail(string|string[] $mail)
 * @method static string wordWrap(string $str, ?int $chars = null)
 * @method static bool send(bool $autoClear = true)
 * @method static void batchBCCSend()
 * @method static string printDebugger(array $include = ['headers', 'subject', 'body'])
 */
class Mailer
{

    private static \InitPHP\Mailer\Mailer $mailerInstance;

    private static function getMailerInstance(): \InitPHP\Mailer\Mailer
    {
        if(!isset(self::$mailerInstance)){
            self::$mailerInstance = new \InitPHP\Mailer\Mailer();
        }
        return self::$mailerInstance;
    }

    public function __call($name, $arguments)
    {
        return self::getMailerInstance()->{$name}(...$arguments);
    }

    public static function __callStatic($name, $arguments)
    {
        return self::getMailerInstance()->{$name}(...$arguments);
    }

}
