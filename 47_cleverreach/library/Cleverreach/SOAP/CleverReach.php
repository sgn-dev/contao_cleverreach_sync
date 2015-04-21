<?php

/**
 * Synchronisation width Cleverreach for Contao Open Source CMS
 *
 * Copyright (C) 2015 47gradnord.de
 *
 * @package    47_cleverreach
 * @license    http://opensource.org/licenses/lgpl-3.0.html LGPL
 */

namespace Cleverreach\SOAP;

/**
 * Class CleverReach
 * @package Cleverreach\SOAP
 */
class CleverReach extends \Backend{

    /**
     * @var $strApiKey
     */
    protected static $strApiKey;

    /**
     * @var $strWsdlUrl
     */
    protected static $strWsdlUrl;

    /**
     * Constructor
     */
    public function __construct()
    {
        try {
            $this->apiKey = \Config::get('clr_api_key');
            $this->soap = new \SoapClient(\Config::get('clr_wsdlUrl'));

        } catch (Exception $e) {
            $this->log("Kein API-Key oder WSDL-File für cleverreach.de in den Einstellungen hinterlegt", 'CleverReach::construct', TL_ERROR);
        }

        parent::__construct();
    }


    /**
     * Add new Recipient to a defined List
     * @param $strEmail
     * @param $strListId
     */
    public function addRecipient($strEmail, $strListId)
    {
        // Check if soap available
        if ($this->soap) {
            $strNewRecipient = array(
                'email' => $strEmail,
                'registered' => time(),
                'activated' => time(),
                'source' => 'CMS CONTAO'
            );

            // Add Recipient and define Return-Message
            $strReturn = $this->soap->receiverAdd($this->apiKey, $strListId, $strNewRecipient);

            // Check Return Message
            if ($strReturn->status == "SUCCESS") {
                $this->log($strEmail . " hinzugefügt zu cleaverreach.de " . $strReturn->message, "CleverReach::addRecipient", TL_NEWSLETTER);

                return true;

            } else {
                $this->log("Fehler beim Hinzufügen von  " . $strEmail . " zu cleaverreach.de -" . $strReturn->message, "CleverReach::addRecipient", TL_ERROR);

                return false;
            }
        } else {
            $this->log("Fehler beim Hinzufügen von  " . $strEmail . " zu cleaverreach.de - Keine Verbindung zur SOAP-Schnittstelle", "CleverReach::addRecipient", TL_ERROR);
            return false;
        }
    }

    /**
     * Get Reciever by E-Mail
     * @param $strEmail
     * @param $intListId
     * @return bool
     */
    public function receiverGetByEmail($strEmail, $intListId)
    {
        // Check if soap available
        if($this->soap)
        {
            // Initiate the Soap-Request
            $objReturn = $this->soap->receiverGetByEmail ($this->apiKey, $intListId, $strEmail);

            // return the Response Object
            return $objReturn;
        } else {

            $this->log("Fehler beim Einlesen von  " . $strEmail . " von cleaverreach.de - Keine Verbindung zur SOAP-Schnittstelle", "CleverReach::receiverGetByEmail", TL_ERROR);
            return false;
        }
    }

    /**
     * Set Reciever Inactive
     * @param $strEmail
     * @param $intListId
     * @return bool
     */
    public function receiverSetInactive($strEmail, $intListId)
    {
        // Check if soap available
        if($this->soap)
        {
            // Initiate the Soap-Request
            $objReturn = $this->soap->receiverSetInactive  ($this->apiKey, $intListId, $strEmail);

            // Check the Response
            if($objReturn->status=="SUCCESS")
            {
                // Check if Recipient already inactivated
                if(!$objReturn->data->active)
                {
                    return true;
                } else
                {
                    return false;
                }
            }
        } else {
            $this->log("Fehler beim Einlesen von  " . $strEmail . " von cleaverreach.de - Keine Verbindung zur SOAP-Schnittstelle", "CleverReach::receiverSetInactive", TL_ERROR);
            return false;
        }
    }

    /**
     * Set Recipient Active
     * @param $strEmail
     * @param $intListId
     * @return bool
     */
    public function receiverSetActive($strEmail, $intListId)
    {
        // Check if soap available
        if($this->soap)
        {
            // Initiate the Soap-Request
            $objReturn = $this->soap->receiverSetActive($this->apiKey, $intListId, $strEmail);

            // Check the Response
            if($objReturn->status=="SUCCESS")
            {
                // Check if Recipient already inactivated
                if($objReturn->data->active)
                {
                    return true;
                } else
                {
                    return false;
                }
            }
        } else {
            $this->log("Fehler beim Einlesen von  " . $strEmail . " von cleaverreach.de - Keine Verbindung zur SOAP-Schnittstelle", "CleverReach::receiverSetActive", TL_ERROR);
            return false;
        }
    }

    /**
     * Delete a Recipient
     * @param $strEmail
     * @param $intListId
     * @return bool
     */
    public function receiverDelete ($strEmail, $intListId)
    {
        // Check if soap available
        if($this->soap)
        {
            // Initiate the Soap-Request
            $objReturn = $this->soap->receiverDelete($this->apiKey, $intListId, $strEmail);

            // Check the Response
            if($objReturn->status=="SUCCESS")
            {
                // Log
                $this->log($strEmail . " ebenfalls aus cleaverreach.de entfernt.", "CleverReach::receiverDelete", TL_NEWSLETTER);

                return true;

            }
        } else {
            $this->log("Fehler beim Einlesen von  " . $strEmail . " von cleaverreach.de - Keine Verbindung zur SOAP-Schnittstelle", "CleverReach::receiverDelete", TL_ERROR);
            return false;
        }
    }

    /**
     * Add a new Group
     * @param $strChannel
     * @return bool
     */
    public function GroupAdd($strChannel)
    {
        // Check if soap available
        if($this->soap)
        {
            // Initiate the Soap-Request
            $objReturn = $this->soap->GroupAdd($this->apiKey, $strChannel);

            // Check the Response
            if($objReturn->status=="SUCCESS")
            {
                // Check if an ID exists
                if($objReturn->data->id!="")
                {
                    // Log
                    $this->log('Gruppe '.$strChannel . " auf cleaverreach.de angelegt.", "CleverReach::GroupAdd", TL_NEWSLETTER);

                    return $objReturn->data->id;
                }
            }
        } else {
            $this->log("Fehler beim Anlegen der Gruppe " . $strChannel . " auf cleaverreach.de - Keine Verbindung zur SOAP-Schnittstelle", "CleverReach::GroupAdd", TL_ERROR);
            return false;
        }
    }

    /**
     * Delete Group
     * @param $intListId
     * @param $strChannel
     * @return bool
     */
    public function groupDelete($intListId, $strChannel)
    {
        // Check if soap available
        if($this->soap)
        {
            // Initiate the Soap-Request
            $objReturn = $this->soap->groupDelete($this->apiKey, $intListId);

            // Check the Response
            if($objReturn->status=="SUCCESS")
            {
                // Log
                $this->log('Gruppe '.$strChannel . " auf cleaverreach.de gelöscht.", "CleverReach::groupDelete", TL_NEWSLETTER);

                // return
                return true;
            }
        } else {
            $this->log("Fehler beim Löschen der Gruppe " . $strChannel . " auf cleaverreach.de - Keine Verbindung zur SOAP-Schnittstelle", "CleverReach::groupDelete", TL_ERROR);
            return false;
        }
    }

    /**
     * Get Group Details
     * @param $intListId
     * @param $strChannel
     * @return bool
     */
    public function getGroupDetails($intListId, $strChannel)
    {
        // Check if soap available
        if($this->soap)
        {
            // Initiate the Soap-Request
            $objReturn = $this->soap->groupGetDetails($this->apiKey, $intListId);

            // Check the Response
            if($objReturn->status=="SUCCESS")
            {
                // Check if Group exists
                if($intListId == $objReturn->data->id)
                {
                    return true;
                }
            }
        }
        else {
            $this->log("Fehler beim Auslesen der Gruppe " . $strChannel . " auf cleaverreach.de - Keine Verbindung zur SOAP-Schnittstelle", "CleverReach::getGroupDetails", TL_ERROR);
            return false;
        }
    }

    public function receiverUpdateBatch($intListId, $objRecipients, $strChannel)
    {
        // Check if soap available
        if($this->soap)
        {
            // Define and Loop the User-Array to synchronize
            $arrUser = array();

            foreach($objRecipients as $item)
            {
                $arrUser[] = array(
                    'email' => $item->email
                );
            }

            // Initiate the Soap-Request
            $objReturn = $this->soap->receiverUpdateBatch($this->apiKey, $intListId, $arrUser);

            // Check the Response
            if($objReturn->status=="SUCCESS")
            {
                // Log
                $this->log('Abonnenten in Gruppe '.$strChannel . " auf cleaverreach.de aktualisiert.", "CleverReach::receiverUpdateBatch", TL_NEWSLETTER);
                return true;
            }
        }
        else {
            $this->log("Fehler beim Synchroniseren der Abonnenten in der Gruppe " . $strChannel . " auf cleaverreach.de - Keine Verbindung zur SOAP-Schnittstelle", "CleverReach::receiverUpdateBatch", TL_ERROR);

            return false;
        }
    }

}