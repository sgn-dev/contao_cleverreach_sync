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
 * Add palettes 47_cleverreach to tl_settings
 */
$pos=strpos($GLOBALS['TL_DCA']['tl_settings']['palettes']['default'],'{update_legend');

$palette=substr($GLOBALS['TL_DCA']['tl_settings']['palettes']['default'],0,$pos).'{cleverreach_legend},clr_wsdlUrl, clr_api_key;'.substr($GLOBALS['TL_DCA']['tl_settings']['palettes']['default'],$pos);

$GLOBALS['TL_DCA']['tl_settings']['palettes']['default'] =$palette;

/**
 * Add fields 47_cleverreach to tl_settings
 */
$GLOBALS['TL_DCA']['tl_settings']['fields']['clr_wsdlUrl'] = array(
    'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['clr_wsdlUrl'],
    'exclude'                 => true,
    'inputType'               => 'text',
    'eval'                    => array('maxlength'=>255, 'tl_class'=>'w50')
);
$GLOBALS['TL_DCA']['tl_settings']['fields']['clr_api_key'] = array(
    'label'                   => &$GLOBALS['TL_LANG']['tl_settings']['clr_api_key'],
    'exclude'                 => true,
    'inputType'               => 'text',
    'eval'                    => array('maxlength'=>255, 'tl_class'=>'w50')
);