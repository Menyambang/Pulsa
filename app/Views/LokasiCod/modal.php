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
                        <label for="">Nama</label>
                        <input type="text" name="nama" id="nama" class="form-control readonly-background" placeholder="Nama">
                        <p class="text-danger" id="er_nama"></p>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Latitude</label>
                        <input type="text" name="latitude" id="latitude" class="form-control readonly-background" placeholder="Latitude">
                        <p class="text-danger" id="er_latitude"></p>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Longitude</label>
                        <input type="text" name="longitude" id="longitude" class="form-control readonly-background" placeholder="Longitude">
                        <p class="text-danger" id="er_longitude"></p>
                    </div>
                    <label class="control-label"><span class="text-danger">*</span> <b>Tarik pin pada map untuk mengubah titik lokasi</b></label><br>
                    <section id="gmap_geocoding">
                    </section>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm grey btn-outline-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-sm grey btn-primary" id="btnSimpan">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Pengaturan -->
<div class="modal fade" id="modalPengaturan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Pengaturan COD</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form">
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="">Radius</label>
                        <p><i>Luas wilayah jangkauan COD, semakin luas radius maka jangkauan COD juga semakin luas</i></p>
                        <div class="input-group mb-3">
                            <input type="text" name="radius" id="radius" class="form-control readonly-background" placeholder="radius">
                            <span class="input-group-text">Meter</span>
                            <p class="text-danger" id="er_radius"></p>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Biaya per meter</label>
                        <p><i>Tarif biaya pengiriman COD, semakin jauh jarak pengiriman maka semakin mahal juga pengiriman. Biaya pengiriman bisa dihitung dengan <code>jarak * biaya</code></i></p>
                        <div class="input-group mb-3">
                            <input type="text" name="biaya" id="biaya" class="form-control readonly-background" placeholder="biaya">
                            <span class="input-group-text">Rupiah</span>
                            <p class="text-danger" id="er_biaya"></p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm grey btn-outline-secondary" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-sm grey btn-primary" id="btnSimpanPengaturan">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>