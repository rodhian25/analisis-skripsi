<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title><?= $title ?></title>

  <!-- Site favicon -->
  <link rel="icon" type="image/png" href="<?= base_url(); ?>/vendors/images/favicon-16x16.png">

  <!-- Mobile Specific Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

  <!-- file css -->
  <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>/vendors/styles/core.css">
  <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>/src/plugins/datatables/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>/src/plugins/datatables/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>/vendors/styles/style.css">
  <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>/src/styles/highcart.css">
  <!-- untuk penambahan css di file lainnya -->
</head>

<body class="container my-4" style="background-color: white;">
  <?php

  function tgl_indo($tanggal)
  {
    $bulan = array(
      1 =>   'Januari',
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
    );
    $pecahkan = explode('-', $tanggal);
    return $pecahkan[2] . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[0];
  }

  function hari_indo($hari)
  {
    switch ($hari) {
      case 'Sunday':
        $hari = 'Minggu';
        break;
      case 'Monday':
        $hari = 'Senin';
        break;
      case 'Tuesday':
        $hari = 'Selasa';
        break;
      case 'Wednesday':
        $hari = 'Rabu';
        break;
      case 'Thursday':
        $hari = 'Kamis';
        break;
      case 'Friday':
        $hari = 'Jum\'at';
        break;
      case 'Saturday':
        $hari = 'Sabtu';
        break;
      default:
        $hari = 'Tidak ada';
        break;
    }
    return $hari;
  }

  ?>

  <?php $this->db = \Config\Database::connect();
  date_default_timezone_set('Asia/Jakarta'); ?>
  <p>
  <h5 class="my-2">ER-COFFEE</h5>
  <p class="row">
    <smal class="col-6">Jl. Arifin Achmad 256, Marpoyan Damai, Kota Pekanbaru, Riau</smal>
    <smal class="col-6 text-right"><?= hari_indo(date("l")) . ', ' . tgl_indo(date("Y-m-d")) . ' ' . date("H:i") ?> WIB</smal>
  </p>
  </p>
  <hr>
  <p class="text-center mb-4 h4" style="font-weight:600;">Laporan Hasil Analisis K-Medoids dan FP-Growth</p>
  <p class="mb-4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Hasil analisa laporan melalui tahapan klaster pengelompokkan data transaksi dari jumlah transaksi tanggal <span style="font-weight:600;"><?= tgl_indo($tgl->tgl_awal) ?></span> sampai tanggal <span style="font-weight:600;"><?= tgl_indo($tgl->tgl_akhir) ?></span> dan menghasilkan aturan asosiasi rekomendasi sebagai promosi. Berikut hasil tahapannya :
  </p>
  <?php
  $pilih = $cari_klaster->c;
  ?>
  <?php
  $d1 = count($data);
  $d2 = count($data_transaksi);
  ?>
  <table border="1" width="100%">
    <tr>
      <th colspan=5 style="padding:5px;"><span style="font-weight:600;">I. Jumlah Pengelompokkan Algoritma <i>K-Medoids</i></span></th>
    </tr>
    <tr>
      <th style="font-weight:600;padding:2px 8px;text-align:center;" width="5px">No</th>
      <th style="font-weight:600;padding:2px 8px;">Item</th>
      <th colspan=3 style="font-weight:600;padding:2px;text-align:center;">Jumlah</th>
    </tr>
    <tr>
      <td style="padding:2px; text-align:center;">1</td>
      <td style="padding:2px 8px;">Transaksi</td>
      <td colspan=3 style="padding:2px 8px; text-align:center;"><?= $d2 ?></td>
    </tr>
    <tr>
      <td style="padding:2px; text-align:center;">2</td>
      <td style="padding:2px 8px;">Detail Transaksi</td>
      <td colspan=3 style="padding:2px 8px; text-align:center;"><?= $d1 ?></td>
    </tr>
    <tr>
      <td style="padding:2px; text-align:center;">3</td>
      <td style="padding:2px 8px;">Item Produk</td>
      <td colspan=3 style="padding:2px 8px; text-align:center;"><?= count($hasil_klaster) ?></td>
    </tr>
    <tr>
      <td style="padding:2px; text-align:center;">4</td>
      <td style="padding:2px 8px;">Produk Terbanyak Dalam Transaksi</td>
      <?php
      $q9 = $this->db->query("SELECT sum(jumlah) as item, item_produk from data GROUP BY item_produk ORDER BY item DESC limit 1")->getResultObject();
      ?>
      <td style="padding:2px 8px; text-align:center;"><?php foreach ($q9 as $pt) {
                                                        echo $dhh = $pt->item_produk;
                                                      } ?></td>
      <td style="padding:2px 8px; text-align:center;"><?php foreach ($q9 as $pt) {
                                                        echo $pt->item;
                                                      } ?></td>
      <?php
      $q12 = $this->db->query("SELECT hasil_klaster.c as c, hasil_processing.item_produk as item, hasil_processing.jumlah as jumlah, hasil_processing.harga as harga FROM hasil_klaster INNER JOIN hasil_processing ON hasil_klaster.fk_id_processing = hasil_processing.id_processing where hasil_processing.item_produk = '$dhh'")->getResultObject();
      ?>
      <td style="padding:2px; text-align:center;">Klaster - <?php foreach ($q12 as $pt) {
                                                              echo
                                                              preg_replace("/c/", "", $pt->c);
                                                            } ?></td>
    </tr>
    <tr>
      <td style="padding:2px; text-align:center;">5</td>
      <td style="padding:2px 8px;">Produk Terendah Dalam Transaksi</td>
      <?php
      $q10 = $this->db->query("SELECT sum(jumlah) as item, item_produk from data GROUP BY item_produk ORDER BY item ASC limit 1")->getResultObject();
      ?>
      <td style="padding:2px 8px; text-align:center;"><?php foreach ($q10 as $pt) {
                                                        echo $dh = $pt->item_produk;
                                                      } ?></td>
      <td style="padding:2px 8px; text-align:center;"><?php foreach ($q10 as $pt) {
                                                        echo $pt->item;
                                                      } ?></td>
      <?php
      $q13 = $this->db->query("SELECT hasil_klaster.c as c, hasil_processing.item_produk as item, hasil_processing.jumlah as jumlah, hasil_processing.harga as harga FROM hasil_klaster INNER JOIN hasil_processing ON hasil_klaster.fk_id_processing = hasil_processing.id_processing where hasil_processing.item_produk = '$dh'")->getResultObject();
      ?>
      <td style="padding:2px; text-align:center;">Klaster - <?php foreach ($q13 as $pt) {
                                                              echo
                                                              preg_replace("/c/", "", $pt->c);;
                                                            } ?></td>
    </tr>
    <tr>
      <td style="padding:2px;text-align:center;">6</td>
      <td style="padding:2px 8px;">Klaster</td>
      <td colspan=3 style="padding:2px 8px;text-align:center;"><?php echo $ops = $options->klaster; ?></td>
    </tr>
    <tr>
      <td style="padding:2px;text-align:center;">7</td>
      <td style="padding:2px 8px;">Hasil Klaster yang akan di Asosiasi (dianalisis)</td>
      <td colspan=3 style="padding:2px 8px;text-align:center;"><?php echo $options->data_analisis; ?> di beli</td>
    </tr>
    <tr>
      <td style="padding:2px; text-align:center;">8</td>
      <td style="padding:2px 8px;">Iterasi</td>
      <?php
      $qs = $this->db->query("SELECT iterasi FROM hasil_iterasi order by iterasi desc limit 1")->getResultObject();
      ?>
      <td colspan=3 style="padding:2px 8px; text-align:center;"><?php foreach ($qs as $qss) {
                                                                  echo $qss->iterasi;
                                                                } ?></td>
    </tr>
    <?php for ($z = 1; $z <= $ops; $z++) { ?>
      <tr>
        <td style="padding:2px;text-align:center;"><?= $z + 8 ?></td>
        <td style="padding:2px 8px;">Klaster - <?= $z ?><span><?php if ('c' . $z == $pilih) {
                                                                echo ' (dianalisis)';
                                                              }  ?></span></td>
        <?php $q3 = $this->db->query("SELECT c, count(c) as t FROM hasil_klaster where c = 'c$z'")->getResultObject(); ?>
        <td colspan=3 style="padding:2px 8px;text-align:center;"><?php foreach ($q3 as $ct) {
                                                                    echo $ct->t;
                                                                  } ?></td>
      </tr>
    <?php } ?>
  </table>
  <br>
  <p>Hasil pengelompokkan :</p>
  <table border="1" width="100%">
    <tr>
      <th colspan=5 style="padding:5px;"><span style="font-weight:600;">II. Hasil Pengelompokkan Algoritma <i>K-Medoids</i></span></th>
    </tr>
    <tr>
      <th style="font-weight:600;padding:2px;text-align:center;">No</th>
      <th style="font-weight:600;padding:2px 8px;">Item Produk</th>
      <th style="font-weight:600;padding:2px;text-align:center;">Jumlah</th>
      <th style="font-weight:600;padding:2px;text-align:center;">Harga (*1000)</th>
      <th style="font-weight:600;padding:2px;text-align:center;">Klaster</th>
    </tr>
    <?php
    $no = 1;
    foreach ($hasil_klaster as $hk) {
    ?>
      <tr>
        <td style="padding:2px;text-align:center;"><?= $no ?></td>
        <td style="padding:2px 8px;"><?= $hk->item ?></td>
        <td style="padding:2px;text-align:center;"><?= $hk->jumlah ?></td>
        <td style="padding:2px;text-align:center;"><?= $hk->harga ?></td>
        <td style="padding:2px;text-align:center;"><?= preg_replace("/c/", "", $hk->c); ?>
          <span><?php if ($hk->c == $pilih) {
                  echo ' (dianalisis)';
                }  ?></span>
        </td>
      </tr>
      <?php $no++ ?>
    <?php } ?>
  </table>
  <br>
  <br>
  <br>
  <div class="row">

    <div class="col-xl-12 mb-30">
      <span colspan=5 style="padding:5px;"><span style="font-weight:600;">III. Hasil Pengelompokkan Algoritma <i>K-Medoids</i></span></span>
      <div class="card-box height-100-p pd-20">

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
          <table border="1" width="100%">
            <tr>
              <th style="padding:5px 8px;">Centroid Medoids -</th>
              <th style="padding:5px 8px;">Jumlah (x)</th>
              <th style="padding:5px 8px;">Harga (y)</th>
            </tr>
            <?php foreach ($b as $l) { ?>
              <tr>
                <td style="padding:5px 8px;"><?= $l->c ?><span><?php if ($l->c == $pilih) {
                                                                  echo ' (dianalisis)';
                                                                }  ?></span></td>
                <td style="padding:5px 8px;"><?= $l->jumlah ?></td>
                <td style="padding:5px 8px;"><?= $l->harga ?></td>
              </tr>
            <?php } ?>
          </table>
          </p>
        </figure>
      </div>
    </div>
  </div>
  <p colspan=5 style="padding:5px;"><span style="font-weight:600;">IV. Hasil Pengujian Sillhoutte Index (SI)</span></p>
  <p>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Hasil Pengujian menggunakan Sillhoutte Index. Sillhoutte Index (SI) mengacu pada metode interpretasi dan validasi konsistensi dalam kelompok data. Teknik ini menyediakan representasi grafis singkat tentang seberapa baik setiap objek telah dikelompokkan. Nilai Sillhoutte adalah ukuran seberapa mirip suatu objek dengan kelompoknya sendiri dibandingkan dengan kelompok lainnya.
  </p>
  <br>
  <p>Pedoman Tabel Nilai Silhoutte Kaufman :</p>
  <table border="1" width="100%">
    <tr>
      <th style="padding:2px 8px;text-align:center;">Nilai Silhoutte Coefficient</th>
      <th style="padding:2px 8px;text-align:center;">Struktur</th>
    </tr>
    <tr>
      <td style="padding:2px 8px;text-align:center;">0,7 < S(i) <=1</td>
      <td style="padding:2px 8px;text-align:center;">Struktur Kuat</td>
    </tr>
    <tr>
      <td style="padding:2px 8px;text-align:center;">0,5 < S(i) < 0.7</td>
      <td style="padding:2px 8px;text-align:center;">Struktur Sedang</td>
    </tr>
    <tr>
      <td style="padding:2px 8px;text-align:center;">0,25 < S(i) < 0.5</td>
      <td style="padding:2px 8px;text-align:center;">Struktur Lemah</td>
    </tr>
    <tr>
      <td style="padding:2px 8px;text-align:center;">S(i) < 0.25</td>
      <td style="padding:2px 8px;text-align:center;">Tidak Terstruktur</td>
    </tr>
  </table>
  <br>
  <p>
    Hasil Pengujian :
  </p>
  <table border="1" width="100%">
    <tr>
      <th style="font-weight:600;padding:2px 8px;text-align:center;" width="5px">No</th>
      <th style="font-weight:600;padding:5px 8px;">Klaster</th>
      <th style="font-weight:600;padding:5px 8px;">SI</th>
      <th style="font-weight:600;padding:5px 8px;">Keterangan</th>
    </tr>
    <?php $no = 1;
    $hb = 0;
    for ($j = 1; $j <= $ops; $j++) { ?>
      <tr>
        <td style="padding:5px 8px;"><?= $no++ ?></td>
        <td style="padding:5px 8px;">klaster <?= $j ?><?php if ('c' . $j == $pilih) {
                                                        echo ' (dianalisis)';
                                                      }  ?></span></td>
        <?php

        $q11 = $this->db->query("SELECT id, si FROM hasil_pengujian where id=$j")->getResultObject();
        ?>
        <td style="padding:5px 8px;"><?php foreach ($q11 as $ct) {
                                        echo $jms = $ct->si;
                                        $hb += $jms;
                                      } ?></td>
        <td style="padding:5px 8px;">
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
    <tr>
      <td colspan=2 style="font-weight:600;padding:2px 8px;text-align:center;">Jumlah</td>
      <td style="padding:2px 8px;"><?= $hb ?></td>
      <td style="padding:2px 8px;"> - </td>
    </tr>
    <tr>
      <td colspan=2 style="font-weight:600;padding:2px 8px;text-align:center;">Rata-rata</td>
      <td style="padding:2px 8px;"><?= $ts = $hb / $ops ?></td>
      <td style="padding:2px 8px;">
        <?php
        if ($ts >= 0.7 and $ts <= 1) {
          $tampil = "CLUSTERING STRUKTUR KUAT";
        } else if ($ts >= 0.5) {
          $tampil = "CLUSTERING STRUKTUR SEDANG";
        } else if ($ts >= 0.25) {
          $tampil = "CLUSTERING STRUKTUR LEMAH";
        } else {
          $tampil = "CLUSTERING TIDAK TERSTRUKTUR";
        }
        echo $tampil;
        ?>
      </td>
    </tr>
  </table>
  <br>
  <br>
  <p colspan=5 style="padding:5px;"><span style="font-weight:600;">V. Jumlah Transaksi setelah di klaster, Nilai minimum <i>Support</i> dan minimum <i>Confidence</i> Algoritma FP-Growth </span></p>
  <?php
  $d3 = count($data_klaster);
  $d4 = count($data_transaksi_klaster);
  ?>
  <table border="1" width="100%">
    <tr>
      <th style="font-weight:600;padding:2px 8px;text-align:center;" width="5px">No</th>
      <th style="font-weight:600;padding:5px 8px;">Item</th>
      <th colspan=2 style="font-weight:600;padding:5px 8px;text-align:center;">Jumlah</th>
    </tr>
    <tr>
      <td style="padding:5px 8px;">1</td>
      <td style="padding:5px 8px;">Transaksi setelah diklaster</td>
      <td colspan=2 style="padding:5px 8px;text-align:center;"><?= $d4 ?></td>
    </tr>
    <tr>
      <td style="padding:5px 8px;">2</td>
      <td style="padding:5px 8px;">Detail Transaksi setelah diklaster</td>
      <td colspan=2 style="padding:5px 8px;text-align:center;"><?= $d3 ?></td>
    </tr>
    <tr>
      <td style="padding:5px 8px;">3</td>
      <td style="padding:5px 8px;">Minimum <i>Support</i></td>
      <td style="padding:5px 8px;text-align:center;"><?php echo $opss = $options->support; ?> % </td>
      <td style="padding:5px 8px;text-align:center;"><?= $d4 ?> x <?= $opss ?> % = <?= round($d4 * $opss / 100, 1) ?> minimum jumlah item produk per-transaksi</td>
    </tr>
    <tr>
      <td style="padding:5px 8px;">4</td>
      <td style="padding:5px 8px;">Minimum <i>Confidence</i></td>
      <td colspan=2 style="padding:5px 8px;text-align:center;"><?php echo $opsc = $options->confidence; ?> % </td>
    </tr>
    <tr>
      <td style="padding:5px 8px;">5</td>
      <td style="padding:5px 8px;">Itemset</td>
      <td colspan=2 style="padding:5px 8px;text-align:center;">2 ~ 3</td>
    </tr>
  </table>
  <br>
  <br>


  <?php
  foreach ($datasss as $row) {
    $tanggal[$row->receipt_number] = $row->tanggal;
  }

  //mengkonversi data dari bentuk transaksi
  function converts($datasss)
  {
    $arr = array();
    foreach ($datasss as $row) {
      $v = trim(strtolower($row->item_produk));
      $arr[$row->id][$v] = $v;
    }
    return $arr;
  }
  $datass = converts($datasss);

  $min_support = doubleval($opss);

  class Fp_growth
  {
    //data transaksi sebelum di perttransaksi
    public $datass;
    //total data transaksi
    protected $total_data;
    //item/category yang ada dalam data transaksi
    protected $min_count;
    //minimal confident dalam persen
    //frequest itemset dari data transaksi
    public $frequent_itemset;


    function __construct($datass, $min_support, $d4)
    {
      $this->datass = $datass;
      $this->total_data = $d4;
      //menghitung jumlah item berdasarkan support yang diinputkan
      $this->min_count = $min_support / 100 * $d4;
      //memanggil fungsi2
      $this->frequent_itemset();
    }

    function frequent_itemset()
    {
      foreach ($this->datass as $key => $val) {
        foreach (array_unique($val) as $k => $v) {
          if (!isset($this->frequent_itemset[$v]))
            $this->frequent_itemset[$v] = 1;
          else
            $this->frequent_itemset[$v]++;
        }
      }
      // print_r($this->frequent_itemset);
      foreach ($this->frequent_itemset as $key => $val) {
        $this->categories[] = $key;
        if ($val < $this->min_count) {
          unset($this->frequent_itemset[$key]);
        } else {
          $this->support[$key] = $val / $this->total_data * 100;
        }
      }
      arsort($this->frequent_itemset);
    }
  }
  //memanggil class fpgrowth
  $f = new Fp_growth($datass, $min_support, $d4);
  ?>




  <p colspan=5 style="padding:5px;"><span style="font-weight:600;">VI. Item Produk yang digunakan dalam Asosiasi Algoritma FP-Growth </span></p>
  <table border="1" width="100%">
    <tr>
      <th style="font-weight:600;padding:2px 8px;text-align:center;" width="5px">No</th>
      <th style="font-weight:600;padding:5px 8px;">Item</th>
      <th style="font-weight:600;padding:5px 8px;text-align:center;">Jumlah</th>
      <th style="font-weight:600;padding:5px 8px;text-align:center;">Support</th>
      <th style="font-weight:600;padding:5px 8px;text-align:center;">Support (%)</th>
    </tr>
    <?php
    $no = 1;
    foreach ($f->frequent_itemset as $key => $val) { ?>
      <tr>
        <td style="padding:5px 8px;"><?= $no++ ?></td>
        <td style="padding:5px 8px;"><?= $key ?></td>
        <td style="padding:5px 8px;text-align:center;"><?= $val ?></td>
        <td style="padding:5px 8px;text-align:center;"><?= $val ?>/<?= $d4 ?> = <?= round($val / $d4, 5) ?> </td>
        <td style="padding:5px 8px;text-align:center;"><?= round($f->support[$key], 2) ?> %</td>
      </tr>
    <?php } ?>
  </table>
  <br>
  <br>
  <p colspan=5 style="padding:5px;"><span style="font-weight:600;">VII. Hasil Asosiasi Algoritma FP-Growth </span></p>
  <p>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Di dalam aturan asosiasi terdapat 3 macam pengukuran penting, yakni Support, Confidence dan Lift Rasio. <code>Support</code> (nilai penunjang) adalah persentase kombinasi item tersebut dalam database, sedangkan <code>confidence</code> (nilai kepastian) adalah kuatnya hubungan antar-item dalam aturan asosiasi. <code>Lift Ratio</code> mengukur seberapa penting rule yang telah terbentuk berdasarkan nilai support dan confidence. Lift ratio merupakan nilai yang menunjukkan kevalidan proses transaksi dan memberikan informasi apakah benar item dibeli bersamaan dengan item lainnya.
  </p><br>
  <table border="1" width="100%">
    <tr>
      <th style="font-weight:600;padding:2px 8px;text-align:center;" width="5px">No</th>
      <th style="font-weight:600;padding:5px 8px;">Rule</th>
      <th colspan=2 style="font-weight:600;padding:5px 8px;text-align:center;">Support</th>
      <th colspan=2 style="font-weight:600;padding:5px 8px;text-align:center;">Confidence</th>
      <th colspan=2 style="font-weight:600;padding:5px 8px;text-align:center;">Lift</th>
    </tr>
    <tr>
      <td style="padding:5px 8px;text-align:center;"> - </td>
      <td style="padding:5px 8px;text-align:center;"> A U B </td>
      <td colspan=2 style="padding:5px 8px;text-align:center;"> support ( A U B ) / Jumlah Transaksi </td>
      <td colspan=2 style="padding:5px 8px;text-align:center;"> support ( A U B ) / support ( A ) </td>
      <td colspan=2 style="padding:5px 8px;text-align:center;"> confidence ( B U A ) / ( support ( A ) / Jumlah Transaksi )</td>
    </tr>
    <?php $no = 1;
    foreach ($hasils as $row) { ?>
      <tr>
        <td style="padding:5px 8px;"><?= $no++ ?></td>
        <td style="padding:5px 8px;"><?= $row->left_item ?> => <?= $row->right_item ?></td>
        <td style="padding:5px 8px;text-align:center;"><?= $ut = round($row->supp * $d4) ?> / <?= $d4 ?> = <?= round($row->supp, 5) ?></td>
        <td style="padding:5px 8px;text-align:center;"><?= round($row->supp * 100, 2) ?> %</td>
        <td style="padding:5px 8px;text-align:center;"><?= $ut ?> / <?= $utt = round($ut / $row->conf) ?> = <?= round($row->conf, 5) ?></td>
        <td style="padding:5px 8px;text-align:center;"><?= round($row->conf * 100, 2) ?> %</td>
        <td style="padding:5px 8px;text-align:center;">( <?= $ut ?> / <?= round($ut / ($row->lift * ($utt / $d4))) ?> ) / ( <?= $utt ?> / <?= $d4 ?> )</td>
        <td style="padding:5px 8px;text-align:center;"><?= round($row->lift, 2) ?></td>
      </tr>
    <?php } ?>
  </table>
  <br>
  <p>Kesimpulan hasil asosiasi FP-Growth :</p>
  <table border="1" width="100%">
    <tr>
      <th style="font-weight:600;padding:2px 8px;text-align:center;" width="5px">No</th>
      <th style="font-weight:600;padding:5px 8px;">Kesimpulan Rule</th>
    </tr>
    <?php $no = 1;
    foreach ($hasils as $row) { ?>
      <tr>
        <td style="padding:5px 8px;"><?= $no++ ?></td>
        <td style="padding:5px 8px;">jika membeli <code><?= $row->left_item ?></code>, maka akan membeli <code><?= $row->right_item ?></code></td>
      </tr>
    <?php } ?>
  </table>
  <br>
  <br>
  <p colspan=5 style="padding:5px;"><span style="font-weight:600;">VIII. Paket Rekomendasi</span></p>
  <table border="1" width="100%">
    <tr>
      <th style="font-weight:600;padding:2px 8px;text-align:center;" width="5px">No</th>
      <th style="font-weight:600;padding:5px 8px;">Produk</th>
      <th style="font-weight:600;padding:5px 8px;text-align:center;">Harga</th>
      <th style="font-weight:600;padding:5px 8px;text-align:center;"> & </th>
      <th style="font-weight:600;padding:5px 8px;text-align:center;">Produk</th>
      <th style="font-weight:600;padding:5px 8px;text-align:center;">Harga</th>
    </tr>
    <?php $no = 1;
    foreach ($hasils as $row) { ?>
      <tr>
        <td style="padding:5px 8px;"><?= $no++ ?></td>
        <td style="padding:5px 8px;"><?= $row->left_item ?></td>
        <?php
        $query = $this->db->query("SELECT item_produk, (harga/jumlah) as peritem from data where item_produk in('$row->left_item') limit 1");
        $hasils = $query->getResultObject();
        ?>
        <td style="padding:5px 8px;text-align:center;"><?php foreach ($hasils as $rows) { ?>
            <?= "Rp " . number_format($rows->peritem, 0, ".", ".") ?>
          <?php } ?></td>
        <?php
        $querys = $this->db->query("SELECT item_produk, (harga/jumlah) as peritem from data where item_produk in('$row->right_item') limit 1");
        $hasilss = $querys->getResultObject();
        ?>
        <td style="padding:5px 8px;text-align:center;"> => </td>
        <td style="padding:5px 8px;"><?= $row->right_item ?></td>
        <td style="padding:5px 8px;text-align:center;"><?php foreach ($hasilss as $rows) { ?>
            <?= "Rp " . number_format($rows->peritem, 0, ".", ".") ?>
          <?php } ?></td>
      </tr>
    <?php } ?>
  </table>
  <br>
  <br>
  <span>
    <br>
    <smal style="position: absolute;
    right: 15px;"><?= hari_indo(date("l")) . ', ' . tgl_indo(date("Y-m-d")) . ' ' . date("H:i") ?> WIB</smal>
    <br>
    <br>
    <img src="<?= base_url('/vendors/images/download qrcode.png') ?>" alt="qrcode" width="120px" style="position: absolute;
    right: 60px;"><br><br><br><br><br>
    <small style="position: absolute;
    right: 45px;">Scan untuk Akses Halaman</small>
    <smal style="position: absolute;
    left: 20px;">Download by : <?= user()->username; ?> (<?= $datas->name; ?>)</smal>
  </span>

  <!-- file javascript -->
  <script src="<?= base_url(); ?>/vendors/scripts/core.js"></script>
  <script src="<?= base_url(); ?>/vendors/scripts/script.min.js"></script>
  <script src="<?= base_url(); ?>/src/plugins/datatables/js/jquery.dataTables.min.js"></script>
  <script src="<?= base_url(); ?>/src/plugins/datatables/js/dataTables.bootstrap4.min.js"></script>
  <script src="<?= base_url(); ?>/src/plugins/datatables/js/dataTables.responsive.min.js"></script>
  <script src="<?= base_url(); ?>/src/plugins/datatables/js/responsive.bootstrap4.min.js"></script>
  <script src="https://code.highcharts.com/highcharts.js"></script>
  <script src="https://code.highcharts.com/modules/exporting.js"></script>
  <script src="https://code.highcharts.com/modules/export-data.js"></script>
  <script src="https://code.highcharts.com/modules/accessibility.js"></script>
  <script src="https://code.highcharts.com/highcharts-3d.js"></script>
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
  </script>
  <script>
    setTimeout(function() {
      window.print();
    }, 800);
    window.onfocus = function() {
      setTimeout(function() {
        window.close();
      }, 800);
    }
  </script>
</body>

</html>