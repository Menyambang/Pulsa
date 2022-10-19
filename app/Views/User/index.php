<?= $this->extend('Layouts/default'); ?>
<?= $this->section('content'); ?>
<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h3>User Terdaftar</h3>
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
                        <p class="card-text">Data User.</p>
                        <div class="table-responsive">
                            <table class="display" id="datatable">
                                <thead>
                                    <tr>
                                        <th width="1%">No</th>
                                        <th width="20%">Email</th>
                                        <th width="20%">Nama</th>
                                        <th width="20%">Saldo</th>
                                        <th width="20%">Status</th>
                                        <th width="12%">Aksi</th>
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

    <?= $this->include('User/modal'); ?>
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

        $('.select2').select2().trigger('change');

        $(document).on('click', '#btnKeranjang', function(e) {
            e.preventDefault();
            let row = $(this).data('row');
            dataRow = grid.row(row).data();
            loadKeranjangDetail(dataRow.email);
            $('.catatan_kurir').html(`${dataRow.alamat.keterangan}`);
            $('.alamat_pembeli').html(`${dataRow.alamat.jalan}, ${dataRow.alamat.kecamatanNama}, ${dataRow.alamat.kotaTipe} ${dataRow.alamat.kotaNama}, ${dataRow.alamat.provinsiNama}`);

            $('#modal-keranjang').modal('show');
            $('#aksi').html('Detail Keranjang');
        });

        var kotaId, kecamatanId;
        $(document).on('click', '#btnEdit', function(e) {
            e.preventDefault();
            let row = $(this).data('row');
            dataRow = grid.row(row).data();
            $('#modal-edit').modal('show');
            $('#aksi').html('Ubah');
            
            $('.email').html(dataRow.email);
            $('[name="nama"]').val(dataRow.nama);
            $('[name="noHp"]').val(dataRow.noHp);
            $('[name="noWa"]').val(dataRow.noWa);

            kotaId = dataRow.alamat.kotaId;
            kecamatanId = dataRow.alamat.kecamatanId;
            $('[name="alamatNama"]').val(dataRow.alamat.nama);
            $('[name="jalan"]').val(dataRow.alamat.jalan);
            $('[name="provinsiId"]').val(dataRow.alamat.provinsiId).trigger('change');
        });

        $(document).on('change', '[name="provinsiId"]', function(){
            let value = $(this).val();
            console.log('PROVINSI ID', value);
            selectKota(value, kotaId);
            select2config('kecamatanId', 'Kecamatan', '');
        });

        $(document).on('change', '[name="kotaId"]', function(){
            let value = $(this).val();
            console.log('KOTA ID', value);
            if(value){
                selectKecamatan(value, kecamatanId);
            }else{
                select2config('kecamatanId', 'Kecamatan', ' ');
            }
        });

        function selectKota(provinsiId, selectedId){
            $.ajax({
                type: "GET",
                url: `<?= current_url() ?>/selectKota/`+provinsiId,
                dataType: "JSON",
                success: function(res) {
                    let text = '';
                    res.forEach(e => {
                        text += `<option value="${e.city_id}">${e.city_name}</option>`
                    });
                    select2config('kotaId', 'Kota', text);
                    $('[name="kotaId"]').val(selectedId).trigger('change');
                },
                beforeSend: function() {
                    select2config('kotaId', 'Kota', '');
                    $('#kotaIdLoading').html('<i class="fa fa-spin fa-spinner"></i>');
                },
                complete: function(res) {
                    $('#kotaIdLoading').html('');
                }
            });
        }

        function selectKecamatan(kotaId, idSelected){
            $.ajax({
                type: "GET",
                url: `<?= current_url() ?>/selectKecamatan/`+kotaId,
                dataType: "JSON",
                success: function(res) {
                    let text = '';
                    res.forEach(e => {
                        text += `<option value="${e.subdistrict_id}">${e.subdistrict_name}</option>`
                    });
                    select2config('kecamatanId', 'Kecamatan', text);
                    $('[name="kecamatanId"]').val(idSelected).trigger('change');
                },
                beforeSend: function() {
                    select2config('kecamatanId', 'Kecamatan', '');
                    $('#kecamatanIdLoading').html('<i class="fa fa-spin fa-spinner"></i>');
                },
                complete: function(res) {
                    $('#kecamatanIdLoading').html('');
                }
            });
        }

        $('#form').submit(function(e) {
            e.preventDefault();

            var data = new FormData(this);
            data.append('email', dataRow ? dataRow.email : '');

            $.ajax({
                type: "POST",
                url: `<?= current_url() ?>/simpan/email`,
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
                    } if(res.code == 403){
                        Swal.fire('Error', res.message, 'error');
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

        function loadKeranjangDetail(id){
            $.ajax({
                type: "POST",
                url: `<?= current_url() ?>/keranjangDetail/`+id,
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

        function templateKeranjangDetail(dataDetail){
            let text = '';
            
            dataDetail.forEach(element => {
                let hargaNormal = element.products.harga;
                let hargaDiskon = element.products.harga;
                let diskonText = '';
    
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
                              <a class="btn btn-success btn-xs" href="#" data-bs-original-title="" title="">Diskon ${element.products.diskon}%</a>
                            </div>
                          </div>
                        </div>`;
            });

            return `${text}`;
        }

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
                    data: 'email',
                    render: function(val, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: 'email',
                },
                {
                    data: 'nama',
                },
                {
                    data: 'saldo',
                    render: function(val, type, row, meta) {
                        if(val == null) return '-';
                        return `Rp. ${formatRupiah(val)}`;
                    }
                },
                {
                    data: 'isActive',
                    render: function(val, type, row, meta) {
                        if(val == '1') return `<span class="badge badge-success text-light">Aktif</span>`;
                        else return `<span class="badge badge-warning text-light">Belum Aktif</span>`;
                    }
                },
                {
                    data: 'username',
                    render: function(val, type, row, meta) {
                        var btnDetail = btnDatatableConfig('detail', {
                            'id': 'btnDetail',
                            'data-row': meta.row,
                        }, {
                            show: true
                        });

                        var btnKeranjang = btnDatatableConfig('custom', {
                            'id': 'btnKeranjang',
                            'data-row': meta.row,
                        }, {
                            'textBtn': 'Keranjang',
                            'iconBtn': 'icon-shopping-cart-full',
                            show: true
                        });

                        var btnEdit = btnDatatableConfig('custom', {
                            'id': 'btnEdit',
                            'data-row': meta.row,
                        }, {
                            'textBtn': 'Update',
                            'iconBtn': 'icon-pencil-alt',
                            show: true
                        });

                        return `${btnKeranjang} ${btnEdit}`;
                    }
                }
            ]
        });

    });
</script>
<?= $this->endSection(); ?>