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
                                <label for="">Kode</label>
                                <input type="text" name="kode" id="kode" class="form-control readonly-background" placeholder="Kode">
                                <p class="text-danger" id="er_kode"></p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group mb-3">
                                <label for="">Kode Suplier</label>
                                <input type="text" name="kodeSuplier" id="kodeSuplier" class="form-control readonly-background" placeholder="Kode Suplier">
                                <p class="text-danger" id="er_kodeSuplier"></p>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="">Nama</label>
                        <input type="text" name="nama" id="nama" class="form-control readonly-background" placeholder="Nama">
                        <p class="text-danger" id="er_nama"></p>
                    </div>

                    <div class="row">
                        <div class="col-4">
                            <div class="form-group mb-3">
                                <label for="">Harga</label>
                                <input type="text" name="harga" id="harga" class="form-control readonly-background" placeholder="Harga">
                                <p class="text-danger" id="er_harga"></p>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group mb-3">
                                <label for="">Saran Harga</label>
                                <input type="text" name="saranHarga" id="saranHarga" class="form-control readonly-background" placeholder="Saran Harga">
                                <p class="text-danger" id="er_saranHarga"></p>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group mb-3">
                                <label for="">Poin</label>
                                <input type="text" name="poin" id="poin" class="form-control readonly-background" placeholder="Poin">
                                <p class="text-danger" id="er_poin"></p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <div class="form-group mb-3">
                                <label for="">Jam Operasional Mulai</label>
                                <input type="time" name="jamOperasionalStart" id="jamOperasionalStart" class="form-control readonly-background" value="00:00" placeholder="Jam Operasional">
                                <p class="text-danger" id="er_jamOperasionalStart"></p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group mb-3">
                                <label for="">Jam Operasional Akhir</label>
                                <input type="time" name="jamOperasionalEnd" id="jamOperasionalEnd" class="form-control readonly-background" value="23:59" placeholder="Jam Operasional">
                                <p class="text-danger" id="er_jamOperasionalEnd"></p>
                            </div>
                        </div>
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
                                <label for="">Kategori</label>
                                <?= form_dropdown('kategoriId', $selectKategori, '', ['class' => 'form-control kategoriId select2', 'id' => 'kategoriId']); ?>
                                <p class="text-danger" id="er_kategoriId"></p>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="">Deskripsi</label>
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
                    <div class="">
                        <div class="form-group mb-3">
                            <label for="">Kategori</label>
                            <?= form_dropdown('kategoriSort', $selectKategori, '', ['class' => 'form-control kategoriSort select2', 'id' => 'kategoriSort']); ?>
                            <p class="text-danger" id="er_kategoriSort"></p>
                        </div>
                    </div>
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