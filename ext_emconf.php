<?php
/** @noinspection PhpUndefinedVariableInspection */
$EM_CONF[$_EXTKEY] = [
    'title' => 'Hide sys_template in backend',
    'description' => 'Make sys_template records vanish everywhere (Prevents TYPO3 admins from using sys_template database records)',
    'category' => 'be',
    'author' => 'Josef Glatz',
    'author_email' => 'josefglatz@gmail.com',
    'author_company' => 'https://www.josefglatz.at',
    'state' => 'stable',
    'clearCacheOnLoad' => 1,
    'version' => '2.0.0',
    'constraints' =>
        [
            'depends' =>
                [
                    'typo3' => '10.4.0-10.4.99',
                    'php' => '7.2.0-7.4.99',
                ],
        ],
    'autoload' =>
        [
            'psr-4' =>
                [
                    'JosefGlatz\\HideSysTemplate\\' => 'Classes',
                ],
        ],
];
