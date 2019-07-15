<?php
/**
 * Created by PhpStorm.
 * User: antoine
 * Date: 12/07/19
 * Time: 15:06
 */

namespace SeynaSDK\API;

use SeynaSDK;
use SeynaSDK\Models\Request;

class RequestManager
{

    /**
     * Envoie une requête et retourne l'objet Request associé
     * @param $uri
     * @param $method
     * @param $body
     * @return Request
     */
    public function request($uri, $method = "GET", $body = null){
        $request = new Request();
        $request->uri = SEYNA_URL . $uri;
        $request->method = $method;
        $request->body = $body;
        $request->send();
        $request->save();
        return $request;
    }

}