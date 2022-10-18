<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'hide_sys_template',
    'description' => 'Make sys_template records vanish everywhere (Prevents TYPO3 admins from using sys_template database records)',
    'version' => '3.0.0',
    'constraints' => [
        'depends' => [
            'typo3' => '11.5.0-12.4.99',
        ],
    ],
    'autoload' => [
        'psr-4' => [
            'JosefGlatz\\HideSysTemplate\\' => 'Classes/',
        ],
    ],
];
