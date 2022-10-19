<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="<?= base_url('assets/images/menyambang/logo_fix.png') ?>" type="image/x-icon">
    <link rel="shortcut icon" href="<?= base_url('assets/images/menyambang/logo_fix.png') ?>" type="image/x-icon">
    <title>SILAKI</title>
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Rubik:400,400i,500,500i,700,700i&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets'); ?>/css/font-awesome.css">
    <!-- ico-font-->
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets'); ?>/css/vendors/icofont.css">
    <!-- Themify icon-->
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets'); ?>/css/vendors/themify.css">
    <!-- Flag icon-->
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets'); ?>/css/vendors/flag-icon.css">
    <!-- Feather icon-->
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets'); ?>/css/vendors/feather-icon.css">
    <!-- Plugins css start-->
    <!-- Plugins css Ends-->
    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets'); ?>/css/vendors/bootstrap.css">
    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets'); ?>/css/style.css">
    <link id="color" rel="stylesheet" href="<?= base_url('assets'); ?>/css/color-1.css" media="screen">
    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets'); ?>/css/responsive.css">

    <link rel="stylesheet" type="text/css" href="<?= base_url('assets'); ?>/css/vendors/sweetalert2.min.css">
    <script src="<?= base_url('assets'); ?>/js/sweet-alert/sweetalert2.all.min.js"></script>
</head>

<body>
    <!-- login page start-->
    <div class="container-fluid p-0">
        <div class="row m-0">
            <div class="col-12 p-0">
                <div class="login-card">
                    <div>
                        <div class="mb-2 text-center"><img class="img-fluid for-light" src="<?= $logo ?>" width="300px"></div>
                        <div class="login-main" style="padding: 20px;">
                            <div class="input-group">
                                <input class="form-control" type="text" name="idAntrian" id="idAntrian" autofocus placeholder="ID Antrian" aria-label="ID Antrian">
                                <!-- <button class="btn btn-primary" id="btnSearch"><i class="fa fa-search"> </i></button> -->
                            </div>
                            <div id="viewAntrian">
                                <hr>
                                <div class="row">
                                    <div class="col-7 view" id="tanggal"></div>
                                    <div class="col-5"><span class="pull-right">ID Antrian : <span class="view" id="viewIdAntrian"></span></span></div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-6">
                                        <table>
                                            <tr>
                                                <th>Nama Pengunjung</th>
                                            </tr>
                                            <tr>
                                                <td class="view" id="namaPengunjung"></td>
                                            </tr>
                                            <tr>
                                                <th>NIK</th>
                                            </tr>
                                            <tr>
                                                <td class="view" id="nik"></td>
                                            </tr>
                                            <tr>
                                                <th>Keterangan</th>
                                            </tr>
                                            <tr>
                                                <td class="view" id="keterangan"></td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-6 pull-right">
                                        <table>
                                            <tbody class="text-center">
                                                <tr>
                                                    <th>
                                                        <h5>NO ANTRIAN</h5>
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th>
                                                        <h1 style="font-size: 85px;" class="view" id="noAntrian"></h1>
                                                    </th>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <hr>
                                <table width="100%">
                                    <tbody>
                                        <tr>
                                            <th width="50%">Nama Narapidana</th>
                                            <td align="right">
                                                <div class="pull-right view" id="namaNarapidana"></div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Blok Kamar</th>
                                            <td>
                                                <div class="pull-right view" id="blokKamar"></div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>No Registrasi</th>
                                            <td>
                                                <div class="pull-right view" id="noRegis"></div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>UU</th>
                                            <td>
                                                <div class="pull-right view" id="uu"></div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <hr>
                                <div class="text-center">
                                    <b>Waktu Kunjungan <span class="view" id="waktuKunjungan"></span></b>
                                </div>
                                <hr>
                                <button class="btn btn-primary btn-block w-100" id="cetak"><i class="fa fa-print"></i> Cetak</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- latest jquery-->
        <script src="<?= base_url('assets'); ?>/js/jquery-3.5.1.min.js"></script>
        <!-- Bootstrap js-->
        <script src="<?= base_url('assets'); ?>/js/bootstrap/bootstrap.bundle.min.js"></script>
        <!-- feather icon js-->
        <script src="<?= base_url('assets'); ?>/js/icons/feather-icon/feather.min.js"></script>
        <script src="<?= base_url('assets'); ?>/js/icons/feather-icon/feather-icon.js"></script>
        <!-- scrollbar js-->
        <!-- Sidebar jquery-->
        <script src="<?= base_url('assets'); ?>/js/config.js"></script>
        <!-- Plugins JS start-->
        <!-- Plugins JS Ends-->
        <!-- Theme js-->
        <script src="<?= base_url('assets'); ?>/js/script.js"></script>
        <!-- login js-->

        <!-- BEGIN: Custom App-->
        <script src="<?= base_url('assets'); ?>/vendors/moment.js"></script>
        <script src="<?= base_url('assets'); ?>/app/custom.js"></script>
        <!-- END: Custom App-->
        <!-- Plugin used-->
        <script>
            $('#viewAntrian').hide();
            $('#idAntrian').focus();

            $(document).ready(function() {

                $('#btnSearch').click(function(e) {
                    e.preventDefault();
                    getData($('#idAntrian').val());
                });

                var idAntrian = '';
                $('#idAntrian').keypress(function(e) {
                    if (e.which == 13) {
                        getData($('#idAntrian').val());

                    }
                });

                $('#cetak').click(function(e) {
                    e.preventDefault();
                    $('#idAntrian').focus();
                    $('#viewAntrian').hide();
                    Swal.fire('Berhasil!', 'No Antrian berhasil dicetak', 'success');
                    window.open(`<?= current_url() ?>/cetakData/${$('#viewIdAntrian').text()}`, 'Cetak Antrian', 'window settings');
                });
            });

            function getData(id) {
                $.ajax({
                    type: "GET",
                    url: `<?= current_url() ?>/getData/${id}`,
                    dataType: "JSON",
                    success: function(res) {
                        console.log(res);
                        if (res.code == 200) {
                            $('#idAntrian').val('');
                            res = res.data;
                            $('#viewAntrian').show();

                            var tanggal = dateConvertToIndo(res.tanggal).date;
                            $('#tanggal').html(tanggal);

                            $('#viewIdAntrian').html(res.id);
                            $('#namaPengunjung').html(res.pengunjung.nama);
                            $('#nik').html(res.nik);
                            $('#keterangan').html(res.keterangan);

                            let noAntrian = parseInt(res.no);
                            if (noAntrian < 10) {
                                noAntrian = `00${noAntrian}`;
                            } else if (noAntrian < 100) {
                                noAntrian = `0${noAntrian}`;
                            }
                            $('#noAntrian').html(noAntrian);

                            $('#namaNarapidana').html(res.napi.nama);
                            $('#blokKamar').html(res.napi.blokKamar);
                            $('#noRegis').html(res.napi.noReg);
                            $('#uu').html(res.napi.uu);
                            $('#namaNarapidana').html(res.napi.nama);

                            $('#waktuKunjungan').html(res.waktuKunjungan);
                        } else {
                            $('.view').html('');
                            $('#viewAntrian').hide();
                        }
                    }
                });
            }
        </script>
    </div>
</body>

</html>