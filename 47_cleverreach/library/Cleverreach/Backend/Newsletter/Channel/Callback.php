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
use \Cleverreach\Model\NewsletterRecipientsModel;



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

        // If cleverreach returns a ListID
        if($intListId)
        {
            // Update ListId
            NewsletterChannelModel::updateListId($intListId, $dc->activeRecord->id);

            // Add Message
            \Message::addConfirmation('Newsletterverteiler '.$dc->activeRecord->title.' auf cleverreach.de angelegt');
        }

        // Check if Group Exists an Update all Reciever
        if($this->objCleverReach->getGroupDetails($dc->activeRecord->clr_listId, $dc->activeRecord->title))
        {
            $objChannelRecipients = NewsletterRecipientsModel::findActiveRecipientsByPid($dc->activeRecord->id);

            // If there is no active Recipient in the Group
            if($objChannelRecipients== NULL)
            {
                // Add Message
                \Message::addConfirmation('Keine Synchronisation möglich, da keine aktiven Abonnenten für den Verteiler '.$dc->activeRecord->title.' verfügbar sind.');

                return;
            }
            // Update active Recipients
            else {

                if($this->objCleverReach->receiverUpdateBatch($dc->activeRecord->clr_listId, $objChannelRecipients,$dc->activeRecord->title))
                {
                    // Add Message
                    \Message::addConfirmation('Alle aktiven Abonnenten des Verteilers '.$dc->activeRecord->title.' erfolgreich mit cleverreach.de synchronisert.');

                    return;
                }
            }
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