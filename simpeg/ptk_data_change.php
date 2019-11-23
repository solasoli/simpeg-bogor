<?php
session_start();
include 'class/cls_ptk.php';
$oPtk = new Ptk();
$dc = $_POST['data_change'];

switch($dc){
    case 'ubahStatusPtkBpkad':
        $data = array(
            'txtCatatanBpkad' => $_POST['txtCatatanBpkad'],
            'strPTKStore' => $_POST['strPTKStore'],
            'statusEdit' => $_POST['statusEdit'],
            'idpApprover' => $_POST['idpApprover']
        );
        $change = $oPtk->updatePtkBPKAD($data);
        echo $change;
        break;
    case 'addDraftPenyesuaianGapok':
        $data = array(
            'penerbitSk' => $_POST['penerbitSk'],
            'thnPeraturanGaji' => $_POST['thnPeraturanGaji'],
            'blnGaji' => $_POST['blnGaji'],
            'thnGaji' => $_POST['thnGaji'],
            'strSKStore' => $_POST['strSKStore']
        );
        $change = $oPtk->addDraftMutasiGapok($data);
        echo $change;
        break;
    case 'addReExecuteMutasiGapok':
        $data = array(
            'blnGaji' => $_POST['blnGaji'],
            'thnGaji' => $_POST['thnGaji'],
            'statusEdit' => $_POST['statusEdit'],
            'strSKStore' => $_POST['strSKStore']
        );
        $change = $oPtk->reExecuteHistorisGapokToSIMGAJI($data);
        echo $change;
        break;
    case 'addDraftPenyesuaianTunjanganJiwa':
        $data = array(
            'blnGaji' => $_POST['blnGaji'],
            'thnGaji' => $_POST['thnGaji'],
            'strPTKStore' => $_POST['strPTKStore']
        );
        $change = $oPtk->addDraftMutasiTunjanganJiwa($data);
        echo $change;
        break;
    case 'addReExecuteMutasiPTK':
        $data = array(
            'blnGaji' => $_POST['blnGaji'],
            'thnGaji' => $_POST['thnGaji'],
            'statusEdit' => $_POST['statusEdit'],
            'strPTKStore' => $_POST['strPTKStore']
        );
        $change = $oPtk->reExecuteHistorisPtkToSIMGAJI($data);
        echo $change;
        break;
}

?>