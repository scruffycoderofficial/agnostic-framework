<?php
/*
 * This file is part of the D6 Assessment Project.
 *
 * (c) Luyanda Siko <sikoluyanda@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace D6\Invoice\Component\Logger;

use Psr\Log\LoggerInterface;

/**
 * Class LoggerDecorator
 */
class LoggerDecorator implements LoggerInterface
{
    public function __construct(private LoggerInterface $decoratedLogger)
    {
    }

    public function emergency(string|\Stringable $message, array $context = []): void
    {
        $this->decoratedLogger->emergency('🆘 '.$message, $context);
    }

    public function alert(string|\Stringable $message, array $context = []): void
    {
        $this->decoratedLogger->alert('🚨 '.$message, $context);
    }

    public function critical(string|\Stringable $message, array $context = []): void
    {
        $this->decoratedLogger->critical('🛑 '.$message, $context);
    }

    public function error(string|\Stringable $message, array $context = []): void
    {
        $this->decoratedLogger->error('❌ '.$message, $context);
    }

    public function warning(string|\Stringable $message, array $context = []): void
    {
        $this->decoratedLogger->warning('⚠️ '.$message, $context);
    }

    public function notice(string|\Stringable $message, array $context = []): void
    {
        $this->decoratedLogger->notice('📝 '.$message, $context);
    }

    public function info(string|\Stringable $message, array $context = []): void
    {
        $this->decoratedLogger->info('ℹ️ '.$message, $context);
    }

    public function debug(string|\Stringable $message, array $context = []): void
    {
        $this->decoratedLogger->debug('🤖 '.$message, $context);
    }

    public function log($level, string|\Stringable $message, array $context = []): void
    {
        $this->decoratedLogger->log($level, $message, $context);
    }
}
