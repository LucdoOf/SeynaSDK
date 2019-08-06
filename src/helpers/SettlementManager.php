<?php

namespace SeynaSDK\Helpers;

use SeynaSDK\Models\Claim;
use SeynaSDK\Models\Guarantee;
use SeynaSDK\Models\Settlement;

/**
 * Created by PhpStorm.
 * User: lucas
 * Date: 16/07/19
 * Time: 09:55
 */
abstract class SettlementManager
{

    /**
     * @param $ref String
     * @param $claim Claim
     * @param $guarantees Guarantee[]
     * @return Settlement
     */
    public static function createSettlement($ref, $claim, $guarantees) {
        $settlement = new Settlement();
        $settlement->ref = $ref;
        $settlement->version = 0;
        $settlement->claim = ["id" => $claim->id, "version" => $claim->version];
        $settlement->guarantees = $guarantees;
        $settlement->createSettlement();
        return $settlement;
    }

}