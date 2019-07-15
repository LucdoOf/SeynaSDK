<?php
/**
 * Created by PhpStorm.
 * User: antoine
 * Date: 15/07/19
 * Time: 09:16
 */

use SeynaSDK\Models\Contract;

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

$contract = new Contract();
$contract->id = "contract-test";
$contract->guarantees = [
    "guarantee1" => new \SeynaSDK\Models\Guarantee([
       "premium" => 0,
       "tax" => 0,
       "discount" => 0,
       "broker_fee" => 0,
       "cost_acquisition" => 0
    ])
];
$contract->cancel = new \SeynaSDK\Models\Cancel([
   "date" => "2019-07-12T13:39:16Z",
    "reason" => "request"
]);
$contract->extra_broker_fee = 0;
$contract->coinsurance = 0;
$contract->end = "2019-07-12T13:39:16Z";
$contract->start = "2019-07-12T13:39:16Z";
$contract->subscription = "2019-07-10T15:19:43Z";
$contract->issuance = "2019-07-10T15:19:43Z";
$contract->splitting = new \SeynaSDK\Models\Splitting([
    "type" => "monthly",
    "fee" => 0
]);
$contract->beneficiary = [
    new \SeynaSDK\Models\Entity([
        "type" => "individual",
        "name" => "string",
        "registration" => "string",
        "representative" => "string",
        "address" => "string",
        "email" => "user@example.com",
        "phone" => "string",
        "birthday" => "2019-07-10"
    ])
];
$contract->customer = "Garofalo";
$contract->subscriber = $contract->beneficiary;
$contract->insured = $contract->beneficiary;
$contract->event = "new";
$contract->version = 0;

$contract->putContract();