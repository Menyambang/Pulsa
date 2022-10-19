<?= $this->extend('Layouts/default'); ?>
<?= $this->section('content'); ?>
<div class="page-body">
          <div class="container-fluid">
            <div class="page-title">
              <div class="row">
                <div class="col-6">
                  <h3>Beranda</h3>
                </div>
                <div class="col-6">
                  <ol class="breadcrumb">
                  </ol>
                </div>
              </div>
            </div>
          </div>
          <!-- Container-fluid starts-->
          <div class="container-fluid">
            <div class="row">
              <div class="col-sm-6 col-xl-3 col-lg-6">
                <div class="card o-hidden">
                  <div class="bg-success b-r-4 card-body">
                    <div class="media static-top-widget">
                      <div class="align-self-center text-center"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user-plus"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><line x1="20" y1="8" x2="20" y2="14"></line><line x1="23" y1="11" x2="17" y2="11"></line></svg></div>
                      <div class="media-body"><span class="m-0">Pengguna</span>
                        <h4 class="mb-0 counter jlhPengguna">0</h4><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user-plus icon-bg"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><line x1="20" y1="8" x2="20" y2="14"></line><line x1="23" y1="11" x2="17" y2="11"></line></svg>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-6 col-xl-3 col-lg-6">
                <div class="card o-hidden">
                  <div class="bg-primary b-r-4 card-body">
                    <div class="media static-top-widget">
                      <div class="align-self-center text-center"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-bag"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg></div>
                      <div class="media-body"><span class="m-0">Produk</span>
                        <h4 class="mb-0 counter jlhProduk">0</h4><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-database icon-bg"><ellipse cx="12" cy="5" rx="9" ry="3"></ellipse><path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"></path><path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"></path></svg>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-6 col-xl-3 col-lg-6">
                <div class="card o-hidden">
                  <div class="bg-warning b-r-4 card-body">
                    <div class="media static-top-widget">
                      <div class="align-self-center text-center"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-message-circle"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg></div>
                      <div class="media-body"><span class="m-0">Stok < 5</span>
                        <h4 class="mb-0 counter jlhStokSedikit">0</h4><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-bag icon-bg"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-6 col-xl-3 col-lg-6">
                <div class="card o-hidden">
                  <div class="bg-secondary b-r-4 card-body">
                    <div class="media static-top-widget">
                      <div class="align-self-center text-center"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-bag"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg></div>
                      <div class="media-body"><span class="m-0">Stok Habis</span>
                        <h4 class="mb-0 counter jlhStokHabis">0</h4><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-bag icon-bg"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
        
            </div>

            <div class="card">
                    <!-- <div class="card-header">
                        <h5 class="m-b-0">Feather Icons</h5>
                    </div> -->
                    <div class="card-body">
                        <h4 class="card-text">Lokasi Pengguna</h4>
                        <p>Menampilkan titik lokasi pengguna yang terdaftar di aplikasi</p>
                        <section id="gmap_geocoding"></section>
                    </div>
                </div>
           
          <!-- Container-fluid Ends-->
        </div>
<!-- Container-fluid Ends-->
</div>

<?= $this->endSection(); ?>

<?= $this->section('css'); ?>
<?= $this->endSection(); ?>

<?= $this->section('js'); ?>
<script src="https://maps.google.com/maps/api/js?sensor=true&key=AIzaSyBWW6k0BFyLl7Q7pmCSH_9NFPnbkzr0InE"></script>
<script src="<?php echo base_url('assets') ?>/vendors/maps/gmaps.js"></script>
<style type="text/css">
    @media only screen and (max-width: 1400px) {
        #gmap_geocoding {
            min-height: 95%;
        }
    }

    #gmap_geocoding {
        min-height: 650px;
    }

    #tablePreview_wrapper {
        margin-top: 20px;
    }
</style>
<script>
    var isRender = false;
    var chart;
    $(document).ready(function() {

        requestDataBeranda();
        function requestDataBeranda() {
            $.ajax({
                type: "POST",
                url: "<?= current_url() ?>/dataBeranda",
                data: $('#formChart').serialize(),
                dataType: "JSON",
                success: function(res) {
                  $('.jlhPengguna').html(res.card.jlhPengguna);
                  $('.jlhProduk').html(res.card.jlhProduk);
                  $('.jlhStokSedikit').html(res.card.jlhStokSedikit);
                  $('.jlhStokHabis').html(res.card.jlhStokHabis);
                  renderMaps(res.pengguna);
                },
                fail: function(xhr) {
                    Swal.fire('Error', "Server gagal merespon", 'error');
                },
                beforeSend: function() {
                    $('#btnLihat').attr('disabled', true).html('<i class="fa fa-spin fa-spinner"></i> Lihat');
                },
                complete: function(res) {
                    $('#btnLihat').removeAttr('disabled').html('<i class="fa fa-search"></i> Lihat');
                }
            });
        }

        var map;
        var marker = [];

        renderMaps();
        function renderMaps(data = []) {
            var lat = -3.4407774;
            var lng = 114.840804;
            if (data.length) {
                lat = parseFloat(data[0].latitude ?? data[0].alamat.latitude);
                lng = parseFloat(data[0].longitude ?? data[0].alamat.longitude);
            }

            map = new google.maps.Map(document.getElementById('gmap_geocoding'), {
                zoom: 8,
                center: {
                    lat: lat,
                    lng: lng
                },
                mapTypeId: 'roadmap',
                gestureHandling: 'cooperative'
            });
            // Long, Lat https://gmapgis.com/

            $.each(data, function(indexInArray, val) {
                var icon = `https://maps.google.com/mapfiles/ms/icons/red-dot.png`

                marker[val.email] = new google.maps.Marker({
                    position: {
                        lat: parseFloat(val.latitude ?? val.alamat.latitude),
                        lng: parseFloat(val.longitude ?? val.alamat.longitude),
                    },
                    animation: google.maps.Animation.DROP,
                    icon: icon,
                    map: map,
                    title: val.nama,
                });


                marker[val.email].addListener('click', function() {
                    getContent(val, marker[val.email])
                });

                google.maps.event.addListener(marker[val.email], 'click', function() {
                    map.panTo(marker[val.email].getPosition());
                });
            });
        }

        function getContent(val, marker) {
            google.maps.event.trigger(map, 'click');

            function titleTemplate(title, value){
              if(value == null) return '-';
              return `<tr>
                          <td>${title}</td>
                          <td style="text-align: end"><b>${value}</b></td>
                      </tr>`;
            }

            var contentString = `<div class="thumbnail">
                                <div class="caption">
                                    <table width="100%">
                                        ${titleTemplate('Nama', val.nama)}
                                        ${titleTemplate('Email', val.email)}
                                        ${titleTemplate('No Hp', val.noHp)}
                                        ${titleTemplate('No WA', val.noWa)}
                                    </table>
                                </div>
                              </div>`;


            var infowindow = new google.maps.InfoWindow({
                content: contentString
            });

            infowindow.open(map, marker);


            closeInfoWindow = function() {
                infowindow.close();
            };
            google.maps.event.addListener(map, 'click', closeInfoWindow);
        }

    });
</script>
<?= $this->endSection(); ?>