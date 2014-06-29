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
	'Fatcrobat\Brew\Brew'             => 'system/modules/brew/classes/Brew.php',
	'Fatcrobat\Brew\BrewDcaExtractor' => 'system/modules/brew/classes/BrewDcaExtractor.php',
	'Fatcrobat\Brew\BrewHooks'        => 'system/modules/brew/classes/BrewHooks.php',
	'Fatcrobat\Brew\BrewTable'        => 'system/modules/brew/classes/BrewTable.php',

	// Models
	'Fatcrobat\Brew\BrewFieldModel'   => 'system/modules/brew/models/BrewFieldModel.php',
	'Fatcrobat\Brew\BrewModel'        => 'system/modules/brew/models/BrewModel.php',
	'Fatcrobat\Brew\BrewTableModel'   => 'system/modules/brew/models/BrewTableModel.php',
));
