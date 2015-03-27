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
class NewsletterChannelModel extends Model
{
    /**
     * Table name
     * @var string
     */
    protected static $strTable = 'tl_newsletter_channel';

    /**
     * @param $intId
     * @return mixed
     */
    public static function findOneChannelById($intId)
    {
        return static::findBy(array("id=?"), $intId);
    }

    /**
     * @param $intListId
     * @param $intId
     */
    public static function updateListId($intListId, $intId)
    {
        \Database::getInstance()->prepare("UPDATE tl_newsletter_channel SET clr_listId = ? WHERE id = ?")
            ->execute($intListId, $intId);
    }

}
