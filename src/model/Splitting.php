<?php

namespace SeynaSDK\Models;

use SeynaSDK\Core\Dbg;
use SeynaSDK\Utils\JSONBuilder;

/**
 * Created by PhpStorm.
 * User: lucas
 * Date: 15/07/19
 * Time: 10:16
 */
class Splitting
{

    use JSONBuilder;

    static $columns = ["type", "fee"];

    /** @var Type du splitting eg: Monthly */
    public $type;
    /** @var Fee du splitting si elle existe */
    public $fee;

    /**
     * Splitting constructor.
     *
     * @param array $data Array Données reçues
     */
    public function __construct($data = []) {
        foreach ($data as $k => $v) {
            if (property_exists($this, $k)) {
                $this->{$k} = $v;
            } else {
                Dbg::logs("Missing variable in Splitting: " . $k . " => " . $v, Dbg::L_ERROR);
            }
        }
    }

}