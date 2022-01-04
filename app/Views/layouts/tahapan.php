  <div class="pd-20 card-box height-100-p">
    <h4 class="mb-20 h4">Tahapan Analisis</h4>
    <table class="table table-bordered table-responsive">
      <thead>
        <tr>
          <th scope="col">Preprocessing Data</th>
          <th scope="col">Input Jumlah Klaster, Input Support & Confidence</th>
          <th scope="col">Algoritma K-Medoids</th>
          <th scope="col">Hasil Klaster & Pengujian Klaster</th>
          <th scope="col">Algoritma FP-Growth & Hasil Rules</th>
        </tr>
      </thead>
      <tbody>
        <?php $request = \Config\Services::request(); ?>
        <tr class="text-center">
          <td scope="row"><span class="badge badge-<?php if ($request->uri->getSegment(2) == "") {
                                                      echo 'success';
                                                    } else {
                                                      echo 'light';
                                                    }
                                                    ?>
          badge-pill">
              <i class="icon-copy dw dw-check"></i></span></td>
          <td scope="row"><span class="badge badge-<?php if ($request->uri->getSegment(2) == "klaster") {
                                                      echo 'success';
                                                    } else {
                                                      echo 'light';
                                                    }
                                                    ?>
          badge-pill">
              <i class="icon-copy dw dw-check"></i></span></td>
          <td scope="row"><span class="badge badge-<?php if ($request->uri->getSegment(2) == "iterasi_klaster") {
                                                      echo 'success';
                                                    } else {
                                                      echo 'light';
                                                    }
                                                    ?>
          badge-pill"><i class="icon-copy dw dw-check"></i></span></td>
          <td scope="row"><span class="badge badge-<?php if ($request->uri->getSegment(2) == "iterasi_klaster") {
                                                      echo 'success';
                                                    } else {
                                                      echo 'light';
                                                    }
                                                    ?>
          badge-pill"><i class="icon-copy dw dw-check"></i></span></td>
          <td scope="row"><span class="badge badge-<?php if ($request->uri->getSegment(2) == "asosiasi") {
                                                      echo 'success';
                                                    } else {
                                                      echo 'light';
                                                    }
                                                    ?>
          badge-pill"><i class="icon-copy dw dw-check"></i></span></td>
        </tr>
      </tbody>
    </table>
  </div>
  </br>