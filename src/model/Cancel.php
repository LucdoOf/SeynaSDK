<?php

namespace SeynaSDK\Models;

use SeynaSDK\Core\Dbg;
use SeynaSDK\Utils\JSONBuilder;

class Cancel
{

    use JSONBuilder;

    static $columns = ["date", "reason"];

    /** @var Date de l'annulation string<date-time> */
    public $date;
    /** @var Raison de l'annulation Enum["request","payment","fraud"] */
    public $reason;

    /**
     * Cancel constructor.
     *
     * @param array $data Array Données reçues
     */
    public function __construct($data = []) {
        foreach ($data as $k => $v) {
            if (property_exists($this, $k)) {
                $this->{$k} = $v;
            } else {
                Dbg::logs("Missing variable in Cancel: " . $k . " => " . $v, Dbg::L_ERROR);
            }
        }
    }
}
