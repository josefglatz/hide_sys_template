<?php

declare(strict_types=1);

/*
 * This file is part of the TYPO3 CMS extension "josefglatz/hide-sys-template".
 *
 * Copyright (C) 2023 Josef Glatz <typo3@josefglatz.at>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <https://www.gnu.org/licenses/>.
 */

return \Symfony\Component\Finder\Finder::create()
    ->files()
    ->in(__DIR__)
    ->ignoreVCSIgnored(true)
    ->exclude([
        'Resources/Public/JavaScript',
        'Resources/Public/Icons',
    ])
    ->notName('README.md');
