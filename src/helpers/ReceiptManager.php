<?php

namespace SeynaSDK\Helpers;

use SeynaSDK\Core\Dbg;
use SeynaSDK\Models\Contract;
use SeynaSDK\Models\Guarantee;
use SeynaSDK\Models\Receipt;

/**
 * Created by PhpStorm.
 * User: lucas
 * Date: 16/07/19
 * Time: 09:44
 */
abstract class ReceiptManager
{

    /**
     * @param $ref String
     * @param $contract Contract
     * @param $issued String
     * @param $due String
     * @param $paid String
     * @param $start String
     * @param $end String
     * @param $guarantees Guarantee[]
     * @return Receipt
     */
    public static function createReceipt($ref, $contract, $issued, $due, $paid, $start, $end, $guarantees) {
        $receipt = new Receipt();
        $receipt->ref = $ref;
        $receipt->version = 0;
        $receipt->event = "new";
        $receipt->contract = ["id" => $contract->id, "version" => $contract->version, "url" => $contract->url];
        $receipt->issued = $issued;
        $receipt->due = $due;
        $receipt->paid = $paid;
        $receipt->start = $start;
        $receipt->end = $end;
        $receipt->guarantees = $guarantees;
        Dbg::logs($receipt->createReceipt(), Dbg::L_NOTICE);
        return $receipt;
    }

}