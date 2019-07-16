<?php

namespace SeynaSDK\API;

use SeynaSDK\Models\Contract;
use SeynaSDK\Models\Guarantee;
use SeynaSDK\Models\Claim;

/**
 * Created by PhpStorm.
 * User: lucas
 * Date: 16/07/19
 * Time: 09:49
 */

abstract class ClaimManager {

    /**
     * @param $id String
     * @param $contract Contract
     * @param $occurence String
     * @param $location String
     * @param $notification String
     * @param $revaluation_reason String
     * @param $guarantees Guarantee[]
     * @return Claim
     */
    public static function createClaim($id,$contract,$occurence,$location,$notification,$revaluation_reason,$guarantees){
        $claim = new Claim();
        $claim->id = $id;
        $claim->version = 0;
        $claim->event = "new";
        $claim->contract = $contract->id;
        $claim->occurence = $occurence;
        $claim->location = $location;
        $claim->notification = $notification;
        $claim->revaluation_reason = $revaluation_reason;
        $claim->guarantees = $guarantees;
        $claim->putClaim();
        return $claim;
    }

}