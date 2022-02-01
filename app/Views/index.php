<?= $this->extend('/layouts/layout') ?>

<?= $this->section('css_scripts') ?>
<link rel="stylesheet" type="text/css" href="https://code.highcharts.com/css/highcharts.css">
<?= $this->endSection() ?>

<?= $this->section('main-container') ?>

<div class="main-container">
  <div class="pd-ltr-20">
    <!--breadcrumb-->
    <?= $this->include('/layouts/breadcrumb') ?>


    <div class="card mb-4 border-0" style="border-radius: 12px !important;">
      <div class="row">

        <div class="col-md-8">
          <div class="card-body pl-4">
            <?php
            //ubah timezone menjadi Asia/Jakarta
            date_default_timezone_set("Asia/Jakarta");
            //ambil jam dan menit
            $jam = date('H:i');
            //atur salam menggunakan IF
            if ($jam > '05:30' && $jam < '10:30') {
              $salam = ['Pagi', 'morning.png'];
            } elseif ($jam >= '10:30' && $jam < '15:00') {
              $salam = ['Siang', 'day.png'];
            } elseif ($jam >= '15:01' && $jam < '18:00') {
              $salam = ['Sore', 'afternoon.png'];
            } else {
              $salam = ['Malam', 'night.png'];
            }
            ?>
            <p class="lead text-center text-md-left">
              <img src="<?= base_url('/vendors/images/' . $salam[1]) ?>" style="width:33px"> Selamat <?= $salam[0] ?>,
            </p>
            <h2 class="text-dark text-lowercase text-center text-md-left"><?= user()->username; ?></h2>
            <hr>
            <p class="text-center text-md-left d-none d-md-block" style="font-size:13pt;">Selamat Datang di Sistem Analisis Data Pembelian Konsumen Dalam Menentukan Promosi Menggunakan Algoritma K-Medoids dan FP-Growth</p>
          </div>
        </div>
        <div class="col-md-4">
          <img src="<?= base_url("/vendors/images/hero.gif") ?>" alt="">
        </div>
      </div>
    </div>



    <div class="row mt-2">
      <p class="container text-center text-md-left d-md-none pb-4" style="font-size:13pt;">Selamat Datang di Sistem Analisis Data Pembelian Konsumen Dalam Menentukan Promosi Menggunakan Algoritma K-Medoids dan FP-Growth</p>
      <div class="col-6 col-md-4 mb-30">
        <a href="<?= base_url('/data') ?>">
          <div class="card-box height-100-p widget-style1">
            <div class="d-flex flex-wrap align-items-center">
              <div class="widget-data">
                <span class="row">
                  <span class="col-md-4 col-12">
                    <img src="<?= base_url('/vendors/images/folder.png') ?>" alt="food" width="80%">
                  </span>
                  <span class="col-md-8 col-12">
                    <div class="h4 mb-0"><?= count($data) ?></div>
                    <div class="weight-600 font-14">Detail Transaksi</div>
                  </span>
                </span>
              </div>
            </div>
          </div>
        </a>
      </div>
      <div class="col-6 col-md-4 mb-30">
        <a href="<?= base_url('/data/transaksi') ?>">
          <div class="card-box height-100-p widget-style1">
            <div class="d-flex flex-wrap align-items-center">
              <div class="widget-data">
                <span class="row">
                  <span class="col-md-5 col-12">
                    <img src="<?= base_url('/vendors/images/transactiony.png') ?>" alt="food" width="60%">
                  </span>
                  <span class="col-md-7 col-12">
                    <div class="h4 mb-0"><?= count($j_data) ?></div>
                    <div class="weight-600 font-14">Transaksi</div>
                  </span>
                </span>
              </div>
            </div>
          </div>
        </a>
      </div>
      <div class="col-6 col-md-4 mb-30">
        <a href="<?= base_url('/data/produk') ?>">
          <div class="card-box height-100-p widget-style1">
            <div class="d-flex flex-wrap align-items-center">
              <div class="widget-data">
                <span class="row">
                  <span class="col-md-5 col-12">
                    <img src="<?= base_url('/vendors/images/food.png') ?>" alt="food" width="70%">
                  </span>
                  <span class="col-md-7 col-12">
                    <div class="h4 mb-0"><?= count($j_menu) ?></div>
                    <div class="weight-600 font-14">Menu</div>
                  </span>
                </span>
              </div>
            </div>
          </div>
        </a>
      </div>
      <div class="col-6 col-md-4 mb-30 d-md-none">
        <a href="<?= base_url('/Hasil') ?>">
          <div class="card-box height-100-p widget-style1">
            <div class="d-flex flex-wrap align-items-center">
              <div class="widget-data">
                <span class="row">
                  <span class="col-md-5 col-12">
                    <img src="<?= base_url('/vendors/images/food.png') ?>" alt="food" width="70%">
                  </span>
                  <span class="col-md-7 col-12">
                    <div class="h4 mb-0"><?= count($j_paket) ?></div>
                    <div class="weight-600 font-14">Paket</div>
                  </span>
                </span>
              </div>
            </div>
          </div>
        </a>
      </div>
    </div>


    <div class="row">
      <div class="col-xl-8 col-md-8 mb-30">
        <div class="card-box height-100-p pd-20">
          <h2 class="h4 mb-20">Grafik Pembelian Produk</h2>
          <div id="container" style="height: 400 px;min-width: 300 px;max-width: 800 px;margin: 0 auto;"></div>
          <br>
          <hr><br>
          <div class="row">
            <div class="col-xl-6 col-md-6">
              <h2 class="h6 mb-20 text-center">5 Teratas Produk Laris</h2>
              <br>
              <table class="table table-hover">
                <tr class="thead-light">
                  <th>No</th>
                  <th>Produk</th>
                  <th>Jumlah</th>
                </tr>
                <?php $i = 1; ?>
                <?php
                foreach ($produk_laris as $pt) :
                ?>
                  <tr>
                    <td><?= $i++ ?></td>
                    <td><?= $pt->item_produk; ?></td>
                    <td><?= $pt->item; ?></td>
                  </tr>
                <?php endforeach ?>
              </table>
            </div><br>
            <div class="col-xl-6 col-md-6">
              <h2 class="h6 mb-20 text-center">5 terbawah Produk Kurang Laris</h2>
              <br>
              <table class="table table-hover">
                <tr class="thead-light">
                  <th>No</th>
                  <th>Produk</th>
                  <th>Jumlah</th>
                </tr>
                <?php $i = 1; ?>
                <?php
                foreach ($produk_kurang_laris as $pt) :
                ?>
                  <tr>
                    <td><?= $i++ ?></td>
                    <td><?= $pt->item_produk; ?></td>
                    <td><?= $pt->item; ?></td>
                  </tr>
                <?php endforeach ?>
              </table>
            </div>
          </div>
        </div>
      </div>

      <div class="col-xl-4 col-md-4 mb-30">
        <div class="card-box height-100-p pd-20">
          <h2 class="h4 mb-20">Persentase Jumlah Produk</h2>
          <div id="produks"></div>
          <table class="table">
            <thead class="thead-light">
              <tr class="text-center">
                <th>Jenis</th>
                <th>Jumlah Produk</th>
                <th>Jumlah Pembelian</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $sum1 = 0;
              $sum2 = 0;
              foreach ($produk_jenis as $pj) { ?>
                <tr class="text-center">
                  <td><?= $pj->jenis ?></td>
                  <td><?= $pj->jumlah ?><?php $sum1 += $pj->jumlah ?></td>
                  <td><?= $pj->jumlahs ?><?php $sum2 += $pj->jumlahs ?></td>
                </tr>
              <?php } ?>
              <tr class="text-center">
                <td>Total</td>
                <th><?= $sum1 ?></th>
                <th><?= $sum2 ?></th>
              </tr>
            </tbody>
          </table>
          <br>
          <figure class="highcharts-figure">
            <div id="containers"></div>
            <p class="highcharts-description">
            </p>
          </figure>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-xl-6 mb-30">
        <div class="card-box height-100-p pd-20">
          <h2 class="h4 mb-20">Jumlah Transaksi Per-Bulan</h2>
          <figure class="highcharts-figure">
            <div id="transaksi_bulan"></div>
          </figure>
        </div>
      </div>

      <div class="col-xl-6 mb-30">
        <div class="card-box height-100-p pd-20">
          <h2 class="h4 mb-20">Jumlah Pemasukan Per-Bulan</h2>
          <figure class="highcharts-figure">
            <div id="pemasukan_bulan"></div>
          </figure>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12 mb-30">
        <div class="card-box height-100-p pd-20">
          <h2 class="h4 mb-20">Jumlah Pembelian Produk</h2>
          <table class="table hover multiple-select-row data-table-export nowrap">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th>Jumlah Pembelian</th>
                <th>Harga</th>
              </tr>
            </thead>
            <tbody>
              <?php $i = 1; ?>
              <?php
              foreach ($produk_item as $pt) :
              ?>
                <tr>
                  <td><?= $i++ ?></td>
                  <td><?= $pt->item_produk; ?></td>
                  <td><?= $pt->item; ?></td>
                  <td>Rp. <?= number_format(($pt->harga), 0, "", ".") ?></td>
                </tr>
              <?php endforeach ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <br>

  </div>
</div>


<?= $this->endSection() ?>

<?= $this->section('pageScripts') ?>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-3d.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script>
  Highcharts.chart('container', {
    chart: {
      type: 'column',
      styledMode: true,
      options3d: {
        enabled: false,
        alpha: 15,
        beta: 15,
        depth: 50
      },
      scrollablePlotArea: {
        minWidth: 7000,
        scrollPositionX: 0
      }
    },
    title: {
      text: ''
    },
    plotOptions: {
      column: {
        depth: 25
      }
    },
    xAxis: {
      categories: [
        <?php foreach ($produk_item_urut as $pt) { ?> '<?= $pt->item_produk ?>',
        <?php } ?>
      ]
    },
    series: [{
      name: 'Jumlah Produk',
      data: [
        <?php foreach ($produk_item_urut as $py) { ?>
          <?= $py->item ?>,
        <?php } ?>
      ],
      colorByPoint: true
    }, {
      name: 'Harga Per-Satuan (*1000)',
      data: [
        <?php foreach ($produk_item_urut as $py) { ?>
          <?= ($py->harga) / 1000 ?>,
        <?php } ?>
      ],
      colorByPoint: true
    }]
  });
</script>
<script>
  Highcharts.chart('produks', {
    chart: {
      plotBackgroundColor: null,
      plotBorderWidth: null,
      plotShadow: false,
      type: 'pie'
    },
    title: {
      text: ''
    },
    tooltip: {
      pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    accessibility: {
      point: {
        valueSuffix: '%'
      }
    },
    plotOptions: {
      pie: {
        allowPointSelect: true,
        cursor: 'pointer',
        dataLabels: {
          enabled: true,
          format: '<b>{point.name}</b>: {point.percentage:.1f} %'
        }
      }
    },
    series: [{
      name: 'Persentase Jumlah Produk',
      colorByPoint: true,
      data: [
        <?php foreach ($produk_jenis as $pj) { ?> {
            name: '<?= $pj->jenis ?>',
            y: <?= $pj->jumlahs ?>
          },
        <?php } ?>
      ]
    }]
  });
</script>

<?php $this->db = \Config\Database::connect(); ?>
<script>
  Highcharts.chart('containers', {
    chart: {
      type: 'column'
    },
    title: {
      text: 'Jam Sibuk Opersional'
    },
    subtitle: {
      text: ''
    },

    xAxis: {
      categories: [
        '9 AM',
        '10 AM',
        '11 AM',
        '12 PM',
        '1 PM',
        '2 PM',
        '3 PM',
        '4 PM',
        '5 PM',
        '6 PM',
        '7 PM',
        '8 PM',
        '9 PM',
        '10 PM',
        '11 PM',
      ],
      crosshair: true
    },
    yAxis: {
      min: 0,
      title: {
        text: 'Transaksi'
      }
    },
    tooltip: {
      headerFormat: '<span style="font-size:10px">Pukul {point.key}</span><table>',
      pointFormat: '<tr>' +
        '<td style="padding:0"><b>{point.y} transaksi</b></td></tr>',
      footerFormat: '</table>',
      shared: true,
      useHTML: true
    },
    plotOptions: {
      column: {
        pointPadding: 0,
        borderWidth: 0,
        groupPadding: 0,
        shadow: false
      }
    },
    series: [{
      name: 'Pukul',
      data: [
        <?php
        for ($i = 9; $i <= 23; $i++) {
          $ry = $this->db->query("SELECT SUBSTRING(pukul, 1, 2) as pukul from data where
          pukul = $i ")->getResultObject();
          print $r = count($ry);
          print ',';
        }
        ?>
      ]
    }]
  });
</script>

<script>
  Highcharts.chart('transaksi_bulan', {
    chart: {
      type: 'areaspline'
    },
    title: {
      text: ''
    },
    legend: {
      layout: 'vertical',
      align: 'left',
      verticalAlign: 'top',
      x: 50,
      y: 10,
      floating: true,
      borderWidth: 1,
      backgroundColor: Highcharts.defaultOptions.legend.backgroundColor || '#FFFFFF'
    },
    xAxis: {
      categories: [
        'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
      ],
      plotBands: [{ // visualize the month
        from: 0,
        to: 0,
        color: 'rgba(68, 170, 213, .2)'
      }]
    },
    yAxis: {
      title: {
        text: 'Jumlah'
      }
    },
    tooltip: {
      shared: true,
      valueSuffix: ' transaksi'
    },
    credits: {
      enabled: false
    },
    plotOptions: {
      areaspline: {
        fillOpacity: 0.5
      }
    },
    series: [
      <?php $query1 = $this->db->query("SELECT year(tanggal) as tahun from data group by tahun")->getResultObject(); ?>
      <?php foreach ($query1 as $q1) { ?> {
          name: '<?= $q1->tahun ?>'
          <?php $query2 = $this->db->query("SELECT month(tanggal) as bulan, count(DISTINCT(receipt_number)) as transaksi from data where year(tanggal)=$q1->tahun group by bulan")->getResultObject(); ?>,
          data: [
            <?php foreach ($query2 as $q2) { ?>
              <?= $q2->transaksi ?>,
            <?php } ?>
          ]
        },
      <?php } ?>
    ]
  });
</script>

<script>
  Highcharts.chart('pemasukan_bulan', {
    chart: {
      type: 'areaspline'
    },
    title: {
      text: ''
    },
    legend: {
      layout: 'vertical',
      align: 'left',
      verticalAlign: 'top',
      x: 50,
      y: 10,
      floating: true,
      borderWidth: 1,
      backgroundColor: Highcharts.defaultOptions.legend.backgroundColor || '#FFFFFF'
    },
    xAxis: {
      categories: [
        'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
      ],
      plotBands: [{ // visualize the month
        from: 0,
        to: 0,
        color: 'rgba(68, 170, 213, .2)'
      }]
    },
    yAxis: {
      title: {
        text: 'Jumlah'
      }
    },
    tooltip: {
      shared: true,
      valueSuffix: ' Rupiah'
    },
    credits: {
      enabled: false
    },
    plotOptions: {
      areaspline: {
        fillOpacity: 0.5
      }
    },
    series: [
      <?php $query1 = $this->db->query("SELECT year(tanggal) as tahun from data group by tahun")->getResultObject(); ?>
      <?php foreach ($query1 as $q1) { ?> {
          name: '<?= $q1->tahun ?>'
          <?php $query2 = $this->db->query("SELECT month(tanggal) as bulan, sum(harga) as transaksi from data where year(tanggal)=$q1->tahun group by bulan")->getResultObject(); ?>,
          data: [
            <?php foreach ($query2 as $q2) { ?>
              <?= $q2->transaksi ?>,
            <?php } ?>
          ]
        },
      <?php } ?>
    ]
  });
</script>

<script src="<?= base_url(); ?>/src/plugins/datatables/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url(); ?>/src/plugins/datatables/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url(); ?>/src/plugins/datatables/js/dataTables.responsive.min.js"></script>
<script src="<?= base_url(); ?>/src/plugins/datatables/js/responsive.bootstrap4.min.js"></script>
<!-- buttons for Export datatable -->
<script src="<?= base_url(); ?>/src/plugins/datatables/js/dataTables.buttons.min.js"></script>
<script src="<?= base_url(); ?>/src/plugins/datatables/js/buttons.bootstrap4.min.js"></script>
<script src="<?= base_url(); ?>/src/plugins/datatables/js/buttons.print.min.js"></script>
<script src="<?= base_url(); ?>/src/plugins/datatables/js/buttons.html5.min.js"></script>
<script src="<?= base_url(); ?>/src/plugins/datatables/js/buttons.flash.min.js"></script>
<script src="<?= base_url(); ?>/src/plugins/datatables/js/pdfmake.min.js"></script>
<script src="<?= base_url(); ?>/src/plugins/datatables/js/vfs_fonts.js"></script>
<!-- Datatable Setting js -->
<script src="<?= base_url(); ?>/vendors/scripts/datatable-setting.js"></script>

<?= $this->endSection() ?>