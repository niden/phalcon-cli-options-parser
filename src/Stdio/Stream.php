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
    protected      $handle = null;
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
            $this->handle = null;
        }
    }

    /**
     * Reads a line from the handle
     *
     * @return false|string
     * @throws InvalidStreamException
     */
    public function fgets(): false | string
    {
        $this->checkStream();
        return fgets($this->handle);
    }

    /**
     * Reads from the resource (8192 bytes at a time)
     *
     * @param int $length
     *
     * @return string|bool
     * @throws InvalidStreamException
     */
    public function fread(int $length = 8192): string | bool
    {
        $this->checkStream();
        return fread($this->handle, $length);
    }

    /**
     * Writes data to the handle
     *
     * @param string $input
     *
     * @return false|int
     * @throws InvalidStreamException
     */
    public function fwrite(string $input): false | int
    {
        $this->checkStream();
        return fwrite($this->handle, $input);
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
     * @throws InvalidStreamException
     */
    public function rewind(): bool
    {
        $this->checkStream();
        return rewind($this->handle);
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
        if (str_starts_with(strtolower($this->os), 'win')) {
            $this->posix = false;
            return;
        }

        /**
         * Try to auto detect using `posix_isatty()` if available
         */
        if (function_exists('posix_isatty')) {
            $level       = error_reporting(0);
            $this->posix = posix_isatty($this->handle);
            error_reporting($level);
        }
    }
}
