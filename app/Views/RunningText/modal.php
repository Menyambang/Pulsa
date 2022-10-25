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
                        <label for="">Pesan</label>
                        <input type="text" name="pesan" id="pesan" class="form-control readonly-background" placeholder="Pesan">
                        <p class="text-danger" id="er_pesan"></p>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Status</label>
                        <?= form_dropdown('status', [
                            '1' => 'Aktif',
                            '0' => 'Non Aktif'
                        ], '1', ['class' => 'form-control status select2', 'id' => 'status']); ?>
                        <p class="text-danger" id="er_status"></p>
                    </div>
                    <div class="form-group mb-2">
                        <label for="">Masa Aktif</label>
                        <input class="form-control" type="date" name="expired" placeholder="expired">
                        <p class="text-danger" id="er_expired"></p>
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