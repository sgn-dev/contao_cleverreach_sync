<?php

/**
 * Synchronisation width Cleverreach for Contao Open Source CMS
 *
 * Copyright (C) 2015 47gradnord.de
 *
 * @package    47_cleverreach
 * @license    http://opensource.org/licenses/lgpl-3.0.html LGPL
 */

namespace Cleverreach\Model;

use Contao\Model;

/**
 * Class NewsletterChannelModel
 * @package Cleverreach\Model
 */
class NewsletterRecipientsModel extends Model
{
    /**
     * Table name
     * @var string
     */
    protected static $strTable = 'tl_newsletter_recipients';

    /**
     * @param $intId
     * @return mixed
     */
    public static function findOneRecipientById($intId)
    {
        return static::findBy(array("id=?"), $intId);
    }

    /**
     * @param $intId
     */
    public static function resetFlagSynchronizeById($intId)
    {
        \Database::getInstance()->prepare("UPDATE tl_newsletter_recipients SET clr_activate_synchronisation = ? WHERE id = ?")
            ->execute("", $intId);
    }

}