<!-- Modal Tambah dan Edit -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><span id="aksi"></span> Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form">
                <div class="modal-body">
                    <!-- <div class="form-group mb-3">
                        <label for="">Url</label>
                        <input type="text" name="url" id="url" class="form-control readonly-background" placeholder="Url">
                        <p class="text-danger" id="er_url"></p>
                    </div> -->
                    <div class="form-group mb-2">
                        <label for="">Gambar</label>
                        <input class="form-control" type="file" name="gambar" placeholder="gambar">
                        <p class="text-danger" id="er_gambar"></p>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <div class="form-group mb-3">
                                <label for="">Jenis</label>
                                <?= form_dropdown('jenis', $selectJenis, '', ['class' => 'form-control jenis select2', 'id' => 'jenis']); ?>
                                <p class="text-danger" id="er_jenis"></p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group mb-3">
                                <label for="">Tipe</label>
                                <?= form_dropdown('type', $selectTipe, 'Horizontal', ['class' => 'form-control type select2', 'id' => 'type']); ?>
                                <p class="text-danger" id="er_type"></p>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Kategori</label>
                        <?= form_dropdown('kategoriId', [], '', ['class' => 'form-control kategoriId select2', 'id' => 'kategoriId']); ?>
                        <p class="text-danger" id="er_kategoriId"></p>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Produk</label>
                        <?= form_dropdown('produkId', [], '', ['class' => 'form-control produkId select2', 'id' => 'produkId']); ?>
                        <p class="text-danger" id="er_produkId"></p>
                    </div>

                    <div class="form-group mb-3">
                        <label for="">Artikel</label>
                        <textarea id="editor1" class="form-control" name="deskripsi" id="deskripsi" rows="5" cols="5" placeholder="Deskripsi"></textarea>
                        <p class="text-danger" id="er_deskripsi"></p>
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