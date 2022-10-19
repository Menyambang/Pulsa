<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="pixelstrap">
    <link rel="icon" href="<?= base_url('assets/images/menyambang/logo_fix.png') ?>" type="image/x-icon">
    <link rel="shortcut icon" href="<?= base_url('assets/images/menyambang/logo_fix.png') ?>" type="image/x-icon">
    <title>Menyambang.id</title>
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Rubik:400,400i,500,500i,700,700i&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets'); ?>/css/font-awesome.css">

    <!-- BEGIN : Page CSS -->
    <?= $this->renderSection('css'); ?>
    <!-- END : Page CSS -->

    <!-- ico-font-->
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets'); ?>/css/vendors/icofont.css">
    <!-- Themify icon-->
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets'); ?>/css/vendors/themify.css">
    <!-- Flag icon-->
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets'); ?>/css/vendors/flag-icon.css">
    <!-- Feather icon-->
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets'); ?>/css/vendors/feather-icon.css">
    <!-- Plugins css start-->
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets'); ?>/css/vendors/scrollbar.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets'); ?>/css/vendors/datatables.css">
    <!-- Plugins css Ends-->
    <!-- Bootstrap css-->
    <!-- <link rel="stylesheet" type="text/css" href="<?= base_url('assets'); ?>/css/vendors/bootstrap.css"> -->
    <link rel="stylesheet" href="<?= base_url('assets'); ?>/vendors/bootstrap/css/bootstrap.css">
    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets'); ?>/css/style.css">
    <link id="color" rel="stylesheet" href="<?= base_url('assets'); ?>/css/color-1.css" media="screen">
    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets'); ?>/css/responsive.css">

    <link rel="stylesheet" type="text/css" href="<?= base_url('assets'); ?>/custom/vendors.css">

    <!-- BEGIN : PAGE CSS -->
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets'); ?>/css/vendors/owlcarousel.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets'); ?>/css/vendors/sweetalert2.min.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets'); ?>/css/vendors/select2.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets'); ?>/vendors/flatpickr/flatpickr.min.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets'); ?>/css/vendors/date-picker.css">
    <link rel="stylesheet" href="<?php echo base_url('assets') ?>/vendors/bootstrap-fileinput/css/fileinput.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="<?php echo base_url('assets') ?>/vendors/bootstrap-toggle/bootstrap4-toggle.css" rel="stylesheet" type="text/css" />
    <!-- END : PAGE CSS -->
    <style>
        .select2-container--open {
            z-index: 9999999
        }

        /* BEGIN :  Datatable Color Row */
        .colorInvalid {
            background-color: #fed0d0 !important;
        }

        .colorInvalidDetail {
            background-color: #fedcdc !important;
        }

        .colorValidDetail {
            background-color: #e4f9f9 !important;
        }


        .dt-top {
            vertical-align: top;
        }

        .dt-middle {
            vertical-align: middle;
        }

        .dt-bottom {
            vertical-align: bottom;
        }

        @media only screen and (max-width: 1400px) {

            #gmap_geocoding,
            #gmap_geocoding_card {
                min-height: 95%;
                margin-top: 10px;
            }
        }

        #gmap_geocoding,
        #gmap_geocoding_card {
            min-height: 650px;
            margin-top: 10px;
        }

        #tablePreview_wrapper {
            margin-top: 20px;
        }

        /* END :  Datatable Color Row */
    </style>
    <!-- latest jquery-->
    <script src="<?= base_url('assets'); ?>/js/jquery-3.5.1.min.js"></script>
    <script src="<?= base_url('assets'); ?>/vendors/bootstrap/js/popper.min.js"></script>
    <script src="<?= base_url('assets'); ?>/vendors/bootstrap/js/bootstrap.min.js"></script>

</head>

<?php
$nama = @$session['nama'];
$username = @$session['username'];
?>

<body>
    <div class="loader-wrapper">
        <div class="loader-index"><span></span></div>
        <svg>
            <defs></defs>
            <filter id="goo">
                <fegaussianblur in="SourceGraphic" stddeviation="11" result="blur"></fegaussianblur>
                <fecolormatrix in="blur" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 19 -9" result="goo"> </fecolormatrix>
            </filter>
        </svg>
    </div>
    <!-- tap on top starts-->
    <div class="tap-top"><i data-feather="chevrons-up"></i></div>
    <!-- tap on tap ends-->
    <!-- page-wrapper Start-->
    <div class="page-wrapper compact-wrapper" id="pageWrapper">
        <!-- Page Header Start-->
        <div class="page-header">
            <div class="header-wrapper row m-0">
                <form class="form-inline search-full col" action="#" method="get">
                    <div class="form-group w-100">
                        <div class="Typeahead Typeahead--twitterUsers">
                            <div class="u-posRelative">
                                <input class="demo-input Typeahead-input form-control-plaintext w-100" type="text" placeholder="Search Cuba .." name="q" title="" autofocus>
                                <div class="spinner-border Typeahead-spinner" role="status"><span class="sr-only">Loading...</span></div><i class="close-search" data-feather="x"></i>
                            </div>
                            <div class="Typeahead-menu"></div>
                        </div>
                    </div>
                </form>
                <div class="header-logo-wrapper col-auto p-0">
                    <div class="logo-wrapper"><a href="<?= base_url() ?>"><img class="img-fluid" src="<?= base_url('assets/images/menyambang/logo_fix.png') ?>" width="40" alt=""></a></div>
                    <div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="align-center"></i></div>
                </div>
                <div class="left-header col horizontal-wrapper ps-0">
                </div>
                <div class="nav-right col-8 pull-right right-header p-0">
                    <ul class="nav-menus">
                        <li class="profile-nav onhover-dropdown p-0 me-0">
                            <div class="media profile-media"><img class="b-r-10" src="<?= base_url('assets'); ?>/images/menyambang/no_pict.png" alt="" width="35px">
                                <div class="media-body"><span><?= $nama ?></span>
                                    <p class="mb-0 font-roboto"><?= $username ?> <i class="middle fa fa-angle-down"></i></p>
                                </div>
                            </div>
                            <ul class="profile-dropdown onhover-show-div">
                                <li><a href="<?= base_url('Login/logout') ?>"><i data-feather="log-in"> </i><span>Logout</span></a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Page Header Ends  -->
        <!-- Page Body Start-->
        <div class="page-body-wrapper">
            <!-- BEGIN: SIDEBAR-->
            <div class="sidebar-wrapper">
                <div>
                    <div class="logo-wrapper" style="padding: 20px 30px;">
                        <a href="<?= base_url() ?>">
                            <img class="img-fluid for-light" src="<?= base_url('assets/images/menyambang/logo_fix.png') ?>" alt="Logo SILAKI" width="40px">
                            <h5 style="display: inline; vertical-align: middle">Menyambang.id</h5>
                        </a>
                        <div class="back-btn"><i class="fa fa-angle-left"></i></div>
                        <!-- <div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="grid"> </i></div> -->
                    </div>
                    <!-- <div class="logo-icon-wrapper"><a href="index.html"><img class="img-fluid" src="<?= base_url('assets'); ?>/images/logo/logo-icon.png" alt=""></a></div> -->
                    <nav class="sidebar-main">
                        <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
                        <div id="sidebar-menu">
                            <ul class="sidebar-links" id="simple-bar">
                                <li class="back-btn"><a href="index.html"><img class="img-fluid" src="../assets/images/logo/logo-icon.png" alt=""></a>
                                    <div class="mobile-back text-end"><span>Back</span><i class="fa fa-angle-right ps-2" aria-hidden="true"></i></div>
                                </li>
                                <?php if (isset($MENUS)) {
                                    foreach ($MENUS as $firstLevel) {
                                        if (isset($ACTIVE_URL))
                                            $class = (isset($firstLevel['url']) && $firstLevel['url'] == $ACTIVE_URL) ? " active" : "";
                                        echo "<li class=''>";
                                        if (isset($firstLevel['url'])) {
                                            $title = isset($firstLevel['children']) ? "sidebar-title" : "";
                                            $link = (isset($firstLevel['url']) && $firstLevel['url'] != '#') ? base_url($firstLevel['url']) : "#";

                                            echo "<a class='sidebar-link sidebar-list $class $title' href='$link'>
                                                <i data-feather='$firstLevel[icon]'></i> $firstLevel[title]
                                            </a>";
                                            // echo "<a href='" . base_url($firstLevel['url']) . "'>
                                            //     <i class='$firstLevel[icon]'></i> $firstLevel[title]</a>";
                                        } else {

                                            echo "<li class='sidebar-main-title'>
                                                <div>
                                                <h6>$firstLevel[title]</h6>
                                                </div>
                                            </li>";
                                        }

                                        if (isset($firstLevel['children'])) {
                                            echo "<ul class='sidebar-submenu'>";
                                            foreach ($firstLevel['children'] as $secondLevel) {
                                                $class = "";
                                                if (isset($ACTIVE_URL))
                                                    $class = (isset($secondLevel['url']) && $secondLevel['url'] == $ACTIVE_URL) ? " active" : "";

                                                $title = isset($secondLevel['children']) ? "submenu-title" : "";
                                                echo "<li class=''>";
                                                echo "<a class='$title $class' href='" . base_url($secondLevel['url']) . "'>
                                                        $secondLevel[title]
                                                    </a>";

                                                if (isset($secondLevel['children'])) {
                                                    echo "<ul class='submenu-content opensubmegamenu'>";
                                                    foreach ($secondLevel['children'] as $thirdLevel) {
                                                        $class = "";
                                                        if (isset($ACTIVE_URL))
                                                            $class = (isset($thirdLevel['url']) && $thirdLevel['url'] == $ACTIVE_URL) ? " active" : "";

                                                        echo "<li class='$class'>
                                                            <a href='" . base_url($thirdLevel['url']) . "'>
                                                            <i class='feather icon-minus'>
                                                            </i> $thirdLevel[title]</a>
                                                            </li>";
                                                    }
                                                    echo "</ul>";
                                                }
                                                echo "</li>";
                                            }
                                            echo "</ul>";
                                        }
                                        echo "</li>";
                                    }
                                }; ?>
                            </ul>
                        </div>

                        <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
                    </nav>
                </div>
            </div>
            <!-- END: SIDEBAR-->

            <!-- BEGIN: Content-->
            <?= $this->renderSection('content'); ?>
            <!-- END: Content-->

            <!-- footer start-->
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12 footer-copyright text-center">
                            <p class="mb-0">Copyright <?= date('Y') ?> © Menyambang.id </p>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <!-- Bootstrap js-->
    <!-- <script src="<?= base_url('assets'); ?>/js/bootstrap/bootstrap.bundle.min.js"></script> -->
    <!-- feather icon js-->
    <script src="<?= base_url('assets'); ?>/js/icons/feather-icon/feather.min.js"></script>
    <script src="<?= base_url('assets'); ?>/js/icons/feather-icon/feather-icon.js"></script>
    <!-- scrollbar js-->
    <script src="<?= base_url('assets'); ?>/js/scrollbar/simplebar.js"></script>
    <script src="<?= base_url('assets'); ?>/js/scrollbar/custom.js"></script>
    <!-- Sidebar jquery-->
    <script src="<?= base_url('assets'); ?>/js/config.js"></script>
    <!-- Plugins JS start-->
    <script src="<?= base_url('assets'); ?>/js/sidebar-menu.js"></script>
    <script src="<?= base_url('assets'); ?>/js/datatable/datatables/jquery.dataTables.min.js"></script>
    <script src="<?= base_url('assets'); ?>/js/datatable/datatables/datatable.custom.js"></script>
    <script src="<?= base_url('assets'); ?>/js/tooltip-init.js"></script>
    <!-- Plugins JS Ends-->
    <!-- Theme js-->
    <script src="<?= base_url('assets'); ?>/js/script.js"></script>
    <!-- <script src="?= base_url('assets'); ?>/js/theme-customizer/customizer.js"></script> -->
    <!-- login js-->
    <!-- Plugin used-->

    <!-- Preloader -->
    <!-- <script src="<?= base_url('assets'); ?>/js/dashboard/default.js"></script> -->

    <!-- BEGIN : PAGE JS -->
    <script src="<?= base_url('assets'); ?>/vendors/moment.js"></script>
    <script src="<?= base_url('assets'); ?>/js/sweet-alert/sweetalert2.all.min.js"></script>
    <script src="<?= base_url('assets'); ?>/js/select2/select2.full.min.js"></script>
    <script src="<?= base_url('assets'); ?>/js/select2/select2-custom.js"></script>
    <script src="<?= base_url('assets'); ?>/vendors/flatpickr/flatpickr.js"></script>
    <script src="<?= base_url('assets'); ?>/vendors/flatpickr/flatpickr.id.js"></script>
    <script src="<?= base_url('assets'); ?>/vendors/flatpickr/flatpickr.id.js"></script>
    <script src="<?= base_url('assets'); ?>/vendors/bootstrap-fileinput/js/fileinput.js"></script>
    <script src="<?= base_url('assets'); ?>/vendors/bootstrap-fileinput/themes/fa/theme.js"></script>
    <script src="<?= base_url('assets'); ?>/vendors/bootstrap-fileinput/js/locales/id.js"></script>
    <script src="<?= base_url('assets'); ?>/vendors/bootstrap-toggle/bootstrap4-toggle.js"></script>

    <script src="<?= base_url('assets'); ?>/js/datepicker/date-picker/datepicker.js"></script>
    <script src="<?= base_url('assets'); ?>/js/datepicker/date-picker/datepicker.id.js"></script>
    <script src="<?= base_url('assets'); ?>/js/datepicker/date-picker/datepicker.custom.js"></script>
    <script src="<?= base_url('assets'); ?>/js/owlcarousel/owl.carousel.js"></script>
    <!-- <script src="?= base_url('assets'); ?>/js/tooltip-init.js"></script> -->
    <!-- END : PAGE JS -->

    <!-- BEGIN: Custom App-->
    <script src="<?= base_url('assets'); ?>/app/custom.js"></script>
    <!-- END: Custom App-->

    <script>
        $.fn.select2.defaults.set('language', 'id');

        $(function() {

            $('#sideMenu').on({
                mouseenter: function() {
                    $('#textLogout').show('fast');
                },
                mouseleave: function() {
                    if ($('#buttonToggle').hasClass("icon-circle")) {
                        $('#textLogout').hide('fast');
                    }
                }
            });

            $('body').click(function() {
                $('[data-toggle="tooltip"]').tooltip("hide");
            });

            $(document).on('mouseover', '.manual', function() {
                $(this).popover('show');
            });
            $(document).on('mouseout', '.manual', function() {
                $(this).popover('hide');
            });

            $.extend(true, $.fn.dataTable.defaults, {
                dom: '<"customSearching">rltip',
                initComplete: function(settings, json) {
                    $("div.customSearching").html(`<div class="col-md-4 col-12 pull-right">
                        <fieldset>
                            <div class="input-group">
                                <input type="text" class="form-control" id="field-cari" placeholder="Pencarian" aria-describedby="button-addon2">
                                <div class="input-group-append" id="button-addon2">
                                    <button class="btn btn-primary waves-effect waves-light" id="btn-cari" type="button"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </fieldset>
                    </div>`);
                },
                drawCallback: function() {
                    $('[data-toggle="tooltip"]').tooltip({
                        trigger: "hover",
                        placement: "top",
                    });
                },
            });
        })

        $(document).ready(function() {

            $(document).on('show.bs.modal', '.modal', function(event) {
                var zIndex = 1040 + (10 * $('.modal:visible').length);
                $(this).css('z-index', zIndex);
                setTimeout(function() {
                    $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
                }, 0);
            });

            $(document).on('hidden.bs.modal', '.modal', function() {
                $('.modal:visible').length && $(document.body).addClass('modal-open');
            });

            $("html, body").animate({
                scrollTop: 0
            }, 600);

            $(document).on('keyup', '#field-cari', function(e) {
                var code = e.which;
                if (code == 13)
                    e.preventDefault();
                if (code == 13 || code == 188 || code == 186) {
                    grid.search($("#field-cari").val()).draw();
                }
            });

            $(document).on('click', '#btn-cari', function() {
                grid.search($("#field-cari").val()).draw();
            });
        });
    </script>

    <!-- BEGIN: Page JS-->
    <?= $this->renderSection('js'); ?>
    <!-- END: Page JS-->
</body>

</html>