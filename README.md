<h1>LiveCare API</h1>

<h3>Usage</h3>

$livecare = new \Fasys\FSLiveCare('username', 'password');

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

//ADD AZIENDA
$livecare->addAzienda($azienda);

//EDIT AZIENDA
var_dump($livecare->editAzienda($azienda);

//GET SESSION
var_dump($livecare->getSession(1));
