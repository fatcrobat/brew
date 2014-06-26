<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2014 Leo Feyer
 *
 * @package Brew
 * @link    https://contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */


/**
 * Register the namespaces
 */
ClassLoader::addNamespaces(array
(
	'Fatcrobat',
));


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	// Classes
	'Fatcrobat\Brew\Hooks' => 'system/modules/brew/classes/Hooks.php',
));
