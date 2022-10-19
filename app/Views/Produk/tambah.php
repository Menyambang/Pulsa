<?= $this->extend('Layouts/default'); ?>
<?= $this->section('content'); ?>
<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h3>Produk</h3>
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
                        <h5>Data Produk</h5>
                    </div>
                    <form class="form theme-form" id="form">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">Kode Produk</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="id" id="id" class="form-control readonly-background" value="<?= $produk->produkId ?? ''; ?>" placeholder="Id">
                                            <p class="text-danger" id="er_id"></p>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">Nama</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="nama" id="nama" class="form-control readonly-background" value="<?= $produk->produkNama ?? ''; ?>" placeholder="Nama">
                                            <p class="text-danger" id="er_nama"></p>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">Harga</label>
                                        <div class="col-sm-6">
                                            <input type="text" name="harga" id="harga" class="form-control readonly-background" value="<?= $produk->produkHarga ?? ''; ?>" placeholder="Harga">
                                            <p class="text-danger" id="er_harga"></p>
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="text" name="hargaPer" id="hargaPer" class="form-control readonly-background" value="<?= $produk->produkHargaPer ?? ''; ?>" placeholder="/ pcs">
                                            <p class="text-danger" id="er_hargaPer"></p>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">Diskon</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="diskon" id="diskon" class="form-control readonly-background" value="<?= $produk->produkDiskon ?? ''; ?>" placeholder="Diskon %">
                                            <p class="text-danger" id="er_diskon"></p>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">Stok</label>
                                        <div class="col-sm-6">
                                            <input type="text" name="stok" id="stok" class="form-control readonly-background" value="<?= $produk->produkStok ?? ''; ?>" placeholder="Stok">
                                            <p class="text-danger" id="er_stok"></p>
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="text" name="berat" id="berat" class="form-control readonly-background" value="<?= $produk->produkBerat ?? ''; ?>" placeholder="Berat (gram)">
                                            <p class="text-danger" id="er_berat"></p>
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">Deskripsi</label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control" name="deskripsi" id="deskripsi" rows="5" cols="5" placeholder="Deskripsi"><?= $produk->produkDeskripsi ?? ''; ?></textarea>
                                            <p class="text-danger" id="er_deskripsi"></p>
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">Kategori</label>
                                        <div class="col-sm-9">
                                            <?= form_dropdown('kategoriId', $kategori, $produk->produkKategoriId ?? '', ['class' => 'form-control kategoriId select2', 'id' => 'kategoriId']); ?>
                                            <p class="text-danger" id="er_kategoriId"></p>
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">Gambar</label>
                                        <div class="col-sm-9">
                                            <input class="form-control gambar" type="file" name="gambar[]" multiple placeholder="icon">
                                            <p class="text-danger" id="er_gambar"></p>
                                            <div class="row">
                                                <?php foreach ($produk->gambar ?? [] as $key => $value) : ?>
                                                    <div class="col-md-3 col-sm-6">
                                                        <div class="card cardGambar">
                                                            <div class="product-box">
                                                                <div class="product-img">
                                                                    <?php if ($key == 0) : ?>
                                                                        <div class="ribbon ribbon-danger">Foto Utama</div>
                                                                    <?php endif; ?>
                                                                    <img class="img-fluid" src="<?= base_url('File/get/produk_gambar/' . $value->file) ?>" alt="">
                                                                    <div class="product-hover">
                                                                        <ul>
                                                                            <li>
                                                                                <button data-toggle="tooltip" data-title="Hapus" data-id="<?= $value->id ?>" data-produkid="<?= $value->produkId ?>" class="btn btnHapus" type="button" data-bs-original-title="" title=""><i class="icofont icofont-trash"></i></button>
                                                                            </li>
                                                                            <?php if ($value->isThumbnail == '0') : ?>
                                                                                <li>
                                                                                    <button data-toggle="tooltip" data-title="Jadikan Foto Utama" data-id="<?= $value->id ?>" data-produkid="<?= $value->produkId ?>" class="btn btnSetThumbnail" type="button" data-bs-original-title="" title=""><i class="icofont icofont-pencil"></i></button>
                                                                                </li>
                                                                            <?php endif; ?>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <div class="col-12">
                                <button class="btn btn-primary pull-right" id="btnSimpan">Simpan</button>
                                <a class="btn btn-light" href="<?= base_url('Produk') ?>" data-bs-original-title="" title="">Kembali</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- VARIASI -->
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Varasi</h5>
                    </div>
                    <form class="form theme-form" id="formVariasi">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">Nama</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="namaVariant" id="namaVariant" class="form-control readonly-background" placeholder="Nama">
                                            <p class="text-danger" id="er_namaVariant"></p>
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">Harga</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="hargaVariant" id="hargaVariant" class="form-control readonly-background" placeholder="Harga">
                                            <p class="text-danger" id="er_hargaVariant"></p>
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">Stok</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="stokVariant" id="stokVariant" class="form-control readonly-background" placeholder="Stok">
                                            <p class="text-danger" id="er_stokVariant"></p>
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">Stok dari produk</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="stokProdukVariant" id="stokProdukVariant" class="form-control readonly-background" placeholder="Stok dari produk">
                                            <p class="text-danger" id="er_stokProdukVariant"></p>
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">Gambar</label>
                                        <div class="col-sm-9">
                                            <input class="form-control gambarVariasi" type="file" name="gambarVariasi" placeholder="icon">
                                            <p class="text-danger" id="er_gambarVariasi"></p>
                                        </div>
                                    </div>

                                    <!-- Variant -->
                                    <div class="mb-3 row">
                                        <label class="col-sm-3 col-form-label">Variasi</label>
                                        <div class="col-sm-9">
                                            <?php foreach (@$produk->variant ?? [] as $key => $value) : ?>
                                                <div class="prooduct-details-box">
                                                    <div class="media"><img class="align-self-center img-fluid img-100 mx-3" src="<?= base_url('File/get/produk_variasi/' . ($value->gambar ?? 'empty.jpg')) ?>" alt="#">
                                                        <div class="media-body ms-3">
                                                            <div class="product-name">
                                                                <h6><a href="#" data-bs-original-title="" title=""><?= $value->nama ?></a>

                                                                </h6>
                                                            </div>
                                                            <div class="price d-flex">
                                                                <div class="text-muted me-2">Harga</div>: Rp. <?= number_format($value->harga) ?> &nbsp;&nbsp;
                                                            </div>
                                                            <div class="price d-flex">
                                                                <div class="text-muted me-2">Stok Variasi</div>: <?= $value->stok ?>
                                                            </div>
                                                            <div class="price d-flex">
                                                                <div class="text-muted me-2">Stok dari produk</div>: <?= $value->produkStok ?>
                                                            </div>
                                                            <a style="position:relative" class="btn pull-right btn-xs btn-outline-warning waves-effect waves-light" id="btnEditVariasi" data-id="<?= $value->id ?>" data-stok="<?= $value->stok ?>" data-harga="<?= $value->harga ?>" data-produkstok="<?= $value->produkStok ?>" data-nama="<?= $value->nama ?>" data-container="body" data-toggle="tooltip" data-placement="top" data-original-title="Ubah" data-row="1"><i class="feather icon-edit"></i></a>
                                                            <a style="position:relative" class="btn pull-right btn-xs btn-outline-danger waves-effect waves-light mr-2" id="btnHapusVariasi" data-id="<?= $value->id ?>" data-container="body" data-toggle="tooltip" data-placement="top" data-original-title="Hapus" data-row="1"><i class="feather icon-trash"></i></a>
                                                            <!-- <a class="btn btn-success btn-xs" href="#" data-bs-original-title="" title="">Stok dari produk <?= $value->produkStok ?></a> -->
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <div class="col-12">
                                <button class="btn btn-primary pull-right" id="btnSimpanVariasi">Simpan</button>
                                <a class="btn btn-light" href="<?= base_url('Produk') ?>" data-bs-original-title="" title="">Kembali</a>
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

        var id = '<?= $id ?? ''; ?>';

        $('[name="harga"]').val(formatRupiah($('[name="harga"]').val()));
        krajeeConfig('.gambar', {
            type: 'image'
        });
        krajeeConfig('.gambarVariasi', {
            type: 'image'
        });


        $('[name="kategoriId"]').select2().trigger('change');

        $(document).on('keyup', '[name="harga"]', function(e) {
            $('[name="harga"]').val(formatRupiah($(this).val()));
        });

        $(document).on('click', '.btnHapus', function(e) {
            e.preventDefault();
            let btn = $(e.currentTarget);
            let gambarId = $(this).data('id');
            let produkId = $(this).data('produkid');
            let ini = $(this);

            Swal.fire({
                title: 'Anda Yakin ?',
                text: "Data yang terhapus tidak dapat dikembalikan!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Tidak',
                confirmButtonText: 'Ya'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type: "POST",
                        url: `<?= base_url('Produk') ?>/hapusGambar/${gambarId}/${produkId}`,
                        dataType: "JSON",
                        success: function(res) {
                            if (res.code == 200) {
                                ini.parents('.cardGambar').remove();
                                Swal.fire('Terhapus!', 'Data berhasil dihapus', 'success')
                            } else {
                                Swal.fire('Info!', res.message, 'warning')
                            }
                        },
                        fail: function(xhr) {
                            Swal.fire('Error', "Server gagal merespon", 'error');
                        },
                        beforeSend: function() {
                            btn.attr('disabled', true).html('<i class="fa fa-spin fa-spinner"></i>');
                        },
                        complete: function(res) {
                            btn.removeAttr('disabled').html('<i class="icofont icofont-trash"></i>');
                        }
                    });

                }
            });

        });

        $(document).on('click', '.btnSetThumbnail', function(e) {
            e.preventDefault();
            let btn = $(e.currentTarget);
            let id = $(this).data('id');
            let ini = $(this);

            Swal.fire({
                title: 'Anda Yakin ?',
                text: "Mengubah jadi foto utama!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Tidak',
                confirmButtonText: 'Ya'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type: "POST",
                        url: `<?= base_url('Produk') ?>/setThumbnail/${id}`,
                        dataType: "JSON",
                        success: function(res) {
                            if (res.code == 200) {
                                Swal.fire('Berhasil', res.message, 'success')
                                location.reload();
                            } else {
                                Swal.fire('Gagal', res.message, 'error')
                            }
                        },
                        fail: function(xhr) {
                            Swal.fire('Error', "Server gagal merespon", 'error');
                        },
                        beforeSend: function() {
                            btn.attr('disabled', true).html('<i class="fa fa-spin fa-spinner"></i>');
                        },
                        complete: function(res) {
                            btn.removeAttr('disabled').html('<i class="icofont icofont-pencil"></i>');
                        }
                    });

                }
            });
        });

        $(document).on('click', '#btnSimpan', function(e) {
            e.preventDefault();
            $('#form').trigger('submit');
        });

        $('#form').submit(function(e) {
            e.preventDefault();

            var data = new FormData(this);
            data.append('idBefore', id);

            $.ajax({
                type: "POST",
                url: `<?= base_url('Produk') ?>/simpan/id`,
                data: data,
                dataType: "JSON",
                cache: false,
                processData: false,
                contentType: false,
                success: function(res) {
                    if (res.code == 200) {
                        Swal.fire('Berhasil!', 'Data berhasil disimpan', 'success');

                        setTimeout(() => {
                            location.reload();
                        }, 400);
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
                    $('#btnSimpan').attr('disabled', true).html('<i class="fa fa-spin fa-spinner"></i> Loading...');
                },
                complete: function(res) {
                    $('#btnSimpan').removeAttr('disabled').html('Simpan');
                }
            });
        });

        var idVariant = null;
        $(document).on('click', '#btnEditVariasi', function(e) {
            e.preventDefault();
            idVariant = $(this).data('id');
            $('[name="namaVariant"]').val($(this).data('nama'));
            $('[name="hargaVariant"]').val($(this).data('harga'));
            $('[name="stokVariant"]').val($(this).data('stok'));
            $('[name="stokProdukVariant"]').val($(this).data('produkstok'));
        });

        $(document).on('click', '#btnHapusVariasi', function(e) {
            e.preventDefault();
            id = $(this).data('id');
            var ini = this;

            Swal.fire({
                title: 'Anda Yakin ?',
                text: "Data yang terhapus tidak dapat dikembalikan!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Tidak',
                confirmButtonText: 'Ya'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type: "POST",
                        url: `<?= base_url('Produk') ?>/hapusVariasi/${id}`,
                        dataType: "JSON",
                        cache: false,
                        processData: false,
                        contentType: false,
                        success: function(res) {
                            if (res.code == 200) {
                                setTimeout(() => {
                                    location.reload();
                                }, 400);
                            } else if (res.code == 400) {
                                Swal.fire('Error', res.message, 'error');
                            }
                        },
                        fail: function(xhr) {
                            Swal.fire('Error', "Server gagal merespon", 'error');
                        },
                        beforeSend: function() {
                            $("[id^='er_']").html('');
                            $(ini).attr('disabled', true).html('<i class="fa fa-spin fa-spinner"></i>');
                        },
                        complete: function(res) {
                            $(ini).removeAttr('disabled').html('<i class="fa fa-trash"></i>');
                        }
                    });

                }
            });


        });

        $('#formVariasi').submit(function(e) {
            e.preventDefault();

            var data = new FormData(this);
            data.append('produkId', id);

            if (idVariant) {
                data.append('id', idVariant);
            }

            $.ajax({
                type: "POST",
                url: `<?= base_url('Produk') ?>/simpanVariasi`,
                data: data,
                dataType: "JSON",
                cache: false,
                processData: false,
                contentType: false,
                success: function(res) {
                    if (res.code == 200) {
                        Swal.fire('Berhasil!', 'Data berhasil disimpan', 'success');

                        setTimeout(() => {
                            location.reload();
                        }, 400);
                    } else if (res.code == 403) {
                        Swal.fire('Error', res.message, 'error');
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
                    $('#btnSimpanVariasi').attr('disabled', true).html('<i class="fa fa-spin fa-spinner"></i> Loading...');
                },
                complete: function(res) {
                    $('#btnSimpanVariasi').removeAttr('disabled').html('Simpan');
                }
            });
        });

    });
</script>
<?= $this->endSection(); ?>