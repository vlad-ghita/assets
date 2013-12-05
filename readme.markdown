# Assets

## About

Provides various assets for Symphony backend.

Asset           | Handle          | Version
----------------|-----------------|------------
Font Awesome    | font-awesome    | 4.0.3
jQuery Select2  | jquery-select2  | 3.4.5
jQuery UI       | jquery-ui       | 1.10.3
jQuery Validate | jquery-validate | 1.11.1
JS Class        | js-class        | 4.0.4

## Usage

Install the extension.

Call `Extension_Assets::load()` method in your PHP.

- `Extension_Assets::load('font-awesome')` loads `Font Awesome`.
- `Extension_Assets::load(array('font-awesome', 'js-class'))` loads `Font Awesome` and `JS Class`.
- `Extension_Assets::load()` loads all.
