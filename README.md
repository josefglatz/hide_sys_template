<div align="center">

<img alt="Extension Icon" src="https://github.com/josefglatz/hide_sys_template/raw/main/Resources/Public/Icons/Extension.svg" width="200" height="200">

# TYPO3 extension `hide_sys_template`

**:orange_book:
&nbsp;[Documentation](https://docs.typo3.org/p/josefglatz/hide-sys-template/main/en-us/)
** |
:package:
&nbsp;[Packagist](https://packagist.org/packages/josefglatz/hide-sys-template) |
:hatched_chick:
&nbsp;[TYPO3 extension repository](https://extensions.typo3.org/extension/hide_sys_template) |
:floppy_disk:
&nbsp;[Repository](https://github.com/josefglatz/hide_sys_template) |
:bug:
&nbsp;[Issue tracker](https://github.com/josefglatz/hide_sys_template/issues)

</div>

An extension for TYPO3 CMS that prevents TYPO3 administrator users from using
sys_template database records. Let's make
sys_template database records vanish everywhere!

## :rocket: Features

* Use Page TSconfig `mod.web_list.deniedNewTables` as basic prevention
* Prevents creating sys_template database records via TYPO3 backend module
  Template
* Prevents creating sys_template database records via TYPO3 backend module List
* Prevents showing the backend form for creating new sys_template database
  records
* Informs a TYPO3 admin when add inline Page TSconfig
  to `pages.tsconfig_includes`

**Future features: (sponsoring needed)**

* Command to check for sys_template records and sends notifications
* Add logging and notifications to blame suspicious backend users

_Contact me if you need that or other useful features!_

## :fire: Installation

### Standalone

Via Composer:

```bash
composer require josefglatz/hide-sys-template
```

Or download the zip file from
[TYPO3 extension repository (TER)](https://extensions.typo3.org/extension/hide_sys_template).

### As part of josefglatz/professional_aspects

Via Composer:

```bash
composer require josefglatz/professional-aspects --with-dependencies
```

## 🏄‍ Usage

1. Install the extension
2. There is no second step. That's all.

**For TYPO3 12.4 LTS:** But you might add your sys_template "record" via TYPO3
hook. I prefer  using `b13/bolt` as a counterpart to this extension. Both
extensions complement each other perfectly.

**Update for TYPO3 13.4 LTS:** You can use a sys_template record free TYPO3
instance without using a 3rd-party TYPO3 extension! Just use the new site sets
and install this extension to prevent your colleagues from adding bored
sys_template records! You will sleep better ;-]

## :star: License

This project is licensed
under [GNU General Public License 2.0 (or later)](LICENSE.md).

[![FOSSA Status](https://app.fossa.com/api/projects/git%2Bgithub.com%2Fjosefglatz%2Fhide_sys_template.svg?type=large)](https://app.fossa.com/projects/git%2Bgithub.com%2Fjosefglatz%2Fhide_sys_template?ref=badge_large)

## Screenshots

<img alt="Extension Icon" src="https://github.com/josefglatz/hide_sys_template/raw/main/Documentation/Images/TypoScriptTemplateModule.gif" width="916" height="548">
