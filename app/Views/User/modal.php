<!-- Modal Keranjang -->
<div class="modal fade" id="modal-keranjang" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Keranjang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <div class="collection-filter-block">
                            <ul class="pro-services">
                                <li>
                                    <div class="media"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-credit-card">
                                            <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                                            <line x1="1" y1="10" x2="23" y2="10"></line>
                                        </svg>
                                        <div class="media-body">
                                            <h5>Alamat</h5>
                                            <p class="alamat_pembeli"></p>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="media"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-gift">
                                            <polyline points="20 12 20 22 4 22 4 12"></polyline>
                                            <rect x="2" y="7" width="20" height="5"></rect>
                                            <line x1="12" y1="22" x2="12" y2="7"></line>
                                            <path d="M12 7H7.5a2.5 2.5 0 0 1 0-5C11 2 12 7 12 7z"></path>
                                            <path d="M12 7h4.5a2.5 2.5 0 0 0 0-5C13 2 12 7 12 7z"></path>
                                        </svg>
                                        <div class="media-body">
                                            <h5>Catatan Untuk Kurir</h5>
                                            <p class="catatan_kurir"></p>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div id="keranjangDetail">

                    </div>
                </div>
                <!-- <div class="modal-footer">
                    <button type="button" class="btn btn-sm grey btn-outline-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-sm grey btn-primary" id="btnSimpan">Simpan</button>
                </div> -->
            </form>
        </div>
    </div>
</div>

<!-- Modal Tambah dan Edit -->
<div class="modal fade" id="modal-edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Biodata</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form">
                <div class="modal-body">

                    <div class="collection-filter-block">
                        <ul class="pro-services">
                            <li>
                                <div class="media"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-credit-card">
                                        <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                                        <line x1="1" y1="10" x2="23" y2="10"></line>
                                    </svg>
                                    <div class="media-body">
                                        <h5>Email</h5>
                                        <p class="email">-</p>
                                    </div>
                                </div>
                            </li>

                        </ul>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Nama</label>
                        <input type="text" name="nama" id="nama" class="form-control readonly-background" placeholder="Nama">
                        <p class="text-danger" id="er_nama"></p>
                    </div>
                    <div class="row">
                        <div class="form-group mb-3 col-md-6">
                            <label for="">No Hp</label>
                            <input type="text" name="noHp" id="noHp" class="form-control readonly-background" placeholder="No Hp">
                            <p class="text-danger" id="er_noHp"></p>
                        </div>
                        <div class="form-group mb-3 col-md-6">
                            <label for="">No Wa</label>
                            <input type="text" name="noWa" id="noWa" class="form-control readonly-background" placeholder="No Wa">
                            <p class="text-danger" id="er_noWa"></p>
                        </div>
                    </div>

                    <br>
                    <h5>Alamat</h5>
                    <p>Berisikan alamat user saat melakukan registrasi</p>
                    <div class="form-group mb-3">
                        <label for="">Nama Alamat</label>
                        <input type="text" name="alamatNama" id="alamatNama" class="form-control readonly-background" placeholder="Nama Alamat">
                        <p class="text-danger" id="er_alamatNama"></p>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Jalan</label>
                        <input type="text" name="jalan" id="jalan" class="form-control readonly-background" placeholder="Jalan">
                        <p class="text-danger" id="er_jalan"></p>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Provinsi</label>
                        <?= form_dropdown('provinsiId', $provinsi, '', ['class' => 'form-control provinsiId select2', 'id' => 'provinsiId']); ?>
                        <p class="text-danger" id="er_provinsiId"></p>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Kabupaten / Kota <span id="kotaIdLoading"></span></label>
                        <?= form_dropdown('kotaId', [], '', ['class' => 'form-control kotaId select2', 'id' => 'kotaId']); ?>
                        <p class="text-danger" id="er_kotaId"></p>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Kecamatan <span id="kecamatanIdLoading"></span></label>
                        <?= form_dropdown('kecamatanId', [], '', ['class' => 'form-control kecamatanId select2', 'id' => 'kecamatanId']); ?>
                        <p class="text-danger" id="er_kecamatanId"></p>
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