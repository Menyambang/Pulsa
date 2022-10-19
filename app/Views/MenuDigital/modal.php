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
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group mb-3">
                                <label for="">Kelompok</label>
                                <input type="text" name="kelompok" id="kelompok" class="form-control readonly-background" placeholder="Kelompok">
                                <p class="text-danger" id="er_kelompok"></p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group mb-3">
                                <label for="">Jenis Menu</label>
                                <?= form_dropdown('jenisMenu', $selectJenisMenu, '', ['class' => 'form-control jenisMenu select2', 'id' => 'jenisMenu']); ?>
                                <p class="text-danger" id="er_jenisMenu"></p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <div class="form-group mb-3">
                                <label for="">Nama</label>
                                <input type="text" name="nama" id="nama" class="form-control readonly-background" placeholder="Nama">
                                <p class="text-danger" id="er_nama"></p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group mb-3">
                                <label for="">Kode Produk PPOB (PPOB Single Produk)</label>
                                <input type="text" name="kodeProdukPPOB" id="kodeProdukPPOB" class="form-control readonly-background" placeholder="Kode Produk PPOB (PPOB Single Produk)">
                                <p class="text-danger" id="er_kodeProdukPPOB"></p>
                            </div>

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <div class="form-group mb-3">
                                <label for="">Show Home</label>
                                <?= form_dropdown('showHome', ['NO', 'YES'], '1', ['class' => 'form-control showHome select2', 'id' => 'showHome']); ?>
                                <p class="text-danger" id="er_showHome"></p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group mb-3">
                                <label for="">Status</label>
                                <?= form_dropdown('enabled', ['DISABLED', 'ENABLED'], '1', ['class' => 'form-control enabled select2', 'id' => 'enabled']); ?>
                                <p class="text-danger" id="er_enabled"></p>
                            </div>
                        </div>
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