<div class="right_col" role="main">
  <div class="page-title">
    <div class="title_left">
      <h3><?= esc($title ?? 'Data Penimbangan'); ?></h3>
    </div>
  </div>
  <div class="clearfix"></div>

  <?php
  // Build map: id_anak => nama_anak (hindari loop di dalam loop)
  $anakMap = [];
  if (!empty($anak) && is_array($anak)) {
    foreach ($anak as $a) {
      $anakMap[(int)($a['id_anak'] ?? 0)] = $a['nama_anak'] ?? '-';
    }
  }

  // Siapkan data grafik dari PHP -> JSON (lebih aman)
  $labels = [];
  $dataBB = [];
  $dataTB = [];
  if (!empty($timbangan) && is_array($timbangan)) {
    // Optional: urutkan berdasarkan tanggal
    usort($timbangan, function ($x, $y) {
      return strcmp($x['tgl_skrng'] ?? '', $y['tgl_skrng'] ?? '');
    });

    foreach ($timbangan as $r) {
      $labels[] = (string)($r['tgl_skrng'] ?? '');
      $dataBB[] = isset($r['bb']) ? (float)$r['bb'] : null;
      $dataTB[] = isset($r['tb']) ? (float)$r['tb'] : null;
    }
  }

  // Helper kecil untuk gender
  $genderText = function ($g) {
    return $g === 'L' ? 'Laki-laki' : ($g === 'P' ? 'Perempuan' : '-');
  };
  ?>

  <div class="row">
    <div class="col-md-12 col-sm-12 ">
      <div class="x_panel">
        <div class="x_title">
          <h2>Data Penimbangan Anak</h2>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">

          <!-- Grafik Line Chart -->
          <canvas id="grafikPenimbangan" width="100%" height="40"></canvas>
          <br><br>

          <!-- Tabel Penimbangan -->
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Anak</th>
                <th>Jenis Kelamin</th>
                <th>Usia</th>
                <th>Tinggi Badan (cm)</th>
                <th>Berat Badan (kg)</th>
                <th>Tanggal Penimbangan</th>
                <th>Keterangan</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($timbangan) && is_array($timbangan)) : ?>
                <?php $no = 1;
                foreach ($timbangan as $row) : ?>
                  <?php
                  $idAnak = (int)($row['anak_id'] ?? 0);
                  $namaAnak = $anakMap[$idAnak] ?? '-';
                  $tgl = $row['tgl_skrng'] ?? '';
                  // format tanggal ke d-m-Y kalau mau
                  $tglFmt = $tgl ? date('d-m-Y', strtotime($tgl)) : '-';
                  ?>
                  <tr>
                    <td><?= $no++; ?></td>
                    <td><?= esc($namaAnak); ?></td>
                    <td><?= esc($row['jenis_kelamin'] ?? ''); ?></td>
                    <td><?= esc((string)($row['usia'] ?? '-')); ?> bulan</td>
                    <td><?= esc((string)($row['tb'] ?? '-')); ?></td>
                    <td><?= esc((string)($row['bb'] ?? '-')); ?></td>
                    <td><?= esc($tglFmt); ?></td>
                    <td><?= esc($row['ket'] ?? '-'); ?></td>
                  </tr>
                <?php endforeach; ?>
              <?php else : ?>
                <tr>
                  <td colspan="8" class="text-center">Belum ada data penimbangan.</td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>

        </div>
      </div>
    </div>
  </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const labels = <?= json_encode($labels, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?>;
  const berat = <?= json_encode($dataBB, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?>;
  const tinggi = <?= json_encode($dataTB, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?>;

  const ctx = document.getElementById('grafikPenimbangan').getContext('2d');
  new Chart(ctx, {
    type: 'line',
    data: {
      labels,
      datasets: [{
          label: 'Berat Badan (kg)',
          data: berat,
          borderColor: 'blue',
          backgroundColor: 'rgba(0, 0, 255, 0.1)',
          tension: 0.4
        },
        {
          label: 'Tinggi Badan (cm)',
          data: tinggi,
          borderColor: 'green',
          backgroundColor: 'rgba(0, 255, 0, 0.1)',
          tension: 0.4
        }
      ]
    },
    options: {
      responsive: true,
      plugins: {
        legend: {
          position: 'top'
        },
        title: {
          display: true,
          text: 'Grafik Perkembangan Penimbangan Anak'
        }
      },
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
</script>