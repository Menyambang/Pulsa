<?= $this->extend('Layouts/default'); ?>
<?= $this->section('content'); ?>
<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h3>Kategori</h3>
                </div>
                <div class="col-6">
                    <button class="btn btn-sm btn-primary pull-right" id="btnTambah" data-toggle="modal" data-target="#modal"><i class="fa fa-plus"></i> Tambah</button>
                    <button class="btn btn-sm btn-primary pull-right mr-1" id="btnUrutkan" data-toggle="modal" data-target="#modalUrutkan"><i class="fa fa-sort"></i> Urutkan</button>
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
                        <p class="card-text">Data Kategori.</p>
                        <div class="table-responsive">
                            <table class="display" id="datatable" width="100%">
                                <thead>
                                    <tr>
                                        <th width="1%">No</th>
                                        <th width="5%">Icon</th>
                                        <th width="20%">Menu</th>
                                        <th width="30%">Nama</th>
                                        <th width="20%">Prefix Operator</th>
                                        <th width="10%">Aksi</th>
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

    <?= $this->include('KategoriPulsa/modal'); ?>
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
<link rel="stylesheet" type="text/css" href="<?= base_url('assets'); ?>/vendors/nestable/nestable.min.css">
<link rel="stylesheet" type="text/css" href="<?= base_url('assets'); ?>/vendors/nestable/nestable.app.css">
<script src="<?= base_url('assets'); ?>/vendors/nestable/nestable.min.js"></script>
<script>
    var grid = null;
    var dataRow;
    $(document).ready(function() {
        $('.select2').select2();

        $('#btnTambah').click(function(e) {
            e.preventDefault();
            dataRow = null;
            $('#aksi').html('Tambah');
            $('input').val('');
            krajeeConfig('[name="icon"]', {
                type: 'image'
            });
        });

        $(document).on('click', '#btnEdit', function(e) {
            e.preventDefault();
            let row = $(this).data('row');
            dataRow = grid.row(row).data();
            $('#modal').modal('show');
            $('#aksi').html('Ubah');

            $('[name="nama"]').val(dataRow.nama);
            $('[name="prefix"]').val(dataRow.prefix);
            $('[name="menuId"]').val(dataRow.menuId).trigger('change');

            if (dataRow.icon != '') {
                krajeeConfig('[name="icon"]', {
                    url: `<?= base_url('File/get/icon_kategori') ?>/${dataRow.icon}`,
                    filename: dataRow.icon,
                    caption: `Icon Kategori`,
                    action: true,
                    type: 'image',
                });
            } else {
                krajeeConfig('[name="icon"]', {
                    type: 'image'
                });
            }
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
                        Swal.fire('Berhasil!', 'Data berhasil disimpan', 'success');
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
                    data: 'icon',
                    render: function(val, type, row, meta) {
                        let link = `<?= base_url('File') ?>/get/<?= PATH_ICON_KATEGORI_PULSA ?>/${val}`;
                        return `<a href="${link}" target="_BLANK"><img  width="60px" class="img-fluid img-thumbnail js-tilt" src="${link}"  ></a>`;
                    }
                },
                {
                    data: 'menu.nama',
                },
                {
                    data: 'nama',
                },
                {
                    data: 'prefix',
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
                        var btnEdit = btnDatatableConfig('update', {
                            'id': 'btnEdit',
                            'data-row': meta.row,
                        }, {
                            show: true
                        });

                        return `${btnEdit} ${btnHapus}`;
                    }
                }
            ]
        });

        $(document).on('click', '#btnUrutkan', function(e) {
            e.preventDefault();

            $('#dataKuesioner').html(`<div class="text-center">
                        <i class="fa fa-spin fa-spinner fa-4x"></i>
                        <h3 style="margin-top: 20px;">Memuat data ...</h3></div>`);

            $.ajax({
                type: "GET",
                url: `<?= current_url() ?>/findAll`,
                dataType: "JSON",
                success: function(res) {
                    var output = `<ol class='dd-list dd3-list' data-for="root">`;
                    $.each((res), function(_, item) {
                        output += buildItem(item);
                    });
                    output += `</ol>`;
                    $('#dataKuesioner').nestable();
                    $('#dataKuesioner').nestable('destroy');
                    $('#dataKuesioner').html(output);
                    $('#dataKuesioner').nestable({
                        maxDepth: 1,
                        handleClass: 'draggable',
                    });
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

        $(document).on('click', '#btnSimpanUrutan', function(e) {
            e.preventDefault();

            let data = $('#dataKuesioner').nestable('serialize');

            $.ajax({
                type: "POST",
                url: `<?= current_url() ?>/simpanUrutan`,
                dataType: "JSON",
                data: {
                    'data': data
                },
                success: function(res) {
                    Swal.fire('Sukses', res.message, res.status);
                    $('#modalUrutkan').modal('hide');
                },
                fail: function(xhr) {},
                beforeSend: function() {
                    $('#btnSimpanUrutan').attr('disabled', true).html('<i class="fa fa-spin fa-spinner"></i> Loading...');
                },
                complete: function(res) {
                    $('#btnSimpanUrutan').removeAttr('disabled').html('Simpan');
                }
            });
        });

        /**
         * Generate tampilan tree
         */
        function buildItem(item) {
            let content = '';
            let urutan = 0;

            content = buildContent(item);
            urutan = item.urutan;

            var html = `<li class='dd-item' data-id='${item.id}' data-urutan='${urutan}'>`;
            html += `<div class='dd-handle card mb-1'>${content}</div>`;

            if (item.children) {
                html += `<ol class='dd-list' data-id='${item.id}'>`;
                $.each(item.children, function(index, sub) {
                    html += buildItem(sub);
                });
                html += "</ol>";
            }

            html += "</li>";

            return html;
        }

        function buildContent(item) {
            let isDikti = item.isDikti == '1' ? `text-danger` : 'text-primary';

            return `<div class="p-1">
                    <div class="media-body">
                        <div class="pull-right">
                            <div class="draggable pull-right text-default">
                                <i class="feather icon-layers" data-toggle="tooltip" data-placement="left" title="Tarik untuk pindah posisi"></i> <span class="title"></span>
                            </div>
                        </div>
                        <div>
                            <small class="font-weight-bold"><span class="text-primary">${item.urutan}</span> ${item.prefix}</small> 
                        </div>
                        <div><b>${item.nama}</b></div>
                    </div>
                </div>`;
        }

    });
</script>
<?= $this->endSection(); ?>