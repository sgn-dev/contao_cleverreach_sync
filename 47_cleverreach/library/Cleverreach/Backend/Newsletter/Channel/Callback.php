<?php

/**
 * Synchronisation width Cleverreach for Contao Open Source CMS
 *
 * Copyright (C) 2015 47gradnord.de
 *
 * @package    47_cleverreach
 * @license    http://opensource.org/licenses/lgpl-3.0.html LGPL
 */

namespace Cleverreach\Backend\Newsletter\Channel;

use \Cleverreach\SOAP\CleverReach;
use \Cleverreach\Model\NewsletterChannelModel;



class Callback extends \Backend
{

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->objCleverReach = new CleverReach();

        parent::__construct();
    }

    /**
     * Handel Group Insert & Update on cleverreach.de
     * @param \DataContainer $dc
     */
    public function HandleGroup(\DataContainer $dc)
    {
        // TODO: Updatefunktion fehlt noch in der Schnittstelle von cleverreach.de


        // Insert Newslettergroup to cleverreach.de
        $intListId = $this->objCleverReach->GroupAdd($dc->activeRecord->title);

        if($intListId)
        {
            // Update ListId
            NewsletterChannelModel::updateListId($intListId, $dc->activeRecord->id);

            // Add Message
            \Message::addConfirmation('Newsletterverteiler '.$dc->activeRecord->title.' auf cleverreach.de angelegt');
        }

    }

    /**
     * Delete Group from cleverreach.de
     * @param \DataContainer $dc
     */
    public function deleteGroup(\DataContainer $dc)
    {
        // Delete Group
        $this->objCleverReach->groupDelete($dc->activeRecord->clr_listId, $dc->activeRecord->title);

    }

}