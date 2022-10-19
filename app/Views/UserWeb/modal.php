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
                        <label for="">Username</label>
                        <input type="text" name="username" id="username" class="form-control readonly-background" placeholder="Username">
                        <p class="text-danger" id="er_username"></p>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Nama</label>
                        <input type="text" name="nama" id="nama" class="form-control readonly-background" placeholder="Nama">
                        <p class="text-danger" id="er_nama"></p>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Role</label>
                        <?= form_dropdown('role', $role, '', ['class' => 'form-control role select2', 'id' => 'role']); ?>
                        <p class="text-danger" id="er_role"></p>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Password</label>
                        <input type="text" name="password" id="password" class="form-control readonly-background" placeholder="Password">
                        <p class="text-danger" id="er_password"></p>
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