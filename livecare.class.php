<?php
/**
 * LiveCare Support API 1.0

 * @author mariani
 * @twitter andreamariani2k
 * @company fasys.it
 * @package zero.fasys
 * @version 0.1
 */

namespace Fasys; 

class FSLiveCare {

    public $api = "http://api.livecare.net/lsws10/"; //session/?type=%TIPO%&outputFormat=%FORMATO%

    public function __construct($username, $password){
        $this->username = $username;
        $this->password = $password;
    }

    private function curl($url, $request_type = 'GET', $postfield = null){
        $ch = curl_init($this->api . $url);
        //curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', ));
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_USERPWD, $this->username . ":" . $this->password);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        switch($request_type){
            case 'POST':
                curl_setopt($ch, CURLOPT_POST, 1); break;
            case 'PUT':
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT"); break;
        }

        if($postfield) {
            $_postfield_type = $postfield['type'];
            unset($postfield['type']);
            if($_postfield_type == 'ARRAY'){
                $postfield = http_build_query($postfield);
            }
            else{
                $postfield = json_encode($postfield);
            }

            curl_setopt($ch, CURLOPT_POSTFIELDS, $postfield);
        }

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }

    /**
     * @param int $type [
     * 0 = Oggi
     * 1 = Ieri
     * 2 = Ultima settimana
     * 3 = Ultimo mese
     * 4 = Settimana corrente
     * 5 = Mese corrente
     * ]
     * @param string $output [json | csv]
     */
    public function getSession($type = 0, $output = 'json'){
        $output = $this->curl(
            'session?type='.(int)$type.'&outputFormat='.$output
        );
        if($output){
            return json_decode($output);
        }
        return $output;
    }


    /**
     * @param $args array
     *
     * external_id : individua il codice da utilizzare per modificare l’azienda in chiamate successive. Deve essere presente ed univoco tra tutte le aziende. Viene tornato anche nelle chiamate di lista delle Assistenze effettuate.
     * company : il nome dell’azienda.
     * email : indirizzo email dell’azienda
     * vat : la partita iva dell’azienda.
     * contract_type : la tipologia di contratto (0: flat, 1: a consuntivo, 2; contratto prepagato).
     * contract_expiration : la data di scadenza del contratto. Se l’operatore effettua una assistenza ad un contatto di una Azienda con contratto scaduto viene avvisato.
     * contract_code : il codice di modello di costo.
     * contract_blocked : se l’azienda è bloccata (0 non bloccata, 1 bloccata). Quando si fa una assistenza ad un contatto di una Azienda bloccata viene avvisato l’operatore.
     */
    public function addAzienda($args){
        $output = $this->curl(
            'company',
            'PUT',
            $args
        );

        if($output){
            $output = json_decode($output);
            if($output->result_code === 0) return true;
            return $output;
        }
        return false;

    }

    /**
     * @param $args [stessi parametri addAzienda()
     */
    public function editAzienda($args){
        $output = $this->curl(
            'company',
            'POST',
            $args
        );

        if($output){
            $output = json_decode($output);
            if($output->result_code === 0) return true;
            return $output;
        }
        return false;

    }


    public function getAzienda($external_id){
        $output = $this->curl(
            'company?external_id='.$external_id,
            'GET'
        );
        if($output){
            return json_decode($output);
        }
        return $output;
    }

}
