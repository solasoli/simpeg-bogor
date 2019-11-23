<?php

$client = new soapclient('http://203.19.4.84:8000/pegawaiservice.asmx?wsdl');
//$err = $client->getError();

$params = array('nama' => 'ari');
//$result = $client->call("HelloWorld", $params);
$result = $client->GetByNama($params);

foreach($result as $i){
  foreach($i as $items){
    foreach($items as $p)
    {
      print_r($p->Nama);
      echo "<hr/>";
    }
  }
}
?>