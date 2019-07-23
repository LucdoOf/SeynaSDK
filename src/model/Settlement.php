<?php

namespace SeynaSDK\Models;

use SeynaSDK\Core\Dbg;
use SeynaSDK\SeynaSDK;
use SeynaSDK\Core\JSONBuilder;

/**
 * Created by PhpStorm.
 * User: lucas
 * Date: 15/07/19
 * Time: 16:44
 */
class Settlement
{

    use JSONBuilder;

    static $columns = ["id", "version", "claim", "guarantees"];

    /** @var Identifiant du règlement */
    public $id;
    /** @var Version du règlement */
    public $version;
    /** @var Claim associé */
    public $claim;
    /** @var Guarantees */
    public $guarantees;

    /**
     * Settlements constructor.
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
                Dbg::logs("Missing variable in Settlements: " . $k . " => " . $v, Dbg::L_ERROR);
            }
        }
    }

    /**
     * Récupère les settlements du portofolio
     */
    public static function getSettlements() {
        $requestManager = SeynaSDK::getInstance()->getRequestManager();
        $request = $requestManager->request("portfolios/" . PORTFOLIO_ID . "/settlements");
        $response = $request->getJSONResponse();
        $settlements = [];
        if (isset($response["data"])) {
            foreach ($response["data"] as $settlement) {
                $settlements[] = new Settlement($settlement);
            }
        } else {
            Dbg::logs("Missing data index in getSettlements()");
        }
        return $settlements;
    }

    /**
     * Créé ou met a jour le settlement chez seyna
     */
    public function putSettlement() {
        $requestManager = SeynaSDK::getInstance()->getRequestManager();
        $data = $this->toJSON();
        $request = $requestManager->request("portfolios/" . PORTFOLIO_ID . "/settlements/" . $this->id, "PUT", $data);
        return $request;
    }

    /**
     * Récupère un settlement par son identifiant unique
     *
     * @param $id
     * @return Settlement|Request
     */
    public static function getSettlement($id) {
        $requestManager = SeynaSDK::getInstance()->getRequestManager();
        $request = $requestManager->request("portfolios/" . PORTFOLIO_ID . "/settlements/" . $id);
        $response = $request->getJSONResponse();
        if (!empty($response)) {
            return new Settlement($response);
        } else {
            Dbg::logs("Unknown settlement " . $id);
            return $request;
        }
    }


}