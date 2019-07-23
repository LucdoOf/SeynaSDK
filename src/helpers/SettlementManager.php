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
     * @param $id String
     * @param $claim Claim
     * @param $guarantees Guarantee[]
     * @return Settlement
     */
    public static function createSettlement($id, $claim, $guarantees) {
        $settlement = new Settlement();
        $settlement->id = $id;
        $settlement->version = 0;
        $settlement->claim = ["id" => $claim->id, "version" => $claim->version];
        $settlement->guarantees = $guarantees;
        $settlement->putSettlement();
        return $settlement;
    }

}