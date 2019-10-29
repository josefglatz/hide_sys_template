TYPO3 Extension `josefglatz/hide-sys-template`
==============================================

> The hide_sys_template extension prevents TYPO3 CMS administrator users
> from using sys_template database records.

## Installation

### Installation using Composer

The recommended way to install the extension is by using
[Composer](https://getcomposer.org/). In your Composer based TYPO3
project root, just do `composer require josefglatz/hide-sys-template`

##### You want to update the extension with composer?

Based on what version constraint is used in your composer.json you can
use the following command to install the latest stable version:

`composer require josefglatz/hide-sys-template`

If you want to install or update to a specific version 1.1 and bugfix
releases use the following command:

`composer require josefglatz/hide-sys-template:1.1.*`


### Installation as extension from TYPO3 Extension Repository (TER)

Download and install the extension with the TYPO3 CMS extension manager
module or directly via
[extensions.typo3.org](https://typo3.org/extensions/repository/view/hide_sys_template).

## Configuration

Nothing to configure! You may need to empty the cache once after
installation – that's all!

## Why?

Imagine a world without sys_template records! That's possible since
TYPO3 8 LTS. Everything is better since then!

### How to use it?

Register your hook
`$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['Core/TypoScript/TemplateService']['runThroughTemplatesPostProcessing']`
in your TYPO3 sitepackage extension. All your TypoScript and
sys_template relevant stuff is right in your sitepackage extension
a.k.a. GIT repository. 🤩

---

## Created by

<http://josefglatz.at/>
