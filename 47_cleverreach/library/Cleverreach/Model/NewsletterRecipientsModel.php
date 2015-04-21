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
     * Find one Recipient by ID
     * @param $intId
     * @return mixed
     */
    public static function findOneRecipientById($intId)
    {
        return static::findBy(array("id=?"), $intId);
    }

    /**
     * Find active Recipients by pid
     * @param $intPId
     * @return \Model\Collection|null
     */
    public static function findActiveRecipientsByPid($intPId)
    {
        $strIsActive = "1";

        $t = static::$strTable;
        return static::findBy(array("$t.pid=? AND $t.active=?"), array($intPId, $strIsActive));
    }

    /**
     * Reset Flag Synchronize
     * @param $intId
     */
    public static function resetFlagSynchronizeById($intId)
    {
        \Database::getInstance()->prepare("UPDATE tl_newsletter_recipients SET clr_activate_synchronisation = ? WHERE id = ?")
            ->execute("", $intId);
    }

}