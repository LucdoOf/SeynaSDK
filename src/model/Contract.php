<?php

namespace SeynaSDK\Models;

use SeynaSDK\SeynaSDK;
use SeynaSDK\Core\Dbg;
use SeynaSDK\Utils\JSONBuilder;

/**
 * Created by PhpStorm.
 * User: lucas
 * Date: 12/07/19
 * Time: 16:15
 */

class Contract {

    use JSONBuilder;

    static $columns = ["id","version","event","customer","subscriber","insured","beneficiary","splitting","subscription","issuance","start","end","coinsurance","extra_broker_fee","cancel","guarantees"];

    /** @var String Identifiant du contrat */
    public $id;
    /** @var int Version récupérée du contrat */
    public $version;
    /** @var string Evennement associé à la version actuelle du contrat */
    public $event;
    /** @var string Identifiant unique qui lie le contrat a un customer unique */
    public $customer;
    /** @var Entity[] Liste des subscribers */
    public $subscriber;
    /** @var Entity[] Liste des assurés */
    public $insured;
    /** @var Entity[] Liste des beneficiaires */
    public $beneficiary;
    /** @var Splitting Splitting du contrat */
    public $splitting;
    /** @var string Date de la souscription */
    public $subscription;
    /** @var string Date de l'émission */
    public $issuance;
    /** @var string Date de début de la cover period */
    public $start;
    /** @var string Date de fin de la cover period */
    public $end;
    /** @var number Entre 0 et 1, coefficient 'coinsurance' pour ce contract, si applicable */
    public $coinsurance;
    /** @var number >= 0 */
    public $extra_broker_fee;
    /** @var Cancel */
    public $cancel;
    /** @var Property[] propriétés du contract */
    public $guarantees;

    /**
     * Contract constructor.
     * @param array $data Array Données reçues lors d'un get contract information
     * @see https://seyna.eu/docs/api#operation/contract_get
     */
    public function __construct($data = []) {
        foreach ($data as $k => $v){
            if(property_exists($this,$k)){
                if(is_array($v)){
                    if($k == "subscriber" || $k == "insured" || $k == "beneficiary"){
                        $this->{$k} = [];
                        foreach ($v as $vv){
                            array_push($this->{$k}, new Entity($vv));
                        }
                    } else {
                        if($k == "splitting"){
                            $this->{$k} = new Splitting($v);
                        } else if($k == "cancel"){
                            $this->{$k} = new Cancel();
                        } else if($k == "guarantees"){
                            $this->{$k} = [];
                            foreach ($v as $kk => $vv){
                                $this->{$k}[$kk] = new Guarantee($vv);
                            }
                        } else {
                            Dbg::logs("Missing array variable in contract: " . $k, Dbg::L_ERROR);
                        }
                    }
                } else {
                    $this->{$k} = $v;
                }
            } else {
                Dbg::logs("Missing variable in contract: " . $k, Dbg::L_ERROR);
            }
        }
    }

    /**
     * Récupère les contracts du portofolio
     */
    public static function getContracts(){
        $requestManager = SeynaSDK::getInstance()->getRequestManager();
        $request = $requestManager->request("portfolios/".PORTFOLIO_ID."/contracts");
        $response = $request->getJSONResponse();
        var_dump($response);
        $contracts = [];
        if(isset($response["data"])) {
            foreach ($response["data"] as $contract) {
                $contracts[] = new Contract($contract);
            }
        } else {
            Dbg::logs("Missing data index in getContracts()");
        }
        return $contracts;
    }

    /**
     * Créé ou met a jour le contract chez seyna
     */
    public function putContract(){
        $requestManager = SeynaSDK::getInstance()->getRequestManager();
        $data = $this->toJSON();
        $request = $requestManager->request("portfolios/".PORTFOLIO_ID."/contracts/".$this->id, "PUT", $data);
        var_dump($request);
    }



}