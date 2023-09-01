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

namespace JosefGlatz\HideSysTemplate\EventListener;

use Psr\Http\Message\ResponseFactoryInterface;
use TYPO3\CMS\Backend\Controller\Event\BeforeFormEnginePageInitializedEvent;
use TYPO3\CMS\Core\Http\PropagateResponseException;
use TYPO3\CMS\Core\Localization\LanguageService;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Messaging\FlashMessageService;
use TYPO3\CMS\Core\Type\ContextualFeedbackSeverity;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * This is the event listener class which prevents TYPO3 backend users to
 * create sys_template records in the TYPO3 database.
 * @author Josef Glatz <typo3@josefglatz.at>
 */
class RenderFlashMessage
{
    private ResponseFactoryInterface $responseFactory;

    // Inject PSR-17 ResponseFactoryInterface
    public function __construct(ResponseFactoryInterface $responseFactory)
    {
        $this->responseFactory = $responseFactory;
    }

    /**
      * The event listener is called via __invoke() since
      * the method isn't configured in Configuration/Services.yaml
      */
    public function __invoke(BeforeFormEnginePageInitializedEvent $event)
    {
        // Check if have to do something
        $parsedBody = $event->getRequest()->getParsedBody();
        $queryParams = $event->getRequest()->getQueryParams();
        $parsedRequestParams = $parsedBody['edit']['sys_template'] ?? $queryParams['edit']['sys_template'] ?? [];
        if (!empty($parsedRequestParams) && \in_array('new', $parsedRequestParams, true)) {
            // Add flash message
            $this->addFlashMessage();
            // Redirect to previous url with proper HTTP status 403
            $response = $this->responseFactory
                ->createResponse(403)
                ->withAddedHeader('location', $queryParams['returnUrl']);

            throw new PropagateResponseException($response);
        }
    }

    /**
     * Add flash message to queue to inform the TYPO3 backend administrator about the restriction.
     */
    protected function addFlashMessage(): void
    {
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
    }

    protected function getLanguageService(): LanguageService
    {
        return $GLOBALS['LANG'];
    }
}
