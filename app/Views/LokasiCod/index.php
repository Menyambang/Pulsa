<?= $this->extend('Layouts/default'); ?>
<?= $this->section('content'); ?>
<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h3>Lokasi COD</h3>
                </div>
                <div class="col-6">
                    <button class="btn btn-sm btn-primary pull-right ml-2" id="btnPengaturan" data-toggle="modal" data-target="#modalPengaturan"><i class="fa fa-cogs"></i> Pengaturan</button>
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
                        <p class="card-text">Data Lokasi COD.</p>

                        <div class="table-responsive">
                            <table class="display" id="datatable" width="100%">
                                <thead>
                                    <tr>
                                        <th width="1%">No</th>
                                        <th>Nama</th>
                                        <th width="8%">Aksi</th>
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

        <div class="card">

            <div class="card-body">
                <div class="row">
                    <div class="col-8">
                        <h4 class="card-text">Titik Lokasi</h4>
                    </div>
                    <!-- <div class="col-4">
                        <div class="input-group mb-3"><span class="input-group-text">Radius</span>
                            <input class="form-control" name="radius" type="text"><span class="input-group-text"> Meter </i></span>
                            <button class="btn btn-sm btn-primary pull-right ml-2" id="btnSimpanRadius"><i class="fa fa-save"></i> Simpan</button>
                        </div>
                    </div> -->
                </div>
                <p>Menampilkan titik lokasi COD yang tersedia</p>
                <section id="gmap_geocoding_card"></section>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->

    <?= $this->include('LokasiCod/modal'); ?>
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

        var lat = -3.4407774;
        var lng = 114.840804;
        var radius = <?= $radius ?? 0 ?>;
        $('[name="radius"]').val(radius);
        $('[name="biaya"]').val(<?= $biaya ?? 0 ?>);

        renderMap();

        function renderMap() {
            lat = $('[name="latitude"]').val() == '' ? lat : parseFloat($('[name="latitude"]').val());
            lng = $('[name="longitude"]').val() == '' ? lng : parseFloat($('[name="longitude"]').val());

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
                radius: radius, // 10 miles in metres
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

        renderMapCard();

        var maps;
        var marker = [];

        function renderMapCard(data = []) {
            var lat = -3.4407774;
            var lng = 114.840804;
            if (data.length) {
                lat = parseFloat(data[0].latitude);
                lng = parseFloat(data[0].longitude);
            }

            maps = new google.maps.Map(document.getElementById('gmap_geocoding_card'), {
                zoom: 16,
                center: {
                    lat: lat,
                    lng: lng
                },
                mapTypeId: 'roadmap',
                gestureHandling: 'cooperative'
            });
            // Long, Lat https://gmapgis.com/

            $.each(data, function(indexInArray, val) {
                var icon = `https://maps.google.com/mapfiles/ms/icons/red-dot.png`

                marker[val.id] = new google.maps.Marker({
                    position: {
                        lat: parseFloat(val.latitude),
                        lng: parseFloat(val.longitude),
                    },
                    animation: google.maps.Animation.DROP,
                    icon: icon,
                    map: maps,
                    title: val.nama,
                });


                marker[val.id].addListener('click', function() {
                    getContent(val, marker[val.id])
                });

                var circle = new google.maps.Circle({
                    map: maps,
                    radius: radius, // 10 miles in metres
                    fillColor: '#5cb85c',
                    strokeColor: '#5cb85c',
                    strokeOpacity: 0.8,
                    strokeWeight: 0,
                });

                circle.bindTo('center', marker[val.id], 'position');

                google.maps.event.addListener(marker[val.id], 'click', function() {
                    map.panTo(marker[val.id].getPosition());
                });
            });
        }

        function getContent(val, marker) {
            google.maps.event.trigger(map, 'click');

            function titleTemplate(title, value) {
                if (value == null) return '-';
                return `<tr>
                          <td style="text-align: end"><b>${value}</b></td>
                      </tr>`;
            }

            var contentString = `<div class="thumbnail">
                                <div class="caption">
                                    <table width="100%">
                                        ${titleTemplate('Nama', val.nama)}
                                    </table>
                                </div>
                              </div>`;


            var infowindow = new google.maps.InfoWindow({
                content: contentString
            });

            infowindow.open(map, marker);

            closeInfoWindow = function() {
                infowindow.close();
            };
            google.maps.event.addListener(map, 'click', closeInfoWindow);
        }

        $('#btnTambah').click(function(e) {
            e.preventDefault();
            dataRow = null;
            $('#aksi').html('Tambah');
            $('input[name="nama"]').val('');
            $('input[name="latitude"]').val('');
            $('input[name="longitude"]').val('');
            $('textarea').html('');
        });

        $(document).on('click', '#btnEdit', function(e) {
            e.preventDefault();
            let row = $(this).data('row');
            dataRow = grid.row(row).data();
            $('#modal').modal('show');
            $('#aksi').html('Ubah');

            $('[name="nama"]').val(dataRow.nama);
            $('[name="latitude"]').val(dataRow.latitude);
            $('[name="longitude"]').val(dataRow.longitude);

            renderMap();
        });

        $(document).on('keyup', '[name="latitude"],[name="longitude"]', function(e) {
            e.preventDefault();
            renderMap();
        });

        $(document).on('click', '#btnSimpanPengaturan', function(e) {
            e.preventDefault();

            let btn = $(e.currentTarget);
            $.ajax({
                type: "POST",
                url: `<?= current_url() ?>/savePengaturan`,
                data: {
                    radius: $('[name="radius"]').val(),
                    biaya: $('[name="biaya"]').val()
                },
                dataType: "JSON",
                success: function(res) {
                    if (res.code == 200) {
                        radius = parseInt($('[name="radius"]').val());
                        renderMap();
                        grid.draw(false);
                        $('.modal').modal('hide');
                        $('.text-danger').html('');
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
                    btn.attr('disabled', true).html('<i class="fa fa-spin fa-spinner"></i> Simpan');
                },
                complete: function(res) {
                    btn.removeAttr('disabled').html('<i class="feather save"></i> Simpan');
                }
            });
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
                },
                dataSrc: function(json) {
                    renderMapCard(json.data);
                    return json.data;
                },
            },
            draw: function(data) {
                console.log(data)
            },
            columns: [{
                    data: 'id',
                    render: function(val, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: 'nama',
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