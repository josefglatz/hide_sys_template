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

namespace JosefGlatz\HideSysTemplate\Hooks\Backend;

use TYPO3\CMS\Backend\Routing\UriBuilder;
use TYPO3\CMS\Core\DataHandling\DataHandler;
use TYPO3\CMS\Core\Http\PropagateResponseException;
use TYPO3\CMS\Core\Http\ResponseFactory;
use TYPO3\CMS\Core\Localization\LanguageService;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Messaging\FlashMessageService;
use TYPO3\CMS\Core\Type\ContextualFeedbackSeverity;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class ProcessDatamapDataHandler
 * @author Josef Glatz <typo3@josefglatz.at>
 */
class ProcessDatamapDataHandler
{
    /**
     * Prevent creating a new sys_template record
     *
     * @throws \TYPO3\CMS\Backend\Routing\Exception\RouteNotFoundException
     * @throws PropagateResponseException
     */
    public function processDatamap_beforeStart(DataHandler $parentObject)
    {
        if (isset($parentObject->datamap['sys_template'])
            && str_starts_with((string)array_key_first($parentObject->datamap['sys_template']), 'NEW')) {
            /**
             * @var FlashMessage $message Error message to inform the backend user about the barrier
             */
            $message = GeneralUtility::makeInstance(
                FlashMessage::class,
                htmlspecialchars($this->getLanguageService()
                    ->sL('LLL:EXT:hide_sys_template/Resources/Private/Language/locallang.xlf:hooks.dataHandler.prevent.sys_template.description')),
                htmlspecialchars($this->getLanguageService()
                    ->sL('LLL:EXT:hide_sys_template/Resources/Private/Language/locallang.xlf:hooks.dataHandler.prevent.sys_template.title')),
                ContextualFeedbackSeverity::ERROR,
                true
            );
            $flashMessageService = GeneralUtility::makeInstance(FlashMessageService::class);
            $messageQueue = $flashMessageService->getMessageQueueByIdentifier();
            $messageQueue->addMessage($message);
            $redirectUri = (string)GeneralUtility::makeInstance(UriBuilder::class)->buildUriFromRoute(
                'web_ts',
                [
                    'id' => (int)$parentObject->datamap['sys_template']['NEW']['pid'],
                ]
            );
            @ob_end_clean();
            $response = GeneralUtility::makeInstance(ResponseFactory::class)
                ->createResponse(403)
                ->withAddedHeader('location', GeneralUtility::locationHeaderUrl($redirectUri));

            throw new PropagateResponseException($response);
        }
    }

    /**
     * Hook into DataHandler for enrich formEngine while editing records
     *
     * @noinspection PhpUnusedParameterInspection
     *
     * @param DataHandler $pObj
     */
    public function processDatamap_postProcessFieldArray($status, $table, $id, &$fieldArray, &$pObj): void
    {
        // Add warning message, if somebody add or edit PageTSConfig directly.
        if ($table === 'pages' && isset($fieldArray['TSconfig']) && ($fieldArray['TSconfig'] !== '')) {
            $message = GeneralUtility::makeInstance(
                FlashMessage::class,
                'In a professional TYPO3 setup all your TSConfig is versioned in your source code ' .
                'management tool like GIT. It\'s better to provide TSconfig for specific pages as files in your sitepackage ' .
                'and include it through tsconfig_includes!',
                'Please consider NOT saving PageTSConfig directly to database!',
                ContextualFeedbackSeverity::WARNING,
                true
            );
            $flashMessageService = GeneralUtility::makeInstance(FlashMessageService::class);
            $messageQueue = $flashMessageService->getMessageQueueByIdentifier();
            $messageQueue->addMessage($message);
        }
    }

    protected function getLanguageService(): LanguageService
    {
        return $GLOBALS['LANG'];
    }
}
