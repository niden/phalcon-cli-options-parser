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
use PHPUnit\Framework\TestCase;

final class FormatterTest extends TestCase
{
    public static function getExamples(): array
    {
        $esc = chr(27);

        return [
            [
                '<strong>bold text</strong>',
                "{$esc}[1mbold text{$esc}[0m",
                true,
            ],
            [
                '<strong>bold<reset> text',
                "{$esc}[1mbold{$esc}[0m text",
                true,
            ],
            [
                '<ul>underline text</ul>',
                "{$esc}[4munderline text{$esc}[0m",
                true,
            ],
            [
                '<em>italic text</em>',
                "{$esc}[3mitalic text{$esc}[0m",
                true,
            ],
            [
                '<blink>blink text</blink>',
                "{$esc}[5mblink text{$esc}[0m",
                true,
            ],
            [
                '<reverse>reverse text</reverse>',
                "{$esc}[7mreverse text{$esc}[0m",
                true,
            ],
            [
                '<black>black text</black>',
                "{$esc}[30mblack text{$esc}[0m",
                true,
            ],
            [
                '<red>red text</red>',
                "{$esc}[31mred text{$esc}[0m",
                true,
            ],
            [
                '<green>green text</green>',
                "{$esc}[32mgreen text{$esc}[0m",
                true,
            ],
            [
                '<yellow>yellow text</yellow>',
                "{$esc}[33myellow text{$esc}[0m",
                true,
            ],
            [
                '<blue>blue text</blue>',
                "{$esc}[34mblue text{$esc}[0m",
                true,
            ],
            [
                '<magenta>magenta text</magenta>',
                "{$esc}[35mmagenta text{$esc}[0m",
                true,
            ],
            [
                '<cyan>cyan text</cyan>',
                "{$esc}[36mcyan text{$esc}[0m",
                true,
            ],
            [
                '<white>white text</white>',
                "{$esc}[37mwhite text{$esc}[0m",
                true,
            ],
            [
                '<blackbg>blackbg text</blackbg>',
                "{$esc}[40mblackbg text{$esc}[0m",
                true,
            ],
            [
                '<redbg>redbg text</redbg>',
                "{$esc}[41mredbg text{$esc}[0m",
                true,
            ],
            [
                '<greenbg>greenbg text</greenbg>',
                "{$esc}[42mgreenbg text{$esc}[0m",
                true,
            ],
            [
                '<yellowbg>yellowbg text</yellowbg>',
                "{$esc}[43myellowbg text{$esc}[0m",
                true,
            ],
            [
                '<bluebg>bluebg text</bluebg>',
                "{$esc}[44mbluebg text{$esc}[0m",
                true,
            ],
            [
                '<magentabg>magentabg text</magentabg>',
                "{$esc}[45mmagentabg text{$esc}[0m",
                true,
            ],
            [
                '<cyanbg>cyanbg text</cyanbg>',
                "{$esc}[46mcyanbg text{$esc}[0m",
                true,
            ],
            [
                '<whitebg>whitebg text</whitebg>',
                "{$esc}[47mwhitebg text{$esc}[0m",
                true,
            ],
            [
                '<strong>bold text</strong>',
                'bold text',
                false,
            ],
        ];
    }

    /**
     * @dataProvider getExamples
     *
     * @param string $input
     * @param string $expected
     * @param bool   $posix
     *
     * @return void
     */
    public function testFormat(
        string $input,
        string $expected,
        bool $posix
    ): void {
        $formatter = new Formatter();

        $actual = $formatter->format($input, $posix);
        $this->assertSame($expected, $actual);
    }
}
