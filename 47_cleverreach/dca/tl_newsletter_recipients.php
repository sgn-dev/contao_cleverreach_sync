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
 * Table tl_newsletter_recipients
 */

// Test Onload Callback
// $GLOBALS['TL_DCA']['tl_newsletter_recipients']['config']['onload_callback'][] = array('Cleverreach\Backend\Newsletter\Recipients\Callback', 'test');

/**
 * OnSubmit Callback
 */
$GLOBALS['TL_DCA']['tl_newsletter_recipients']['config']['onsubmit_callback'][] = array('Cleverreach\Backend\Newsletter\Recipients\Callback', 'HandleRecipient');

/**
 * OnDelete Callback
 */
$GLOBALS['TL_DCA']['tl_newsletter_recipients']['config']['ondelete_callback'][] = array('Cleverreach\Backend\Newsletter\Recipients\Callback', 'DeleteRecipient');

/**
 * Define and Add new palettes
 */
$strPalette = $GLOBALS['TL_DCA']['tl_newsletter_recipients']['palettes']['default'];
$strNewPalette = ''.$strPalette.';{cleverreach_legend},clr_activate_synchronisation';
$GLOBALS['TL_DCA']['tl_newsletter_recipients']['palettes']['default'] = $strNewPalette;

/**
 * Add fields 47_cleverreach to tl_newsletter_recipients
 */
$GLOBALS['TL_DCA']['tl_newsletter_recipients']['fields']['clr_activate_synchronisation'] = array(
    'label'                   => &$GLOBALS['TL_LANG']['tl_newsletter_recipients']['clr_activate_synchronisation'],
    'exclude'                 => true,
    'inputType'               => 'checkbox',
    'eval'                    => array('tl_class'=>'w50'),
    'sql'                     => "char(1) NOT NULL default ''"
);