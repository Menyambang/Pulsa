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
                    <a class="btn btn-sm btn-primary pull-right" href="<?=base_url('Produk')?>/tambah"><i class="fa fa-plus"></i> Tambah</a>
                    <button class="btn btn-sm btn-primary pull-right mr-1" id="btnTambah" data-toggle="modal" data-target="#modal"><i class="fa fa-pencil"></i> Bulk Update</button>
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
                        <p class="card-text">Data Produk.</p>
                        <div class="table-responsive">
                            <table class="display" id="datatable" width="100%">
                                <thead>
                                    <tr>
                                        <th width="1%">No</th>
                                        <th width="5%">Kode</th>
                                        <th width="6%">Gambar</th>
                                        <th width="40%">Nama</th>
                                        <th width="2%">Stok</th>
                                        <th width="5%">Harga</th>
                                        <th width="5%">Kategori</th>
                                        <th width="3%">Aksi</th>
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

        $('#btnTambah').click(function(e) {
            e.preventDefault();
            $('#aksi').html('Tambah');
            $('input').val('');
            krajeeConfig('[name="file"]', {
                type: 'excel'
            });
        });

        $(document).on('click', '.btnDownloadTemplate', function(e) {
            e.preventDefault();
            
            let stok = $('[name="stok"]').val();
            console.log('test', stok)

            // if(stok <= 0){
            //     $('#er_stok').html('Stok tidak boleh kosong');
            // }else{
                $('#er_stok').html('');
                window.open('<?=base_url('Produk/downloadTemplate')?>/'+stok, '_blank');
            // }
        });

        $(document).on('click', '#btnHapus', function(e) {
            e.preventDefault();
            let btn = $(e.currentTarget);
            let row = $(this).data('row');
            dataRow = grid.row(row).data();

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
                        url: `<?= current_url() ?>/hapus/${dataRow.id}`,
                        // data: send,
                        dataType: "JSON",
                        success: function(res) {
                            if (res.code == 200) {
                                grid.draw(false);
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
                            btn.removeAttr('disabled').html('<i class="feather icon-trash"></i>');
                        }
                    });

                }
            });

            $("[id^='er_']").html('');
        });

        $('#form').submit(function(e) {
            e.preventDefault();

            var data = new FormData(this);

            $.ajax({
                type: "POST",
                url: `<?= current_url() ?>/bulkUpdate`,
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
                    $('#btnUpdate').attr('disabled', true).html('<i class="fa fa-spin fa-spinner"></i> Loading...');
                },
                complete: function(res) {
                    $('#btnUpdate').removeAttr('disabled').html('Update');
                }
            });
        });

        grid = $("#datatable").DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "<?= current_url(); ?>/grid",
                data: function(d) {
                    d.filter = $("#form-advanced-filter").serialize();
                }
            },
            columns: [{
                    data: 'id',
                    render: function(val, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: 'id',
                },
                {
                    data: 'gambar',
                    render: function(val, type, row, meta) {
                        let file = val[0].file;

                        val.forEach(element => {
                            if(element.isThumbnail == 1){
                                file = element.file
                            }
                        });
                        let link = `<?= base_url('File') ?>/get/produk_gambar/${file}`;
                        return `<a href="${link}" target="_BLANK"><img  width="60px" class="img-fluid img-thumbnail js-tilt" src="${link}"  ></a>`;
                    }
                },
                {
                    data: 'nama',
                },
                {
                    data: 'stok',
                    render: function(val, type, row, meta) {
                        return `${formatRupiah(val)}`;
                    }
                },
                {
                    data: 'harga',
                    render: function(val, type, row, meta) {
                        return `Rp. ${formatRupiah(val)}`;
                    }
                },
                {
                    data: 'kategori.nama',
                },
                {
                    data: 'id',
                    render: function(val, type, row, meta) {
                        var btnHapus = btnDatatableConfig('delete', {
                            'id': 'btnHapus',
                            'data-row': meta.row,
                        }, {
                            show: true
                        });
                        var btnEdit = `<a style="margin:1px" href="<?=base_url('Produk/ubah')?>/${row.id}" class="btn btn-xs btn-outline-warning waves-effect waves-light" data-container="body" data-toggle="tooltip" data-placement="top" data-original-title="Ubah" data-row="1"><i class="feather icon-edit"></i></a>`

                        return `${btnEdit} ${btnHapus}`;
                    }
                }
            ]
        });

    });
</script>
<?= $this->endSection(); ?>