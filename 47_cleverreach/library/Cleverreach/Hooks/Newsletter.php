<?php

/**
 * Synchronisation width Cleverreach for Contao Open Source CMS
 *
 * Copyright (C) 2015 47gradnord.de
 *
 * @package    47_cleverreach
 * @license    http://opensource.org/licenses/lgpl-3.0.html LGPL
 */

namespace Cleverreach\Hooks;

use \Cleverreach\SOAP\CleverReach;
use \Cleverreach\Model\NewsletterChannelModel;
use Contao\Frontend;

/**
 * Class CleverReach
 * @package Cleverreach\Hooks
 */
class Newsletter extends Frontend{

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->objCleverReach = new CleverReach();

        parent::__construct();
    }

    public function activateRecipient($strEmail, $arrRecipients, $arrChannels)
    {
        // Loop the Channels
        foreach($arrChannels as $item)
        {
            // Get the Channel-Object
            $objChannel = NewsletterChannelModel::findOneChannelById($item);

            // Add Recipient to cleverreach
            $this->objCleverReach->addRecipient($strEmail, $objChannel->clr_listId);
        }

    }

    public function removeRecipient($strEmail, $arrChannels)
    {
        // Loop the Channels
        foreach($arrChannels as $item)
        {
            // Get the Channel-Object
            $objChannel = NewsletterChannelModel::findOneChannelById($item);

            // Add Recipient to cleverreach
            $this->objCleverReach->receiverDelete($strEmail, $objChannel->clr_listId);
        }

    }

}