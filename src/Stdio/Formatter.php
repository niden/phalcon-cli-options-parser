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

/**
 * Converts <tag> to VT100 display control codes for POSIX, or strips
 * the <tag> entirely for non-POSIX.
 */
class Formatter
{
    /**
     * @var array<string, string>
     */
    protected array $codes = [
        '<reset>'      => '0',
        '<strong>'     => '1',
        '</strong>'    => '0',
        '<ul>'         => '4',
        '</ul>'        => '0',
        '<em>'         => '3',
        '</em>'        => '0',
        '<blink>'      => '5',
        '</blink>'     => '0',
        '<reverse>'    => '7',
        '</reverse>'   => '0',
        '<black>'      => '30',
        '</black>'     => '0',
        '<red>'        => '31',
        '</red>'       => '0',
        '<green>'      => '32',
        '</green>'     => '0',
        '<yellow>'     => '33',
        '</yellow>'    => '0',
        '<blue>'       => '34',
        '</blue>'      => '0',
        '<magenta>'    => '35',
        '</magenta>'   => '0',
        '<cyan>'       => '36',
        '</cyan>'      => '0',
        '<white>'      => '37',
        '</white>'     => '0',
        '<blackbg>'    => '40',
        '</blackbg>'   => '0',
        '<redbg>'      => '41',
        '</redbg>'     => '0',
        '<greenbg>'    => '42',
        '</greenbg>'   => '0',
        '<yellowbg>'   => '43',
        '</yellowbg>'  => '0',
        '<bluebg>'     => '44',
        '</bluebg>'    => '0',
        '<magentabg>'  => '45',
        '</magentabg>' => '0',
        '<cyanbg>'     => '46',
        '</cyanbg>'    => '0',
        '<whitebg>'    => '47',
        '</whitebg>'   => '0',
    ];

    /**
     * Converts <markup> in text to VT100 control codes for POSIX, or removes
     * them for non-POSIX.
     *
     * @param string $input
     * @param bool   $isPosix
     *
     * @return string
     */
    public function format(string $input, bool $isPosix): string
    {
        if ($isPosix) {
            return $this->formatForPosix($input);
        } else {
            return $this->stripMarkup($input);
        }
    }

    /**
     * Format the string for POSIX
     *
     * @param string $input
     *
     * @return string
     */
    protected function formatForPosix(string $input): string
    {
        $search  = array_keys($this->codes);
        $replace = array_map(
            function ($code) {
                return chr(27) . '[' . $code . 'm';
            },
            $this->codes
        );

        return str_replace($search, $replace, $input);
    }

    /**
     * Strip markup from the output
     *
     * @param string $input
     *
     * @return string
     */
    protected function stripMarkup(string $input): string
    {
        return str_replace(array_keys($this->codes), '', $input);
    }
}
