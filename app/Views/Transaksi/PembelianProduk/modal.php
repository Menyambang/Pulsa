<!-- Modal Tambah dan Edit -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Data Pengiriman</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form">
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <div class="collection-filter-block">
                            <ul class="pro-services">
                                <li>
                                    <div class="media"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-truck">
                                            <rect x="1" y="3" width="15" height="13"></rect>
                                            <polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon>
                                            <circle cx="5.5" cy="18.5" r="2.5"></circle>
                                            <circle cx="18.5" cy="18.5" r="2.5"></circle>
                                        </svg>
                                        <div class="media-body">
                                            <h5>Informasi Pengiriman</h5>
                                            <p>
                                                <span class="kurir_layanan">Layanan Reguler (REG)</span> -
                                                <span class="kurir_nama">Jalur Eka Nugraha (JNE)</span>
                                                <span class="pull-right kurir_tipe">-</span>
                                            </p>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="media"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-credit-card"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>
                                    <div class="media-body">
                                        <h5>Alamat</h5>
                                        <p class="alamat_pembeli"></p>
                                    </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="media"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-gift"><polyline points="20 12 20 22 4 22 4 12"></polyline><rect x="2" y="7" width="20" height="5"></rect><line x1="12" y1="22" x2="12" y2="7"></line><path d="M12 7H7.5a2.5 2.5 0 0 1 0-5C11 2 12 7 12 7z"></path><path d="M12 7h4.5a2.5 2.5 0 0 0 0-5C13 2 12 7 12 7z"></path></svg>
                                    <div class="media-body">
                                        <h5>Catatan Untuk Kurir</h5>
                                        <p class="catatan_kurir"></p>
                                    </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="media"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-gift"><polyline points="20 12 20 22 4 22 4 12"></polyline><rect x="2" y="7" width="20" height="5"></rect><line x1="12" y1="22" x2="12" y2="7"></line><path d="M12 7H7.5a2.5 2.5 0 0 1 0-5C11 2 12 7 12 7z"></path><path d="M12 7h4.5a2.5 2.5 0 0 0 0-5C13 2 12 7 12 7z"></path></svg>
                                    <div class="media-body">
                                        <h5>Catatan Pembeli</h5>
                                        <p class="catatan_pembeli"></p>
                                    </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <p>
                            Masukkan no resi yang terdapat pada paket yang dikirimkan. Seletah memasukkan
                            no resi maka status pembelian akan berubah menjadi dikirimkan.
                        </p>
                        <label for="">No Resi</label>
                        <input type="text" name="noResi" id="noResi" class="form-control readonly-background" placeholder="Masukkan Nomor Resi Pengiriman">
                        <p class="text-danger" id="er_noResi"></p>
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

<!-- Modal Tambah dan Edit -->
<div class="modal fade" id="modal-detail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Pengiriman</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form">
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <div class="collection-filter-block">
                            <ul class="pro-services">
                                <li>
                                    <div class="media"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-truck">
                                            <rect x="1" y="3" width="15" height="13"></rect>
                                            <polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon>
                                            <circle cx="5.5" cy="18.5" r="2.5"></circle>
                                            <circle cx="18.5" cy="18.5" r="2.5"></circle>
                                        </svg>
                                        <div class="media-body">
                                            <h5>Informasi Pengiriman</h5>
                                            <p>
                                                <span class="kurir_layanan">Layanan Reguler (REG)</span> -
                                                <span class="kurir_nama">Jalur Eka Nugraha (JNE)</span>
                                                <span class="pull-right kurir_tipe">-</span>
                                            </p>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="media"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-credit-card"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>
                                    <div class="media-body">
                                        <h5>Alamat</h5>
                                        <p class="alamat_pembeli"></p>
                                    </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="media"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-gift"><polyline points="20 12 20 22 4 22 4 12"></polyline><rect x="2" y="7" width="20" height="5"></rect><line x1="12" y1="22" x2="12" y2="7"></line><path d="M12 7H7.5a2.5 2.5 0 0 1 0-5C11 2 12 7 12 7z"></path><path d="M12 7h4.5a2.5 2.5 0 0 0 0-5C13 2 12 7 12 7z"></path></svg>
                                    <div class="media-body">
                                        <h5>Catatan Untuk Kurir</h5>
                                        <p class="catatan_kurir"></p>
                                    </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="media"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-gift"><polyline points="20 12 20 22 4 22 4 12"></polyline><rect x="2" y="7" width="20" height="5"></rect><line x1="12" y1="22" x2="12" y2="7"></line><path d="M12 7H7.5a2.5 2.5 0 0 1 0-5C11 2 12 7 12 7z"></path><path d="M12 7h4.5a2.5 2.5 0 0 0 0-5C13 2 12 7 12 7z"></path></svg>
                                    <div class="media-body">
                                        <h5>Catatan Pembeli</h5>
                                        <p class="catatan_pembeli"></p>
                                    </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div id="keranjangDetail">

                    </div>

                    <div class="table-responsive invoice-table" id="orderDetail">
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <td class="item">
                                        <h6 class="p-2 mb-0">Keterangan</h6>
                                    </td>
                                    <td class="subtotal">
                                        <h6 class="p-2 mb-0">Sub-total</h6>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <p class="m-0">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                    </td>
                                    <td>
                                        <p class="itemtext">$375.00</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p class="m-0">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                    </td>
                                    <td>
                                        <p class="itemtext">$375.00</p>
                                    </td>
                                </tr>
                               
                                <tr>
                                    <td class="Rate">
                                        <h6 class="mb-0 p-2">Total</h6>
                                    </td>
                                    <td class="payment">
                                        <h6 class="mb-0 p-2">$3,644.25</h6>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
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

<!-- Modal Verifikasi -->
<div class="modal fade" id="modalVerifikasi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Verifikasi Pembayaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form">
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <p>
                            Fitur ini digunakan untuk memverifikasi pembayaran yang dilakukan oleh pelanggan menggunakan transfer ke nomor rekening.
                            Verifikasi jika pelanggan sudah mentransfer ke nomor rekening anda.
                            Setelah diverifikasi maka status pembayaran akan berubah menjadi <b><i>Settlement</i></b>
                        </p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm grey btn-primary" id="btnAksiVerifikasi">Verifikasi</button>
                </div>
            </form>
        </div>
    </div>
</div>