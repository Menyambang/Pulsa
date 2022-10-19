<?= $this->extend('Layouts/default'); ?>
<?= $this->section('content'); ?>
<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h3>Pembelian Produk</h3>
                </div>
                <div class="col-6">
                    <!-- <button class="btn btn-sm btn-primary pull-right" id="btnTambah" data-toggle="modal" data-target="#modal"><i class="fa fa-plus"></i> Tambah</button> -->
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <!-- <div class="card-header">
                        <h5 class="m-b-0">Feather Icons</h5>
                    </div> -->
                    <div class="card-body">
                        <p class="card-text">Data Pembelian Produk.</p>
                        <div class="table-responsive">
                            <table class="display" id="datatable" width="100%">
                                <thead>
                                    <tr>
                                        <th width="1%">No</th>
                                        <th>Metode Pembayaran</th>
                                        <th>Tanggal & Waktu</th>
                                        <th>ID Pesanan</th>
                                        <th>Email Pelanggan</th>
                                        <th>Jumlah</th>
                                        <th>Status Pembayaran</th>
                                        <th>Status Pembelian</th>
                                        <th width="70px">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->

    <?= $this->include('Transaksi/PembelianProduk/modal'); ?>
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
    $(document).ready(function() {

        var id;
        $(document).on('click', '#btnVerifikasi', function(e) {
            e.preventDefault();

            let row = $(this).data('row');
            dataRow = grid.row(row).data();
            id = dataRow.pembayaran.id;

            $('#modalVerifikasi').modal('show');
        });

        $(document).on('click', '#btnInvoice', function(e) {
            e.preventDefault();

            let row = $(this).data('row');
            dataRow = grid.row(row).data();
            id = dataRow.id;

            window.open('<?= base_url('TransaksiPembelianProduk/invoice/')?>/'+id, '_blank');
        });

        $(document).on('click', '#btnAksiVerifikasi', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Pembayaran yang sudah diverikasi tidak bisa dikembalikan",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Verifikasi!',
                confirmButtonClass: 'btn btn-primary',
                cancelButtonClass: 'btn btn-danger ml-1',
                buttonsStyling: false,
                }).then(function (result) {
                    if (result.value) {
                        $.ajax({
                            type: "POST",
                            url: `<?= current_url() ?>/verifikasiPembayaran/${id}`,
                            dataType: "JSON",
                            success: function(res) {
                                if (res.code == 200) {
                                    grid.draw(false);
                                    $('#modalVerifikasi').modal('hide');
                                    Swal.fire('Berhasil!', res.message, 'success');
                                }else{
                                    Swal.fire('Gagal!', res.message, 'error');
                                }
                            },
                            fail: function(xhr) {
                                Swal.fire('Error', "Server gagal merespon", 'error');
                            },
                            beforeSend: function() {
                                $("[id^='er_']").html('');
                                $('#btnAksiVerifikasi').attr('disabled', true).html('<i class="fa fa-spin fa-spinner"></i> Loading...');
                            },
                            complete: function(res) {
                                $('#btnAksiVerifikasi').removeAttr('disabled').html('Verifikasi');
                            }
                        });
                    }
            })
        });

        $(document).on('click', '#btnEdit', function(e) {
            e.preventDefault();
            let row = $(this).data('row');
            dataRow = grid.row(row).data();


            $('[name="noResi"]').val(dataRow.kurir.noResi);

            let tipe = dataRow.kurir.tipePengiriman == 'pickup' ? '<span class="badge badge-primary text-light">Ambil Sendiri</span>' : '<span class="badge badge-success text-light">Diantar</span>';
            $('.kurir_tipe').html(`${tipe}`);
            $('.kurir_layanan').html(`${dataRow.kurir.deskripsi} (${dataRow.kurir.service})`);
            $('.kurir_nama').html(`${dataRow.kurir.nama} (${dataRow.kurir.kurir})`);
            $('.catatan_pembeli').html(`${dataRow.catatan}`);
            $('.catatan_kurir').html(`${dataRow.alamat.keterangan}`);
            $('.alamat_pembeli').html(`${dataRow.alamat.jalan}, ${dataRow.alamat.kecamatanNama}, ${dataRow.alamat.kotaTipe} ${dataRow.alamat.kotaNama}, ${dataRow.alamat.provinsiNama}`);

            $('#modal').modal('show');
            $('#aksi').html('Ubah');
        });

        function templateOrderDetail(dataDetail){
            let text = '';
            let total = 0;
            dataDetail.forEach(element => {
                text +=  `<tr>
                            <td>
                                <p class="m-0">${element.keterangan}</p>
                            </td>
                            <td>
                                <p class="itemtext">Rp. ${formatRupiah(element.biaya.toString())}</p>
                            </td>
                        </tr>`;

                total += element.biaya;
            });

            return `<table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <td class="item">
                                        <h6 class="p-2 mb-0">Keterangan</h6>
                                    </td>
                                    <td class="subtotal">
                                        <h6 class="p-2 mb-0">Sub-total</h6>
                                    </td>
                                </tr>

                                ${text}
                               
                                <tr>
                                    <td class="Rate">
                                        <h6 class="mb-0 p-2">Total</h6>
                                    </td>
                                    <td class="payment">
                                        <h6 class="mb-0 p-2">Rp. ${formatRupiah(total.toString())}</h6>
                                    </td>
                                </tr>
                            </tbody>
                        </table>`;
            
        }

        $(document).on('click', '#btnDetail', function(e) {
            e.preventDefault();
            let row = $(this).data('row');
            dataRow = grid.row(row).data();

            $('[name="noResi"]').val(dataRow.kurir.noResi);
            $('#orderDetail').html(templateOrderDetail(dataRow.detail));

            loadKeranjangDetail(dataRow);

            let tipe = dataRow.kurir.tipePengiriman == 'pickup' ? '<span class="badge badge-primary text-light">Ambil Sendiri</span>' : '<span class="badge badge-success text-light">Diantar</span>';
            $('.kurir_tipe').html(`${tipe}`);
            $('.kurir_layanan').html(`${dataRow.kurir.deskripsi} (${dataRow.kurir.service})`);
            $('.kurir_nama').html(`${dataRow.kurir.nama} (${dataRow.kurir.kurir})`);
            $('.catatan_pembeli').html(`${dataRow.catatan}`);
            $('.catatan_kurir').html(`${dataRow.alamat.keterangan}`);
            $('.alamat_pembeli').html(`${dataRow.alamat.jalan}, ${dataRow.alamat.kecamatanNama}, ${dataRow.alamat.kotaTipe} ${dataRow.alamat.kotaNama}, ${dataRow.alamat.provinsiNama}`);

            $('#modal-detail').modal('show');
            $('#aksi').html('Ubah');
        });

        function templateKeranjangDetail(dataDetail){
            let text = '';
            
            dataDetail.forEach(element => {
                let hargaNormal = element.products.harga;
                let hargaDiskon = element.products.harga;
                let diskonText = '';
                var variant = '';
                var variantText = '';

                if(element.products.variant){
                    variant = element.products.variant.find(data => data.id == element.variantId);
                }

                console.log('VARIANT', typeof variant)

                if(variant != '' && variant != null && variant != undefined){
                    hargaNormal = variant.harga;
                    hargaDiskon = variant.harga;

                    variantText = `<div class="price d-flex">
                                    <div class="text-muted me-2">Variant</div>: <code>${variant.nama}</code>
                                </div>`;
                }
    
                if(element.products.diskon != 0){
                    hargaNormal = hargaNormal - (hargaNormal * (element.products.diskon / 100));
                    diskonText = `<del>${formatRupiah(hargaDiskon.toString())}</del>`;
                }
                text +=  `<div class="prooduct-details-box"> 
                          <div class="media"><img class="align-self-center img-fluid img-100 mx-3" src="<?=base_url('File/get/produk_gambar/')?>/${element.products.gambar[0].file}" alt="#">
                            <div class="media-body ms-3">
                              <div class="product-name">
                                <h6><a href="#" data-bs-original-title="" title="">${element.products.nama}</a></h6>
                              </div>
                              <div class="price d-flex"> 
                                <div class="text-muted me-2">Harga</div>: Rp. ${formatRupiah(hargaNormal.toString())} &nbsp;&nbsp; ${diskonText}
                              </div>
                              <div class="price d-flex">
                                <div class="text-muted me-2">Jumlah</div>: ${element.quantity}
                              </div>
                              ${variantText}
                              <a class="btn btn-success btn-xs" href="#" data-bs-original-title="" title="">Diskon ${element.products.diskon}%</a>
                            </div>
                          </div>
                        </div>`;
            });

            return `${text}`;
            
        }

        function loadKeranjangDetail(data){
            $.ajax({
                type: "POST",
                url: `<?= current_url() ?>/keranjangDetail/`+data.id,
                dataType: "JSON",
                cache: false,
                processData: false,
                contentType: false,
                success: function(res) {
                    $('#keranjangDetail').html(templateKeranjangDetail(res.data));
                },
                fail: function(xhr) {
                    Swal.fire('Error', "Server gagal merespon", 'error');
                },
                beforeSend: function() {
                    $('#keranjangDetail').attr('disabled', true).html('<i class="fa fa-spin fa-spinner"></i> Loading...');
                },
                complete: function(res) {
                }
            });
        }
        

        $('#form').submit(function(e) {
            e.preventDefault();

            var data = new FormData(this);
            data.append('id', dataRow ? dataRow.id : '');

            $.ajax({
                type: "POST",
                url: `<?= current_url() ?>/simpan/id`,
                data: data,
                dataType: "JSON",
                cache: false,
                processData: false,
                contentType: false,
                success: function(res) {
                    if (res.code == 200) {
                        grid.draw(false);
                        $('.modal').modal('hide');
                        Swal.fire('Berhasil!', res.message, 'success');
                    } else {
                        $.each(res.message, function(index, val) {
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

        grid = $("#datatable").DataTable({
            processing: true,
            serverSide: true,
            order: [
                [2, "desc"]
            ],
            ajax: {
                url: "<?= current_url(); ?>/grid",
                data: function(d) {
                    d.filter = $("#form-advanced-filter").serialize();
                }
            },
            columns: [{
                    data: 'pembayaran.id',
                    render: function(val, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: 'pembayaran.paymentType',
                    render: function(val, type, row, meta) {
                        if(val == 'bank_transfer') return 'Transfer Bank <span class="badge badge-primary text-light">Virtual Account</span>';
                        else if(val == 'manual_transfer') return 'Transfer Bank <span class="badge badge-primary text-light">Rekening</span>';
                        else if (val == 'echannel') return 'Mandiri Bill';
                        else if (val == 'saldo') return 'Saldo';
                        else if (val == 'cod') return 'Cash On Delivery';
                        else if (val == 'cstore') return row.pembayaran.store.toUpperCase();
                    }
                },
                {
                    data: 'pembayaran.time',
                },
                {
                    data: 'pembayaran.orderId',
                },
                {
                    data: 'pembayaran.userEmail',
                },
                {
                    data: 'pembayaran.grossAmount',
                    render: function(val, type, row, meta) {
                        return `Rp. ${formatRupiah(val.toString())}`;
                    }
                },
                {
                    data: 'pembayaran.status',
                    render: function(val, type, row, meta) {
                        let text = '';

                        if(val == 'pending') return `<span class="badge badge-light text-dark">Pending</span>`;
                        else if(val == 'settlement') return `<span class="badge badge-success text-light">Settelment</span>`;
                        else if (val == 'cancel') return `<span class="badge badge-danger text-light">Cancel</span>`;
                        else if (val == 'expire') return `<span class="badge badge-danger text-light">Expire</span>`;
                        else if (val == 'failure') return `<span class="badge badge-danger text-light">Failure</span>`;

                        text = val;

                        return text;
                    }
                },
                {
                    data: 'status',
                    render: function(val, type, row, meta) {
                        let text = '';

                        if (val == 'selesai') return `<span class="badge badge-success text-light">Selesai</span>`;
                        else if (val == 'dikirim') return `<span class="badge badge-primary text-light">Dikirim</span>`;
                        else if (val == 'dikemas') return `<span class="badge badge-primary text-light">Dikemas</span>`;
                        else if (val == 'belum_bayar') return `<span class="badge badge-danger text-light">Belum Dibayar</span>`;
                        else if (val == 'dibatalkan') return `<span class="badge badge-danger text-light">Dibatalkan</span>`;

                        text = val;

                        return text;
                    }
                },
                {
                    data: 'id',
                    render: function(val, type, row, meta) {
                        var btnDetail = btnDatatableConfig('detail', {
                            'id': 'btnDetail',
                            'data-row': meta.row,
                        }, {
                            show: true
                        });

                        var btnInvoice = btnDatatableConfig('custom', {
                            'id': 'btnInvoice',
                            'data-row': meta.row,
                        }, {
                            'textBtn': 'Invoice',
                            'iconBtn': 'fa fa-print',
                            show: true
                        });

                        var btnEdit = btnDatatableConfig('update', {
                            'id': 'btnEdit',
                            'data-row': meta.row,
                        }, {
                            show: row.pembayaran.status == 'settlement' && (row.status == 'dikemas' || row.status == 'dikirim')
                        });

                        var btnVerifikasi = '';
                        if((row.pembayaran.paymentType == 'manual_transfer' || row.pembayaran.paymentType == 'cod') && row.pembayaran.status == 'pending'){
                            btnVerifikasi = btnDatatableConfig('custom', {
                                'id': 'btnVerifikasi',
                                'data-row': meta.row,
                            }, {
                                'textBtn': 'Verifikasi',
                                'iconBtn': 'feather icon-check-circle',
                                show: true
                            });
                        }

                        return `${btnDetail} ${btnEdit} ${btnVerifikasi} ${btnInvoice}`;
                    }
                }
            ]
        });

    });
</script>
<?= $this->endSection(); ?>