<?= $this->extend('Layouts/default'); ?>
<?= $this->section('content'); ?>
<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h3>Pengaturan</h3>
                </div>
                <div class="col-6">
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Umum</h5>
                    </div>
                    <form class="form theme-form" id="form">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">App Name</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="app_name" id="app_name" class="form-control readonly-background" value="<?= @$settings['app_name'] ?>" placeholder="EndPoint URL">
                                            <p class="text-danger" id="er_app_name"></p>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">Server ID</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="server_id" id="server_id" class="form-control readonly-background" value="<?= @$settings['server_id'] ?>" placeholder="ID">
                                            <p class="text-danger" id="er_server_id"></p>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">Tagline</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="tagline" id="tagline" class="form-control readonly-background" value="<?= @$settings['tagline'] ?>" placeholder="User">
                                            <p class="text-danger" id="er_tagline"></p>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">Api URL</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="api_url" id="api_url" class="form-control readonly-background" value="<?= @$settings['api_url'] ?>" placeholder="Password">
                                            <p class="text-danger" id="er_api_url"></p>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">Api KEY</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="api_key" id="api_key" class="form-control readonly-background" value="<?= @$settings['api_key'] ?>" placeholder="Password">
                                            <p class="text-danger" id="er_api_key"></p>
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">Maksimal Kode OTP (per hari)</label>
                                        <div class="col-sm-9">
                                            <input type="number" name="max_otp" id="max_otp" class="form-control readonly-background" value="<?= @$settings['max_otp'] ?>" placeholder="Maksimal Kode OTP">
                                            <p class="text-danger" id="er_max_otp"></p>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <div class="col-12">
                                <button class="btn btn-primary pull-right btnSimpan">Simpan</button>
                                <a class="btn btn-light invisible" href="" data-bs-original-title="" title="">Kembali</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>


        </div>



        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Pengaturan Aplikasi Mobile</h5>
                    </div>
                    <form class="form theme-form" id="formAplikasiMobile">
                        <div class="card-body">
                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label">Warna Aplikasi</label>
                                <div class="col-sm-1">
                                    <input type="color" name="app_color" id="app_color" class="form-control readonly-background" value="<?= @$settings['app_color'] ?>" placeholder="Password">
                                    <p class="text-danger" id="er_app_color"></p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">Splash Banner</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="file" name="splash_banner" placeholder="splash_banner">
                                            <p class="text-danger" id="er_splash_banner"></p>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <div class="col-12">
                                <button class="btn btn-primary pull-right btnSimpan">Simpan</button>
                                <a class="btn btn-light invisible" href="" data-bs-original-title="" title="">Kembali</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>


        </div>
    </div>
    <!-- Container-fluid Ends-->

    <?= $this->include('Produk/modal'); ?>
</div>
<?= $this->endSection(); ?>

<?= $this->section('css'); ?>
<style>
    .readonly-background[readonly] {
        background-color: white !important;
    }
</style>
<?= $this->endSection(); ?>

<?= $this->section('js'); ?>
<script>
    var grid = null;
    var dataRow;
    $(document).ready(function() {

        // $('[name="harga"]').val(formatRupiah($('[name="harga"]').val()));
        krajeeConfig('[name="splash_banner"]', {
            url: `<?= base_url('File/get/' . PATH_PENGATURAN . '/' . @$settings['splash_banner']) ?>`,
            filename: '<?= @$settings['splash_banner'] ?>',
            caption: `Splash`,
            action: true,
            type: 'image',
        });


        // $(document).on('click', '.btnSimpan', function(e) {
        //     e.preventDefault();
        //     $('#form').trigger('submit');
        // });

        $('#form').submit(function(e) {
            e.preventDefault();

            let ini = $(this)

            var data = new FormData(this);

            $.ajax({
                type: "POST",
                url: `<?= base_url('Pengaturan') ?>/simpan`,
                data: data,
                dataType: "JSON",
                cache: false,
                processData: false,
                contentType: false,
                success: function(res) {
                    if (res.code == 200) {
                        Swal.fire('Berhasil!', res.message, 'success');
                    } else {
                        $.each(res.message, function(index, val) {
                            if (index == 'gambar[]') index = 'gambar';
                            $('#er_' + index).html(val);
                        });
                    }
                },
                fail: function(xhr) {
                    Swal.fire('Error', "Server gagal merespon", 'error');
                },
                beforeSend: function() {
                    $("[id^='er_']").html('');
                    ini.find('.btnSimpan').attr('disabled', true).html('<i class="fa fa-spin fa-spinner"></i> Loading...');
                },
                complete: function(res) {
                    ini.find('.btnSimpan').removeAttr('disabled').html('Simpan');
                }
            });
        });

        $('#formAplikasiMobile').submit(function(e) {
            e.preventDefault();

            let ini = $(this)

            var data = new FormData(this);

            $.ajax({
                type: "POST",
                url: `<?= base_url('Pengaturan') ?>/simpanPengaturanAplikasiMobile`,
                data: data,
                dataType: "JSON",
                cache: false,
                processData: false,
                contentType: false,
                success: function(res) {
                    if (res.code == 200) {
                        Swal.fire('Berhasil!', res.message, 'success');
                    } else {
                        $.each(res.message, function(index, val) {
                            if (index == 'gambar[]') index = 'gambar';
                            $('#er_' + index).html(val);
                        });
                    }
                },
                fail: function(xhr) {
                    Swal.fire('Error', "Server gagal merespon", 'error');
                },
                beforeSend: function() {
                    $("[id^='er_']").html('');
                    ini.find('.btnSimpan').attr('disabled', true).html('<i class="fa fa-spin fa-spinner"></i> Loading...');
                },
                complete: function(res) {
                    ini.find('.btnSimpan').removeAttr('disabled').html('Simpan');
                }
            });
        });


    });
</script>
<?= $this->endSection(); ?>