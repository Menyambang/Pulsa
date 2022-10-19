<!-- Modal Tambah dan Edit -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><span id="aksi"></span> Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form">
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="">Menu Digital</label>
                        <?= form_dropdown('menuId', $selectMenu, '', ['class' => 'form-control menuId select2', 'id' => 'menuId']); ?>
                        <p class="text-danger" id="er_menuId"></p>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Nama</label>
                        <input type="text" name="nama" id="nama" class="form-control readonly-background" placeholder="Nama">
                        <p class="text-danger" id="er_nama"></p>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Prefix Operator</label>
                        <input type="text" name="prefix" id="prefix" class="form-control readonly-background" placeholder="0812,0822">
                        <p class="text-danger" id="er_prefix"></p>
                    </div>
                    <div class="form-group mb-2">
                        <label for="">Icon</label>
                        <input class="form-control" type="file" name="icon" placeholder="icon">
                        <p class="text-danger" id="er_icon"></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm grey btn-outline-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-sm grey btn-primary" id="btnSimpan">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Urutkan -->
<div class="modal fade" id="modalUrutkan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><span id="aksi"></span> Urutkan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form">
                <div class="modal-body">
                    <div class="dd" id="dataKuesioner">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm grey btn-outline-secondary" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-sm grey btn-primary" id="btnSimpanUrutan">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>