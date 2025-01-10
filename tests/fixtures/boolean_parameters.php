<?php

/**
 * This file is part of the Cop package.
 *
 * (c) Phalcon Team <team@phalconphp.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

return [
    [
        [
            'key'     => 'key1',
            'default' => false,
            'argv'    => [
                '/usr/bin/phalcon',
                '--key1',
                '1',
            ],
        ],
        true,
    ],
    [
        [
            'key'     => 'key2',
            'default' => true,
            'argv'    => [
                '/usr/bin/phalcon',
                '--key2',
                '0',
            ],
        ],
        false,
    ],
    [
        [
            'key'     => 'key3',
            'default' => false,
            'argv'    => [
                '/usr/bin/phalcon',
                '--key3',
                'y',
            ],
        ],
        true,
    ],
    [
        [
            'key'     => 'key4',
            'default' => true,
            'argv'    => [
                '/usr/bin/phalcon',
                '--key4',
                'n',
            ],
        ],
        false,
    ],
    [
        [
            'key'     => 'key5',
            'default' => false,
            'argv'    => [
                '/usr/bin/phalcon',
                '--key5',
                'yes',
            ],
        ],
        true,
    ],
    [
        [
            'key'     => 'key6',
            'default' => true,
            'argv'    => [
                '/usr/bin/phalcon',
                '--key6',
                'no',
            ],
        ],
        false,
    ],
    [
        [
            'key'     => 'key7',
            'default' => false,
            'argv'    => [
                '/usr/bin/phalcon',
                '--key7',
                'true',
            ],
        ],
        true,
    ],
    [
        [
            'key'     => 'key8',
            'default' => true,
            'argv'    => [
                '/usr/bin/phalcon',
                '--key8',
                'false',
            ],
        ],
        false,
    ],
    [
        [
            'key'     => 'key9',
            'default' => false,
            'argv'    => [
                '/usr/bin/phalcon',
                '--key9',
                'on',
            ],
        ],
        true,
    ],
    [
        [
            'key'     => 'key10',
            'default' => true,
            'argv'    => [
                '/usr/bin/phalcon',
                '--key10',
                'off',
            ],
        ],
        false,
    ],
    [
        [
            'key'     => 'key11',
            'default' => false,
            'argv'    => [
                '/usr/bin/phalcon',
                '--key11',
            ],
        ],
        true,
    ],
    [//test default param
     [
         'key'     => 'key13',
         'default' => false,
         'argv'    => [
             '/usr/bin/phalcon',
             '--key12',
         ],
     ],
     false,
    ],
];
