<?php

namespace SeynaSDK\Models;

use SeynaSDK\Core\Dbg;
use SeynaSDK\SeynaSDK;
use SeynaSDK\Utils\JSONBuilder;

class Claim
{
    use JSONBuilder;

    static $columns = [
        "id",
        "version",
        "event",
        "contract",
        "occurence",
        "location",
        "notification",
        "claim_type",
        "revaluation_reason",
        "guarantees",
    ];

    /** @var Identifiant du claim */
    public $id;
    /** @var Version actuelle du claim */
    public $version;
    /** @var Dernier évenement appliqué au claim */
    public $event;
    /** @var Identifiant du contrat associé au claim */
    public $contract;
    /** @var Date de l'occurence du claim */
    public $occurence;
    /** @var Location de l'occurence */
    public $location;
    /** @var Date de notification du claim */
    public $notification;
    /** @var Type du claim, spécifique au portfolio */
    public $claim_type;
    /** @var Raison de la révaluation du claim */
    public $revaluation_reason;
    /** @var Garanties */
    public $guarantees;

    /**
     * Claim constructor.
     *
     * @param array $data Array Données reçues
     */
    public function __construct($data = []) {
        foreach ($data as $k => $v) {
            if (property_exists($this, $k)) {
                if ($k == "guarantees") {
                    $this->{$k} = [];
                    foreach ($v as $kk => $vv) {
                        $this->{$k}[$kk] = new Guarantee($vv);
                    }
                } else {
                    $this->{$k} = $v;
                }
            } else {
                Dbg::logs("Missing variable in Claim: " . $k . " => " . $v, Dbg::L_ERROR);
            }
        }
    }

    /**
     * Récupère les claims du portofolio
     */
    public static function getClaims() {
        $requestManager = SeynaSDK::getInstance()->getRequestManager();
        $request = $requestManager->request("portfolios/" . PORTFOLIO_ID . "/claims");
        $response = $request->getJSONResponse();
        $claims = [];
        if (isset($response["data"])) {
            foreach ($response["data"] as $claim) {
                $claims[] = new Claim($claim);
            }
        } else {
            Dbg::logs("Missing data index in getClaims()");
        }
        return $claims;
    }

    /**
     * Créé ou met a jour le claim chez seyna
     */
    public function putClaim() {
        $requestManager = SeynaSDK::getInstance()->getRequestManager();
        $data = $this->toJSON();
        $request = $requestManager->request("portfolios/" . PORTFOLIO_ID . "/claims/" . $this->id, "PUT", $data);
        return $request;
    }

    /**
     * Récupère un claim par son identifiant unique
     *
     * @param $id
     * @return Claim|Request
     */
    public static function getClaim($id) {
        $requestManager = SeynaSDK::getInstance()->getRequestManager();
        $request = $requestManager->request("portfolios/" . PORTFOLIO_ID . "/claims/" . $id);
        $response = $request->getJSONResponse();
        if (!empty($response)) {
            return new Claim($response);
        } else {
            Dbg::logs("Unknown claim " . $id);
            return $request;
        }
    }

    /**
     * Récupère la liste des claim par version
     */
    public function getHistory() {
        $requestManager = SeynaSDK::getInstance()->getRequestManager();
        $request = $requestManager->request("portfolios/" . PORTFOLIO_ID . "/claims/" . $this->id . "/versions");
        $response = $request->getJSONResponse();
        $claims = [];
        if (isset($response["data"])) {
            foreach ($response["data"] as $claim) {
                $claims[] = new Claim($claim);
            }
        } else {
            Dbg::logs("Missing data index in claim getHistory()");
        }
        return $claims;
    }

    /**
     * Récupère la liste des settlements associés
     */
    public function getSettlements() {
        $requestManager = SeynaSDK::getInstance()->getRequestManager();
        $request = $requestManager->request("portfolios/" . PORTFOLIO_ID . "/claims/" . $this->id . "/settlements");
        $response = $request->getJSONResponse();
        $settlements = [];
        if (isset($response["data"])) {
            foreach ($response["data"] as $settlement) {
                $settlements[] = new Settlement($settlement);
            }
        } else {
            Dbg::logs("Missing data index in claim getSettlements()");
        }
        return $settlements;
    }

}