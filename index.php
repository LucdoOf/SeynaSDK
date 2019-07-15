<?php
/**
 * Created by PhpStorm.
 * User: antoine
 * Date: 15/07/19
 * Time: 09:16
 */

use SeynaSDK\Models\Cancel;
use SeynaSDK\Models\Contract;
use SeynaSDK\Models\Entity;
use SeynaSDK\Models\Guarantee;
use SeynaSDK\Models\Receipt;
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

//createContract();
//createReceipt(Contract::getContract("contract-test-7"));
//var_dump(Contract::getContract("contract-test-2")->getReceipts());
//var_dump(Receipt::getReceipt("receipt-test-7"));