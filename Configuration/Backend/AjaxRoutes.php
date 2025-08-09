<?php

use W3code\W3cTreecacheflush\Controller\FlushController;

return [
    'w3c_treecacheflush_flush' => [
        'path' => '/w3c-treecacheflush/flush',
        'target' => FlushController::class . '::flushAction',
    ],
];
