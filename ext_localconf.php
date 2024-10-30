<?php

declare(strict_types=1);

/*
 * This file is part of the TYPO3 CMS extension "josefglatz/hide-sys-template".
 *
 * Copyright (C) 2024 Josef Glatz <typo3@josefglatz.at>
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

\defined('TYPO3') or die();

\call_user_func(
    static function ($extKey) {
        // Edit restriction for specific records / Enrich DataHandler while updating specific records
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass'][$extKey] =
            \JosefGlatz\HideSysTemplate\Hooks\Backend\ProcessDatamapDataHandler::class;
    },
    'hide_sys_template'
);
