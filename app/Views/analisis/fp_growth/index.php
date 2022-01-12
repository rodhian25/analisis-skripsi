<?= $this->extend('/layouts/layout') ?>

<?= $this->section('css_scripts') ?>
<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>/src/styles/highcart.css">
<?= $this->endSection() ?>


<?= $this->section('main-container') ?>
<?php
ini_set('memory_limit', '10240M');
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
    <br />
    <!--end breadcrumb-->

    <?= $this->include('/layouts/loading') ?>
    <!-- Tahapan Analisis Data -->
    <?= $this->include('/layouts/tahapan') ?>
    <!-- End Tahapan Analisis Data -->


    <div class="card shadow mb-5">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-dark"><i class="fa fa-table"></i> Nilai Minimum Support dan Confidence</h6>
      </div>
      <div class="card-body">
        <?= view('Myth\Auth\Views\_message_block') ?></br>
        <span>
          <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead class="bg-light-blue text-dark">
              <tr align="center">
                <th>Minimum Support (%)</th>
                <th>Minimum Confidence (%)</th>
              </tr>
            </thead>
            <tbody>
              <tr align="center">
                <td><?= $sup ?></td>
                <td><?= $con ?></td>
              </tr>
            </tbody>
          </table>
        </span>
      </div>
    </div>
    <br>


    <span id="perhitungans">
      <div class="card shadow my-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-dark"><i class="fa fa-table"></i> Penyiapan Dataset Transaksi Hasil Klaster K-Medoids</h6>
        </div>
        <div class="card-body">
          <div class="row px-4 table-responsive">
            <table class="table hover multiple-select-row data-table-export nowrap" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>no</th>
                  <th>recepit number</th>
                  <th>tanggal</th>
                  <th>itemset</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $nos = 1;
                $totalss = 0;
                foreach ($data_ as $row) {
                  $tanggal[$row->receipt_number] = $row->tanggal;
                }
                foreach ($data as $key => $val) : ?>
                  <tr>
                    <td><?php $totalss = $nos ?><?= $nos ?></td>
                    <td><?= $key ?></td>
                    <td><?= $tanggal[$key] ?></td>
                    <td><?= implode(', ', $val) ?></td>
                  </tr>
                  <?php $nos++ ?>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div><br>


      <div class="card shadow my-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-dark"><i class="fa fa-table"></i> Frequent Itemset</h6>
        </div>
        <div class="card-body">
          <div class="row px-4 table-responsive">
            <table class="table hover multiple-select-row nowrap">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Itemset</th>
                  <th>Qty</th>
                  <th>Support</th>
                  <th>Support (%)</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 1;
                foreach ($frequent_itemset as $key => $val) { ?>
                  <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $key ?></td>
                    <td><?= $val ?></td>
                    <td><?= $val ?>/<?= $totalss ?> = <?= round($val / $totalss, 5) ?> </td>
                    <td><?= round(($val / $totalss) * 100, 2) ?>%</td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div><br>

      <div class="card shadow my-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-dark"><i class="fa fa-table"></i> Ordered Itemset</h6>
        </div>
        <div class="card-body">
          <div class="row px-4 table-responsive">
            <table class="table hover multiple-select-row data-table-export nowrap">
              <thead>
                <tr>
                  <th>Transaksi Ke-</th>
                  <th>Itemset</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 1;
                foreach ($ordered_itemset as $key => $val) : ?>
                  <tr>
                    <td><?= $no++ ?></td>
                    <td><?= implode(', ', $val) ?></td>
                  </tr>
                <?php endforeach ?>
              </tbody>
            </table>
          </div>
        </div>
      </div><br>


      <div class="card shadow my-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-dark"><i class="fa fa-table"></i> FP-Tree</h6>
        </div>
        <div class="card-body">
          <div class="row px-4">
            <div class="alert alert-primary my-2" role="alert">
              Untuk melihat struktur pohon asosiasi dari itemset transaksi
              <a href="<?= base_url('/analisis/asosiasi/fptree') ?>" target="_blank" class="btn btn-sm btn-outline-primary ml-4">Lihat</a>
            </div>
          </div>
        </div>
      </div><br>


      <div class="card shadow my-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-dark"><i class="fa fa-table"></i> Conditional Patern Base</h6>
        </div>
        <div class="card-body">
          <div class="row px-4  table-responsive">
            <table class="table hover multiple-select-row nowrap" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Suffix Pattern</th>
                  <th>Conditional Patern Base</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 1;
                // echo '<pre>' . print_r($f->item, 1) . '</pre>';
                // echo '<pre>' . print_r($f->cpb, 1) . '</pre>';
                foreach ($item as $key => $val) :
                  if (isset($cpb[$key])) : ?>
                    <tr>
                      <td><?= $no++ ?></td>
                      <td class="nw"><?= $key ?></td>
                      <td>
                        <?php
                        $arr = array();
                        foreach ($cpb[$key] as $key => $val) {
                          $arr[] = "<p> { " . implode(',', $val['items']) . ": <b>$val[count]</b> } </p>";
                        }
                        echo implode(', ', $arr); ?>
                      </td>
                    </tr>
                  <?php endif ?>
                <?php endforeach ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <br>


      <div class="card shadow my-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-dark"><i class="fa fa-table"></i> Conditional FP-Tree</h6>
        </div>
        <div class="card-body">
          <div class="row px-4  table-responsive">
            <table class="table hover multiple-select-row nowrap" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Item</th>
                  <th>Conditional Fp Tree</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 1;
                foreach ($item as $key => $val) :
                  if (isset($cfpt[$key])) : ?>
                    <tr>
                      <td><?= $no++ ?></td>
                      <td class="nw"><?= $key ?></td>
                      <td>
                        <?php
                        $arr = array();
                        foreach ($cfpt[$key] as $key => $val) {
                          $arr[] = "<p> { " . implode(',', $val['items']) . " : <b>$val[count]</b> } </p>";
                        }
                        echo implode(', ', $arr); ?>
                      </td>
                    </tr>
                  <?php endif ?>
                <?php endforeach ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <br>

      <div class="card shadow my-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-dark"><i class="fa fa-table"></i> Frequency Patern</h6>
        </div>
        <div class="card-body">
          <div class="row px-4  table-responsive">
            <table class="table hover multiple-select-row nowrap" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Item</th>
                  <th>Frequent Patern</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 1;
                foreach ($fpg as $key => $val) : ?>
                  <?php foreach ($val as $k => $v) : ?>
                    <tr>
                      <td><?= $no++ ?></td>
                      <td><?= $key ?></td>
                      <td>
                        <?= implode(', ', $v['items']); ?> (<?= $v['count'] ?>)
                      </td>
                    </tr>
                  <?php endforeach ?>
                <?php endforeach ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <br>
    </span>


    <div class="card shadow my-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-dark"><i class="fa fa-table"></i> Aturan Asosiasi</h6>
      </div>
      <div class="card-body">
        <div class="row px-4 table-responsive">
          <table class="table hover multiple-select-row nowrap" cellspacing="0" width="100%">
            <thead>
              <tr class="text-center">
                <th>No</th>
                <th colspan=6>Rule</th>
                <th colspan="2">Support</th>
                <th colspan="2">Confidence</th>
                <th>Lift Ratio</th>
              </tr>
              <tr class="text-center">
                <td> - </td>
                <td> A </td>
                <td> B </td>
                <td>Kemunculan ( A )</td>
                <td>Kemunculan ( B )</td>
                <td>Kemunculan ( A, B )</td>
                <td>J. Transaksi</td>
                <td>Support ( A, B )</td>
                <td>% </td>
                <td>Confidence ( A, B )</td>
                <td>% </td>
                <td>( Confidence ( A, B ) ) / ( Benchmark Confience (A, B) )</td>
              </tr>
            </thead>
            <tbody>
              <?php
              $no = 1;
              //menghapus hasil tabel hasil_asosiasi
              $this->db = \Config\Database::connect();
              $this->db->query("TRUNCATE hasil_asosiasi");
              $sql = "INSERT INTO hasil_asosiasi (left_item, right_item, supp, conf, lift)
              VALUES";
              foreach ($ass as $key => $val) :
                if ($val['conf'] >= $con / 100) :
                  //insert hasil asosiasi ke hasil_asosiasi
                  $sql .= "('" . implode(', ', $val['left']) . "','" . implode(', ', $val['right']) . "'," . $val['sup'] . "," . $val['conf'] . "," . $val['lr'] . "), ";
              ?>
                  <tr class="<?= $val['conf'] >= $con / 100 ? '' : 'danger' ?>">
                    <td><?= $no++ ?></td>
                    <td><code>Jika</code>
                      <p><?= implode('</p>, <p>', $val['left']) ?></p>
                    </td>
                    <td>
                      <code>maka </code>
                      <p><?= implode('</p>, <p>', $val['right']) ?></p>
                    </td>
                    <td class="text-center">
                      <?= $val['b'] ?>
                    </td>
                    <td class="text-center">
                      <?= $val['a'] / ($val['lr'] * ($val['b'] / $val['total'])) ?>
                    </td>
                    <td class="text-center">
                      <?= $val['a'] ?>
                    </td>
                    <td class="text-center">
                      <?= $val['total'] ?>
                    </td>
                    <td class="text-center"><?= $val['a'] ?>/<?= $val['total'] ?> = <?= round($val['sup'], 5) ?></td>
                    <td class="text-center font-weight-bolder" style="background-color: #F0FFFF;"><?= round($val['sup'] * 100, 2) ?>%</td>
                    <td class="text-center"><?= $val['a'] ?>/<?= $val['b'] ?> = <?= round($val['conf'], 5) ?></td>
                    <td class="text-center font-weight-bolder" style="background-color: #F0FFFF;"><?= round($val['conf'] * 100, 2) ?>%</td>
                    <td class="text-center">( <?= $val['a'] ?> / <?= $val['a'] / ($val['lr'] * ($val['b'] / $val['total'])) ?> ) / ( <?= $val['b'] ?> / <?= $val['total'] ?> ) = <?= round($val['lr'], 2) ?></td>
                  </tr>
              <?php endif;
              endforeach;
              $sql = rtrim($sql, ', ');
              $this->db->query($sql);
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <br>

    <!----modal ubah support dan confidence--->
    <a href="#" class="btn btn-warning text-white btn-sm" data-toggle="modal" data-target="#Medium-modal" type="button"><i class="fa fa-pencil"></i> Ubah Support dan Confidence
    </a>
    <a href="#" class="btn btn-danger btn-sm" id="tutup_perhitungans"><i class="fa fa-minus-circle"></i> Tutup Perhitungan
    </a>
    <a href="#" class="btn btn-info btn-sm" id="buka_perhitungans"><i class="fa fa-calculator"></i> Buka Perhitungan
    </a>
    <a href="<?php base_url() ?>/hasil" class="btn btn-success btn-sm" type="button"><i class="fa fa-floppy-o"></i> Hasil
    </a>
    <br>
    <div class="modal fade" id="Medium-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h6 class="modal-title" id="myLargeModalLabel">Ubah Support dan Confidence</h6>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          </div>
          <div class="modal-body">
            <div class="alert alert-primary my-3" role="alert">
              Untuk bilangan desimal menggunakan titik (.) bukan koma (,)
            </div>
            <form action="<?= base_url(); ?>/analisis/asosiasi/ubah_sup_conf" method="post">
              <?= csrf_field() ?>
              <div class="row">
                <div class="form-group col-md-6">
                  <label class="font-weight-bold">Nilai Minimum Support %</label>
                  <input type="text" name="support" autocomplete="off" id="inputJumlah" class="form-control" required="required" value="<?= $sup ?>">
                </div>
                <div class="form-group col-md-6">
                  <label class="font-weight-bold">Nilai Minimum Confidence %</label>
                  <input type="text" name="confidence" autocomplete="off" id="inputJumlah" class="form-control" required="required" value="<?= $con ?>">
                </div>
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-primary" onclick="fungsi_tutup_modall()">Ubah</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <br>
    <div class="row">
      <div class="col-xl-12 mb-30">
        <div class="card-box height-100-p pd-20">
          <h2 class="h4 mb-20">Grafik Penyebaran</h2>
          <figure class="highcharts-figure">
            <div id="container"></div>
            <p class="highcharts-description">
            </p>
          </figure>
        </div>
      </div>
    </div>
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
    <br>
  </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('pageScripts') ?>
<!-- buttons for Export datatable -->
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
      text: 'Hasil Penyebaran Sup & Conf Asosiasi FP-Growth'
    },
    subtitle: {
      text: 'Source: sistem'
    },
    xAxis: {
      title: {
        enabled: true,
        text: 'Confidence (%)'
      },
      startOnTick: true,
      endOnTick: true,
      showLastLabel: true
    },
    yAxis: {
      title: {
        text: 'Support (%)'
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
          radius: 6,
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
          pointFormat: '{point.x} %, {point.y} item'
        }
      }
    },
    series: [{
        name: 'Support',
        color: 'rgba(216,65,143,0.77)',
        data: [
          <?php $q3 = $this->db->query("SELECT count(supp) as t, supp FROM hasil_asosiasi group by supp order by supp asc"); ?>
          <?php $cc = $q3->getResultObject(); ?>

          <?php foreach ($cc as $h) { ?>[<?= round($h->supp * 100, 2) ?>, <?= $h->t ?>],
          <?php } ?>
        ]
      },
      {
        name: 'Confidence',
        color: 'rgba(58, 168, 19, 0.83)',
        data: [
          <?php $q3 = $this->db->query("SELECT count(conf) as t, conf FROM hasil_asosiasi group by conf order by conf asc"); ?>
          <?php $cc = $q3->getResultObject(); ?>

          <?php foreach ($cc as $h) { ?>[<?= round($h->conf * 100, 2) ?>, <?= $h->t ?>],
          <?php } ?>
        ]
      },
    ]
  });
</script>
<script>
  $(document).ready(function() {
    $(".preloader").fadeOut();
  })
</script>
<script>
  $(document).ready(function() {
    $("#perhitungans").hide();
    $("#tutup_perhitungans").hide();
    $("#buka_perhitungans").click(function() {
      $("#perhitungans").show();
      $("#buka_perhitungans").hide();
      $("#tutup_perhitungans").show();
    });
    $("#tutup_perhitungans").click(function() {
      $("#perhitungans").hide();
      $("#buka_perhitungans").show();
      $("#tutup_perhitungans").hide();
    });
  });
</script>
<script>
  function fungsi_tutup_modall() {
    $('#Medium-modal').modal('hide');
    $(".preloader").fadeIn();
  }
</script>

<?= $this->endSection() ?>