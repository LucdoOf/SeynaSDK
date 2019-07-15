<?php

namespace SeynaSDK\Models;

use SeynaSDK\SeynaSDK;
use SeynaSDK\Utils\JSONBuilder;
use SeynaSDK\Core\Dbg;

/**
 * Created by PhpStorm.
 * User: lucas
 * Date: 15/07/19
 * Time: 14:36
 */

class Receipt {

    use JSONBuilder;

    static $columns = ["id","version","event","contract","issued","due","paid","start","end","guarantees"];

    /** @var Indentifiant du reçu (unique par portfolio) */
    public $id;
    /** @var Version du reçu */
    public $version;
    /** @var Evenement lié à la version du reçu */
    public $event;
    /** @var Contract lié */
    public $contract;
    /** @var Date de publication du reçu */
    public $issued;
    /** @var Date d'échéance */
    public $due;
    /** @var Date du paiment si disponible */
    public $paid;
    /** @var Date de début de cover du reçu */
    public $start;
    /** @var Date de fin de cover du reçu */
    public $end;
    /** @var Garanties */
    public $guarantees;

    /**
     * Splitting constructor.
     * @param array $data Array Données reçues
     */
    public function __construct($data = []) {
        foreach ($data as $k => $v){
            if(property_exists($this,$k)){
                if($k == "guarantees"){
                    $this->{$k} = [];
                    foreach ($v as $kk => $vv){
                        $this->{$k}[$kk] = new Guarantee($vv);
                    }
                } else {
                    $this->{$k} = $v;
                }
            } else {
                Dbg::logs("Missing variable in Receipt: " . $k . " => " . $v, Dbg::L_ERROR);
            }
        }
    }

    /**
     * Créé ou met a jour le receipt chez seyna
     */
    public function putReceipt(){
        $requestManager = SeynaSDK::getInstance()->getRequestManager();
        $data = $this->toJSON();
        $request = $requestManager->request("portfolios/".PORTFOLIO_ID."/receipts/".$this->id, "PUT", $data);
        return $request;
    }

    /**
     * Récupère un receipt par son identifiant unique
     * @param $id
     * @return Receipt|Request
     */
    public static function getReceipt($id){
        $requestManager = SeynaSDK::getInstance()->getRequestManager();
        $request = $requestManager->request("portfolios/".PORTFOLIO_ID."/receipts/".$id);
        $response = $request->getJSONResponse();
        if(!empty($response)){
            return new Receipt($response);
        } else {
            Dbg::logs("Unknown receipt " . $id);
            return $request;
        }
    }

    /**
     * Récupère la liste des receipt par version
     */
    public function getHistory(){
        $requestManager = SeynaSDK::getInstance()->getRequestManager();
        $request = $requestManager->request("portfolios/".PORTFOLIO_ID."/receipts/".$this->id."/versions");
        $response = $request->getJSONResponse();
        $contracts = [];
        if(isset($response["data"])){
            foreach ($response["data"] as $contract) {
                $contracts[] = new Receipt($contract);
            }
        } else {
            Dbg::logs("Missing data index in receipts getHistory()");
        }
        return $contracts;
    }

}