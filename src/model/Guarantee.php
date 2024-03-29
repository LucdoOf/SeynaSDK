<?php

namespace SeynaSDK\Models;

use SeynaSDK\Core\Dbg;
use SeynaSDK\Core\JSONBuilder;

/**
 * Created by PhpStorm.
 * User: lucas
 * Date: 15/07/19
 * Time: 10:21
 */
class Guarantee
{

    use JSONBuilder;

    static $columns = ["premium", "tax", "discount", "broker_fee", "cost_acquisition"];

    /** @var Premium without tax, fees, commissions Number >= 0 */
    private $premium;
    /** @var Tax paid Number >= 0 */
    private $tax;
    /** @var Discount given on this contract Number >= 0 */
    private $discount;
    /** @var Broker fee Number >= 0 */
    private $broker_fee;
    /** @var Cost of acquisition given to the distributor Number >= 0 */
    private $cost_acquisition;

    /**
     * Guarantee constructor.
     *
     * @param array $data Array Données reçues
     */
    public function __construct($data = []) {
        foreach ($data as $k => $v) {
            if (property_exists($this, $k)) {
                $this->{$k} = $v;
            } else {
                Dbg::logs("Missing variable in Guarantee: " . $k . " => " . $v, Dbg::L_ERROR);
            }
        }
    }


}