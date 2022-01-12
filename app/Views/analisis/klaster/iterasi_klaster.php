<?= $this->extend('/layouts/layout') ?>

<?= $this->section('css_scripts') ?>
<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>/src/styles/highcart.css">
<?= $this->endSection() ?>

<?= $this->section('main-container') ?>

<?php

use App\Models\KlasterModel;

$this->db = \Config\Database::connect();
$this->m_klaster = new KlasterModel();

//rumus mencari jarak antar medoid dengan manhattan
function manhattan($perulangan, $jumlahnya, $harganya, $centroidJumlah, $centroidHarga)
{
  $h[$perulangan] = abs((($jumlahnya - $centroidJumlah[$perulangan])) - (($harganya - $centroidHarga[$perulangan])));
  echo $h[$perulangan];
  return $h[$perulangan];
}
?>

<div class="main-container">
  <div class="pd-ltr-20">
    <!--breadcrumb-->
    <nav aria-label="breadcrumb" role="navigation">
      <ol class="breadcrumb">
        <li class="breadcrumb-item active" aria-current="page"><a class="text-primary" href="<?= base_url(); ?>/">Beranda</a></li>
        <li class="breadcrumb-item"><?= $title ?></li>
      </ol>
    </nav>
    </br>
    <!---->

    <?= $this->include('/layouts/loading') ?>
    <!-- Tahapan Analisis Data -->
    <?= $this->include('/layouts/tahapan') ?>
    <!-- End Tahapan Analisis Data -->
    <br>


    <span id="perhitungan">
      <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h4 class="h5 mb-0 text-gray-800"><i class="icon-copy dw dw-analytics-11"></i> Data Pengelompokan Iterasi Ke-1</h4>
      </div>

      <!-- medoid -->
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-dark"><i class="fa fa-table"></i> Centroid Medoids</h6>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
              <thead class="bg-light-blue text-dark">
                <tr class="text-center">
                  <th>Centroid ke-</th>
                  <th>No</th>
                  <th>Item Produk</th>
                  <th>Jumlah</th>
                  <th>harga (*1000)</th>
                </tr>
              </thead>
              <tbody>
                <?php $no = 1 ?>
                <?php foreach ($produk_rand as $m1) { ?>
                  <tr class="text-center">
                    <td><?= $no ?></td>
                    <td><?= $id = $m1['id_processing'] ?></td>
                    <td class="text-left"><?= $m1['item_produk'] ?></td>
                    <td><?= $jmlh = $m1['jumlah'] ?></td>
                    <td><?= $hrga = $m1['harga'] ?></td>
                    <?php $centroid1 = "insert into centroid(fk_id_processing,jumlah,harga,tahapan,c) values(" . $id . "," . $jmlh . "," . $hrga . ",1,'c" . $no . "')";
                    $this->db->query($centroid1);
                    ?>
                  </tr>
                  <?php $no++ ?>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- iterasi medoid -->
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-dark"><i class="fa fa-table"></i> Iterasi Medoids</h6>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
              <thead class="bg-light-blue text-dark">
                <tr class="text-center">
                  <th rowspan="2">No</th>
                  <th rowspan="2">Item Produk</th>
                  <th rowspan="2">Jumlah</th>
                  <th rowspan="2">Harga (*1000)</th>
                  <?php $ct = 1 ?>
                  <?php foreach ($produk_rand as $m) { ?>
                    <th colspan="2">Centroid <?= $ct;
                                              $ct++ ?></th>
                  <?php } ?>
                  <?php $d = 1 ?>
                  <?php foreach ($produk_rand as $m) { ?>
                    <th rowspan="2">C<?= $d;
                                      $d++ ?></th>
                  <?php } ?>
                </tr>
                <tr class="text-center">
                  <?php foreach ($produk_rand as $m1) { ?>
                    <th><?php $c_jumlah[] = $m1['jumlah'];
                        echo $m1['jumlah'] ?></th>
                    <th><?php $c_harga[] = $m1['harga'];
                        echo $m1['harga'] ?></th>
                  <?php } ?>
                </tr>
              </thead>
              <tbody>
                <?php $no  = 1;
                $tc0 = 0;
                $tc  = 0 ?>
                <?php foreach ($produk as $key) { ?>
                  <tr class="text-center">
                    <td class="align-middle"><?= $no ?></td>
                    <td class="text-left align-middle"><?= $key->item_produk ?></td>
                    <td class="align-middle"><?= $key->jumlah ?></td>
                    <td class="align-middle"><?= $key->harga ?></td>
                    <?php $no++ ?>
                    <?php $e = 0;
                    $tc = array(); ?>
                    <?php foreach ($produk_rand as $k) { ?>
                      <td class="align-middle" colspan="2">
                        <?php $hm[$e] = manhattan($e, $key->jumlah, $key->harga, $c_jumlah, $c_harga);
                        $hc[$e] = $hm[$e]; ?>
                      </td>
                      <?php $e++ ?>
                    <?php } ?>
                    <?php for ($i = 0; $i < COUNT($hc); $i++) { ?>
                      <?php if ($hc[$i] == MIN($hc)) {
                        echo "<td class='align-middle bg-success text-white font-weight-bold'>1</td>";
                        $cm = $i + 1;
                        $q = "insert into centroid_temp(jenis,iterasi,c) values('M',1,'c" . $cm . "')";
                        $this->db->query($q);
                      } else {
                        echo "<td class='align-middle'>0</td>";
                      }
                      ?>
                    <?php } ?>
                    <?php
                    for ($j = 0; $j < COUNT($hc); $j++) {
                      $tc0 = $tc0 + $hc[$j];
                      $ttc[] = $tc0;
                    }
                    ?>
                  </tr>
                <?php } ?>
                <tr class="text-center">
                  <td class="align-middle" colspan="4"><b>TOTAL</b></td>
                  <td class="align-middle" colspan="15"><b><?php echo $tc0 ?></b></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      </br>
      <hr>
      <br>


      <!-- non medoids -->
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-dark"><i class="fa fa-table"></i> Centroid Non Medoids</h6>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
              <thead class="bg-light-blue text-dark">
                <tr class="text-center">
                  <th>Centroid ke-</th>
                  <th>No</th>
                  <th>Item Produk</th>
                  <th>Jumlah</th>
                  <th>harga (*1000)</th>
                </tr>
              </thead>
              <tbody>
                <?php $nom = 1 ?>
                <?php foreach ($produk_rand2 as $nm1) { ?>
                  <tr class="text-center">
                    <td><?= $nom ?></td>
                    <td><?= $id = $nm1['id_processing'] ?></td>
                    <td class="text-left"><?= $nm1['item_produk'] ?></td>
                    <td><?= $jmlh = $nm1['jumlah'] ?></td>
                    <td><?= $hrga = $nm1['harga'] ?></td>
                    <?php $centroid2 = "insert into centroid(fk_id_processing,jumlah,harga,tahapan,c) values(" . $id . "," . $jmlh . "," . $hrga . ",2,'c" . $nom . "')";
                    $this->db->query($centroid2);
                    ?>
                  </tr>
                  <?php $nom++ ?>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!--iterasi non medoids-->
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-dark"><i class="fa fa-table"></i> Iterasi Non Medoids</h6>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
              <thead class="bg-light-blue text-dark">
                <tr class="text-center">
                  <th rowspan="2">No</th>
                  <th rowspan="2">Item Produk</th>
                  <th rowspan="2">Jumlah</th>
                  <th rowspan="2">Harga (*1000)</th>
                  <?php $f = 1 ?>
                  <?php foreach ($produk_rand2 as $m) { ?>
                    <th colspan="2">Centroid <?= $f;
                                              $f++ ?></th>
                  <?php } ?>
                  <?php $g = 1 ?>
                  <?php foreach ($produk_rand2 as $m) { ?>
                    <th rowspan="2">C<?php echo $g;
                                      $g++ ?></th>
                  <?php } ?>
                </tr>
                <tr class="text-center">
                  <?php foreach ($produk_rand2 as $nm1) { ?>
                    <th><?php $cn_jumlah[] = $nm1['jumlah'];
                        echo $nm1['jumlah'] ?></th>
                    <th><?php $cn_harga[] = $nm1['harga'];
                        echo $nm1['harga'] ?></th>
                  <?php } ?>
                </tr>
              </thead>
              <tbody>
                <?php $no = 1;
                $tcnm0 = 0;
                $tcnm = 0 ?>
                <?php foreach ($produk as $key) { ?>
                  <tr class="text-center">
                    <td class="align-middle"><?= $no ?></td>
                    <td class="text-left align-middle"><?= $key->item_produk ?></td>
                    <td class="align-middle"><?= $key->jumlah ?></td>
                    <td class="align-middle"><?= $key->harga ?></td>
                    <?php $no++ ?>
                    <?php $l = 0;
                    $tcnm = array(); ?>
                    <?php foreach ($produk_rand2 as $k) { ?>
                      <td class="align-middle" colspan="2">
                        <?php
                        $hnm[$l] = manhattan($l, $key->jumlah, $key->harga, $cn_jumlah, $cn_harga);
                        $hcnm[$l] = $hnm[$l];
                        ?>
                      </td>
                      <?php $l++ ?>
                    <?php } ?>
                    <?php for ($i = 0; $i < COUNT($hcnm); $i++) { ?>
                      <?php if ($hcnm[$i] == MIN($hcnm)) {
                        echo "<td class='align-middle bg-success text-white font-weight-bold'>1</td>";
                        $cnm = $i + 1;
                        $q = "insert into centroid_temp(jenis,iterasi,c) values('NM',1,'c" . $cnm . "')";
                        $this->db->query($q);
                      } else {
                        echo "<td class='align-middle'>0</td>";
                      }
                      ?>
                    <?php } ?>
                    <?php
                    for ($j = 0; $j < COUNT($hcnm); $j++) {
                      $tcnm0 = $tcnm0 + $hcnm[$j];
                      $ttcnm[] = $tcnm0;
                    }
                    ?>
                  </tr>
                <?php } ?>
                <tr class="text-center">
                  <td class="align-middle" colspan="4"><b>TOTAL</b></td>
                  <td class="align-middle" colspan="13"><b><?php echo $tcnm0 ?></b></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      </br>
      <hr>
      </br>

      <!--menghitung selisih-->
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-dark"><i class="fa fa-table"></i> Selisih antara Non-Medoids dengan Medoids</h6>
        </div>
        <div class="card-body">
          <table class="table table-bordered">
            <tr>
              <th width="30%">Total Medoids</th>
              <td><?= round($tc0, 4) ?></td>
            </tr>
            <tr>
              <th>Total Non Medoids</th>
              <td><?= round($tcnm0, 4) ?></td>
            </tr>
            <tr>
              <th>Selisih</th>
              <?php $selisih = $tcnm0 - $tc0 ?>
              <td><?= round($selisih, 4) ?></td>
            </tr>
          </table>
        </div>
      </div>
      </br>

      <?php $n = "insert into hasil_iterasi(iterasi,total_medoids,total_non_medoids,selisih) values(1," . $tc0 . "," . $tcnm0 . "," . $selisih . ")";
      $this->db->query($n); ?>
      <?php
      if ($selisih < 0) {
        //#################################################################
        //lakukan perulangan jika selisih < 0
        $iterasi = 1;
        do {
          $hasil_iterasi = $this->m_klaster->getIterasi($iterasi);
      ?>
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h4 class="h5 mb-0 text-gray-800"><i class="icon-copy dw dw-analytics-11"></i> Data Pengelompokan Iterasi Ke-<?php echo $iterasi + 1 ?></h4>
          </div>

          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-dark"><i class="fa fa-table"></i> Hasil Medoids</h6>
            </div>

            <div class="card-body">
              <div class="alert alert-info">Dikarenakan hasil selisih antara Medoids dengan Non-Medoids di bawah 0, maka hasil dari Non-Medoids dijadikan sebagai Medoids dan dibentuk perhitungan untuk Non-Medoids baru.</div>
              <div class="alert alert-warning font-weight-bold">
                Hasil Medoids Sebelumnya:
                <?php
                foreach ($hasil_iterasi as $key) {
                  echo $medoids = $key->total_non_medoids;
                }
                ?>
              </div>
            </div>
          </div>
          </br>

          <!-- non medoids -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-dark"><i class="fa fa-table"></i> Centroid Non Medoids</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                  <thead class="bg-light-blue text-dark">
                    <tr class="text-center">
                      <th>Centroid ke-</th>
                      <th>Item Produk</th>
                      <th>Jumlah</th>
                      <th>harga (*1000)</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $qs = $this->db->query("SELECT klaster FROM options");
                    $cc = $qs->getResultObject();
                    foreach ($cc as $twr) {
                      $jumlah_klaster = $twr->klaster;
                    }
                    $produk_rand3[$iterasi] = $this->m_klaster->getProdukRand($jumlah_klaster);
                    $no = 1 ?>
                    <?php foreach ($produk_rand3[$iterasi] as $m1) { ?>
                      <tr class="text-center">
                        <td><?= $no ?></td>
                        <td class="text-left"><?= $m1['item_produk'] ?></td>
                        <td><?= $jmlh = $m1['jumlah'] ?></td>
                        <td><?= $hrga = $m1['harga'] ?></td>
                        <?php $itr = $iterasi + 2 ?>
                        <?php $centroid3 = "insert into centroid(fk_id_processing,jumlah,harga,tahapan,c) values(" . $m1['id_processing'] . "," . $jmlh . "," . $hrga . "," . $itr . ",'c" . $no . "')";
                        $this->db->query($centroid3);
                        ?>
                      </tr>
                      <?php $no++ ?>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <br>

          <!--iterasi non medoids-->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-dark"><i class="fa fa-table"></i> Iterasi Non Medoids</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                  <thead class="bg-light-blue text-dark">
                    <tr class="text-center">
                      <th rowspan="2">No</th>
                      <th rowspan="2">Item Produk</th>
                      <th rowspan="2">Jumlah</th>
                      <th rowspan="2">Harga (*1000)</th>
                      <?php $ct = 1 ?>
                      <?php foreach ($produk_rand3[$iterasi] as $m) { ?>
                        <th colspan="2">Centroid <?= $ct;
                                                  $ct++ ?></th>
                      <?php } ?>
                      <?php $d = 1 ?>
                      <?php foreach ($produk_rand3[$iterasi] as $m) { ?>
                        <th rowspan="2">C<?= $d;
                                          $d++ ?></th>
                      <?php } ?>
                    </tr>
                    <tr class="text-center">
                      <?php
                      foreach ($produk_rand3[$iterasi] as $m1) { ?>
                        <th><?php ${'jumlah_' . $iterasi}[] = $m1['jumlah'];
                            echo $m1['jumlah'] ?></th>
                        <th><?php ${'harga_' . $iterasi}[] = $m1['harga'];
                            echo $m1['harga'] ?></th>
                      <?php } ?>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $no = 1;
                    $tcs0 = 0;
                    $tc = 0 ?>
                    <?php foreach ($produk as $key) { ?>
                      <tr class="text-center">
                        <td class="align-middle"><?= $no ?></td>
                        <td class="text-left align-middle"><?= $key->item_produk ?></td>
                        <td class="align-middle"><?= $key->jumlah ?></td>
                        <td class="align-middle"><?= $key->harga ?></td>
                        <?php $no++ ?>
                        <?php $e = 0;
                        $tc = array(); ?>
                        <?php foreach ($produk_rand3[$iterasi] as $k) { ?>
                          <td class="align-middle" colspan="2"><?php $hm[$e] = abs((($key->jumlah - ${'jumlah_' . $iterasi}[$e])) - (($key->harga - ${'harga_' . $iterasi}[$e])));
                                                                echo $hm[$e];
                                                                $hc[$e] = $hm[$e]; // $tc[$e] = array_sum($hc[$e]);
                                                                ?>
                          </td>
                          <?php $e++ ?>
                        <?php } ?>
                        <?php for ($i = 0; $i < COUNT($hc); $i++) { ?>
                          <?php if ($hc[$i] == MIN($hc)) { ?>
                            <td class='align-middle bg-success text-white font-weight-bold'>1</td>
                          <?php
                            $cm = $i + 1;
                            $it = $iterasi + 1;
                            $q = "insert into centroid_temp(jenis,iterasi,c) values('NM'," . $it . ",'c" . $cm . "')";
                            $this->db->query($q);
                          } else {
                            echo "<td>0</td>";
                          }
                          ?>
                        <?php } ?>
                        <?php
                        for ($j = 0; $j < COUNT($hc); $j++) {
                          $tcs0 = $tcs0 + $hc[$j];
                          $ttc[] = $tcs0;
                        }
                        ?>
                      </tr>
                    <?php } ?>
                    <tr class="text-center">
                      <td class="align-middle" colspan="4"><b>TOTAL</b></td>
                      <td class="align-middle" colspan="12"><b><?= end($ttc) ?></b></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          </br>
          <hr>
          </br>

          <!--menghitung selisih-->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-dark"><i class="fa fa-table"></i> Selisih antara Non-Medoids dengan Medoids</h6>
            </div>
            <div class="card-body">
              <table class="table table-bordered">
                <tr>
                  <th width="30%">Total Medoids</th>
                  <td><?= $medoids ?></td>
                </tr>
                <tr>
                  <th>Total Non Medoids</th>
                  <td><?= $tcs0 ?></td>
                </tr>
                <tr>
                  <th>Selisih</th>
                  <?php $selisihs = $tcs0 - $medoids ?>
                  <td><?= $selisihs ?></td>
                </tr>
              </table>
              <?php $n = "insert into hasil_iterasi(iterasi,total_medoids,total_non_medoids,selisih) values(" . $it . "," . $medoids . "," . $tcs0 . "," . $selisihs . ")";
              $this->db->query($n); ?>
            </div>
          </div>
          </br>
          <!--############################################################--->
      <?php
          $iterasi++;
        } while ($selisihs < 0);
      }

      ?>
      <div class="card shadow my-4">
        <div class="card-body">
          <div class="row px-4">
            <div class="alert alert-primary my-3" role="alert">
              <?php $tahapans = $this->m_klaster->getTahapan(); ?>
              Proses iterasi berakhir pada tahap ke-<?= $tahapans ?>, Iterasi ke-<?php if ($tahapans - 1 == 0) {
                                                                                    echo 1;
                                                                                  } else {
                                                                                    echo $tahapans - 1;
                                                                                  } ?>, karena nilai total non medoids - total medoids = > 0
            </div>
            <br>
          </div>
        </div>
      </div>
      <br>
      <br>
      <br>
      <?php
      //inisiaslisasi untuk hasil pengelompokkan dan pengujian
      $this->db->query("TRUNCATE TABLE hasil_klaster");
      $this->db->query('TRUNCATE TABLE hasil_pengujian');
      $centroid_temp_by_iterasi = $this->m_klaster->getCentroidTempByIterasi();
      $centroid_temp_by_c = $this->m_klaster->getCentroidTempByC();
      //pengujian klaster dengan si()
      $hasilByC = $this->m_klaster->getHasilKlasterGroup();
      ?>

      <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h4 class="h5 mb-0 text-gray-800"><i class="icon-copy dw dw-analytics-11"></i> Hasil Pengelompokkan </h4>
      </div>

      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-dark"><i class="fa fa-table"></i> Hasil Pengelompokan</h6>
        </div>
        <div class="card-body">
          <?php foreach ($centroid_temp_by_c as $val) {
            $c[] = $val->c;
          }
          ?>
          <?php foreach ($centroid_temp_by_iterasi as $key) {
            if ($key->it == 1) {
              $it = $key->it;
              $q2 = $this->db->query("select id, jenis, c, iterasi from centroid_temp where iterasi=" . $it);
              foreach ($q2->getResultObject() as $vil) {
                $hasil_q2[] = $vil->c;
              }
            }
            if ($key->it == 2) {
              $it = $key->it - 1;
              $q2 = $this->db->query("select id, jenis, c, iterasi from centroid_temp where iterasi=$it and jenis='NM'");
              foreach ($q2->getResultObject() as $vil) {
                $hasil_q2[] = $vil->c;
              }
            } else {
              $it = $key->it - 1;
              $q2 = $this->db->query("select id, jenis, c, iterasi from centroid_temp where iterasi=" . $it);
              foreach ($q2->getResultObject() as $vil) {
                $hasil_q2[] = $vil->c;
              }
            }
          } ?>

          <?php $no = 0 ?>
          <div class="table-responsive">
            <table class="data-table table hover multiple-select-row nowrap" width="100%" cellspacing="0">
              <thead class="bg-light-blue text-dark">
                <tr align="center">
                  <th width="5%">No</th>
                  <th>Item Produk</th>
                  <?php for ($i = 0; $i < count($c); $i++) { ?>
                    <th width="5%"><?php echo strtoupper($c[$i]); ?></th>
                  <?php } ?>
                  <th>Jumlah Pembelian</th>
                  <th>Harga</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($produk as $key) { ?>
                  <tr align="center">
                    <td class="align-middle"><?= $no + 1 ?></td>
                    <td class="align-middle text-left"><?= $key->item_produk ?></td>
                    <?php for ($k = 0; $k < count($c); $k++) { ?>
                      <?php if ($hasil_q2[$no] == $c[$k]) { ?>
                        <td class='align-middle bg-success text-white font-weight-bold'>1</td>
                        <?php $kk = $k + 1; ?>
                        <?php $q3 = "insert into hasil_klaster(fk_id_processing,c) values(" . $key->id_processing . ",'c" . $kk . "')";
                        $this->db->query($q3); ?>
                      <?php } else {
                        echo "<td>0</td>";
                      } ?>
                    <?php } ?>
                    <td class="align-middle"><?= $key->jumlah ?></td>
                    <td class="align-middle"><?= strval(number_format($key->harga * 1000, 0, '', '.')) ?></td>
                  </tr>
                  <?php $no++ ?>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div><br>





      <!--PENGUJIAN KLASTER DENGAN SI-->
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-dark"><i class="fa fa-table"></i> Perhitungan Pengujian Silhouette Coefficient(si)</h6>
        </div>
        <div class="card-body">
          <button id="lihat1" class="btn btn-sm btn-outline-primary mb-3">Lihat</button>
          <span id="pengujian-si">
            <div class="alert alert-info mb-2">Untuk mengetahui akurasi klaster yang telah dibuat menggunakan pengujian Silhouette Coefficient(si).</div>
            <?php foreach ($hasilByC as $vil) { ?>
              <?php unset($c_jumlah); ?>
              <?php unset($c_harga); ?>
              <?php $kondisiC  = $vil->c; ?>

              <?php $qt2 = $this->db->query('SELECT hasil_klaster.c as c, hasil_processing.jumlah as jumlah, hasil_processing.harga as harga, hasil_processing.item_produk as item FROM hasil_klaster INNER JOIN hasil_processing ON hasil_klaster.fk_id_processing = hasil_processing.id_processing WHERE c="' . $kondisiC . '"'); ?>

              <?php foreach ($qt2->getResultObject() as $vel) {
                $c_jumlah[] = $vel->jumlah;
                $c_harga[] = $vel->harga;
              } ?>

              <div class="text-center mb-4 alert-warning">
                <h5 class="font-weight-bold py-4 my-4">Hasil Perhitungan Jarak Ke Klaster Ke-<?= substr($vil->c, -1); ?></h5>
              </div>
              <?php unset($hp) ?>
              <?php foreach ($hasilByC as $key) { ?>
                <div class="mt-4 mb-4">
                  <h5 class="font-weight-bold">Klaster ke-<?= $clus = substr($key->c, -1); ?></h5>
                </div>

                <?php $q = $this->db->query('SELECT hasil_klaster.c as c, hasil_processing.jumlah as jumlah, hasil_processing.harga as harga, hasil_processing.item_produk as item FROM hasil_klaster INNER JOIN hasil_processing ON hasil_klaster.fk_id_processing = hasil_processing.id_processing WHERE c="' . $key->c  . '"'); ?>

                <?php $no = 0; ?>
                <div class="table-responsive">
                  <table class="data-table table hover multiple-select-row nowrap" id="dataTable" width="100%" cellspacing="0">
                    <thead class="bg-light-blue text-dark">
                      <tr align="center">
                        <th width="5%">No</th>
                        <th>Item Produk</th>
                        <th>Jumlah</th>
                        <th>Harga (*1000)</th>
                        <?php $jarak = 0; ?>
                        <?php for ($i = 0; $i < count($c_jumlah); $i++) { ?>
                          <th>Jarak ke-<?= $i + 1 ?></th>
                        <?php } ?>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $cc = 0; ?>
                      <?php foreach ($q->getResultArray() as $val) { ?>
                        <tr align="center">
                          <td class="align-middle"><?= $no + 1 ?></td>
                          <td class="align-middle text-left"><?= $val['item'] ?></td>
                          <td class="align-middle"><?php echo $val['jumlah'] ?></td>
                          <td class="align-middle"><?php echo $val['harga'] ?></td>
                          <?php for ($i = 0; $i < count($c_jumlah); $i++) { ?>
                            <td class="align-middle">
                              <?php $ccc = sqrt(pow(($c_jumlah[$i] - $val['jumlah']), 2) + pow(($c_harga[$i] - $val['harga']), 2)) ?>
                              <?php echo $ccc ?>
                              <?php $cc = $cc + $ccc ?>
                              <br>
                            </td>
                          <?php } ?>
                          <?php $no++ ?>
                        </tr>
                      <?php } ?>
                      <?php $jml = count($c_jumlah) ?>
                      <tr>
                        <td>Total: <?= $cc ?></td>
                        <td colspan="<?= $jml + 4 ?>" align="right"><b>Rata-rata</b></td>
                        <td><b><?= $hp[] = $cc / ($no * $jml); ?></b></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <?php $cc++ ?>
              <?php } ?>

              <table class="data-table table hover multiple-select-row nowrap mt-4 mb-4">
                <thead class="bg-light-blue text-dark">
                  <tr align="center">
                    <th>a(i)</th>
                    <th>b(i)</th>
                    <th>S(i)</th>
                  </tr>
                </thead>
                <tbody>
                  <tr align="center">
                    <td><?= $a1[] = $hp[substr($vil->c, -1) - 1];
                        $ai = $hp[substr($vil->c, -1) - 1]; ?></td>
                    <td>
                      <?php $ckkk = array($ai) ?>
                      <?php $array = array_diff($hp, $ckkk);
                      print_r($array);
                      echo $bi = min($array) ?>
                    </td>
                    <td><?= $si[] = ($bi - $ai) / (MAX($bi, $ai)) ?></td>
                  </tr>
                </tbody>
              </table>
            <?php } ?>
            <?php for ($o = 0; $o < count($si); $o++) {
              $q3 = "insert into hasil_pengujian(c,si) values(" . $o . "," . $si[$o] . ")";
              $this->db->query($q3);
            } ?>
          </span>
          <button id="tutup1" class="btn btn-sm btn-outline-primary mb-3">
            <i class="fa fa-ban"></i> Tutup
          </button>
        </div>
      </div>
      </br>
      </br>




      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-dark"><i class="fa fa-table"></i> Hasil Pengujian Pengelompokan Menggunakan Silhouette Coefficient</h6>
        </div>
        <div class="card-body">
          <span id="hasil-si">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead class="bg-light-blue text-dark">
                <tr align="center">
                  <th width="5">No</th>
                  <th>Klaster ke-</th>
                  <th>S(i)</th>
                  <th>Struktur</th>
                </tr>
              </thead>
              <tbody>
                <?php $qq = $this->db->query('SELECT id, si FROM hasil_pengujian'); ?>
                <?php $hasil = $qq->getResultObject() ?>
                <?php $no = 1;
                $jmlsi = 0 ?>
                <?php foreach ($hasil as $key) { ?>
                  <tr align="center">
                    <td><?php echo $no ?></td>
                    <td><?php echo $key->id ?></td>
                    <td><?php echo $key->si;
                        $jmlsi = $jmlsi + $key->si;
                        $jms = $key->si; ?></td>
                    <?php $no++ ?>
                    <td>
                      <?php
                      if ($jms >= 0.7 and $jms <= 1) {
                        $tampil = "CLUSTERING STRUKTUR KUAT";
                      } else if ($jms >= 0.5) {
                        $tampil = "CLUSTERING STRUKTUR SEDANG";
                      } else if ($jms >= 0.25) {
                        $tampil = "CLUSTERING STRUKTUR LEMAH";
                      } else {
                        $tampil = "CLUSTERING TIDAK TERSTRUKTUR";
                      }
                      echo $tampil;
                      ?>
                    </td>
                  </tr>
                <?php } ?>
                <tr align="center">
                  <th colspan="2">Jumlah</th>
                  <th colspan="2"><?php echo $jmlsi ?></th>
                </tr>
                <tr align="center">
                  <th colspan="2">Rata-rata</th>
                  <th colspan="2"><?php echo $rt2 = $jmlsi / count($hasil) ?></td>
                </tr>
                <tr align="center">
                  <th colspan="2">Hasil</th>
                  <th colspan="2">
                    <?php
                    if ($rt2 >= 0.7 and $rt2 <= 1) {
                      $tampils = 'CLUSTERING STRUKTUR KUAT';
                    } else if ($rt2 >= 0.5) {
                      $tampils = 'CLUSTERING STRUKTUR SEDANG';
                    } else if ($rt2 >= 0.25) {
                      $tampils = 'CLUSTERING STRUKTUR LEMAH';
                    } else {
                      $tampils = 'CLUSTERING TIDAK TERSTRUKTUR';
                    }
                    echo "$tampils <a href='#' data-toggle='modal' data-target='#range-si' type='button'><i class='icon-copy ion-information-circled'></i></a>";
                    ?>

                    <!-- modal range-si -->
                    <div class="modal fade" id="range-si" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h6 class="modal-title" id="myLargeModalLabel">Tabel Nilai Silhoutte Kaufman</h6>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                          </div>
                          <div class="modal-body">
                            <table class="table table-bordered">
                              <tr>
                                <th>Nilai Silhoutte Coefficient</th>
                                <th>Struktur</th>
                              </tr>
                              <tr>
                                <td>0,7 < S(i) <=1</td>
                                <td>Struktur Kuat</td>
                              </tr>
                              <tr>
                                <td>0,5 < S(i) < 0.7</td>
                                <td>Struktur Sedang</td>
                              </tr>
                              <tr>
                                <td>0,25 < S(i) < 0.5</td>
                                <td>Struktur Lemah</td>
                              </tr>
                              <tr>
                                <td>S(i) < 0.25</td>
                                <td>Tidak Terstruktur</td>
                              </tr>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                  </th>
                </tr>
              </tbody>
            </table>
          </span>
        </div>
      </div>
      </br>
    </span>
    </br>




    <div class="row">
      <div class="col-xl-12 mb-30">
        <div class="card-box height-100-p pd-20">
          <h2 class="h4 mb-20">Grafik Penyebaran</h2>
          <figure class="highcharts-figure">
            <div id="container"></div>
            <p class="highcharts-description">
              <?php
              $query = $this->db->query('SELECT max(tahapan) as tahapan FROM centroid');
              $hasil = $query->getResultObject();
              foreach ($hasil as $t) {
                $tahapan = $t->tahapan;
              }
              ?>
              <?php $q2 = $this->db->query("SELECT c, jumlah, harga FROM centroid where tahapan=$tahapan-1"); ?>
              <?php $b = $q2->getResultObject(); ?>
            <table class="table table-bordered">
              <tr>
                <th>Centroid Medoids -</th>
                <th>Jumlah (x)</th>
                <th>Harga (y)</th>
              </tr>
              <?php foreach ($b as $l) { ?>
                <tr>
                  <td><?= $l->c ?></td>
                  <td><?= $l->jumlah ?></td>
                  <td><?= $l->harga ?></td>
                </tr>
              <?php } ?>
            </table>
            </p>
          </figure>
        </div>
      </div>
    </div>
    <br>


    <?php
    $max = "SELECT hasil_klaster.c as c, hasil_processing.jumlah as jumlah FROM hasil_klaster INNER JOIN hasil_processing ON hasil_klaster.fk_id_processing = hasil_processing.id_processing order by jumlah desc limit 1";
    $min = "SELECT hasil_klaster.c as c, hasil_processing.jumlah as jumlah FROM hasil_klaster INNER JOIN hasil_processing ON hasil_klaster.fk_id_processing = hasil_processing.id_processing order by jumlah asc limit 1";

    $pilihmaxgbn = '';
    if ($data_analisis == 'banyak') {
      //mendapatkan klaster yang tertinggi nilainya
      $varb = $max;
    } elseif ($data_analisis == 'sedikit') {
      //mendapatkan klaster yang terendah nilainya
      $varb = $min;
    } else {
      $varb = $min;
      $hasilsmaxgbn = $this->db->query($max)->getResultObject();
      //jika yang dipilih banyak dalam gabungan
      foreach ($hasilsmaxgbn as $ttt) {
        $pilihmaxgbn = $ttt->c;
      }
    }

    //jika yang dipilih antra sedikit atau banyak, dan juga untuk yang sedikit dalam gabungan
    $hasils = $this->db->query($varb)->getResultObject();
    foreach ($hasils as $tt) {
      $pilih = $tt->c;
    }

    //menampilkan produk yang terdapat pada klaster yang dipilih sebelumnya
    $queryss = $this->db->query("SELECT hasil_klaster.c as c, hasil_processing.jumlah as jumlah, hasil_processing.harga as harga, hasil_processing.item_produk as item FROM hasil_klaster INNER JOIN hasil_processing ON hasil_klaster.fk_id_processing = hasil_processing.id_processing where c='$pilih' or c='$pilihmaxgbn'");
    $hasilss = $queryss->getResultArray(); ?>

    <div class="row">
      <div class="col-xl-12 mb-30">
        <div class="card-box height-100-p pd-20">
          <h2 class="h4 mb-20">Diagram Tabel klaster</h2>
          <figure class="highcharts-figure">
            <div id="diagram_btg"></div>
            <p class="highcharts-description">
            <table class="table table-bordered">
              <tr>
                <th class="text-center">Cluster</th>
                <th class="text-center">Item Produk</th>
                <th class="text-center">Jumlah</th>
                <th class="text-center">Harga</th>
              </tr>
              <?php for ($i = 1; $i <= COUNT($b); $i++) { ?>
                <?php $q3 = $this->db->query("SELECT hasil_klaster.c as c, hasil_processing.jumlah as jumlah, hasil_processing.harga as harga, hasil_processing.item_produk as item FROM hasil_klaster INNER JOIN hasil_processing ON hasil_klaster.fk_id_processing = hasil_processing.id_processing where c = 'c$i' ORDER BY jumlah ASC"); ?>
                <?php $cc = $q3->getResultObject(); ?>

                <?php $q4 = $this->db->query("SELECT si from hasil_pengujian where id = " . $i); ?>
                <?php $ccd = $q4->getResultObject(); ?>
                <tr style="<?php if (('c' . $i == $pilih) || ('c' . $i == $pilihmaxgbn)) {
                              echo 'background-color:rgb(216, 227, 252);';
                            } ?>">
                  <td>Cluster <?= $i ?><br>
                    <?php foreach ($ccd as $h) { ?>
                      (si = <?= round($h->si, 4) ?>)
                    <?php } ?><br>
                    <?php if (('c' . $i == $pilih) || ('c' . $i == $pilihmaxgbn)) {
                      echo 'dianalisis';
                    } ?>
                  </td>
                  <td>
                    <?php $ll = 1 ?>
                    <?php foreach ($cc as $h) { ?>
                      <?= $ll++ . ')' . ' ' . '&nbsp&nbsp' . $h->item ?><br>
                    <?php } ?>
                  </td>
                  <td class="text-center">
                    <?php foreach ($cc as $h) { ?>
                      <?= $h->jumlah ?> <br>
                    <?php } ?>
                  </td>
                  <td class="text-right">
                    <?php foreach ($cc as $h) { ?>
                      <?= strval(number_format($h->harga * 1000, 0, '', '.')) ?> <br>
                    <?php } ?>
                  </td>
                <?php } ?>
                </tr>
            </table>
            </p>
          </figure>
        </div>
      </div>





      <?php
      //menghapus tabel view data_klaster untuk dibuat kembali
      $this->db->query('DROP VIEW data_klaster');
      $coba = array();
      foreach ($hasilss as $ttt) {
        $coba[] = $ttt['item'];
      }
      $input = $coba;
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
      //melakukan pencarian nama produk yang dipilih klaster tadi kemudian pembuatan tabel view yang akan digunakan pada tahap fp-growth nanatinya

      $this->db->query("CREATE VIEW data_klaster as SELECT id, receipt_number, tanggal, pukul, item_produk FROM data where tanggal>='$tanggal_awal' AND tanggal<='$tanggal_akhir' AND item_produk in ('$output')");
      ?>


    </div>
    <a href="<?php base_url() ?>/analisis" class="btn btn-warning btn-sm text-white"><i class="fa fa-undo"></i> Ulangi Klaster</a>
    <?php if ($rt2 >= 0.25) {  ?>
      <a href="#" id="buka_perhitungan" class="btn btn-info btn-sm"><i class="fa fa-calculator"></i> Buka Perhitungan</a>
      <a href="#" id="tutup_perhitungan" class="btn btn-danger btn-sm"><i class="fa fa-minus-circle"></i> Tutup Perhitungan</a>
      <a href="<?php base_url() ?>/analisis/asosiasi" class="btn btn-success btn-sm"><i class="fa fa-arrow-right"></i> Lanjut FP-Growth</a>
    <?php } ?>
    <br>



    <div class="card shadow my-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-dark"><i class="fa fa-table"></i> Waktu Proses</h6>
      </div>
      <div class="card-body">
        <div class="row px-4">
          <?php
          //menyimpan waktu selesai
          $time_end = microtime(true);
          //waktu eksemusi dalam detik
          $time = $time_end - $time_start;
          //memory yang digunakan dalam kilo byte
          $memory = round(memory_get_usage() / 1024, 2);
          //menampilkan waktu eksekusi dan memory yang digunakan
          echo '<pre>';
          echo "\nExecution Time: $time seconds";
          echo "\nMemory Usage: " . $memory . ' kb';
          echo '</pre>';
          ?>
        </div>
      </div>
    </div>




  </div>
</div>
</br>
</br>
<?= $this->endSection() ?>

<?= $this->section('pageScripts') ?>
<script src="<?= base_url(); ?>/src/plugins/datatables/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url(); ?>/src/plugins/datatables/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url(); ?>/src/plugins/datatables/js/dataTables.responsive.min.js"></script>
<script src="<?= base_url(); ?>/src/plugins/datatables/js/responsive.bootstrap4.min.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script src="https://code.highcharts.com/highcharts-3d.js"></script>
<!-- Datatable Setting js -->
<script src="<?= base_url(); ?>/vendors/scripts/datatable-setting.js"></script>
<script>
  Highcharts.chart('container', {
    chart: {
      type: 'scatter',
      zoomType: 'xy'
    },
    title: {
      text: 'Hasil Klaster K-Medoids'
    },
    subtitle: {
      text: 'Source: sistem'
    },
    xAxis: {
      title: {
        enabled: true,
        text: 'item (jumlah)'
      },
      startOnTick: true,
      endOnTick: true,
      showLastLabel: true
    },
    yAxis: {
      title: {
        text: 'harga (*1000)'
      }
    },
    legend: {
      layout: 'vertical',
      align: 'left',
      verticalAlign: 'top',
      x: 50,
      y: 1,
      floating: true,
      backgroundColor: Highcharts.defaultOptions.chart.backgroundColor,
      borderWidth: 1
    },
    plotOptions: {
      scatter: {
        marker: {
          radius: 5,
          states: {
            hover: {
              enabled: true,
              lineColor: 'rgb(100,100,100)'
            }
          }
        },
        states: {
          hover: {
            marker: {
              enabled: false
            }
          }
        },
        tooltip: {
          headerFormat: '<b>{series.name}</b><br>',
          pointFormat: '{point.x} item, {point.y}.000'
        }
      }
    },
    series: [
      <?php for ($i = 1; $i <= COUNT($b); $i++) { ?> {
          name: 'Cluster <?= $i ?>',
          color: 'rgba(<?= rand(10, 245) ?>, <?= rand(3 + $i, 245) ?>, <?= rand(10, 245) ?>, .5)',
          data: [
            <?php $q3 = $this->db->query("SELECT hasil_klaster.c as c, hasil_processing.jumlah as jumlah, hasil_processing.harga as harga FROM hasil_klaster INNER JOIN hasil_processing ON hasil_klaster.fk_id_processing = hasil_processing.id_processing where c = 'c$i'"); ?>
            <?php $cc = $q3->getResultObject(); ?>

            <?php foreach ($cc as $h) { ?>[<?= $h->jumlah ?>, <?= $h->harga ?>],
            <?php } ?>
          ]
        },
      <?php } ?> {
        name: 'Centroid Medoid',
        color: 'rgba(0,0,0,.9)',
        data: [
          <?php
          $query = $this->db->query('SELECT max(tahapan) as tahapan FROM centroid');
          $hasil = $query->getResultObject();
          foreach ($hasil as $t) {
            $tahapan = $t->tahapan;
          }
          ?>
          <?php $v3 = $this->db->query("SELECT jumlah, harga FROM centroid where tahapan=$tahapan-1"); ?>
          <?php $vv3 = $v3->getResultObject(); ?>
          <?php foreach ($vv3 as $g) { ?>[<?= $g->jumlah ?>, <?= $g->harga ?>],
          <?php } ?>
        ],
      },
    ]
  });

  Highcharts.chart('diagram_btg', {
    chart: {
      type: 'column',
      styledMode: true,
      options3d: {
        enabled: true,
        alpha: 15,
        beta: 15,
        depth: 50
      }
    },
    title: {
      text: 'Jumlah Item Per-Klaster'
    },
    plotOptions: {
      column: {
        depth: 50
      }
    },
    xAxis: {
      categories: [
        <?php for ($i = 1; $i <= COUNT($b); $i++) { ?>
          <?= "'Cluster $i'" ?>,
        <?php } ?>
      ]
    },
    series: [{
      data: [
        <?php for ($i = 1; $i <= COUNT($b); $i++) { ?>
          <?php $q3 = $this->db->query("SELECT hasil_klaster.c as c FROM hasil_klaster INNER JOIN hasil_processing ON hasil_klaster.fk_id_processing = hasil_processing.id_processing where c = 'c$i'");
          $cc = $q3->getResultObject();
          ?>
          <?= count($cc) ?>,
        <?php } ?>
      ],
      colorByPoint: true
    }, ]
  });
</script>

<script>
  $(document).ready(function() {
    $("#pengujian-si").hide();
    $("#tutup1").hide();
    $("#lihat1").click(function() {
      $("#pengujian-si").show();
      $("#lihat1").hide();
      $("#tutup1").show();
    });
    $("#tutup1").click(function() {
      $("#pengujian-si").hide();
      $("#lihat1").show();
      $("#tutup1").hide();
    });
    $("#kelompok-klaster").hide();
    $("#tutup3").hide();
    $("#lihat3").click(function() {
      $("#kelompok-klaster").show();
      $("#lihat3").hide();
      $("#tutup3").show();
    });
    $("#tutup3").click(function() {
      $("#kelompok-klaster").hide();
      $("#lihat3").show();
      $("#tutup3").hide();
    });
    $("#perhitungan").hide();
    $("#tutup_perhitungan").hide();
    $("#buka_perhitungan").click(function() {
      $("#perhitungan").show();
      $("#buka_perhitungan").hide();
      $("#tutup_perhitungan").show();
    });
    $("#tutup_perhitungan").click(function() {
      $("#perhitungan").hide();
      $("#buka_perhitungan").show();
      $("#tutup_perhitungan").hide();
    });
  });
</script>
<script>
  $(document).ready(function() {
    $(".preloader").fadeOut();
  })
</script>
<?= $this->endSection() ?>