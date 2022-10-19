<?= $this->extend('Layouts/default'); ?>
<?= $this->section('content'); ?>
<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h3>Service Center</h3>
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
                        <p class="card-text">Service Center.</p>
                        <div class="table-responsive">
                            <table class="display" id="datatable" width="100%">
                                <thead>
                                    <tr>
                                        <th width="1%">No</th>
                                        <th width="10%">Foto</th>
                                        <th width="20%">Nama</th>
                                        <th width="10%">Whatsapp</th>
                                        <th width="10%">No Hp</th>
                                        <th width="10%">Telegram</th>
                                        <th width="6%">Aksi</th>
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

    <?= $this->include('ServiceCenter/modal'); ?>
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
<script src="https://maps.google.com/maps/api/js?sensor=true&key=AIzaSyBWW6k0BFyLl7Q7pmCSH_9NFPnbkzr0InE"></script>
<script src="<?php echo base_url('assets') ?>/vendors/maps/gmaps.js"></script>
<script>
    var grid = null;
    var dataRow;
    $(document).ready(function() {

        renderMap();
        function renderMap() {
            var lat = $('[name="latitude"]').val() == '' ? -3.4407774 : parseFloat($('[name="latitude"]').val());
            var lng = $('[name="longitude"]').val() == '' ? 114.840804 : parseFloat($('[name="longitude"]').val());

            map = new google.maps.Map(document.getElementById('gmap_geocoding'), {
                zoom: 16,
                center: {
                    lat: lat,
                    lng: lng
                },
                mapTypeId: 'roadmap',
                gestureHandling: 'cooperative'
            });

            var location = new google.maps.LatLng(lat, lng);
            var marker = new google.maps.Marker({
                position: location,
                map: map,
                draggable: true,
                title: "Tarik lokasi ini untuk menentukan"
            });

            var circle = new google.maps.Circle({
                map: map,
                fillColor: '#5cb85c',
                strokeColor: '#5cb85c',
                strokeOpacity: 0.8,
                strokeWeight: 0,
            });

            circle.bindTo('center', marker, 'position');

            google.maps.event.addListener(marker, 'dragend', function() {
                $('[name="latitude"]').val(this.position.lat());
                $('[name="longitude"]').val(this.position.lng());
            });
        }

        $('#btnTambah').click(function(e) {
            dataRow = null;
            e.preventDefault();
            $('#aksi').html('Tambah');
            $('input').val('');
            $('textarea').html('');
            $('form').trigger('reset');
            krajeeConfig('[name="foto"]', {
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
            $('[name="whatsapp"]').val(dataRow.whatsapp);
            $('[name="telegram"]').val(dataRow.telegram);
            $('[name="noHp"]').val(dataRow.noHp);
            $('[name="latitude"]').val(dataRow.latitude);
            $('[name="longitude"]').val(dataRow.longitude);

            renderMap();

            if (dataRow.foto != '') {
                krajeeConfig('[name="foto"]', {
                    url: `<?= base_url('File/get/'.PATH_FOTO_SERVICE_CENTER) ?>/${dataRow.foto}`,
                    filename: dataRow.foto,
                    caption: `foto`,
                    action: true,
                    type: 'image',
                });
            } else {
                krajeeConfig('[name="foto"]', {
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
                    data: 'foto',
                    render: function(val, type, row, meta) {
                        let link = `<?= base_url('File') ?>/get/<?= PATH_FOTO_SERVICE_CENTER ?>/${val}`;
                        return `<a href="${link}" target="_BLANK"><img style="height: 100px" class="img-fluid img-thumbnail js-tilt" src="${link}"  ></a>`;
                    }
                },
                {
                    data: 'nama',
                },
                {
                    data: 'whatsapp',
                },
                {
                    data: 'noHp',
                },
                {
                    data: 'telegram',
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

    });
</script>
<?= $this->endSection(); ?>