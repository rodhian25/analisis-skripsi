<div class="header container px-4">
  <div class="header-left">
    <div class="menu-icon dw dw-menu"></div>
  </div>

  <div class="header-right">
    <div class="user-info-dropdown">
      <div class="dropdown">
        <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown">
          <span class="user-icon">
            <i class="icon-copy dw dw-user"></i>
            <span class="badge notification-active"></span>
          </span>
          <!---menampilkan username user-->
          <span class="user-name"><?= user()->username; ?></span>
        </a>
        <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
          <!---menu ubah profile-->
          <a class="dropdown-item" href="<?= base_url(); ?>/profile"><i class="dw dw-user1"></i> Profil</a>
          <a class="dropdown-item" href="mailto:m.rodhiansabri@gmail.com?subject=Isi%20dengan%20judul%20permasalahannya%20&body=Isi%20pesan%20permasalahan%20dengan%20lengkap%20disertai%20gambar/screenshoot%20terimakasih.%21"><i class="dw dw-mail"></i> Kontak Pengembang</a>
          <!---meni logout-->
          <a class="dropdown-item" data-toggle="modal" data-target="#confirmation-modal-logout" href="#" type="button"><i class="dw dw-logout"></i> Keluar</a>
        </div>
      </div>
    </div>
  </div>

</div>

<!-- modal jika ingin logout -->
<div class="modal fade" id="confirmation-modal-logout" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body text-center font-18">
        <h4 class="padding-top-30 mb-30 weight-500">Yakin ingin logout?</h4>
        <div class="padding-bottom-30 row" style="max-width: 170px; margin: 0 auto;">
          <div class="col-6">
            <button type="button" class="btn btn-secondary border-radius-100 btn-block confirmation-btn" data-dismiss="modal"><i class="fa fa-times"></i></button>
            Tidak
          </div>
          <div class="col-6">
            <a href="<?= base_url('logout'); ?>" type="button" class="btn btn-primary border-radius-100 btn-block confirmation-btn"><i class="fa fa-check pt-2"></i></a>
            Ya
          </div>
        </div>
      </div>
    </div>
  </div>
</div>