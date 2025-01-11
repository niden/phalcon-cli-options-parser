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

use Phalcon\Cop\Exception\InvalidStreamException;

use function error_reporting;
use function fclose;
use function fgets;
use function fopen;
use function fread;
use function function_exists;
use function fwrite;
use function is_bool;
use function is_resource;
use function posix_isatty;
use function rewind;
use function str_starts_with;
use function strtolower;

use const PHP_OS;

/**
 * Wrapper for file streams
 */
class Stream
{
    /**
     * @var resource|null
     */
    protected $handle = null;
    protected bool $posix;

    /**
     * @param string      $name
     * @param string      $mode
     * @param string|null $os
     * @param bool|null   $posix
     *
     * @throws InvalidStreamException
     */
    public function __construct(
        protected string $name,
        protected string $mode,
        protected ?string $os = null,
        ?bool $posix = null
    ) {
        $this->checkStream();
        $this->os = $this->os ?? PHP_OS;

        $this->setPosix($posix);
    }

    /**
     * Close the handle if open
     */
    public function __destruct()
    {
        if ($this->handle) {
            fclose($this->handle);
        }
    }

    /**
     * Reads a line from the handle
     *
     * @return false|string
     */
    public function fgets(): false | string
    {
        if (is_resource($this->handle)) {
            return fgets($this->handle);
        }

        return false;
    }

    /**
     * Reads from the resource (8192 bytes at a time)
     *
     * @param int<1, max> $length
     *
     * @return string|false
     */
    public function fread(int $length = 8192): string | false
    {
        if (is_resource($this->handle)) {
            return fread($this->handle, $length);
        }

        return false;
    }

    /**
     * Writes data to the handle
     *
     * @param string $input
     *
     * @return false|int
     */
    public function fwrite(string $input): false | int
    {
        if (is_resource($this->handle)) {
            return fwrite($this->handle, $input);
        }

        return false;
    }

    /**
     * Returns the mode the handle was opened with
     *
     * @return string
     */
    public function getMode(): string
    {
        return $this->mode;
    }

    /**
     * Returns the handle name.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Return if the handle is in POSIX
     *
     * @return bool
     */
    public function isPosix(): bool
    {
        return $this->posix;
    }

    /**
     * Rewinds the pointer
     *
     * @return bool
     */
    public function rewind(): bool
    {
        if (is_resource($this->handle)) {
            return rewind($this->handle);
        }

        return false;
    }

    /**
     * Checks the stream and opens it if not already open. Throws an exception
     * if there is an error
     *
     * @return void
     * @throws InvalidStreamException
     */
    protected function checkStream(): void
    {
        if (!$this->handle) {
            $handle = fopen($this->name, $this->mode);

            if (false === $handle) {
                throw new InvalidStreamException(
                    "Cannot open file $this->name with mode $this->mode"
                );
            }

            $this->handle = $handle;
        }
    }

    /**
     * Sets the posix flag
     *
     * @param bool|null $posix
     *
     * @return void
     */
    protected function setPosix(?bool $posix): void
    {
        if (is_bool($posix)) {
            $this->posix = $posix;
            return;
        }

        /**
         * Check for Windows. If yes, it is not posix
         */
        if (
            null !== $this->os &&
            str_starts_with(strtolower($this->os), 'win')
        ) {
            $this->posix = false;
            return;
        }

        /**
         * Try to auto detect using `posix_isatty()` if available
         */
        if (
            function_exists('posix_isatty') &&
            is_resource($this->handle)
        ) {
            $level       = error_reporting(0);
            $this->posix = posix_isatty($this->handle);
            error_reporting($level);
        }
    }
}
