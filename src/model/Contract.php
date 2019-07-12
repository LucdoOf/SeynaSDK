<?php

use SeynaSDK\Core\Dbg;
use SeynaSDK\SeynaSDK;

/**
 * Created by PhpStorm.
 * User: lucas
 * Date: 12/07/19
 * Time: 16:15
 */

class Contract {

    /** @var String Identifiant du contrat */
    public $id;
    /** @var int Version récupérée du contrat */
    public $version;
    /** @var string Evennement associé à la version actuelle du contrat */
    public $event;
    /** @var string Date de création du contrat */
    public $created;
    /** @var string Date de la dernière mise à jour de l'objet */
    public $updated;
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
     * @param $data Array Données reçues lors d'un get contract information
     * @see https://seyna.eu/docs/api#operation/contract_get
     */
    public function __construct($data) {
        foreach ($data as $k => $v){
            if($this->{$k}){
                $this->{$k} = $v;
            } else {
                Dbg::logs("Missing variable in contract: " . $k . " => " . $v, Dbg::L_ERROR);
            }
        }
    }

    /**
     * Récupère les contracts du portofolio
     */
    public static function getContracts(){
        $requestManager = SeynaSDK::getInstance()->getRequestManager();
        $request = $requestManager->request("portofolios/".PORTOFOLIO_ID."/contracts");
        $response = $request->getJSONResponse();
        $contracts = [];
        foreach ($response["data"] as $contract){
            $contracts[] = new Contract($contract);
        }
        return $contracts;
    }



}