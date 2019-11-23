<?php

require_once('../../src/pdf-sign-cli.php');

$pdfSigner =  new BSrE_PDF_Signer_Cli();

$pdfSigner->setDocument('../pdf/example.pdf');

$pdfSigner->readCertificateFromFile(
    '../cert/devel-juni2019.p12',
    '1234'              
);

$pdfSigner->setPermission(
    'user', // set User Password
    true,   // mode encryption
    true    // Disallow Printing
);

if(!$pdfSigner->sign()) 
    echo $pdfSigner->getError();

    