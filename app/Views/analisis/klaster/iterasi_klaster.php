<?= $this->extend('/layouts/layout') ?>

<?= $this->section('css_scripts') ?>
<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>/src/styles/highcart.css">
<?= $this->endSection() ?>

<?= $this->section('main-container') ?>
<?php

use App\Models\KlasterModel;

$this->db = \Config\Database::connect();
$this->m_klaster = new KlasterModel();

//nampilin tulisan centroid 1,2,.. di bagian header tabel perhitungan
function cnto($centroid, $posisi)
{
  for ($i = 1; $i <= count($centroid); $i++) {
    $bagian2 = "Centroid ";
    if ($posisi == 1) {
      $bagian = "colspan=2";
    } else {
      $bagian = "rowspan=2";
      $bagian2 = "C";
    }
    echo '<th ' . $bagian . ' >' . $bagian2 . '' . $i . '</th>';
  }
  $i++;
}



//mendapatkan centroid untuk perhitungan manhattan
function centroids($centroidss)
{
  foreach ($centroidss as $m1) {
    $c_jumlah[] = $m1['jumlah'];
    $c_harga[] = $m1['harga'];
  }
  return array($c_jumlah, $c_harga);
}

//menampilkan centroid dan memasukkan centroid ke database
function perhitungan_centroid($centroidsss, $tahap)
{
  $sqlc1 = "INSERT INTO centroid(fk_id_processing, jumlah, harga, tahapan, c) VALUES ";
  $no = 1;
  foreach ($centroidsss as $m1) {
    echo '<tr class="text-center">
          <td>' . $no . '</td>
          <td>' . $m1['id_processing'] . '</td>
          <td class="text-left">' . $m1['item_produk'] . '</td>
          <td>' . $m1['jumlah'] . '</td>
          <td>' . $m1['harga'] . '</td>';
    $sqlc1 .= "(" . $m1['id_processing'] . "," . $m1['jumlah'] . "," . $m1['harga'] . ",$tahap,'c" . $no . "'),";
    echo '</tr>';
    $no++;
  }
  $sqlc1 = rtrim($sqlc1, ', ');
  \Config\Database::connect()->query($sqlc1);
  return $sqlc1;
}

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
                <?php perhitungan_centroid($produk_rand, 1); ?>
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
                  <?php
                  cnto($produk_rand, 1);
                  cnto($produk_rand, 2);
                  ?>
                </tr>
                <tr class="text-center">
                  <?php foreach ($produk_rand as $m1) { ?>
                    <th><?= $m1['jumlah'] ?></th>
                    <th><?= $m1['harga'] ?></th>
                  <?php }?>
                </tr>
              </thead>
              <tbody>
                <?php $sql1 = "INSERT INTO centroid_temp(jenis, iterasi, c) VALUES ";
                $no  = 1;
                $tc0 = 0;
                $tc  = 0;
                foreach ($produk as $key) { ?>
                  <tr class="text-center">
                    <td class="align-middle"><?= $no ?></td>
                    <td class="text-left align-middle"><?= $key->item_produk ?></td>
                    <td class="align-middle"><?= $key->jumlah ?></td>
                    <td class="align-middle"><?= $key->harga ?></td>
                    <?php $no++;
                    $e = 0;
                    $tc = array();
                    foreach ($produk_rand as $k) { ?>
                      <td class="align-middle" colspan="2">
                        <?php $hm[$e] = manhattan($e, $key->jumlah, $key->harga, centroids($produk_rand)[0], centroids($produk_rand)[1]);
                        $hc[$e] = $hm[$e]; ?>
                      </td>
                      <?php $e++;
                    }
                    ?>
                    <?php for ($i = 0; $i < COUNT($hc); $i++) {
                      if ($hc[$i] == MIN($hc)) {
                        echo "<td class='align-middle bg-success text-white font-weight-bold'>1</td>";
                        $cm = $i + 1;
                        $sql1 .= "('M',1,'c" . $cm . "'),";
                      } else {
                        echo "<td class='align-middle'>0</td>";
                      }
                    }

                    for ($j = 0; $j < COUNT($hc); $j++) {
                      $tc0 = $tc0 + $hc[$j];
                      $ttc[] = $tc0;
                    }
                    ?>
                  </tr>
                <?php }
                $sql1 = rtrim($sql1, ', ');
                $this->db->query($sql1);
                ?>
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
      <hr><br>






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
                <?php perhitungan_centroid($produk_rand2, 2); ?>
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
                  <?php
                  cnto($produk_rand2, 1);
                  cnto($produk_rand2, 2);
                  ?>
                </tr>
                <tr class="text-center">
                  <?php foreach ($produk_rand2 as $nm1) { ?>
                    <th><?= $nm1['jumlah'] ?></th>
                    <th><?= $nm1['harga'] ?></th>
                  <?php } ?>
                </tr>
              </thead>
              <tbody>
                <?php $sql2 = "INSERT INTO centroid_temp(jenis, iterasi, c) VALUES ";
                $no = 1;
                $tcnm0 = 0;
                $tcnm = 0;
                foreach ($produk as $key) { ?>
                  <tr class="text-center">
                    <td class="align-middle"><?= $no ?></td>
                    <td class="text-left align-middle"><?= $key->item_produk ?></td>
                    <td class="align-middle"><?= $key->jumlah ?></td>
                    <td class="align-middle"><?= $key->harga ?></td>
                    <?php $no++;
                    $l = 0;
                    $tcnm = array();
                    foreach ($produk_rand2 as $k) { ?>
                      <td class="align-middle" colspan="2">
                        <?php
                        $hnm[$l] = manhattan($l, $key->jumlah, $key->harga, centroids($produk_rand2)[0], centroids($produk_rand2)[1]);
                        $hcnm[$l] = $hnm[$l];
                        ?>
                      </td>
                      <?php $l++;
                    }
                    for ($i = 0; $i < COUNT($hcnm); $i++) {
                      if ($hcnm[$i] == MIN($hcnm)) {
                        echo "<td class='align-middle bg-success text-white font-weight-bold'>1</td>";
                        $cnm = $i + 1;
                        $sql2 .= "('NM',1,'c" . $cnm . "'), ";
                      } else {
                        echo "<td class='align-middle'>0</td>";
                      }
                    }

                    for ($j = 0; $j < COUNT($hcnm); $j++) {
                      $tcnm0 = $tcnm0 + $hcnm[$j];
                      $ttcnm[] = $tcnm0;
                    }
                    ?>
                  </tr>
                <?php }
                $sql2 = rtrim($sql2, ', ');
                $this->db->query($sql2); ?>
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
      <hr></br>






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
      $this->db->query($n);

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
                      <th>No</th>
                      <th>Item Produk</th>
                      <th>Jumlah</th>
                      <th>harga (*1000)</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $qs = $this->db->query("SELECT klaster FROM options");
                    $hasil_qs = $qs->getResultObject();
                    foreach ($hasil_qs as $twr) {
                      $jumlah_klaster = $twr->klaster;
                    }
                    $produk_rand3[$iterasi] = $this->m_klaster->getProdukRand($jumlah_klaster);
                    $itr = $iterasi + 2;
                    perhitungan_centroid($produk_rand3[$iterasi], $itr);
                    ?>
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
                      <?php
                      cnto($produk_rand3[$iterasi], 1);
                      cnto($produk_rand3[$iterasi], 2);
                      ?>
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
                    <?php $sql3 = "INSERT INTO centroid_temp(jenis,iterasi,c) VALUES";
                    $no = 1;
                    $tcs0 = 0;
                    $tc = 0; 
                    foreach ($produk as $key) { ?>
                      <tr class="text-center">
                        <td class="align-middle"><?= $no ?></td>
                        <td class="text-left align-middle"><?= $key->item_produk ?></td>
                        <td class="align-middle"><?= $key->jumlah ?></td>
                        <td class="align-middle"><?= $key->harga ?></td>
                        <?php $no++;
                        $e = 0;
                        $tc = array();
                        foreach ($produk_rand3[$iterasi] as $k) { ?>
                          <td class="align-middle" colspan="2"><?php $hm[$e] = abs((($key->jumlah - ${'jumlah_' . $iterasi}[$e])) - (($key->harga - ${'harga_' . $iterasi}[$e])));
                                                                echo $hm[$e];
                                                                $hc[$e] = $hm[$e];
                                                                ?>
                          </td>
                          <?php $e++;
                        }
                        for ($i = 0; $i < COUNT($hc); $i++) {
                          if ($hc[$i] == MIN($hc)) { ?>
                            <td class='align-middle bg-success text-white font-weight-bold'>1</td>
                          <?php
                            $cm = $i + 1;
                            $it = $iterasi + 1;
                            $sql3 .= "('NM'," . $it . ",'c" . $cm . "'),";
                          } else {
                            echo "<td>0</td>";
                          }
                        }

                        for ($j = 0; $j < COUNT($hc); $j++) {
                          $tcs0 = $tcs0 + $hc[$j];
                          $ttc[] = $tcs0;
                        }
                        ?>
                      </tr>
                    <?php }
                    $sql3 = rtrim($sql3, ', ');
                    $this->db->query($sql3);
                    ?>
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
          foreach ($centroid_temp_by_iterasi as $key) {
            $jika2 = "";
            if ($key->it == 1) {
              $it = $key->it;
            } else if ($key->it == 2) {
              $it = $key->it - 1;
              $jika2 = " and jenis='NM'";
            } else {
              $it = $key->it - 1;
            }
            $query2 = $this->db->query('SELECT id, jenis, c, iterasi from centroid_temp where iterasi=' . $it . '' . $jika2);
            foreach ($query2->getResultObject() as $vil) {
              $hasil_q2[] = $vil->c;
            }
          }
          ?>

          <?php $no = 0 ?>
          <div class="table-responsive">
            <table class="data-table table hover multiple-select-row nowrap" width="100%" cellspacing="0">
              <thead class="bg-light-blue text-dark">
                <tr class="text-center">
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
                <?php $sql4 = "INSERT INTO hasil_klaster(fk_id_processing,c) VALUES";
                foreach ($produk as $key) { ?>
                  <tr class="text-center">
                    <td class="align-middle"><?= $no + 1 ?></td>
                    <td class="align-middle text-left"><?= $key->item_produk ?></td>
                    <?php for ($k = 0; $k < count($c); $k++) {
                      if ($hasil_q2[$no] == $c[$k]) { ?>
                        <td class='align-middle bg-success text-white font-weight-bold'>1</td>
                        <?php $kk = $k + 1; ?>
                        <?php
                        $sql4 .= "(" . $key->id_processing . ",'c" . $kk . "'),";
                        ?>
                      <?php } else {
                        echo "<td>0</td>";
                      }
                    }
                    ?>
                    <td class="align-middle"><?= $key->jumlah ?></td>
                    <td class="align-middle"><?= strval(number_format($key->harga * 1000, 0, '', '.')) ?></td>
                  </tr>
                  <?php $no++ ?>
                <?php }
                $sql4 = rtrim($sql4, ', ');
                $this->db->query($sql4);
                ?>
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
            <?php foreach ($hasilByC as $vil) {
              unset($c_jumlah);
              unset($c_harga);
              $kondisiC  = $vil->c;
            ?>

              <?php $qt2 = $this->db->query('SELECT hasil_klaster.c as c, hasil_processing.jumlah as jumlah, hasil_processing.harga as harga, hasil_processing.item_produk as item FROM hasil_klaster INNER JOIN hasil_processing ON hasil_klaster.fk_id_processing = hasil_processing.id_processing WHERE c="' . $kondisiC . '"'); ?>

              <?php foreach ($qt2->getResultObject() as $vel) {
                $c_jumlah[] = $vel->jumlah;
                $c_harga[] = $vel->harga;
              } ?>

              <div class="text-center mb-4 alert-warning">
                <h5 class="font-weight-bold py-4 my-4">Hasil Perhitungan Jarak Ke Klaster Ke-<?= substr($vil->c, -1); ?></h5>
              </div>
              <?php unset($hp);
              foreach ($hasilByC as $key) { ?>
                <div class="mt-4 mb-4">
                  <h5 class="font-weight-bold">Klaster ke-<?= $clus = substr($key->c, -1); ?></h5>
                </div>

                <?php $q = $this->db->query('SELECT hasil_klaster.c as c, hasil_processing.jumlah as jumlah, hasil_processing.harga as harga, hasil_processing.item_produk as item FROM hasil_klaster INNER JOIN hasil_processing ON hasil_klaster.fk_id_processing = hasil_processing.id_processing WHERE c="' . $key->c  . '"'); ?>

                <?php $no = 0; ?>
                <div class="table-responsive">
                  <table class="data-table table hover multiple-select-row nowrap" id="dataTable" width="100%" cellspacing="0">
                    <thead class="bg-light-blue text-dark">
                      <tr class="text-center">
                        <th width="5%">No</th>
                        <th>Item Produk</th>
                        <th>Jumlah</th>
                        <th>Harga (*1000)</th>
                        <?php $jarak = 0;
                        for ($i = 0; $i < count($c_jumlah); $i++) { ?>
                          <th>Jarak ke-<?= $i + 1 ?></th>
                        <?php } ?>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $hasilEuclidian = 0;
                      foreach ($q->getResultArray() as $val) { ?>
                        <tr class="text-center">
                          <td class="align-middle"><?= $no + 1 ?></td>
                          <td class="align-middle text-left"><?= $val['item'] ?></td>
                          <td class="align-middle"><?php echo $val['jumlah'] ?></td>
                          <td class="align-middle"><?php echo $val['harga'] ?></td>
                          <?php for ($i = 0; $i < count($c_jumlah); $i++) { ?>
                            <td class="align-middle">
                              <?php
                              $euclidian = sqrt(pow(($c_jumlah[$i] - $val['jumlah']), 2) + pow(($c_harga[$i] - $val['harga']), 2));
                              echo $euclidian;
                              $hasilEuclidian = $hasilEuclidian + $euclidian
                              ?>
                              <br>
                            </td>
                          <?php }
                          $no++ ?>
                        </tr>
                      <?php } ?>
                      <?php $jml = count($c_jumlah) ?>
                      <tr>
                        <td>Total: <?= $hasilEuclidian ?></td>
                        <td colspan="<?= $jml + 4 ?>" align="right"><b>Rata-rata</b></td>
                        <td><b><?= $hp[] = $hasilEuclidian / ($no * $jml); ?></b></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <?php $hasilEuclidian++;
              } ?>

              <table class="data-table table hover multiple-select-row nowrap mt-4 mb-4">
                <thead class="bg-light-blue text-dark">
                  <tr class="text-center">
                    <th>a(i)</th>
                    <th>b(i)</th>
                    <th>S(i)</th>
                  </tr>
                </thead>
                <tbody>
                  <tr class="text-center">
                    <td><?= $a1[] = $hp[substr($vil->c, -1) - 1];
                        $ai = $hp[substr($vil->c, -1) - 1]; ?></td>
                    <td>
                      <?php
                        $ckkk = array($ai);
                        $array = array_diff($hp, $ckkk);
                        print_r($array);
                        echo $bi = min($array);
                      ?>
                    </td>
                    <td><?= $si[] = ($bi - $ai) / (MAX($bi, $ai)) ?></td>
                  </tr>
                </tbody>
              </table>
            <?php } ?>
            <?php  $query3 = "INSERT INTO hasil_pengujian(c,si) VALUES "; ?>
            <?php for ($o = 0; $o < count($si); $o++) {
              $query3 .= "(" . $o . "," . $si[$o] . "), ";
            }
            $query3 = rtrim($query3, ', ');
            $this->db->query($query3);
            ?>
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
                <tr class="text-center">
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
                  <tr class="text-center">
                    <td><?= $no ?></td>
                    <td><?= $key->id ?></td>
                    <td><?= $key->si;
                        $jmlsi = $jmlsi + $key->si;
                        $jms = $key->si; ?>
                    </td>
                    <?php $no++ ?>
                    <td>
                      <?php
                      $sindex = ['CLUSTERING STRUKTUR KUAT', 'CLUSTERING STRUKTUR SEDANG', 'CLUSTERING STRUKTUR LEMAH', 'CLUSTERING TIDAK TERSTRUKTUR'];
                      if ($jms >= 0.7 and $jms <= 1) {
                        $tampil = $sindex[0];
                      } else if ($jms >= 0.5) {
                        $tampil = $sindex[1];
                      } else if ($jms >= 0.25) {
                        $tampil = $sindex[2];
                      } else {
                        $tampil = $sindex[3];
                      }
                      echo $tampil;
                      ?>
                    </td>
                  </tr>
                <?php } ?>
                <tr class="text-center">
                  <th colspan="2">Jumlah</th>
                  <th colspan="2"><?php echo $jmlsi ?></th>
                </tr>
                <tr class="text-center">
                  <th colspan="2">Rata-rata</th>
                  <th colspan="2"><?php echo $rt2 = $jmlsi / count($hasil) ?></td>
                </tr>
                <tr class="text-center">
                  <th colspan="2">Hasil</th>
                  <th colspan="2">
                    <?php
                    if ($rt2 >= 0.7 and $rt2 <= 1) {
                      $tampils = $sindex[0];
                    } else if ($rt2 >= 0.5) {
                      $tampils = $sindex[1];
                    } else if ($rt2 >= 0.25) {
                      $tampils = $sindex[2];
                    } else {
                      $tampils = $sindex[3];
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
              $query5 = $this->db->query('SELECT max(tahapan) as tahapan FROM centroid');
              $hasil5 = $query5->getResultObject();
              foreach ($hasil5 as $t) {
                $tahapan = $t->tahapan;
              }
              ?>
              <?php $q2 = $this->db->query("SELECT c, jumlah, harga FROM centroid where tahapan=$tahapan-1");
              $b = $q2->getResultObject(); ?>
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
      $hasilmaxgbn = $this->db->query($max)->getResultObject();
      //jika yang dipilih banyak dalam gabungan
      foreach ($hasilmaxgbn as $ttt) {
        $pilihmaxgbn = $ttt->c;
      }
    }

    //jika yang dipilih antra sedikit atau banyak, dan juga untuk yang sedikit dalam gabungan
    $cari_c = $this->db->query($varb)->getResultObject();
    foreach ($cari_c as $tt) {
      $pilih = $tt->c;
    }

    //menampilkan produk yang terdapat pada klaster yang dipilih sebelumnya
    $queryss = $this->db->query("SELECT hasil_klaster.c as c, hasil_processing.jumlah as jumlah, hasil_processing.harga as harga, hasil_processing.item_produk as item FROM hasil_klaster INNER JOIN hasil_processing ON hasil_klaster.fk_id_processing = hasil_processing.id_processing where c='$pilih' or c='$pilihmaxgbn'");
    $hasil_produk_klaster = $queryss->getResultArray(); ?>

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
              <?php for ($i = 1; $i <= COUNT($b); $i++) {
                $q3 = $this->db->query("SELECT hasil_klaster.c as c, hasil_processing.jumlah as jumlah, hasil_processing.harga as harga, hasil_processing.item_produk as item FROM hasil_klaster INNER JOIN hasil_processing ON hasil_klaster.fk_id_processing = hasil_processing.id_processing where c = 'c$i' ORDER BY jumlah ASC");

                $hasil_q3 = $q3->getResultObject();
                $q4 = $this->db->query("SELECT si from hasil_pengujian where id = " . $i);
                $hasil_q4 = $q4->getResultObject();
              ?>
                <tr style="<?php if (('c' . $i == $pilih) || ('c' . $i == $pilihmaxgbn)) {
                              echo 'background-color:rgb(216, 227, 252);';
                            } ?>">
                  <td>Cluster <?= $i ?><br>
                    <?php foreach ($hasil_q4 as $h) { ?>
                      (si = <?= round($h->si, 4) ?>)
                    <?php } ?><br>
                    <?php if (('c' . $i == $pilih) || ('c' . $i == $pilihmaxgbn)) {
                      echo 'dianalisis';
                    } ?>
                  </td>
                  <td>
                    <?php $ll = 1;
                    foreach ($hasil_q3 as $h) { ?>
                      <?= $ll++ . ')' . ' ' . '&nbsp&nbsp' . $h->item ?><br>
                    <?php } ?>
                  </td>
                  <td class="text-center">
                    <?php foreach ($hasil_q3 as $h) { ?>
                      <?= $h->jumlah ?> <br>
                    <?php } ?>
                  </td>
                  <td class="text-right">
                    <?php foreach ($hasil_q3 as $h) { ?>
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
      $anggota_item = array();
      foreach ($hasil_produk_klaster as $ttt) {
        $anggota_item[] = $ttt['item'];
      }
      $input = $anggota_item;
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
    <?php
    if ($rt2 <= 0.25) {
      echo "<p class='text-danger'>Akurasi klaster " . round($rt2, 3) . " masih sangat rendah</p>";
    }
    ?>
    <a href="<?php base_url() ?>/analisis" class="btn btn-warning btn-sm text-white"><i class="fa fa-undo"></i> Ulangi Klaster</a>
    <?php if ($rt2 > 0.25) {  ?>
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
            <?php $qq2 = $this->db->query("SELECT hasil_klaster.c as c, hasil_processing.jumlah as jumlah, hasil_processing.harga as harga FROM hasil_klaster INNER JOIN hasil_processing ON hasil_klaster.fk_id_processing = hasil_processing.id_processing where c = 'c$i'"); ?>
            <?php $hasil_qq2 = $qq2->getResultObject(); ?>

            <?php foreach ($hasil_qq2 as $h) { ?>[<?= $h->jumlah ?>, <?= $h->harga ?>],
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
          <?php $qq3 = $this->db->query("SELECT hasil_klaster.c as c FROM hasil_klaster INNER JOIN hasil_processing ON hasil_klaster.fk_id_processing = hasil_processing.id_processing where c = 'c$i'");
          $hasil_qq3 = $qq3->getResultObject();
          ?>
          <?= count($hasil_qq3) ?>,
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