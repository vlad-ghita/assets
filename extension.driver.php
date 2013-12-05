<?php

	Class Extension_Assets extends Extension {

		private static $loaded = array();

		private static $supported = array(
			'font-awesome',
			'jquery-select2',
			'jquery-ui',
			'jquery-validate',
			'js-class',
		);



		/*------------------------------------------------------------------------------------------------*/
		/*  Delegates  */
		/*------------------------------------------------------------------------------------------------*/

		public function getSubscribedDelegates() {
			return array(

				array(
					'page'     => '/backend/',
					'delegate' => 'InitialiseAdminPageHead',
					'callback' => 'dInitialiseAdminPageHead'
				),
			);
		}

		public function dInitialiseAdminPageHead() {
			self::load();
		}



		/*------------------------------------------------------------------------------------------------*/
		/*  Public  */
		/*------------------------------------------------------------------------------------------------*/

		/**
		 * Load given assets.
		 *
		 * @param string|array|null $assets (optional) - handles of assets to load. Defaults to all of them.
		 */
		public static function load($assets = null) {
			// check context
			if (
				class_exists('Administration')
				&& Administration::instance() instanceof Administration
				&& Administration::instance()->Page instanceof HTMLPage
			) {
				return;
			}

			if ($assets === null) {
				$assets = self::$supported;
			}
			else if (!is_array($assets)) {
				$assets = array($assets);
			}

			$assets = array_map(function ($asset) {
				return General::createHandle($asset);
			}, $assets);

			foreach ($assets as $asset) {
				if (
					!in_array($asset, self::$supported)
					|| in_array($asset, self::$loaded)
				) {
					continue;
				}

				self::$loaded[] = $asset;

				$loader = "load_" . str_replace('-', '', $asset);

				call_user_func('Extension_Assets', $loader);
			}
		}

		/**
		 * Font Awesome
		 */
		private static function load_FontAwesome() {
			$page = Administration::instance()->Page;
			$path = URL . '/extensions/assets/assets/font-awesome';

			$page->addStylesheetToHead($path . '/font-awesome.css', 'screen');
		}

		/**
		 * jQuery Select2
		 */
		private static function load_jQuerySelect2() {
			$page = Administration::instance()->Page;
			$path = URL . '/extensions/assets/assets/jquery-select2';

			$page->addScriptToHead($path . '/select2.js');
			$page->addStylesheetToHead($path . '/select2.css', 'screen');
			$page->addElementToHead(new XMLElement(
				'script',
				sprintf('
					Symphony.Select2 = {
						"lang": "%s"
					}',
					Administration::instance()->Author->get('lang')
				),
				array('type' => 'text/javascript')
			));
		}

		/**
		 * jQuery UI
		 */
		private static function load_jQueryUI() {
			$page = Administration::instance()->Page;
			$path = URL . '/extensions/assets/assets/jquery-ui';

			$page->addScriptToHead($path . '/jquery-ui.js');
			$page->addStylesheetToHead($path . '/jquery-ui.css', 'screen');
		}

		/**
		 * jQuery Validate
		 */
		private static function load_jQueryValidate() {
			$page = Administration::instance()->Page;
			$path = URL . '/extensions/assets/assets/jquery-validate';

			$page->addScriptToHead($path . '/jquery.validate.js');
			$page->addScriptToHead($path . '/additional-methods.js');
		}

		/**
		 * JS Class
		 */
		private static function load_JsClass() {
			$page = Administration::instance()->Page;
			$path = URL . '/extensions/assets/assets/js-class';

			$page->addElementToHead(new XMLElement(
				'script',
				"JSCLASS_PATH = $path",
				array('type' => 'text/javascript')
			));

			$page->addScriptToHead($path . '/loader-browser.js');
		}
	}
 
