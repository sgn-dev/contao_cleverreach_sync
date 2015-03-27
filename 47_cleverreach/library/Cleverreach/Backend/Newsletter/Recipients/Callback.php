<?php

/**
 * Synchronisation width Cleverreach for Contao Open Source CMS
 *
 * Copyright (C) 2015 47gradnord.de
 *
 * @package    47_cleverreach
 * @license    http://opensource.org/licenses/lgpl-3.0.html LGPL
 */

namespace Cleverreach\Backend\Newsletter\Recipients;

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
     * @param \DataContainer $dc
     */
    public function DeleteRecipient(\DataContainer $dc)
    {
        // Get the NewsletterChannel-Model
        $objChannel = NewsletterChannelModel::findOneChannelById($dc->activeRecord->pid);

        // Delete Recipient
        $this->objCleverReach->receiverDelete($dc->activeRecord->email, $objChannel->clr_listId);

    }

    /**
     * @param \DataContainer $dc
     */
    public function HandleRecipient(\DataContainer $dc)
    {
        // Check if Synchronisation-Checkbox is activated
        if($dc->activeRecord->clr_activate_synchronisation=="1")
        {
            // Get the NewsletterChannel-Model
            $objChannel = NewsletterChannelModel::findOneChannelById($dc->activeRecord->pid);

            // Check if the Recipient should be activated
            if($dc->activeRecord->active=="1")
            {
                // Check if Recipient already exists
                $objRecipient = $this->objCleverReach->receiverGetByEmail($dc->activeRecord->email, $objChannel->clr_listId);


                // Recipient already exists and is activated
                if($objRecipient->data->active)
                {
                    // Add Message
                    \Message::addError('Newsletterempfänger '.$dc->activeRecord->email.' konnte nicht synchronisiert werden, da die Adresse in dieser Liste bereits aktiviert ist.');

                    return false;
                }

                // Recipient already exists and is NOT activated
                if(!$objRecipient->data->active)
                {

                    if($this->objCleverReach->receiverSetActive($dc->activeRecord->email, $objChannel->clr_listId))
                    {
                        // Add Message
                        \Message::addConfirmation('Newsletterempfänger '.$dc->activeRecord->email.' mit cleverreach.de synchronisiert und (wieder) aktiviert');

                        return;

                    }
                }

                // Add the User to cleverreach.de
                if($this->objCleverReach->addRecipient($dc->activeRecord->email, $objChannel->clr_listId))
                {
                    // Add Message
                    \Message::addConfirmation('Newsletterempfänger '.$dc->activeRecord->email.' mit cleverreach.de synchronisiert und aktiviert');

                } else
                {
                    // Add Message
                    \Message::addError('Newsletterempfänger '.$dc->activeRecord->email.' konnte nicht synchronisiert werden. Bitte überprüfen Sie die System-Logs');

                }
            }

            // Check if Recipient should be inactivated
            if($dc->activeRecord->active!="1")
            {
                // Check if Recipient already exists in this List
                if(!$this->objCleverReach->receiverGetByEmail($dc->activeRecord->email, $objChannel->clr_listId))
                {
                    // Add Message
                    \Message::addError('Newsletterempfänger '.$dc->activeRecord->email.' konnte nicht synchronisiert werden, da dieser noch nie mit cleverreach.de synchronisiert wurde.');

                    return false;
                }

                // Inactivate the given Recipient
                if($this->objCleverReach->receiverSetInactive($dc->activeRecord->email, $objChannel->clr_listId))
                {
                    // Add Message
                    \Message::addConfirmation('Newsletterempfänger '.$dc->activeRecord->email.' mit cleverreach.de synchronisiert und deaktiviert');

                }

            }

            // Reset the Synchronisation Flag
            NewsletterRecipientsModel::resetFlagSynchronizeById($dc->activeRecord->id);

        }
    }

}