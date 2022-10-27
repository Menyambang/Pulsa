<!-- Modal Tambah dan Edit -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
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
                        <label for="">Title</label>
                        <input type="text" name="title" id="title" class="form-control readonly-background" placeholder="Title">
                        <p class="text-danger" id="er_title"></p>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Show Home</label>
                        <?= form_dropdown('show', [
                            '1' => 'Ya',
                            '0' => 'Tidak'
                        ], '1', ['class' => 'form-control show select2', 'id' => 'show']); ?>
                        <p class="text-danger" id="er_show"></p>
                    </div>

                    <div class="form-group mb-3">
                        <label for="">Menu</label>
                        <?= form_dropdown('menu[]', $selectMenu, '', ['class' => 'form-control menu select2',  "multiple"=>"multiple", 'id' => 'menu']); ?>
                        <p class="text-danger" id="er_menu"></p>
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