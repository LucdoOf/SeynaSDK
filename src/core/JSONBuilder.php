<?php

namespace SeynaSDK\Core;

/**
 * Created by PhpStorm.
 * User: lucas
 * Date: 15/07/19
 * Time: 10:58
 */
trait JSONBuilder
{

    /**
     * JSON-IFIER
     * @return array
     */
    public function toJSON() {
        $col = $this::$columns;
        $data = [];
        foreach ($col as $k) {
            if (property_exists($this, $k)) {
                $data[$k] = $this->{$k};
            } else {
                Dbg::logs("Missing variable in JSONBuilder " . $k, Dbg::L_ERROR);
            }
        }
        $array = $this->formatArray($data);
        return $array;
    }

    /**
     * Formatting array to strings and int only (->toJSON on objects)
     *
     * @param $array
     * @return array
     */
    public function formatArray($array) {
        $return = [];
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $return[$key] = $this->formatArray($value);
            } else {
                if (is_object($value)) {
                    $return[$key] = $value->toJSON();
                } else {
                    $return[$key] = $value;
                }
            }
        }
        return $return;
    }

}