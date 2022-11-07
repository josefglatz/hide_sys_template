<?php declare(strict_types = 1);

namespace JosefGlatz\HideSysTemplate\Hooks\Backend;

use TYPO3\CMS\Backend\Routing\UriBuilder;
use TYPO3\CMS\Core\DataHandling\DataHandler;
use TYPO3\CMS\Core\Localization\LanguageService;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Messaging\FlashMessageService;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Tstemplate\Controller\TypoScriptTemplateInformationModuleFunctionController;

class ProcessDatamapDataHandler
{
    /**
     * Prevent creating a new sys_template record
     *
     * @param DataHandler $parentObject
     * @throws \TYPO3\CMS\Backend\Routing\Exception\RouteNotFoundException
     */
    public function processDatamap_beforeStart(DataHandler $parentObject): void
    {
        if (isset($parentObject->datamap['sys_template']['NEW'])) {
            /**
             * @var FlashMessage $message Error message to inform the backend user about the barrier
             */
            $message = GeneralUtility::makeInstance(
                FlashMessage::class,
                htmlspecialchars($this->getLanguageService()
                    ->sL('LLL:EXT:hide_sys_template/Resources/Private/Language/locallang.xlf:hooks.dataHandler.prevent.sys_template.description')),
                htmlspecialchars($this->getLanguageService()
                    ->sL('LLL:EXT:hide_sys_template/Resources/Private/Language/locallang.xlf:hooks.dataHandler.prevent.sys_template.title')),
                FlashMessage::ERROR,
                true
            );
            $flashMessageService = GeneralUtility::makeInstance(FlashMessageService::class);
            $messageQueue = $flashMessageService->getMessageQueueByIdentifier();
            $messageQueue->addMessage($message);
            $redirectUri = (string)GeneralUtility::makeInstance(UriBuilder::class)->buildUriFromRoute(
                'web_ts',
                [
                    'id' => (int)$parentObject->datamap['sys_template']['NEW']['pid'],
                    'function' => TypoScriptTemplateInformationModuleFunctionController::class
                ]
            );
            @ob_end_clean();
            header('Location: ' . GeneralUtility::locationHeaderUrl($redirectUri));
            die();
        }
    }

    /**
     * Hook into DataHandler for enrich formEngine while editing records
     *
     * @noinspection PhpUnusedParameterInspection
     *
     * @param $status
     * @param $table
     * @param $id
     * @param $fieldArray
     * @param DataHandler $pObj
     */
    public function processDatamap_postProcessFieldArray($status, $table, $id, &$fieldArray, &$pObj): void
    {
        // Add warning message, if somebody add or edit PageTSConfig directly.
        if ($table === 'pages' && isset($fieldArray['TSconfig']) && ($fieldArray['TSconfig'] !== '')) {
            $message = GeneralUtility::makeInstance(
                FlashMessage::class,
                'Read EXT:hide_sys_template/Configuration/TsConfig/Page/Specific/README.md for instructions ' .
                'how to add page specific TSConfig with an alternative way.',
                'Please consider NOT saving Page TS Config directly to database!',
                FlashMessage::WARNING,
                true
            );
            $flashMessageService = GeneralUtility::makeInstance(FlashMessageService::class);
            $messageQueue = $flashMessageService->getMessageQueueByIdentifier();
            $messageQueue->addMessage($message);
        }
    }

    /**
     * @return LanguageService
     */
    protected function getLanguageService(): LanguageService
    {
        return $GLOBALS['LANG'];
    }
}
