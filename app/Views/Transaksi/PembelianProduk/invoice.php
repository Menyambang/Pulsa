<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="<?= base_url('assets/images/menyambang/logo_fix.png') ?>" type="image/x-icon">
    <link rel="shortcut icon" href="<?= base_url('assets/images/menyambang/logo_fix.png') ?>" type="image/x-icon">
    <title>Invoice</title>
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Rubik:400,400i,500,500i,700,700i&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets'); ?>/css/font-awesome.css">
    <!-- ico-font-->
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets'); ?>/css/vendors/icofont.css">
    <!-- Themify icon-->
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets'); ?>/css/vendors/themify.css">
    <!-- Flag icon-->
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets'); ?>/css/vendors/flag-icon.css">
    <!-- Feather icon-->
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets'); ?>/css/vendors/feather-icon.css">
    <!-- Plugins css start-->
    <!-- Plugins css Ends-->
    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets'); ?>/css/vendors/bootstrap.css">
    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets'); ?>/css/style.css">
    <link id="color" rel="stylesheet" href="<?= base_url('assets'); ?>/css/color-1.css" media="screen">
    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets'); ?>/css/responsive.css">

    <link rel="stylesheet" type="text/css" href="<?= base_url('assets'); ?>/css/vendors/sweetalert2.min.css">
    <script src="<?= base_url('assets'); ?>/js/sweet-alert/sweetalert2.all.min.js"></script>
</head>

<body>

    <div class="card-body">
        <div class="invoice">
            <div>
                <div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="media">
                                <div class="media-left"><img class="media-object img-60" src="<?= base_url('assets'); ?>/images/menyambang/logo_fix.png" alt=""></div>
                                <div class="media-body m-l-20 text-right">
                                    <h4 class="media-heading">Menyambang.id</h4>
                                    <p>Menyambang@gmail.com<br><span>+62812-5131-2000</span></p>
                                </div>
                            </div>
                            <!-- End Info-->
                        </div>
                        <div class="col-sm-6">
                            <div class="text-md-end text-xs-center">
                                <h3>Invoice #<span class="counter"><?= $data->pembayaran->orderId ?></span></h3>
                                <p>Issued: <?= $data->createdAt ?></span><br> Payment Due: <?= $data->pembayaran->time ?></p>
                            </div>
                            <!-- End Title-->
                        </div>
                    </div>
                </div>
                <hr>
                <!-- End InvoiceTop-->
                <div class="row">
                    <div class="col-md-4">
                        <div class="media">
                            <div class="media-left"><img class="media-object rounded-circle" style=" width: 60px !important; height: 60px !important; " src="<?= base_url('File/get/'.PATH_FOTO_USER.'/'.$data->user->foto) ?>" alt=""></div>
                            <div class="media-body m-l-20">
                                <h4 class="media-heading"><?= $data->user->nama ?></h4>
                                <p><?= $data->user->email ?><br><span><?= $data->user->noHp ?></span></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="text-md-end" id="project">
                            <h6>Alamat Pengiriman</h6>
                            <p>
                                <?= $data->alamat->kecamatanNama ?>, <?= $data->alamat->kotaTipe ?> <?= $data->alamat->kotaNama ?>, <?= $data->alamat->provinsiNama ?>
                                <br>
                                <?= $data->alamat->keterangan ?>
                            </p>
                        </div>
                    </div>
                </div>
                <!-- End Invoice Mid-->
                <div>
                    <div class="table-responsive invoice-table" id="table">
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <td class="item">
                                        <h6 class="p-2 mb-0">INFO PRODUK</h6>
                                    </td>
                                    <td class="Rate">
                                        <h6 class="p-2 mb-0">JUMLAH</h6>
                                    </td>
                                    <td class="subtotal">
                                        <h6 class="p-2 mb-0">HARGA SATUAN</h6>
                                    </td>
                                    <td class="subtotal">
                                        <h6 class="p-2 mb-0">TOTAL HARGA</h6>
                                    </td>
                                </tr>

                                <!-- PRODUK -->
                                <?php $totalHarga = []; ?>
                                <?php foreach ($detail as $produk) : ?>
                                    <?php $total = $produk->quantity * $produk->products->harga; ?>
                                    <?php ///$totalHarga[] = $total; ?>
                                    <tr>
                                        <td>
                                            <label><?= $produk->products->nama ?></label>
                                        </td>
                                        <td>
                                            <p class="text-center"><?= $produk->quantity ?></p>
                                        </td>
                                        <td>
                                            <p class="text-center">Rp. <?= number_format($produk->products->harga) ?></p>
                                        </td>
                                        <td>
                                            <p class="text-center">Rp. <?= number_format($total) ?></p>
                                        </td>
                                    </tr>
                                <?php endforeach ?>

                                <!-- TOTAL -->
                                <tr>
                                    <td></td>
                                    <td colspan="3">
                                        <!-- <div class="row mb-4">
                                            <div class="col-8">
                                                <b>TOTAL HARGA (<?=count($totalHarga)?> Barang)</b>
                                            </div>
                                            <div class="col-4">
                                                <b class="pull-right">Rp. <?= number_format(array_sum($totalHarga)) ?></b>
                                            </div>
                                        </div> -->
                                        <?php foreach ($data->detail as $detail) : ?>
                                            <?php $totalHarga[] = $detail->biaya; ?>

                                            <div class="row mb-2">
                                                <div class="col-8">
                                                    <b><?=$detail->keterangan?></b>
                                                </div>
                                                <div class="col-4">
                                                    <span class="pull-right">Rp. <?= number_format($detail->biaya) ?></span>
                                                </div>
                                            </div>
                                        <?php endforeach ?>
                                        <hr>
                                        <div class="row mb-4">
                                            <div class="col-8">
                                                <b>TOTAL BELANJA</b>
                                            </div>
                                            <div class="col-4">
                                                <b class="pull-right">Rp. <?= number_format(array_sum($totalHarga)) ?></b>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-8">
                                                <b>TOTAL TAGIHAN</b>
                                            </div>
                                            <div class="col-4">
                                                <b class="pull-right">Rp. <?= number_format(array_sum($totalHarga)) ?></b>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <!-- KURIR -->
                                <tr>
                                    <td>
                                        <label>Kurir</label>
                                        <p><?= $data->kurir->nama ?> - <?= $data->kurir->deskripsi ?></p>
                                    </td>
                                    <td colspan="3">
                                        <p>Metode pembayaran</p>
                                        <h6 class="mb-0"><?= PAYMENT_TYPE[$data->pembayaran->paymentType] ?? '' ?> <?= BANK_NAME[$data->pembayaran->bank] ?? '' ?></h6>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- End Table-->

                </div>
                <!-- End InvoiceBot-->
            </div>
            <div class="row">
                <div class="col-md-8">
                    <div>
                        <p class="legal">Invoice ini sah dan diproses olehh komputer</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="pull-right">
                        <p class="legal"><i>Terakhir diupdate : <?= date('Y-m-d H:i:s') ?></i></p>
                    </div>
                </div>
            </div>

            <!-- End Invoice-->
            <!-- End Invoice Holder-->
            <!-- Container-fluid Ends-->
        </div>
    </div>
</body>