<?php

return [
    'dependencies' => [
        'backend',
    ],
    'tags' => [
        'backend.contextmenu',
    ],
    'imports' => [
        '@w3code/w3c_treecacheflush/' => 'EXT:w3c_treecacheflush/Resources/Public/JavaScript/',
    ],
    'translations' => [
        'EXT:w3c_treecacheflush/Resources/Private/Language/locallang.xlf',
    ],
];
