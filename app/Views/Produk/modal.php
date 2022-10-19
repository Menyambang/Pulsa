<!-- Modal Tambah dan Edit -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Bulk Update Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form">
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <p>
                            Fitur ini digunakan untuk mengubah stok produk secara masal. Download template Excel dengan memasukan minimum stok yang ingin di ubah, lalu tekan download untuk mendownload template dengan stok yang kurang dari yang sudah di inputkan sebelumnya.
                        </p>
                        <label for="">Minimum Stok</label>
                        <div class="row">
                            <div class="col-md-7">
                                <input type="number" name="stok" id="stok" class="form-control readonly-background" placeholder="Minimun Stok">
                            </div>
                            <div class="col-5">
                                <button type="button" class="btn btn-sm grey btn-outline-primary btnDownloadTemplate" >Download Template</button>
                            </div>
                        </div>
                        <p class="text-danger" id="er_stok"></p>
                    </div>
                    <div class="form-group mb-2">
                        <label for="">Template Excel</label>
                        <input class="form-control" type="file" name="file" placeholder="file">
                        <p class="text-danger" id="er_file"></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm grey btn-outline-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-sm grey btn-primary" id="btnUpdate">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>