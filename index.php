<?php

/**
 * Created by PhpStorm.
 * User: lucas
 * Date: 15/07/19
 * Time: 09:16
 */

use SeynaSDK\Models\Cancel;
use SeynaSDK\Models\Claim;
use SeynaSDK\Models\Contract;
use SeynaSDK\Models\Entity;
use SeynaSDK\Models\Guarantee;
use SeynaSDK\Models\Receipt;
use SeynaSDK\Models\Settlement;
use SeynaSDK\Models\Splitting;

require "conf.inc.php";
require "utils/JSONBuilder.php";;
require "src/model/Contract.php";
require "src/model/Model.php";
require "src/model/Request.php";
require "src/core/Dbg.php";
require "src/core/database/Sql.php";
require "src/core/database/DatabaseConnector.php";
require "api/RequestManager.php";
require "SeynaSDK.php";
require "src/model/Entity.php";
require "src/model/Cancel.php";
require "src/model/Splitting.php";
require "src/model/Guarantee.php";
require "src/model/Receipt.php";
require "src/model/Claim.php";
require "src/model/Settlement.php";

function createContract() {
    $contract = new Contract();
    $contract->id = "contract-test-7";
    $contract->guarantees = [
        "cancel" => new Guarantee([
            "premium"          => 0,
            "tax"              => 0,
            "discount"         => 0,
            "broker_fee"       => 0,
            "cost_acquisition" => 0
        ])
    ];
    $contract->cancel = new Cancel([
        "date"   => "2019-07-12T13:39:16Z",
        "reason" => "request"
    ]);
    $contract->extra_broker_fee = 0;
    $contract->coinsurance = 0;
    $contract->end = "2019-07-12T13:39:16Z";
    $contract->start = "2019-07-12T13:39:16Z";
    $contract->subscription = "2019-07-10T15:19:43Z";
    $contract->issuance = "2019-07-10T15:19:43Z";
    $contract->splitting = new Splitting([
        "type" => "monthly",
        "fee"  => 0
    ]);
    $contract->beneficiary = [
        new Entity([
            "type"           => "individual",
            "name"           => "string",
            "registration"   => "string",
            "representative" => "string",
            "address"        => "string",
            "email"          => "user@example.com",
            "phone"          => "string",
            "birthday"       => "2019-07-10"
        ])
    ];
    $contract->customer = "Garofalos";
    $contract->subscriber = $contract->beneficiary;
    $contract->insured = $contract->beneficiary;
    $contract->event = "new";
    $contract->version = 0;

    var_dump($contract->putContract());
}

function getContracts(){
    var_dump(Contract::getContracts());
}

function createReceipt($contract){
    $receipt = new Receipt();
    $receipt->id = "receipt-test-7";
    $receipt->version = 0;
    $receipt->event = "new";
    $receipt->contract = ["id" => $contract->id, "version" => $contract->version,"url" => $contract->url];
    $receipt->issued = "2019-07-10T15:19:43Z";
    $receipt->due = "2019-07-10T15:19:43Z";
    $receipt->paid = "2019-07-10T15:19:43Z";
    $receipt->start = "2019-07-10T15:19:43Z";
    $receipt->end = "2019-07-10T15:19:43Z";
    $receipt->guarantees = [
        "cancel" => new Guarantee([
            "premium"          => 0,
            "tax"              => 0,
            "discount"         => 0,
            "broker_fee"       => 0,
            "cost_acquisition" => 0
        ])
    ];

    var_dump($receipt->putReceipt());
}

function createClaim($contract){
    $claim = new Claim();
    $claim->id = "claim-test";
    $claim->version = 0;
    $claim->event = "new";
    $claim->contract = $contract->id;
    $claim->occurence = "2019-07-10";
    $claim->location = "string";
    $claim->notification = "2019-07-10";
    $claim->notification = "string";
    $claim->revaluation_reason = "string";
    $claim->guarantees = [
        "cancel" => new Guarantee([
            "premium"          => 0,
            "tax"              => 0,
            "discount"         => 0,
            "broker_fee"       => 0,
            "cost_acquisition" => 0
        ])
    ];
    \SeynaSDK\API\ClaimManager::createClaim("contract-test", $contract, "occurence", "location", "notification", "revaluation_reason", $guarantees);
    var_dump($claim->putClaim());
}

function createSettlement($claim){
    $settlement = new Settlement();
    $settlement->id = "settlement-test";
    $settlement->version = 0;
    $settlement->claim = ["id"=>$claim->id, "version"=>$claim->version];
    $settlement->guarantees = [
        "cancel" => new Guarantee([
            "premium"          => 0,
            "tax"              => 0,
            "discount"         => 0,
            "broker_fee"       => 0,
            "cost_acquisition" => 0
        ])
    ];

    var_dump($settlement->putSettlement());
}

//createSettlement(Claim::getClaim("claim-test"));

var_dump(Settlement::getSettlements());
var_dump(Claim::getClaim("claim-test")->getSettlements());

//var_dump(Claim::getClaims());

//createClaim(Contract::getContract("contract-test-7"));
//var_dump(Contract::getContract("contract-test-7")->getClaims());

//createContract();
//createReceipt(Contract::getContract("contract-test-7"));
//var_dump(Contract::getContract("contract-test-2")->getReceipts());
//var_dump(Receipt::getReceipt("receipt-test-7"));