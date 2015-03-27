<?php

/**
 * Synchronisation width Cleverreach for Contao Open Source CMS
 *
 * Copyright (C) 2015 47gradnord.de
 *
 * @package    47_cleverreach
 * @license    http://opensource.org/licenses/lgpl-3.0.html LGPL
 */

/**
 * Register PSR-0 namespace
 */
NamespaceClassLoader::add('Cleverreach', 'system/modules/47_cleverreach/library');

/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
    // 'mod_pva_registrierung'   => 'system/modules/es_pvanlagen/templates/modules',
));