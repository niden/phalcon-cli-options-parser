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

namespace Phalcon\Cop;

use Phalcon\Cop\Stdio\Formatter;
use Phalcon\Cop\Stdio\Stdio;
use Phalcon\Cop\Stdio\Stream;

/**
 * Client Options Parser Factory
 */
class CopFactory
{
    public function newStdio(
        string $stdin = 'php://stdin',
        string $stdout = 'php://stdout',
        string $stderr = 'php://stderr'
    ): Stdio {
        return new Stdio(
            new Stream($stdin, 'r'),
            new Stream($stdout, 'w+'),
            new Stream($stderr, 'w+'),
            new Formatter()
        );
    }
}
