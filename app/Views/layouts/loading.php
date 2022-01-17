<style type="text/css">
  .preloader {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 9999;
    /* background-color: #181e25; */
    background-color: #fff;
  }

  .preloader .loading {
    position: absolute;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
    font: 14px arial;
  }
</style>


<div class="preloader">
  <div class="loading">
    <img src="<?= base_url('/vendors/images/loading2.gif') ?>" alt="test" width="100%">
    <!-- <button class="btn btn-success" type="button" disabled>
      <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
      Loading <br> mohon bersabar ya...
    </button> -->
  </div>
</div>