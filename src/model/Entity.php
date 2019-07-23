<?php

namespace SeynaSDK\Models;

use SeynaSDK\Core\Dbg;
use SeynaSDK\Core\JSONBuilder;

class Entity
{

    use JSONBuilder;

    static $columns = ["type", "name", "registration", "representative", "address", "email", "phone", "birthday"];

    /** @var Type de l'entitié eg: individual, company, nonprofit */
    public $type;
    /** @var Full name de la personne ou de la compagnie */
    public $name;
    /** @var Le nom de registration de la compagnie */
    public $registration;
    /** @var Nom du représentant légal de la compagnie */
    public $representative;
    /** @var Full adresse physique de l'entité */
    public $address;
    /** @var Email de la personne ou du representant */
    public $email;
    /** @var Telephone de la personne ou du representant */
    public $phone;
    /** @var Date de naissance de la personne ou du representant */
    public $birthday;

    /**
     * Contract constructor.
     *
     * @param array $data Array Données reçues
     */
    public function __construct($data = []) {
        foreach ($data as $k => $v) {
            if (property_exists($this, $k)) {
                $this->{$k} = $v;
            } else {
                Dbg::logs("Missing variable in Entity: " . $k . " => " . $v, Dbg::L_ERROR);
            }
        }
    }


}