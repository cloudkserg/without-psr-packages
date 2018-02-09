<?php
/**
 * Created by PhpStorm.
 * User: dns
 * Date: 09.02.18
 * Time: 15:32
 */

namespace Src\Core\Log;


class Logger
{
    private $file;

    public function __construct(string $file)
    {
        $this->file = $file;
    }

    public function info($message)
    {
        file_put_contents($this->file, "INFO: " . $message . "\n", FILE_APPEND);
    }

    public function error($message)
    {
        file_put_contents($this->file, "ERROR: " .$message . "\n", FILE_APPEND);

    }

    public function warning($message)
    {
        file_put_contents($this->file, "WARNING: " . $message . "\n", FILE_APPEND);

    }

}