<?php
declare(strict_types = 1);

namespace JosefGlatz\HideSysTemplate\EventListener;

use TYPO3\CMS\Backend\Controller\Event\BeforeFormEnginePageInitializedEvent;
use TYPO3\CMS\Core\Localization\LanguageService;
use TYPO3\CMS\Core\Messaging\FlashMessageService;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\HttpUtility;

/**
 * This is the event listener class which prevents TYPO3 backend users to
 * create sys_template records in the TYPO3 database.
 */
class RenderFlashMessage
{
    /**
     * The event listener is called via __invoke() since
     * the method isn't configured in Configuration/Services.yaml
     *
     * @param BeforeFormEnginePageInitializedEvent $event
     */
    public function __invoke(BeforeFormEnginePageInitializedEvent $event): void
    {
        // Check if have to do something
        $parsedBody = $event->getRequest()->getParsedBody();
        $queryParams = $event->getRequest()->getQueryParams();
        $parsedRequestParams = $parsedBody['edit']['sys_template'] ?? $queryParams['edit']['sys_template'] ?? [];
        if (!empty($parsedRequestParams) && \in_array('new', $parsedRequestParams, true)) {
            // Add flash message
            $this->addFlashMessage();
            // Redirect to previous url with proper HTTP status 403
            HttpUtility::redirect($queryParams['returnUrl'], HttpUtility::HTTP_STATUS_403);
        }
    }

    /**
     * Add flash message to queue to inform the TYPO3 backend administrator about the restriction.
     */
    protected function addFlashMessage(): void
    {
        /**
         * @var \TYPO3\CMS\Core\Messaging\FlashMessage $message Error message to inform the backend user about the barrier
         */
        $message = GeneralUtility::makeInstance(
            \TYPO3\CMS\Core\Messaging\FlashMessage::class,
            htmlspecialchars($this->getLanguageService()
                ->sL('LLL:EXT:hide_sys_template/Resources/Private/Language/locallang.xlf:hooks.dataHandler.prevent.sys_template.description')),
            htmlspecialchars($this->getLanguageService()
                ->sL('LLL:EXT:hide_sys_template/Resources/Private/Language/locallang.xlf:hooks.dataHandler.prevent.sys_template.title')),
            \TYPO3\CMS\Core\Messaging\FlashMessage::ERROR,
            true
        );
        $flashMessageService = GeneralUtility::makeInstance(FlashMessageService::class);
        $messageQueue = $flashMessageService->getMessageQueueByIdentifier();
        $messageQueue->addMessage($message);
    }

    /**
     * @return LanguageService
     */
    protected function getLanguageService(): LanguageService
    {
        return $GLOBALS['LANG'];
    }
}
