<?php

namespace SeynaSDK\API;

use SeynaSDK\Models\Cancel;
use SeynaSDK\Models\Contract;
use SeynaSDK\Models\Entity;
use SeynaSDK\Models\Guarantee;
use SeynaSDK\Models\Splitting;
use App\Core\Dbg;

/**
 * Created by PhpStorm.
 * User: lucas
 * Date: 16/07/19
 * Time: 09:35
 */

abstract class ContractManager {

    /**
     * @param $id String
     * @param $guarantees Guarantee[]
     * @param $cancel Cancel
     * @param $extra_broker_fee int
     * @param $coinsurance int
     * @param $end String
     * @param $start String
     * @param $subscription String
     * @param $issuance String
     * @param $splitting Splitting
     * @param $beneficiary Entity []
     * @param $customer String
     * @param $subscriber Entity[]
     * @param $insured Entity[]
     * @return Contract
     */
    public static function createContract($id,$guarantees,$cancel,$extra_broker_fee,$coinsurance,$end,$start,$subscription,$issuance,$splitting,$beneficiary,$customer,$subscriber,$insured){
        $contract = new Contract();
        $contract->id = $id;
        $contract->guarantees = $guarantees;
        $contract->cancel = $cancel;
        $contract->extra_broker_fee = $extra_broker_fee;
        $contract->coinsurance = $coinsurance;
        $contract->end = $end;
        $contract->start = $start;
        $contract->subscription = $subscription;
        $contract->issuance = $issuance;
        $contract->splitting = $splitting;
        $contract->beneficiary = $beneficiary;
        $contract->customer = $customer;
        $contract->subscriber = $subscriber;
        $contract->insured = $insured;
        $contract->event = "new";
        $contract->version = 0;
        Dbg::logs($contract->putContract(), Dbg::L_NOTICE);
        return $contract;
    }


}