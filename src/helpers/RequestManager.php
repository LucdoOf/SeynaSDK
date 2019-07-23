<?php

namespace SeynaSDK\Helpers;

use SeynaSDK;
use SeynaSDK\Models\Request;

/**
 * Created by PhpStorm.
 * User: lucas
 * Date: 12/07/19
 * Time: 15:06
 */
class RequestManager
{

    /**
     * Envoie une requête et retourne l'objet Request associé
     *
     * @param $uri
     * @param $method
     * @param $body
     * @return Request
     */
    public function request($uri, $method = "GET", $body = null) {
        $request = new Request();
        $request->uri = SEYNA_URL . $uri;
        $request->method = $method;
        $request->body = $body;
        $request->send();
        //$request->save();
        return $request;
    }

    /**
     * Retourne la liste des requêtes envoyées
     *
     * @return Request[]
     */
    public function getRequests() {
        return Request::getAll();
    }

}