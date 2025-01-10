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

namespace Phalcon\Cop\Tests\Unit;

use Phalcon\Cop\CopFactory;
use Phalcon\Cop\Stdio\Stdio;
use PHPUnit\Framework\TestCase;

final class CopFactoryTest extends TestCase
{
    public function testCopFactoryNewStdio(): void
    {
        $formatter = new CopFactory();

        $actual = $formatter->newStdio();
        $this->assertInstanceOf(Stdio::class, $actual);
    }
}
