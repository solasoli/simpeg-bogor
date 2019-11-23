<?php

require_once('../../src/pdf-sign-cli.php');

$pdfSigner =  new BSrE_PDF_Signer_Cli();

$pdfSigner->setDocument('../pdf/example.pdf');

$pdfSigner->readCertificateFromFile(
    '../cert/devel-juni2019.p12',
    '1234'            
);

$pdfSigner->setCertificationLevel(3);

$pdfSigner->setLocation('Jakarta');

$pdfSigner->setAppearance(
    $position = array(
        'llx' => '442',
        'lly' => '831',
        'urx' => '577',
        'ury' => '774'
    ),
    $page = 1,
    $spesimen = null
);


if(!$pdfSigner->sign()) 
    echo $pdfSigner->getError();

    