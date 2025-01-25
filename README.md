<h1>LiveCare API</h1>

<h3>Usage</h3>

<pre>
$livecare = new \Smartware\LiveCareApi('username', 'password');

$azienda = array(
    'external_id' => '100000',
    'company' => 'Company12345',
    'email' => '',
    'vat' => '11111111111',
    'contract_type' => '0',
    'contract_expiration' => '',
    'contract_code' => '',
    'contract_blocked' => ''
);


//GETAZIENDA
$livecare->getAzienda('100000');

//GETAZIENDE
$livecare->getAziende();

//ADD AZIENDA
$livecare->addAzienda($azienda);

//EDIT AZIENDA
var_dump($livecare->editAzienda($azienda);

//RECHARGE AZIENDA
$args = array();
$args["external_id"] = $external_id;
$args["minutes"] = $total_minutes;
$args["notes"] = $notes;
$args["action"] = $action; //SET or ADD
$livecare_array = $livecare->rechargePutAzienda($args);
$result_code = $livecare_array[0]; //MUST BE 0 TO CONFIRM THE RECHARGE

//GET CREDIT
$livecare->rechargeGetAzienda($azienda);

//GET SESSION
var_dump($livecare->getSession(1));
</pre>
