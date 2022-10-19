<?= $this->extend('Layouts/default'); ?>
<?= $this->section('content'); ?>
<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h3>Top Up Saldo</h3>
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
                        <p class="card-text">Data Top Up Saldo.</p>
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
                                        <th>Status</th>
                                        <th>Jenis</th>
                                        <th>Aksi</th>
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

    <!-- Modal Verifikasi -->
    <div class="modal fade" id="modalVerifikasi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Verifikasi Pembayaran</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form">
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <p>
                                Fitur ini digunakan untuk memverifikasi pembayaran yang dilakukan oleh pelanggan menggunakan transfer ke nomor rekening.
                                Verifikasi jika pelanggan sudah mentransfer ke nomor rekening anda.
                                Setelah diverifikasi maka status pembayaran akan berubah menjadi <b><i>Settlement</i></b>
                            </p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm grey btn-primary" id="btnAksiVerifikasi">Verifikasi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

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
            id = dataRow.id;

            $('#modalVerifikasi').modal('show');
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

     
        grid = $("#datatable").DataTable({
            processing: true,
            serverSide: true,
            order: [[ 2, "desc" ]],
            ajax: {
                url: "<?= current_url(); ?>/grid",
                data: function(d) {
                    d.filter = $("#form-advanced-filter").serialize();
                }
            },
            columns: [{
                    data: 'email',
                    render: function(val, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: 'paymentType',
                    render: function(val, type, row, meta) {
                        if(val == 'bank_transfer') return 'Transfer Bank <span class="badge badge-primary text-light">Virtual Account</span>';
                        else if(val == 'manual_transfer') return 'Transfer Bank <span class="badge badge-primary text-light">Rekening</span>';
                        else if(val == 'echannel') return 'Mandiri Bill';
                        else if(val == 'saldo') return 'Saldo';
                        else if (val == 'cstore') return row.store.toUpperCase();
                    }
                },
                {
                    data: 'time',
                },
                {
                    data: 'orderId',
                },
                {
                    data: 'userEmail',
                },
                {
                    data: 'grossAmount',
                    render: function(val, type, row, meta) {
                        return `Rp. ${formatRupiah(val)}`;
                    }
                },
                {
                    data: 'status',
                    render: function(val, type, row, meta) {
                        let text = '';

                        if(val == 'pending') return `<span class="badge badge-light text-dark">Pending</span>`;
                        else if(val == 'settlement') return `<span class="badge badge-success text-light">Settelment</span>`;
                        else if(val == 'cancel') return `<span class="badge badge-danger text-light">Cancel</span>`;
                        else if(val == 'expire') return `<span class="badge badge-danger text-light">Expire</span>`;
                        else if(val == 'failure') return `<span class="badge badge-danger text-light">Failure</span>`;
                        
                        text = val;

                        return text;
                    }
                },
                {
                    data: 'statusSaldo',
                    render: function(val, type, row, meta) {
                        let text = '';

                        if(val == 'top_up') return `<span class="badge badge-primary text-light">Top UP</span>`;
                        else if(val == 'top_down') return `<span class="badge badge-success text-light">Pembayaran</span>`;
                        else if(val == 'pembelian_pulsa') return `<span class="badge badge-primary text-light">Produk Digital</span>`;
                        
                        text = val;

                        return text;
                    }
                },
                {
                    data: 'id',
                    render: function(val, type, row, meta) {
                        var btnVerifikasi = btnDatatableConfig('custom', {
                            'id': 'btnVerifikasi',
                            'data-row': meta.row,
                        }, {
                            'textBtn': 'Verifikasi',
                            'iconBtn': 'feather icon-check-circle',
                            show: true
                        });

                        if(row.paymentType == 'manual_transfer' && row.status == 'pending'){
                            return `${btnVerifikasi}`;
                        }

                        return '';
                    }
                }
            ]
        });

    });
</script>
<?= $this->endSection(); ?>