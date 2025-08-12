<div class="right_col" role="main">
  <div class="row">
    <div class="col-md-12 col-sm-12 ">
      <div class="x_panel">
        <div class="x_title">
          <h3>Data Imunisasi Anak Anda</h3>
          <div class="clearfix"></div>
        </div>

        <div class="x_content">
          <div class="row">
            <div class="col-sm-12">
              <div class="card-box table-responsive">
                <table class="table table-bordered" style="width:100%">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Nama Anak</th>
                      <th>Tanggal Imunisasi</th>
                      <th>Jenis Imunisasi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if (!empty($imunisasi)): $i = 1; ?>
                      <?php foreach ($imunisasi as $n): ?>
                        <tr>
                          <td><?= $i++; ?></td>
                          <td><?= esc($n['nama_anak'] ?? '-') ?></td>
                          <td><?= esc($n['tgl_skrng'] ?? '-') ?></td>
                          <td><?= esc($n['jenis_imunisasi'] ?? '-') ?></td>
                        </tr>
                      <?php endforeach; ?>
                    <?php else: ?>
                      <tr>
                        <td colspan="4" class="text-center">Belum ada data imunisasi.</td>
                      </tr>
                    <?php endif; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>