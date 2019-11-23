<?php
    $idberkas = $_GET['idberkas'];
    $fileBerkas = $_GET['filelist'];
    $idawal = $_GET['idawal'];
    $jenis = $_GET['jenis'];
    $nm_berkas = $_GET['nm_berkas'];
    $ket_berkas = $_GET['ket_berkas'];
    $idpeg = $_GET['idpeg'];
?>
                <!-- The file upload form used as target for the file upload widget -->
                <form id="fileupload<?php echo $idawal.$idberkas; ?>" action="//jquery-file-upload.appspot.com/" method="POST" enctype="multipart/form-data">
                    <!-- Redirect browsers with JavaScript disabled to the origin page -->
                    <noscript><input type="hidden" name="redirect" value="https://blueimp.github.io/jQuery-File-Upload/"></noscript>
                    <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
                    <div class="row fileupload-buttonbar">
                        <div class="col-lg-9">
                            <!-- The fileinput-button span is used to style the file input field as button -->
                                                                    <span class="btn btn-success fileinput-button">
                                                                        <i class="glyphicon glyphicon-plus"></i>
                                                                        <span>Add files...</span>
                                                                        <input type="file" name="files[]" multiple>
                                                                    </span>
                            <button type="submit" class="btn btn-primary start">
                                <i class="glyphicon glyphicon-upload"></i>
                                <span>Start upload</span>
                            </button>
                            <button type="reset" class="btn btn-warning cancel">
                                <i class="glyphicon glyphicon-ban-circle"></i>
                                <span>Cancel upload</span>
                            </button>
                            <button type="button" class="btn btn-danger delete">
                                <i class="glyphicon glyphicon-trash"></i>
                                <span>Delete</span>
                            </button>
                            <input type="checkbox" class="toggle">
                            <input type="hidden" id="fileElement" name="fileElement" value="fileupload<?php echo $idberkas ?>" />
                            <input type="hidden" id="fileBerkas<?php echo $idawal.$idberkas; ?>" name="fileBerkas<?php echo $idawal.$idberkas; ?>" value="<?php echo $fileBerkas; ?>" style="width: 400px;"/>
                            <!-- The global file processing state -->
                            <span class="fileupload-process"></span>
                        </div>
                        <!-- The global progress state -->
                        <div class="col-lg-3 fileupload-progress fade">
                            <!-- The global progress bar -->
                            <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar progress-bar-success" style="width:0%;"></div>
                            </div>
                            <!-- The extended global progress state -->
                            <div class="progress-extended">&nbsp;</div>
                        </div>
                    </div>
                    <!-- The table listing the files available for upload/download -->
                    <table role="presentation" class="table table-striped">
                        <tbody class="files"></tbody>
                    </table>
                </form>

<script language="javascript">
    $(function () {
        'use strict';
        var $fileBerkas;
        $fileBerkas = $("#fileBerkas<?php echo $idawal.$idberkas; ?>").val();
        // Initialize the jQuery File Upload widget:
        $('#fileupload<?php echo $idawal.$idberkas; ?>').fileupload({
            // Uncomment the following to send cross-domain cookies:
            //xhrFields: {withCredentials: true},
            url: 'uploaderverifikasi.php?filesnya=' + $fileBerkas + '&idberkasnya=<?php echo $idberkas; ?>' + '&idawal=<?php echo $idawal; ?>' + '&jenis=<?php echo $jenis; ?>' + '&nm_berkas=<?php echo $nm_berkas; ?>' + '&ket_berkas=<?php echo $ket_berkas; ?>' + '&idpeg=<?php echo $idpeg; ?>'
        }).bind('fileuploadcompleted', function (e, responseJSON) {
            var files = getFilesFromResponse(responseJSON);
            //console.log(files);
            $.each(files, function (index, file) {
                if (typeof file.jmlberkas_skrg != 'undefined') {
                    //$("#jmlBerkasHid"+file.idAwalVerif+file.idBerkasnya ).val(file.jmlberkas_skrg); // -> kalo tipe input
                    switch (file.jenisVerif){
                        case 'SK':
                            $("#jmlToolTipSK"+file.idAwalVerif+file.idBerkasnya).text(file.jmlberkas_skrg); // -> kalo tipe span
                            break;
                        case 'Ijazah':
                            $("#jmlToolTipPend"+file.idAwalVerif+file.idBerkasnya).text(file.jmlberkas_skrg);
                            break;
                        case 'Pendukung':
                            $("#jmlToolTipSupp"+file.idBerkasnya).text(file.jmlberkas_skrg);
                            break;
                        case 'Jabatan':
                            $("#jmlToolTipJab"+file.idAwalVerif+file.idBerkasnya).text(file.jmlberkas_skrg);
                            break;
                    }
                    if(file.jmlberkas_skrg==1){
                        switch (file.jenisVerif){
                            case 'SK':
                                $("#jmlToolTipSK"+file.idAwalVerif+file.idBerkasnya).tooltip('hide').attr('data-original-title', file.name).tooltip('fixTitle');
                                $("#labelVerifSK"+file.idAwalVerif+file.idBerkasnya).text('Belum');
                                $("#btnSkCek"+file.idAwalVerif+file.idBerkasnya).removeClass('disabled').addClass('active');
                                $("#btnSkVerif"+file.idAwalVerif+file.idBerkasnya).removeClass('disabled').addClass('active');
                                var idBerkasnya = file.name.substring(19, 24);
                                $("#btnSkCek"+file.idAwalVerif+file.idBerkasnya).prop('onclick',null).off('click');
                                $("#btnSkCek"+file.idAwalVerif+file.idBerkasnya).click(function () {
                                    openWindowCekBerkas(idBerkasnya);
                                });
                                $("#spnVerifSK"+file.idAwalVerif+file.idBerkasnya).attr('data-toggle', 'modal');
                                $("#btnSave"+file.idAwalVerif+file.idBerkasnya).prop('onclick',null).off('click');
                                $("#btnSave"+file.idAwalVerif+file.idBerkasnya).click(function () {
                                    updateStatusVerif("modSKVerif"+file.idAwalVerif+file.idBerkasnya,idBerkasnya,"labelVerifSK"+file.idAwalVerif+file.idBerkasnya,document.getElementById('labelVerifSK'+file.idAwalVerif+file.idBerkasnya).innerHTML);
                                });
                                $("#btnSkUpload"+file.idAwalVerif+file.idBerkasnya).prop('onclick',null).off('click');
                                $("#btnSkUpload"+file.idAwalVerif+file.idBerkasnya).click(function () {
                                    loadUploadFileWindow("modSKUpload"+file.idAwalVerif+file.idBerkasnya,"divUploadWin"+file.idAwalVerif+file.idBerkasnya,file.idAwalVerif,file.idBerkasnya,file.name,'SK','SK '+file.nm_berkas,file.ket_berkas);
                                });
                                break;
                            case 'Ijazah':
                                $("#jmlToolTipPend"+file.idAwalVerif+file.idBerkasnya).tooltip('hide').attr('data-original-title', file.name).tooltip('fixTitle');
                                $("#labelVerifPend"+file.idAwalVerif+file.idBerkasnya).text('Belum');
                                $("#btnPendCek"+file.idAwalVerif+file.idBerkasnya).removeClass('disabled').addClass('active');
                                $("#btnPendVerif"+file.idAwalVerif+file.idBerkasnya).removeClass('disabled').addClass('active');
                                var idBerkasnya = file.name.substring(19, 24);
                                $("#btnPendCek"+file.idAwalVerif+file.idBerkasnya).prop('onclick',null).off('click');
                                $("#btnPendCek"+file.idAwalVerif+file.idBerkasnya).click(function () {
                                    openWindowCekBerkas(idBerkasnya);
                                });
                                $("#spnVerifPend"+file.idAwalVerif+file.idBerkasnya).attr('data-toggle', 'modal');
                                $("#btnSavePend"+file.idAwalVerif+file.idBerkasnya).prop('onclick',null).off('click');
                                $("#btnSavePend"+file.idAwalVerif+file.idBerkasnya).click(function () {
                                    updateStatusVerif("modPendVerif"+file.idAwalVerif+file.idBerkasnya,idBerkasnya,"labelVerifPend"+file.idAwalVerif+file.idBerkasnya,document.getElementById('labelVerifPend'+file.idAwalVerif+file.idBerkasnya).innerHTML);
                                });
                                $("#btnPendUpload"+file.idAwalVerif+file.idBerkasnya).prop('onclick',null).off('click');
                                $("#btnPendUpload"+file.idAwalVerif+file.idBerkasnya).click(function () {
                                    loadUploadFileWindow("modPendUpload"+file.idAwalVerif+file.idBerkasnya,"divUploadWinPend"+file.idAwalVerif+file.idBerkasnya,file.idAwalVerif,file.idBerkasnya,file.name,'Ijazah',file.nm_berkas,file.ket_berkas);
                                });
                                break;
                            case 'Pendukung':
                                $("#jmlToolTipSupp"+file.idBerkasnya).tooltip('hide').attr('data-original-title', file.name).tooltip('fixTitle');
                                $("#labelVerifSupp"+file.idBerkasnya).text('Belum');
                                $("#btnSuppCek"+file.idBerkasnya).removeClass('disabled').addClass('active');
                                $("#btnSuppVerif"+file.idBerkasnya).removeClass('disabled').addClass('active');
                                var idBerkasnya = file.name.substring(19, 24);
                                $("#btnSuppCek"+file.idBerkasnya).prop('onclick',null).off('click');
                                $("#btnSuppCek"+file.idBerkasnya).click(function () {
                                    openWindowCekBerkas(idBerkasnya);
                                });
                                $("#spnVerifSupp"+file.idBerkasnya).attr('data-toggle', 'modal');
                                $("#btnSaveSupp"+file.idBerkasnya).prop('onclick',null).off('click');
                                $("#btnSaveSupp"+file.idBerkasnya).click(function () {
                                    updateStatusVerif("modSuppVerif"+file.idBerkasnya,idBerkasnya,"labelVerifSupp"+file.idBerkasnya,document.getElementById('labelVerifSupp'+file.idBerkasnya).innerHTML);
                                });
                                $("#btnSuppUpload"+file.idBerkasnya).prop('onclick',null).off('click');
                                $("#btnSuppUpload"+file.idBerkasnya).click(function () {
                                    loadUploadFileWindow("modSuppUpload"+file.idBerkasnya,"divUploadWinSupp"+file.idBerkasnya,file.idBerkasnya,file.idBerkasnya,file.name,'Pendukung','Ijazah',file.ket_berkas);
                                });
                                break;
                            case 'Jabatan':
                                $("#jmlToolTipJab"+file.idAwalVerif+file.idBerkasnya).tooltip('hide').attr('data-original-title', file.name).tooltip('fixTitle');
                                $("#labelVerifJab"+file.idAwalVerif+file.idBerkasnya).text('Belum');
                                $("#btnJabCek"+file.idAwalVerif+file.idBerkasnya).removeClass('disabled').addClass('active');
                                $("#btnJabVerif"+file.idAwalVerif+file.idBerkasnya).removeClass('disabled').addClass('active');
                                var idBerkasnya = file.name.substring(19, 24);
                                $("#btnJabCek"+file.idAwalVerif+file.idBerkasnya).prop('onclick',null).off('click');
                                $("#btnJabCek"+file.idAwalVerif+file.idBerkasnya).click(function () {
                                    openWindowCekBerkas(idBerkasnya);
                                });
                                $("#spnVerifJab"+file.idAwalVerif+file.idBerkasnya).attr('data-toggle', 'modal');
                                $("#btnSaveJab"+file.idAwalVerif+file.idBerkasnya).prop('onclick',null).off('click');
                                $("#btnSaveJab"+file.idAwalVerif+file.idBerkasnya).click(function () {
                                    updateStatusVerif("modJabVerif"+file.idAwalVerif+file.idBerkasnya,idBerkasnya,"labelVerifJab"+file.idAwalVerif+file.idBerkasnya,document.getElementById('labelVerifJab'+file.idAwalVerif+file.idBerkasnya).innerHTML);
                                });
                                $("#btnJabUpload"+file.idAwalVerif+file.idBerkasnya).prop('onclick',null).off('click');
                                $("#btnJabUpload"+file.idAwalVerif+file.idBerkasnya).click(function () {
                                    loadUploadFileWindow("modJabUpload"+file.idAwalVerif+file.idBerkasnya,"divUploadWin"+file.idAwalVerif+file.idBerkasnya,file.idAwalVerif,file.idBerkasnya,file.name,'Jabatan','SK Jabatan',file.ket_berkas);
                                });
                                break;
                        }
                    }else{
                        switch (file.jenisVerif) {
                            case 'SK':
                                $("#jmlToolTipSK"+file.idAwalVerif+file.idBerkasnya).tooltip('hide')
                                    .attr('data-original-title', $("#jmlToolTipSK"+file.idAwalVerif+file.idBerkasnya).attr('data-original-title') + ", " + file.name).tooltip('fixTitle');
                                $("#btnSkUpload"+file.idAwalVerif+file.idBerkasnya).prop('onclick',null).off('click');
                                $("#btnSkUpload"+file.idAwalVerif+file.idBerkasnya).click(function () {
                                    loadUploadFileWindow("modSKUpload"+file.idAwalVerif+file.idBerkasnya,"divUploadWin"+file.idAwalVerif+file.idBerkasnya,file.idAwalVerif,file.idBerkasnya,$("#jmlToolTipSK"+file.idAwalVerif+file.idBerkasnya).attr('data-original-title'),'SK','SK '+file.nm_berkas,file.ket_berkas);
                                });
                                break;
                            case 'Ijazah':
                                $("#jmlToolTipPend"+file.idAwalVerif+file.idBerkasnya).tooltip('hide')
                                    .attr('data-original-title', $("#jmlToolTipPend"+file.idAwalVerif+file.idBerkasnya).attr('data-original-title') + ", " + file.name).tooltip('fixTitle');
                                $("#btnPendUpload"+file.idAwalVerif+file.idBerkasnya).prop('onclick',null).off('click');
                                $("#btnPendUpload"+file.idAwalVerif+file.idBerkasnya).click(function () {
                                    loadUploadFileWindow("modPendUpload"+file.idAwalVerif+file.idBerkasnya,"divUploadWinPend"+file.idAwalVerif+file.idBerkasnya,file.idAwalVerif,file.idBerkasnya,$("#jmlToolTipPend"+file.idAwalVerif+file.idBerkasnya).attr('data-original-title'),'Ijazah',file.nm_berkas,file.ket_berkas);
                                });
                                break;
                            case 'Pendukung':
                                $("#jmlToolTipSupp"+file.idBerkasnya).tooltip('hide')
                                    .attr('data-original-title', $("#jmlToolTipSupp"+file.idBerkasnya).attr('data-original-title') + ", " + file.name).tooltip('fixTitle');
                                $("#btnSuppUpload"+file.idBerkasnya).prop('onclick',null).off('click');
                                $("#btnSuppUpload"+file.idBerkasnya).click(function () {
                                    loadUploadFileWindow("modSuppUpload"+file.idBerkasnya,"divUploadWinSupp"+file.idBerkasnya,file.idBerkasnya,file.idBerkasnya,$("#jmlToolTipSupp"+file.idBerkasnya).attr('data-original-title'),'Pendukung',file.nm_berkas,file.ket_berkas);
                                });
                                break;
                            case 'Jabatan':
                                $("#jmlToolTipJab"+file.idAwalVerif+file.idBerkasnya).tooltip('hide')
                                    .attr('data-original-title', $("#jmlToolTipJab"+file.idAwalVerif+file.idBerkasnya).attr('data-original-title') + ", " + file.name).tooltip('fixTitle');
                                $("#btnJabUpload"+file.idAwalVerif+file.idBerkasnya).prop('onclick',null).off('click');
                                $("#btnJabUpload"+file.idAwalVerif+file.idBerkasnya).click(function () {
                                    loadUploadFileWindow("modJabUpload"+file.idAwalVerif+file.idBerkasnya,"divUploadWin"+file.idAwalVerif+file.idBerkasnya,file.idAwalVerif,file.idBerkasnya,$("#jmlToolTipJab"+file.idAwalVerif+file.idBerkasnya).attr('data-original-title'),'Jabatan','SK Jabatan',file.ket_berkas);
                                });
                                break;
                        }
                    }
                }
            });
        }).bind('fileuploaddestroyed', function (e, data) {
            destroyed_file();
        });

        // Enable iframe cross-domain access via redirect option:
        $('#fileupload<?php echo $idawal.$idberkas; ?>').fileupload(
            'option',
            'redirect',
            window.location.href.replace(
                /\/[^\/]*$/,
                '/cors/result.html?%s'
            )
        );

        if (window.location.hostname === 'blueimp.github.io') {
            // Demo settings:
            /*$('#'+$("#fileElement").val()).fileupload('option', {
             url: '//jquery-file-upload.appspot.com/',
             // Enable image resizing, except for Android and Opera,
             // which actually support image resizing, but fail to
             // send Blob objects via XHR requests:
             disableImageResize: /Android(?!.*Chrome)|Opera/
             .test(window.navigator.userAgent),
             maxFileSize: 999000,
             acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i
             });
             // Upload server status check for browsers with CORS support:
             if ($.support.cors) {
             $.ajax({
             url: '//jquery-file-upload.appspot.com/',
             type: 'HEAD'
             }).fail(function () {
             $('<div class="alert alert-danger"/>')
             .text('Upload server currently unavailable - ' +
             new Date())
             .appendTo('#fileupload');
             });
             }*/
        } else {
            // Load existing files:
            $('#fileupload<?php echo $idawal.$idberkas; ?>').addClass('fileupload-processing');
            $.ajax({
                // Uncomment the following to send cross-domain cookies:
                //xhrFields: {withCredentials: true},
                url: $('#fileupload<?php echo $idawal.$idberkas; ?>').fileupload('option', 'url'),
                dataType: 'json',
                context: $('#fileupload<?php echo $idawal.$idberkas; ?>')[0]
            }).always(function () {
                $(this).removeClass('fileupload-processing');
            }).done(function (result) {
                $(this).fileupload('option', 'done')
                    .call(this, $.Event('done'), {result: result});
            });
        }

    });
    function getFilesFromResponse(data) {
        //console.log(data);
        if (data.result && $.isArray(data.result.files)) {
            return data.result.files;
        }
        return [];
    }

    function destroyed_file() {
        $.ajax({
            url: ('request_response.php?filter=get_delete_msg_uploadfile&jenisVerif=<?php echo $jenis?>&idPegawainya=<?php echo $idpeg?>&idAwalVerif=<?php echo $idawal;?>&idBerkasnya=<?php echo $idberkas ?>'),
            dataType: "json",
            type: 'GET',
            success: function(results) {
                if (typeof results.jmlberkas_skrg != 'undefined') {
                    switch (results.jenisVerif){
                        case 'SK':
                            $("#jmlToolTipSK"+results.idAwalVerif+results.idBerkasnya).text(results.jmlberkas_skrg);
                            break;
                        case 'Ijazah':
                            $("#jmlToolTipPend"+results.idAwalVerif+results.idBerkasnya).text(results.jmlberkas_skrg);
                            break;
                        case 'Pendukung':
                            $("#jmlToolTipSupp"+results.idBerkasnya).text(results.jmlberkas_skrg);
                            break;
                        case 'Jabatan':
                            $("#jmlToolTipJab"+results.idAwalVerif+results.idBerkasnya).text(results.jmlberkas_skrg);
                            break;
                    }
                    if(results.jmlberkas_skrg==0){
                        switch (results.jenisVerif){
                            case 'SK':
                                $("#jmlToolTipSK"+results.idAwalVerif+results.idBerkasnya).tooltip('hide').attr('data-original-title', '').tooltip('fixTitle');
                                $("#labelVerifSK"+results.idAwalVerif+results.idBerkasnya).text('No Berkas').addClass('label-danger');
                                $("#btnSkCek"+results.idAwalVerif+results.idBerkasnya).removeClass('active').addClass('disabled');
                                $("#btnSkVerif"+results.idAwalVerif+results.idBerkasnya).removeClass('active').addClass('disabled');
                                $("#spnVerifSK"+results.idAwalVerif+results.idBerkasnya).attr('data-toggle', '');
                                break;
                            case 'Ijazah':
                                $("#jmlToolTipPend"+results.idAwalVerif+results.idBerkasnya).tooltip('hide').attr('data-original-title', '').tooltip('fixTitle');
                                $("#labelVerifPend"+results.idAwalVerif+results.idBerkasnya).text('No Berkas').addClass('label-danger');
                                $("#btnPendCek"+results.idAwalVerif+results.idBerkasnya).removeClass('active').addClass('disabled');
                                $("#btnPendVerif"+results.idAwalVerif+results.idBerkasnya).removeClass('active').addClass('disabled');
                                $("#spnVerifPend"+results.idAwalVerif+results.idBerkasnya).attr('data-toggle', '');
                                break;
                            case 'Pendukung':
                                $("#jmlToolTipSupp"+results.idBerkasnya).tooltip('hide').attr('data-original-title', '').tooltip('fixTitle');
                                $("#labelVerifSupp"+results.idBerkasnya).text('No Berkas').addClass('label-danger');
                                $("#btnSuppCek"+results.idBerkasnya).removeClass('active').addClass('disabled');
                                $("#btnSuppVerif"+results.idBerkasnya).removeClass('active').addClass('disabled');
                                $("#spnVerifSupp"+results.idBerkasnya).attr('data-toggle', '');
                                break;
                            case 'Jabatan':
                                $("#jmlToolTipJab"+results.idAwalVerif+results.idBerkasnya).tooltip('hide').attr('data-original-title', '').tooltip('fixTitle');
                                $("#labelVerifJab"+results.idAwalVerif+results.idBerkasnya).text('No Berkas').addClass('label-danger');
                                $("#btnJabCek"+results.idAwalVerif+results.idBerkasnya).removeClass('active').addClass('disabled');
                                $("#btnJabVerif"+results.idAwalVerif+results.idBerkasnya).removeClass('active').addClass('disabled');
                                $("#spnVerifJab"+results.idAwalVerif+results.idBerkasnya).attr('data-toggle', '');
                                break;
                        }
                    }else{
                        switch (results.jenisVerif) {
                            case 'SK':
                                $("#jmlToolTipSK"+results.idAwalVerif+results.idBerkasnya).tooltip('hide')
                                    .attr('data-original-title', results.filenya ).tooltip('fixTitle');
                                break;
                            case 'Ijazah':
                                $("#jmlToolTipPend"+results.idAwalVerif+results.idBerkasnya).tooltip('hide')
                                    .attr('data-original-title', results.filenya ).tooltip('fixTitle');
                                break;
                            case 'Pendukung':
                                $("#jmlToolTipSupp"+results.idBerkasnya).tooltip('hide')
                                    .attr('data-original-title', results.filenya).tooltip('fixTitle');
                                break;
                            case 'Jabatan':
                                $("#jmlToolTipJab"+results.idAwalVerif+results.idBerkasnya).tooltip('hide')
                                    .attr('data-original-title', results.filenya ).tooltip('fixTitle');
                                break;
                                break;
                        }
                    }
                }
            }
        });
    }
</script>