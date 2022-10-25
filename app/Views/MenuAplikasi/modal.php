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
                        <label for="">Jenis Menu</label>
                        <?= form_dropdown('jenis', $jenisMenu, '', ['class' => 'form-control jenis select2', 'id' => 'jenis']); ?>
                        <p class="text-danger" id="er_jenis"></p>
                    </div>

                    <div class="form-group mb-3">
                        <label for="">Show Home</label>
                        <?= form_dropdown('showHome', [
                            '1' => 'Ya',
                            '0' => 'Tidak'
                        ], '1', ['class' => 'form-control showHome select2', 'id' => 'showHome']); ?>
                        <p class="text-danger" id="er_showHome"></p>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Label</label>
                        <input type="text" name="label" id="label" class="form-control readonly-background" placeholder="Label">
                        <p class="text-danger" id="er_label"></p>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">ID Operator</label>
                        <input type="text" name="idOperator" id="idOperator" class="form-control readonly-background" placeholder="214,213,148,212,311,338,33">
                        <p class="text-danger" id="er_idOperator"></p>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Kode Produk</label>
                        <input type="text" name="kodeProdukPPOB" id="kodeProdukPPOB" class="form-control readonly-background" placeholder="(PPOB Single Produk)">
                        <p class="text-danger" id="er_kodeProdukPPOB"></p>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Target URL</label>
                        <input type="text" name="targetUrlWeb" id="targetUrlWeb" class="form-control readonly-background" placeholder="Untuk WebView Mobile">
                        <p class="text-danger" id="er_targetUrlWeb"></p>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Deskripsi</label>
                        <textarea name="deskripsi" id="deskripsi" class="form-control readonly-background" placeholder="Deskripsi (Opsional)"></textarea>
                        <p class="text-danger" id="er_deskripsi"></p>
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