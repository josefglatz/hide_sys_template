<?php

declare(strict_types=1);

use EliasHaeussler\PhpCsFixerConfig;
use TYPO3\CodingStandards;


// Create header rule
$header = PhpCsFixerConfig\Rules\Header::create(
    'josefglatz/hide-sys-template',
    PhpCsFixerConfig\Package\Type::TYPO3Extension,
    PhpCsFixerConfig\Package\Author::create('Josef Glatz', 'typo3@josefglatz.at'),
    PhpCsFixerConfig\Package\License::GPL2OrLater,
);



$config = CodingStandards\CsFixerConfig::create();

$finder = $config->getFinder()
    ->in(__DIR__)
    ->ignoreVCSIgnored(true)
    ->ignoreDotFiles(false);

return PhpCsFixerConfig\Config::create()
    ->withConfig($config)
    ->withRule($header);
