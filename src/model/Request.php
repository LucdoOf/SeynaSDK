<?php
/**
 * Created by PhpStorm.
 * User: lucas
 * Date: 12/07/19
 * Time: 15:16
 */

namespace SeynaSDK\Core\Model;

use SeynaSDK\Models\Model;

class Request extends Model
{

    /** Table de stockage SQL */
    const TBNAME = "seyna_requests";
    /** @var string Requête POST */
    const POST = "POST";
    /** @var string Requête PUT */
    const PUT = "PUT";

    /** @var int Identifiant de la requête */
    public $id;
    /** @var string URI correspondante */
    public $uri;
    /** @var string Méthode http */
    public $method;
    /** @var string Status HTTP */
    public $httpStatus;
    /** @var string Réponse de la requête */
    public $response;
    /** @var string Corps de la requête */
    public $body;
    /** @var string Erreur éventuelle renvoyée par la requête */
    public $error;
    /** @var int Stamp d'envoie de la requête */
    public $stamp;

    /**
     * Request constructor.
     * @param int $id
     */
    public function __construct(int $id = 0) {
        parent::__construct($id);
    }

    /**
     * Envoie la requête et sauvegarde l'objet en base de donnée
     */
    public function send(){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->uri);
        if($this->method === self::POST && !is_null($this->body)) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($this->body));
        } else if($this->method === self::PUT && !is_null($this->body)){
            curl_setopt($ch, CURLOPT_PUT, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($this->body));
        }
        //curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if(IS_DEV) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        }
        $data = curl_exec($ch);
        if (curl_errno($ch)) {
            $this->error =  curl_error($ch);
        }
        $this->httpStatus = curl_getinfo($ch)['http_code'];
        curl_close($ch);
        $this->response = $data;
        $this->stamp = time();
    }


    /**
     * Retourne la réponse de la requête sous forme d'array
     * @return Array
     */
    public function getJSONResponse(){
        return json_decode($this->response, true);
    }

}