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

namespace Phalcon\Cop\Tests\Unit\Stdio;

use Phalcon\Cop\Exception\InvalidStreamException;
use Phalcon\Cop\Stdio\Stream;
use PHPUnit\Framework\TestCase;

use const STDIN;

final class StreamTest extends TestCase
{
    public function testNameMode()
    {
        $handle = new Stream('php://memory', 'w+');

        $expected = 'php://memory';
        $actual   = $handle->getName();
        $this->assertSame($expected, $actual);

        $expected = 'w+';
        $actual   = $handle->getMode();
        $this->assertSame($expected, $actual);
    }

    public function testCannotOpenStream()
    {
        $this->expectException(InvalidStreamException::class);
        $this->expectExceptionMessage('Cannot open file php://doesnotexist with mode w+');

        $handle = new Stream('php://doesnotexist', 'w+');
    }

    public function testPosixFalse()
    {
        $handle = new Stream('php://memory', 'w+', null, false);

        $actual = $handle->isPosix();
        $this->assertFalse($actual);
    }

    public function testPosixInWindows()
    {
        $handle = new Stream('php://memory', 'w+', 'win');

        $actual = $handle->isPosix();
        $this->assertFalse($actual);
    }
}
