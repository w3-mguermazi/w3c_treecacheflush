<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Tree Cache Flush',
    'description' => 'Adds a context menu item to flush page cache recursively',
    'category' => 'backend',
    'author' => 'Mehdi Guermazi',
    'author_company' => 'W3code',
    'state' => 'stable',
    'clearCacheOnLoad' => 1,
    'version' => '1.0.0',
    'constraints' => [
        'depends' => [
            'typo3' => '12.4.0-13.9.99',
        ],
    ],
];
