# Backoffice CSS module for Thelia

This module add the possibility to write a css file for the front office.
This module is compatible with Thelia 2.1

## Installation

### Manually

* Copy the module into ```<thelia_root>/local/modules/``` directory and be sure that the name of the module is BackOfficeCss.
* Activate it in your thelia administration panel

### Composer

Add it in your main thelia composer.json file

```
composer require thelia/backoffice-css-module:~1.0
```

## Usage

Go on your back office and activate the module. Refresh the page then you can use the "Edit stylesheet" link in the Tools dropdown.

## Hook

The module uses the hook ```main.top-menu-tools``` to show the link to the redirection management table.
