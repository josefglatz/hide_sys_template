<?php
/** @noinspection PhpFullyQualifiedNameUsageInspection */
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    static function ($extKey) {
        // First level of restriction
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
            'mod.web_list.deniedNewTables := addToList(sys_template)'
        );

        // Edit restriction for specific records / Enrich DataHandler while updating specific records
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass'][$extKey] =
            \JosefGlatz\HideSysTemplate\Hooks\Backend\ProcessDatamapDataHandler::class;
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS'][TYPO3\CMS\Tstemplate\Controller\TypoScriptTemplateModuleController::class]['newStandardTemplateHandler'] =
            \JosefGlatz\HideSysTemplate\Hooks\Backend\NewStandardTemplateHandler::class . '->restrict';
    },
    'hide_sys_template'
);
