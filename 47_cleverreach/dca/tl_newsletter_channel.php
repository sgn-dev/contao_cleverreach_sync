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
 * Table tl_newsletter_channel
 */

/**
 * OnSubmit Callback
 */
$GLOBALS['TL_DCA']['tl_newsletter_channel']['config']['onsubmit_callback'][] = array('Cleverreach\Backend\Newsletter\Channel\Callback', 'HandleGroup');
$GLOBALS['TL_DCA']['tl_newsletter_channel']['config']['ondelete_callback'][] = array('Cleverreach\Backend\Newsletter\Channel\Callback', 'deleteGroup');

/**
 * Add palettes 47_cleverreach to tl_newsletter_channel
 */
$pos=strpos($GLOBALS['TL_DCA']['tl_newsletter_channel']['palettes']['default'],'{smtp_legend');

$palette=substr($GLOBALS['TL_DCA']['tl_newsletter_channel']['palettes']['default'],0,$pos).'{cleverreach_legend},clr_do_synchronize;'.substr($GLOBALS['TL_DCA']['tl_newsletter_channel']['palettes']['default'],$pos);

$GLOBALS['TL_DCA']['tl_newsletter_channel']['palettes']['default'] =$palette;

/**
 * Add selector an subpalettes
 */
$GLOBALS['TL_DCA']['tl_newsletter_channel']['palettes']['__selector__'] = array('clr_do_synchronize');
$GLOBALS['TL_DCA']['tl_newsletter_channel']['subpalettes'] = array('clr_do_synchronize' => 'clr_listId');


/**
 * Add fields 47_cleverreach to tl_newsletter_channel
 */
$GLOBALS['TL_DCA']['tl_newsletter_channel']['fields']['clr_do_synchronize'] = array(
    'label'                   => &$GLOBALS['TL_LANG']['tl_newsletter_channel']['clr_do_synchronize'],
    'exclude'                 => true,
    'inputType'               => 'checkbox',
    'eval'                    => array('submitOnChange'=>true),
    'sql'                     => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_newsletter_channel']['fields']['clr_listId'] = array(
    'label'                   => &$GLOBALS['TL_LANG']['tl_newsletter_channel']['clr_listId'],
    'exclude'                 => true,
    'inputType'               => 'text',
    'eval'                    => array('maxlength'=>255, 'tl_class'=>'w50', 'rgxp'=>'digit'),
    'sql'                     => "varchar(255) NOT NULL default ''"
);