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
                        <label for="">Judul</label>
                        <input type="text" name="judul" id="judul" class="form-control readonly-background" placeholder="Judul">
                        <p class="text-danger" id="er_judul"></p>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Deskripsi</label>
                        <textarea class="form-control" name="deskripsi" id="deskripsi" rows="5" cols="5" placeholder="Deskripsi"></textarea>
                        <p class="text-danger" id="er_deskripsi"></p>
                    </div>
                    <div class="form-group mb-2">
                        <label for="">Gambar</label>
                        <input class="form-control" type="file" name="gambar" placeholder="gambar">
                        <p class="text-danger" id="er_gambar"></p>
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