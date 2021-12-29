<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title><?= $title ?></title>

  <!-- Site favicon -->
  <link rel="icon" type="image/png" href="<?= base_url(); ?>/vendors/images/favicon-16x16.png">

  <!-- Mobile Specific Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>/vendors/styles/style.css">
  <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>/vendors/styles/core.css">
  <style>
    @charset "utf-8";

    .fp_tree ul {
      margin-left: 30px
    }

    .fp_tree li {
      list-style-type: none;
      margin: 10px;
      position: relative
    }

    .fp_tree li::before {
      content: "";
      position: absolute;
      top: -5px;
      left: -20px;
      border-left: 2px solid #ccc;
      border-bottom: 2px solid #ccc;
      border-radius: 0 0 0 0;
      width: 20px;
      height: 14px
    }

    .fp_tree li::after {
      position: absolute;
      content: "";
      top: 8px;
      left: -20px;
      border-left: 2px solid #ccc;
      border-top: 2px solid #ccc;
      border-radius: 0 0 0 0;
      width: 20px;
      height: 100%
    }

    .fp_tree li:last-child::after {
      display: none
    }

    .fp_tree li:last-child:before {
      border-radius: 0 0 0 5px
    }

    ul.fp_tree>li:first-child::before {
      display: none
    }

    .fp_tree b {
      min-width: 50px;
    }

    .fp_tree .btn-ty {
      background-color: cornsilk;
    }
  </style>
</head>

<body>
  <br><br>
  <?= $this->section('main-container') ?>
  <div class="main-container">
    <div class="pd-ltr-20">
      <div class="card shadow my-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-dark"><i class="fa fa-table"></i> FP-Tree</h6>
        </div>
        <div class="card-body">
          <div class="row px-4">
            <?= $display ?>
          </div>
        </div>
      </div>
    </div>
    <br>
  </div>
  </div>
  <?= $this->endSection() ?>
  <br><br>
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