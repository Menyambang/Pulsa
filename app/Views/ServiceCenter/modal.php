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
                    <div class="row">
                        <div class="col-5">
                            <div class="form-group mb-3">
                                <label for="">Nama</label>
                                <input type="text" name="nama" id="nama" class="form-control readonly-background" placeholder="Nama">
                                <p class="text-danger" id="er_nama"></p>
                            </div>

                            <div class="form-group mb-3">
                                <label for="">Telegram</label>
                                <input type="text" name="telegram" id="telegram" class="form-control readonly-background" placeholder="Telegram">
                                <p class="text-danger" id="er_telegram"></p>
                            </div>
                            <div class="form-group mb-3">
                                <label for="">Whatsapp</label>
                                <input type="text" name="whatsapp" id="whatsapp" class="form-control readonly-background" placeholder="Whatsapp">
                                <p class="text-danger" id="er_whatsapp"></p>
                            </div>
                            <div class="form-group mb-3">
                                <label for="">No Hp</label>
                                <input type="text" name="noHp" id="noHp" class="form-control readonly-background" placeholder="No Hp">
                                <p class="text-danger" id="er_noHp"></p>
                            </div>

                            <div class="form-group mb-2">
                                <label for="">Foto</label>
                                <input class="form-control" type="file" name="foto" placeholder="foto">
                                <p class="text-danger" id="er_foto"></p>
                            </div>
                        </div>
                        <div class="col-7">
                          
                            <div class="form-group mb-3">
                                <label for="">Latitude</label>
                                <input type="text" name="latitude" id="latitude" readonly class="form-control readonly-background" placeholder="Latitude">
                                <p class="text-danger" id="er_latitude"></p>
                            </div>
                            <div class="form-group mb-3">
                                <label for="">Longitude</label>
                                <input type="text" name="longitude" id="longitude" readonly class="form-control readonly-background" placeholder="Longitude">
                                <p class="text-danger" id="er_longitude"></p>
                            </div>


                            <label class="control-label"><span class="text-danger">*</span> <b>Tarik pin pada map untuk mengubah titik lokasi</b></label><br>
                            <section id="gmap_geocoding">
                        </div>
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