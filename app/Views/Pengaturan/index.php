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
                        <h5>Pengaturan Produk Digital</h5>
                    </div>
                    <form class="form theme-form" id="form">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">URL Endpoint</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="h2h_endpoint" id="h2h_endpoint" class="form-control readonly-background" value="<?= @$settings['h2h_endpoint'] ?>" placeholder="EndPoint URL">
                                            <p class="text-danger" id="er_h2h_endpoint"></p>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">ID</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="h2h_id" id="h2h_id" class="form-control readonly-background" value="<?= @$settings['h2h_id'] ?>" placeholder="ID">
                                            <p class="text-danger" id="er_h2h_id"></p>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">User</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="h2h_user" id="h2h_user" class="form-control readonly-background" value="<?= @$settings['h2h_user'] ?>" placeholder="User">
                                            <p class="text-danger" id="er_h2h_user"></p>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">Password</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="h2h_pass" id="h2h_pass" class="form-control readonly-background" value="<?= @$settings['h2h_pass'] ?>" placeholder="Password">
                                            <p class="text-danger" id="er_h2h_pass"></p>
                                        </div>
                                    </div>
                                 

                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <div class="col-12">
                                <button class="btn btn-primary pull-right btnSimpan">Simpan</button>
                                <a class="btn btn-light" href="" data-bs-original-title="" title="">Kembali</a>
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
                                <a class="btn btn-light" href="" data-bs-original-title="" title="">Kembali</a>
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
            url: `<?= base_url('File/get/'.PATH_PENGATURAN.'/'.@$settings['splash_banner']) ?>`,
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