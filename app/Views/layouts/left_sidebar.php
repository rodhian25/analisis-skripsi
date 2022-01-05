<div class="left-side-bar">
  <div class="brand-logo">
    <a href="<?= base_url(); ?>/">&nbsp;&nbsp;
      <i style="color: #142127;" class="icon-copy fa fa-coffee mr-3" aria-hidden="true"></i>
      <h5 style="color: #142127;">ER COFFEE</h5>
    </a>
    <div class="close-sidebar" data-toggle="left-sidebar-close">
      <i class="ion-close-round"></i>
    </div>
  </div>
  <div class="menu-block customscroll">
    <img src="<?= base_url(); ?>/vendors/images/banner-img.png" alt="banner" class="p-3 mt-4">
    <div class="sidebar-menu">
      <center>
        <span id="lihat-calendar" class="text-white" style="font-family:sans-serif">
          <?php
          date_default_timezone_set('Asia/Jakarta');
          function tgl_indo($tanggal)
          {
            $bulan = array(
              1 => 'Januari',
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
          //ambil jam dan menit
          $jam = date('H:i');
          //atur salam menggunakan IF
          if ($jam > '05:30' && $jam < '10:30') {
            $ffff = '/vendors/images/morning.png';
          } elseif ($jam >= '10:30' && $jam < '15:00') {
            $ffff =  '/vendors/images/day.png';
          } elseif ($jam >= '15:01' && $jam < '18:00') {
            $ffff =  '/vendors/images/afternoon.png';
          } else {
            $ffff =  '/vendors/images/night.png';
          }
          ?>
          <span style="font-size:15px; color:#142127;">
            <?= hari_indo(date("l")) . ', ' . tgl_indo(date("Y-m-d")) . '<br>' ?><span id="clock"></span> <img src="<?= base_url($ffff) ?>" style="width:22px" alt="suasana">
          </span>
        </span>
      </center>
      <br>
      <ul id="accordion-menu">
        <li>
          <?php $request = \Config\Services::request(); ?>
          <a href="<?= base_url(); ?>/" class="dropdown-toggle no-arrow  <?php if ($request->uri->getSegment(1) == "") {
                                                                            echo 'active';
                                                                          } ?>">
            <span class="micon dw dw-house-1"></span><span class="mtext">Beranda</span>
          </a>
        </li>
        <!-- menu jika user admin yang login-->
        <?php if (in_groups('admin')) : ?>
          <li>
            <a href="<?= base_url(); ?>/admin/data-user" class="dropdown-toggle no-arrow  <?php if ($request->uri->getSegment(1) == "admin") {
                                                                                            echo 'active';
                                                                                          } ?>">
              <span class="micon dw dw-user1"></span><span class="mtext">Akun User</span>
            </a>
          </li>
        <?php endif; ?>
        <!-- akhir menu jika user admin yang login-->
        <li>
          <a href="<?= base_url(); ?>/data" class="dropdown-toggle no-arrow  <?php if ($request->uri->getSegment(1) == "data") {
                                                                                echo 'active';
                                                                              } ?>">
            <span class="micon dw dw-folder"></span><span class="mtext">Data</span>
          </a>
        </li>
        <li>
          <a href="<?= base_url(); ?>/analisis" class="dropdown-toggle no-arrow <?php if ($request->uri->getSegment(1) == "analisis") {
                                                                                  echo 'active';
                                                                                } ?>">
            <span class="micon dw dw-analytics1"></span><span class="mtext">Analisis</span>
          </a>
        </li>
        <li>
          <a href="<?= base_url(); ?>/hasil" class="dropdown-toggle no-arrow  <?php if ($request->uri->getSegment(1) == "hasil") {
                                                                                echo 'active';
                                                                              } ?>">
            <span class="micon dw dw-invoice"></span><span class="mtext">Hasil</span>
          </a>
        </li>
        <li>
          <a href="<?= base_url(); ?>/info" class="dropdown-toggle no-arrow  <?php if ($request->uri->getSegment(1) == "info") {
                                                                                echo 'active';
                                                                              } ?>">
            <span class="micon dw dw-keyhole"></span><span class="mtext">Info</span>
          </a>
        </li>
      </ul>
    </div>
  </div>
</div>
<div class="mobile-menu-overlay"></div>

<!-- menampilkan jam -->
<script type="text/javascript">
  function showTime() {
    var a_p = "";
    var today = new Date();
    var curr_hour = today.getHours();
    var curr_minute = today.getMinutes();
    var curr_second = today.getSeconds();
    if (curr_hour < 12) {
      a_p = "AM";
    } else {
      a_p = "PM";
    }
    if (curr_hour == 0) {
      curr_hour = 12;
    }
    if (curr_hour > 12) {
      curr_hour = curr_hour - 12;
    }
    curr_hour = checkTime(curr_hour);
    curr_minute = checkTime(curr_minute);
    curr_second = checkTime(curr_second);
    document.getElementById('clock').innerHTML = curr_hour + ":" + curr_minute + ":" + curr_second + " " + a_p;
  }

  function checkTime(i) {
    if (i < 10) {
      i = "0" + i;
    }
    return i;
  }
  setInterval(showTime, 500);
</script>