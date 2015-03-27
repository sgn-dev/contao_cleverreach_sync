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
 * Models
 */
$GLOBALS['TL_MODELS']['tl_newsletter_channel']                = 'Cleverreach\Model\NewsletterChannelModel';
$GLOBALS['TL_MODELS']['tl_newsletter_recipients']                = 'Cleverreach\Model\NewsletterRecipientsModel';

/**
 * Hooks
 */
$GLOBALS['TL_HOOKS']['activateRecipient'][] = array('Cleverreach\Hooks\Newsletter', 'activateRecipient');
$GLOBALS['TL_HOOKS']['removeRecipient'][] = array('Cleverreach\Hooks\Newsletter', 'removeRecipient');