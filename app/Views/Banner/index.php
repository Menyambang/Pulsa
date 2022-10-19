<?= $this->extend('Layouts/default'); ?>
<?= $this->section('content'); ?>
<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h3>Banner</h3>
                </div>
                <div class="col-6">
                    <button class="btn btn-sm btn-primary pull-right" id="btnTambah" data-toggle="modal" data-target="#modal"><i class="fa fa-plus"></i> Tambah</button>
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
                        <p class="card-text">Data Banner.</p>
                        <div class="table-responsive">
                            <table class="display" id="datatable" width="100%">
                                <thead>
                                    <tr>
                                        <th width="1%">No</th>
                                        <!-- <th width="80%">Deskripsi</th> -->
                                        <th width="10%">Gambar</th>
                                        <th width="10%">Jenis</th>
                                        <th width="10%">Tipe</th>
                                        <th width="5%">Aksi</th>
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

    <?= $this->include('Banner/modal'); ?>
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
<script src="<?= base_url('assets'); ?>/js/editor/ckeditor/ckeditor.js"></script>
<script src="<?= base_url('assets'); ?>/js/editor/ckeditor/adapters/jquery.js"></script>
<script src="<?= base_url('assets'); ?>/js/editor/ckeditor/styles.js"></script>
<!-- <script src="<?= base_url('assets'); ?>/js/editor/ckeditor/ckeditor.custom.js"></script> -->
<script>
    var grid = null;
    var dataRow;
    $('.select2').select2();

    CKEDITOR.replace('editor1', {
        toolbar: [{
                name: 'clipboard',
                items: ['Undo', 'Redo']
            },
            {
                name: 'styles',
                items: ['Styles', 'Format']
            },
            {
                name: 'basicstyles',
                items: ['Bold', 'Italic', 'Strike', '-', 'RemoveFormat']
            },
            {
                name: 'paragraph',
                items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote']
            },
            {
                name: 'links',
                items: ['Link', 'Unlink']
            },
            {
                name: 'insert',
                items: ['Image', 'EmbedSemantic', 'Table']
            },
            {
                name: 'tools',
                items: ['Maximize']
            },
            {
                name: 'editing',
                items: ['Scayt']
            }
        ],
        customConfig: '',
        removePlugins: 'image',
        height: 600,
        contentsCss: ['https://cdn.ckeditor.com/4.8.0/standard-all/contents.css'],
        bodyClass: 'article-editor',
        format_tags: 'p;h1;h2;h3;pre',
        removeDialogTabs: 'image:advanced;link:advanced',
        stylesSet: [{
                name: 'Marker',
                element: 'span',
                attributes: {
                    'class': 'marker'
                }
            },
            {
                name: 'Cited Work',
                element: 'cite'
            },
            {
                name: 'Inline Quotation',
                element: 'q'
            },
            {
                name: 'Special Container',
                element: 'div',
                styles: {
                    padding: '5px 10px',
                    background: '#eee',
                    border: '1px solid #ccc'
                }
            },
            {
                name: 'Compact table',
                element: 'table',
                attributes: {
                    cellpadding: '5',
                    cellspacing: '0',
                    border: '1',
                    bordercolor: '#ccc'
                },
                styles: {
                    'border-collapse': 'collapse'
                }
            },
            {
                name: 'Borderless Table',
                element: 'table',
                styles: {
                    'border-style': 'hidden',
                    'background-color': '#E6E6FA'
                }
            },
            {
                name: 'Square Bulleted List',
                element: 'ul',
                styles: {
                    'list-style-type': 'square'
                }
            },
            {
                name: 'Illustration',
                type: 'widget',
                widget: 'image',
                attributes: {
                    'class': 'image-illustration'
                }
            },
            {
                name: '240p',
                type: 'widget',
                widget: 'embedSemantic',
                attributes: {
                    'class': 'embed-240p'
                }
            },
            {
                name: '360p',
                type: 'widget',
                widget: 'embedSemantic',
                attributes: {
                    'class': 'embed-360p'
                }
            },
            {
                name: '480p',
                type: 'widget',
                widget: 'embedSemantic',
                attributes: {
                    'class': 'embed-480p'
                }
            },
            {
                name: '720p',
                type: 'widget',
                widget: 'embedSemantic',
                attributes: {
                    'class': 'embed-720p'
                }
            },
            {
                name: '1080p',
                type: 'widget',
                widget: 'embedSemantic',
                attributes: {
                    'class': 'embed-1080p'
                }
            }
        ]
    });
    var editor = CKEDITOR.instances['editor1'];

    $(document).ready(function() {

        $('#btnTambah').click(function(e) {
            e.preventDefault();
            dataRow = null;
            $('#aksi').html('Tambah');
            $('input').val('');
            editor.setData('');
            $('textarea').html('');
            krajeeConfig('[name="gambar"]', {
                type: 'image'
            });
            $('[name="jenis"]').val('Artikel').trigger('change');
            $('[name="produkId"],[name="kategoriId"]').html('').trigger('change');
        });

        $(document).on('change', '[name="jenis"]', function(e) {
            let value = $(this).val();

            $('[name="produkId"]').parents('.form-group').hide();
            $('[name="kategoriId"]').parents('.form-group').hide();
            $('[name="deskripsi"]').parents('.form-group').hide();

            if (value == 'Produk') {
                $('[name="produkId"]').parents('.form-group').show();
            } else if (value == 'Kategori') {
                $('[name="kategoriId"]').parents('.form-group').show();
            } else {
                $('[name="deskripsi"]').parents('.form-group').show();
            }
        });

        $(document).on('click', '#btnEdit', function(e) {
            e.preventDefault();
            let row = $(this).data('row');
            dataRow = grid.row(row).data();
            $('#modal').modal('show');
            $('#aksi').html('Ubah');

            $('[name="deskripsi"]').text(dataRow.deskripsi);
            $('[name="url"]').val(dataRow.url);
            $('[name="jenis"]').val(dataRow.jenis).trigger('change');
            $('[name="type"]').val(dataRow.type).trigger('change');
            $('[name="kategoriId"]').val(dataRow.kategoriId).trigger('change');
            $('[name="produkId"]').val(dataRow.produkId).trigger('change');

            if(dataRow.produkId){
                var newOption = new Option(dataRow.produk.nama, dataRow.produk.id, false, false);
                $('[name="produkId"]').append(newOption).trigger('change');
            }
            
            if(dataRow.kategoriId){
                var newOption = new Option(dataRow.kategori.nama, dataRow.kategori.id, false, false);
                $('[name="kategoriId"]').append(newOption).trigger('change');
            }

            editor.setData(dataRow.deskripsi);

            if (dataRow.gambar != '') {
                krajeeConfig('[name="gambar"]', {
                    url: `<?= base_url('File/get/' . PATH_BANNER) ?>/${dataRow.gambar}`,
                    filename: dataRow.gambar,
                    caption: `gambar`,
                    action: true,
                    type: 'image',
                });
            } else {
                krajeeConfig('[name="gambar"]', {
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

            var deskripsi = editor.getData();
            $('[name="deskripsi"]').text(deskripsi);
            $('[name="deskripsi"]').val(deskripsi);

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
            columnDefs: [{
                targets: [0, 2, 3],
                className: "dt-top"
            }, ],
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
                // {
                //     data: 'deskripsi',
                // },
                {
                    data: 'gambar',
                    render: function(val, type, row, meta) {
                        let link = `<?= base_url('File') ?>/get/<?= PATH_BANNER ?>/${val}`;
                        return `<a href="${link}" target="_BLANK"><img style="height: 100px" class="img-fluid img-thumbnail js-tilt" src="${link}"  ></a>`;
                    }
                },
                {
                    data: 'jenis',
                }, {
                    data: 'type',
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

        // Produk
        $('[name="produkId"]').select2({
            ajax: {
                url: "<?= base_url('produk/show') ?>",
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        'nama[like]': params.term, // search term
                        page: params.page
                    };
                },
                processResults: function(data, params) {
                    params.page = params.page || 1;

                    return {
                        results: data.rows,
                        pagination: {
                            more: (params.page * 30) < data.total_count
                        }
                    };
                },
                cache: true
            },
            placeholder: 'Cari Produk',
            minimumInputLength: 1,
            templateResult: formatProdukId,
            templateSelection: formatProdukIdSelection
        });


        function formatProdukId(repo) {
            return repo.nama || repo.text;
        }

        function formatProdukIdSelection(repo) {
            return repo.nama || repo.text;
        }

        // KATEGORI
        $('[name="kategoriId"]').select2({
            ajax: {
                url: "<?= base_url('kategori/show') ?>",
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        'nama[like]': params.term, // search term
                        page: params.page
                    };
                },
                processResults: function(data, params) {
                    params.page = params.page || 1;

                    return {
                        results: data.rows,
                        pagination: {
                            more: (params.page * 30) < data.total_count
                        }
                    };
                },
                cache: true
            },
            placeholder: 'Cari Kaegori',
            minimumInputLength: 1,
            templateResult: formatKategoriId,
            templateSelection: formatKategoriIdSelection
        });


        function formatKategoriId(repo) {
            return repo.nama || repo.text;
        }

        function formatKategoriIdSelection(repo) {
            return repo.nama || repo.text;
        }

    });
</script>
<?= $this->endSection(); ?>