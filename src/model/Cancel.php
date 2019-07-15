<?php

namespace SeynaSDK\Models;

use SeynaSDK\Core\Dbg;

/**
 * Created by PhpStorm.
 * User: lucas
 * Date: 15/07/19
 * Time: 10:17
 */

class Cancel {

    /** @var Date de l'annulation string<date-time> */
    public $date;
    /** @var Raison de l'annulation Enum["request","payment","fraud"] */
    public $reason;

    /**
     * Cancel constructor.
     * @param array $data Array Données reçues
     */
    public function __construct($data = []) {
        foreach ($data as $k => $v){
            if(property_exists($this,$k)){
                $this->{$k} = $v;
            } else {
                Dbg::logs("Missing variable in Cancel: " . $k . " => " . $v, Dbg::L_ERROR);
            }
        }
    }

    public function toJSON(){
        return [
          "date" => $this->date,
          "reason" => $this->reason
        ];
    }

}