<div class="right_col" role="main">
  <div class="page-title">
    <div class="title_left">
      <h3><?= esc($title) ?></h3>
    </div>
  </div>
  <div class="clearfix"></div>

  <div class="row">
    <div class="col-md-12 col-sm-12 ">
      <div class="x_panel">
        <div class="x_title">
          <h2>Jadwal Pemeriksaan Anak</h2>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Anak</th>
                <th>Tanggal Pemeriksaan</th>
                <th>Jam Pemeriksaan</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($jadwal)): $no = 1; ?>
                <?php foreach ($jadwal as $row): ?>
                  <tr>
                    <td><?= $no++ ?></td>
                    <td><?= esc($row['nama_anak'] ?? '-') ?></td>
                    <td><?= esc($row['tanggal'] ?? '-') ?></td>
                    <td><?= esc($row['jam'] ?? '-') ?></td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="4" class="text-center">Belum ada jadwal pemeriksaan.</td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>