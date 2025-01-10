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

use Phalcon\Cop\Stdio\Formatter;
use Phalcon\Cop\Stdio\Stdio;
use Phalcon\Cop\Stdio\Stream;
use PHPUnit\Framework\TestCase;

use function uniqid;

use const PHP_EOL;

final class StdioTest extends TestCase
{
    protected Formatter $formatter;
    protected Stream    $stderr;
    protected Stream    $stdin;
    protected Stdio     $stdio;
    protected Stream    $stdout;

    public function setUp(): void
    {
        parent::setUp();

        $this->stdin     = new Stream('php://memory', 'r+');
        $this->stdout    = new Stream('php://memory', 'w+');
        $this->stderr    = new Stream('php://memory', 'w+');
        $this->formatter = new Formatter();
        $this->stdio     = new Stdio(
            $this->stdin,
            $this->stdout,
            $this->stderr,
            $this->formatter
        );
    }

    public function testErr(): void
    {
        $text = uniqid('txt-') . ' ' . uniqid('txt-');
        $this->stdio->err($text);
        $this->stderr->rewind();

        $expected = $text;
        $actual   = $this->stderr->fread();
        $this->assertSame($expected, $actual);
    }

    public function testErrEol(): void
    {
        $text = uniqid('txt-') . ' ' . uniqid('txt-');
        $this->stdio->err($text, true);
        $this->stderr->rewind();

        $expected = $text . PHP_EOL;
        $actual   = $this->stderr->fread();
        $this->assertSame($expected, $actual);
    }

    public function testGetStderr()
    {
        $expected = $this->stderr;
        $actual   = $this->stdio->getStderr();
        $this->assertSame($expected, $actual);
    }

    public function testGetStdin(): void
    {
        $expected = $this->stdin;
        $actual   = $this->stdio->getStdin();
        $this->assertSame($expected, $actual);
    }

    public function testGetStdout()
    {
        $expected = $this->stdout;
        $actual   = $this->stdio->getStdout();
        $this->assertSame($expected, $actual);
    }

    public function testIn(): void
    {
        $text = uniqid('txt-') . ' ' . uniqid('txt-') . PHP_EOL;

        $this->stdin->fwrite($text);
        $this->stdin->rewind();

        $expected = $text;
        $actual   = $this->stdio->in();
        $this->assertSame($expected, $actual);
    }

    public function testInEol(): void
    {
        $text = uniqid('txt-') . ' ' . uniqid('txt-');

        $this->stdin->fwrite($text . PHP_EOL);
        $this->stdin->rewind();

        $expected = $text;
        $actual   = $this->stdio->in(true);
        $this->assertSame($expected, $actual);
    }

    public function testOut(): void
    {
        $text = uniqid('txt-') . ' ' . uniqid('txt-');
        $this->stdio->out($text);
        $this->stdout->rewind();

        $expected = $text;
        $actual   = $this->stdout->fread();
        $this->assertSame($expected, $actual);
    }

    public function testOutEol(): void
    {
        $text = uniqid('txt-') . ' ' . uniqid('txt-');
        $this->stdio->out($text, true);
        $this->stdout->rewind();

        $expected = $text . PHP_EOL;
        $actual   = $this->stdout->fread();
        $this->assertSame($expected, $actual);
    }
}
