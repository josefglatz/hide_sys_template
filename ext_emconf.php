<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'hide_sys_template - A life without sys_template database records',
    'description' => 'Make sys_template records vanish everywhere (Prevents TYPO3 admins from using sys_template database records)',
    'version' => '3.0.4',
    'state' => 'stable',
    'constraints' => [
        'depends' => [
            'typo3' => '11.5.0-11.5.99',
        ],
    ],
    'autoload' => [
        'psr-4' => [
            'JosefGlatz\\HideSysTemplate\\' => 'Classes/',
        ],
    ],
    'author' => 'Josef Glatz',
    'author_email' => 'typo3@josefglatz.at',
    'author_company' => 'J18',
];
