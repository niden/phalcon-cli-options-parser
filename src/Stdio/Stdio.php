<?php

/**
 * This file is part of the Cop package.
 *
 * (c) Phalcon Team <team@phalconphp.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Cop\Stdio;

use function rtrim;

use const PHP_EOL;

class Stdio
{
    public function __construct(
        protected Stream $stdin,
        protected Stream $stdout,
        protected Stream $stderr,
        protected Formatter $formatter
    ) {
    }

    /**
     * Print text to the standard error (stderr) formatted
     * (with or without PHP_EOL)
     *
     * @param string $input
     * @param bool   $eol
     *
     * @return void
     */
    public function err(string $input = '', bool $eol = false): void
    {
        $this->output($this->stderr, $input, $eol);
    }

    /**
     * Return the stderr Stream object.
     *
     * @return Stream
     */
    public function getStderr(): Stream
    {
        return $this->stderr;
    }

    /**
     * Return the stdin Stream object.
     *
     * @return Stream
     */
    public function getStdin(): Stream
    {
        return $this->stdin;
    }

    /**
     * Return the stdout Stream object.
     *
     * @return Stream
     */
    public function getStdout(): Stream
    {
        return $this->stdout;
    }

    /**
     * Get input from the command line and return it (with or without PHP_EOL)
     *
     * @param bool $eol
     *
     * @return string
     */
    public function in(bool $eol = false): string
    {
        return rtrim($this->stdin->fgets(), ($eol ? PHP_EOL : ''));
    }

    /**
     * Print text to the command line (stdout) formatted
     * (with or without PHP_EOL)
     *
     * @param string $input
     * @param bool   $eol
     *
     * @return void
     */
    public function out(string $input = '', bool $eol = false): void
    {
        $this->output($this->stdout, $input, $eol);
    }

    /**
     * Helper method to print formatted text to a stream (stdout/stderr)
     * (with or without PHP_EOL)
     *
     * @param Stream $stream
     * @param string $input
     * @param bool   $eol
     *
     * @return void
     */
    protected function output(Stream $stream, string $input = '', bool $eol = false): void
    {
        $input = $this->formatter->format($input, $stream->isPosix());
        $stream->fwrite($input . ($eol ? PHP_EOL : ''));
    }
}
