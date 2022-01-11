<?= $this->extend('/layouts/layout') ?>
<?php $time_start = microtime(true); ?>


<?= $this->section('main-container') ?>
<div class="main-container">
  <div class="pd-ltr-20">
    <!--breadcrumb-->
    <nav aria-label="breadcrumb" role="navigation">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><a class="text-primary" href="<?= base_url(); ?>/">Beranda</a></li>
        <li class="breadcrumb-item"><?= $title ?></li>
      </ol>
    </nav>
    <br>

    <!--end breadcrumb-->
    <a href="<?= base_url('/hasil/download') ?>" target="_blank" class="btn btn-success btn-sm mb-3">Download Hasil</a>
    <a href="<?= base_url('/hasil/download_fptree') ?>" target="_blank" class="btn btn-warning btn-sm mb-3 text-white">Download FP-Tree</a>
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-dark"><i class="fa fa-table"></i> Konfigurasi</h6>
      </div>
      <div class="card-body">
        <?= view('Myth\Auth\Views\_message_block') ?><br>
        <table class="table table-responsive">
          <thead class="bg-light-blue text-dark">
            <tr align="center">
              <th>Jumlah Data</th>
              <th>Data Transaksi</th>
              <th>Jumlah Klaster</th>
              <th>Hasil Klaster</th>
              <th>Jumlah Data Hasil Klaster</th>
              <th>Data Transaksi Hasil Klaster</th>
              <th>Min. Support</th>
              <th>Min. Confidence</th>
            </tr>
          </thead>
          <tbody>
            <tr class="text-center">
              <?php
              $d1 = number_format(count($data), 0, "", ",");
              $d2 = number_format(count($data_transaksi), 0, "", ",");
              $d3 = number_format(count($data_klaster), 0, "", ",");
              $d4 = number_format(count($data_transaksi_klaster), 0, "", ",");
              ?>
              <td><?= $d1 ?></td>
              <td><?= $d2 ?></td>
              <td><?= $klaster ?></td>
              <td><?= $data_analisis ?> di beli</td>
              <td><?= $d3 ?></td>
              <td><?= $d4 ?></td>
              <td><?= $supp ?> %</td>
              <td><?= $conf ?> %</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>


    <div class="card shadow my-5">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-dark"><i class="fa fa-table"></i> Data Hasil K-medoids dan FP-Growth</h6>
      </div>
      <div class="card-body">
        <span id="hasil-si">
          <table class="table hover multiple-select-row nowrap" width="100%" cellspacing="0">
            <thead class="bg-light-blue text-dark">
              <tr align="center">
                <th>No</th>
                <th>Rule</th>
                <th>Support</th>
                <th>Confident</th>
                <th>Lift Ratio</th>
              </tr>
            </thead>
            <tbody>
              <?php $no = 1;
              foreach ($hasil as $row) { ?>
                <tr>
                  <td><?= $no++ ?></td>
                  <td><?= $row->left_item ?> => <?= $row->right_item ?></td>
                  <td><?= round($row->supp * 100, 2) ?>%</td>
                  <td><?= round($row->conf * 100, 2) ?>%</td>
                  <td><?= round($row->lift, 2) ?></td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </span>
      </div>
    </div>

    <div class="card shadow my-5">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-dark"><i class="fa fa-table"></i> Kesimpulan</h6>
      </div>
      <div class="card-body">
        <span id="hasil-si">
          <table class="table hover multiple-select-row nowrap" width="100%" cellspacing="0">
            <thead class="bg-light-blue text-dark">
              <tr align="center">
                <th>No</th>
                <th>Rule</th>
              </tr>
            </thead>
            <tbody>
              <?php $no = 1;
              foreach ($hasil as $row) { ?>
                <tr>
                  <td><?= $no++ ?></td>
                  <td>Jika membeli <code><?= $row->left_item ?></code> , maka akan membeli <code><?= $row->right_item ?></code></td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </span>
      </div>
    </div>


    <div class="card shadow my-5">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-dark"><i class="fa fa-table"></i> Paket Rekomendasi</h6>
      </div>
      <div class="card-body">
        <span id="hasil-si">
          <table class="table hover multiple-select-row nowrap" width="100%" cellspacing="0">
            <thead class="bg-light-blue text-dark">
              <tr align="center">
                <th>No</th>
                <th>Item Produk (x)</th>
                <th>Harga (x)</th>
                <th>Item Produk (y)</th>
                <th>Harga (y)</th>
              </tr>
            </thead>
            <tbody>
              <?php
              //fungsi agar mendapatkan array di dalam string
              function penjabaran($x)
              {
                $cobak = $x;
                  $input = explode(", ", $cobak);
                  $output = implode("','", array_map(
                    function ($v, $k) {
                      if (is_array($v)) {
                        return $k . '[]=' . implode('&' . $k . '[]=', $v);
                      } else {
                        return $v;
                      }
                    },
                    $input,
                    array_keys($input)
                  ));
                  return $output;
              }

              ?>
              <?php $no = 1;
              $this->db = \Config\Database::connect();
              foreach ($hasil as $row) { ?>
                <tr>
                  <td><?= $no++ ?></td>
                  <td><?= $row->left_item ?></td>
                  <?php
                  $left_produk = penjabaran($row->left_item);
                  $query = $this->db->query("SELECT distinct item_produk, (harga/jumlah) as peritem from data where item_produk in('$left_produk')");
                  $hasils = $query->getResultObject();
                  ?>
                  <td>
                    <?php foreach ($hasils as $rows) { ?>
                      <span style="margin-right:35px"><?= "Rp " . number_format($rows->peritem, 0, ".", ".") ?></span>
                    <?php } ?>
                  </td>
                  <td><?= $row->right_item ?></td>
                  <?php
                  $right_produk = penjabaran($row->right_item);
                  $querys = $this->db->query("SELECT distinct item_produk, (harga/jumlah) as peritem from data where item_produk in('$right_produk')");
                  $hasilss = $querys->getResultObject();
                  ?>
                  <td>
                    <?php foreach ($hasilss as $rows) { ?>
                      <span style="margin-right:35px"><?= "Rp " . number_format($rows->peritem, 0, ".", ".") ?></span>
                    <?php } ?>
                  </td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </span>
      </div>
    </div>
    </br>


    <?= $this->endSection() ?>

    <?= $this->section('pageScripts') ?>
    <script src="<?= base_url(); ?>/src/plugins/datatables/js/jquery.dataTables.min.js"></script>
    <script src="<?= base_url(); ?>/src/plugins/datatables/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?= base_url(); ?>/src/plugins/datatables/js/dataTables.responsive.min.js"></script>
    <script src="<?= base_url(); ?>/src/plugins/datatables/js/responsive.bootstrap4.min.js"></script>
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