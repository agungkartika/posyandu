</div>
<!-- /page content -->

<!-- footer content -->
<footer>
	<div class="pull-right">
		<span>Copyright &copy; Posyandu Mawar XIII <?= date('Y'); ?></span>
	</div>
	<div class="clearfix"></div>
</footer>
<!-- /footer content -->
</div>

<!-- jQuery -->
<script src="<?= base_url('vendors/jquery/dist/jquery.min.js') ?>"></script>
<!-- Bootstrap -->
<script src="<?= base_url('vendors/bootstrap/dist/js/bootstrap.bundle.min.js') ?>"></script>
<!-- FastClick -->
<script src="<?= base_url('vendors/fastclick/lib/fastclick.js') ?>"></script>
<!-- NProgress -->
<script src="<?= base_url('vendors/nprogress/nprogress.js') ?>"></script>
<!-- jquery.inputmask -->
<script src="<?= base_url('vendors/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js') ?>"></script>
<!-- iCheck -->
<script src="<?= base_url('vendors/iCheck/icheck.min.js') ?>"></script>
<!-- Parsley -->
<script src="<?= base_url('vendors/parsleyjs/dist/parsley.min.js') ?>"></script>
<script src="<?= base_url('vendors/parsleyjs/dist/i18n/id.js') ?>"></script>
<!-- Datatables -->
<script src="<?= base_url('vendors/datatables/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('vendors/datatables/dataTables.bootstrap4.min.js') ?>"></script>
<!-- Sweet Alert 2 -->
<script src="<?= base_url('js/dist/sweetalert2.all.min.js'); ?>"></script>
<script src="<?= base_url('js/dist/myscript.js'); ?>"></script>

<!-- Custom Theme Scripts -->
<script src="<?= base_url('js/custom.min.js') ?>"></script>

</body>
</html>

<script type="text/javascript">
	$(document).ready(function() {
		// Inisialisasi DataTable hanya jika belum diinisialisasi
		if (!$.fn.DataTable.isDataTable('#datatable')) {
			$('#datatable').DataTable();
		}

		$('.btnSelectAnak').click(function() {
			var id = $(this).data('id');
			var nama = $(this).data('nama');
			var tgl_lahir = $(this).data('tgllahir');
			var jk = $(this).data('jk');
			var umur = $(this).data('umur');
			var idibu = $(this).data('idibu');
			var nama_ibu = $(this).data('ibu');

			$('#id_anak').val(id);
			$('#nama_anak').val(nama);
			$('#tgl_lahir').val(tgl_lahir);
			$('#jenis_kelamin').val(jk);
			$('#umur').val(umur);
			$('#ibu_id').val(idibu);
			$('#nama_ibu').val(nama_ibu);

			$('#DataAnakModal').modal('toggle');
		});

		$('.btnSelectAnakLaporan').click(function() {
			var id = $(this).data('id');
			var nama = $(this).data('nama');
			var tgl_lahir = $(this).data('tgllahir');
			var ayah = $(this).data('ayah');
			var idibu = $(this).data('idibu');
			var nama_ibu = $(this).data('ibu');

			$('#id_anak').val(id);
			$('#nama_anak').val(nama);
			$('#tgl_lahir').val(tgl_lahir);
			$('#nama_ayah').val(ayah);
			$('#ibu_id').val(idibu);
			$('#nama_ibu').val(nama_ibu);

			$('#DataAnakModal').modal('toggle');
		});

		$("#pilihAnak").click(function() {
			getPertumbuhan();
		});

		$("#pilihAnak_Bidan").click(function() {
			getImun();
		});

		$("#tgl_skrng").change(function() {
			getUsia();
		});

		$('#proseslaporan').click(function() {
			$.ajax({
				url: '<?php echo site_url('laporan-anak/cetak'); ?>',
				type: 'POST',
				data: $('#laporananak').serialize(),
				dataType: 'html',
				success: function(res) {
					$('#rowData').html(res);
				}
			});
		});

		function getPertumbuhan() {
			$("#usia").focus();

			$("#usia").prop("disabled", false);
			$("#bb").prop("disabled", false);
			$("#tb").prop("disabled", false);
			$("#deteksiS").prop("disabled", false);
			$("#deteksiT").prop("disabled", false);
			$("#tgl_skrng").prop("disabled", false);
			$("#keterangan").prop("disabled", false);
		}

		function getImun() {
			$("#usia").focus();

			$("#usia").prop("disabled", false);
			$("#imun").prop("disabled", false);
			$("#vita-merah").prop("disabled", false);
			$("#vita-biru").prop("disabled", false);
			$("#tgl_skrng").prop("disabled", false);
			$("#keterangan").prop("disabled", false);
		}

		function getUsia() {
			var userinput = document.getElementById("tgl_skrng").value;
			var DOB = document.getElementById("tgl_lahir").value;
			var millisecondsBetweenDOBAnd1970 = Date.parse(DOB);
			var millisecondsBetweenNowAnd1970 = Date.parse(userinput);
			var ageInMilliseconds = millisecondsBetweenNowAnd1970 - millisecondsBetweenDOBAnd1970;

			var milliseconds = ageInMilliseconds;
			var month = 1000 * 60 * 60 * 24 * 30;
			var months = (Math.round(milliseconds / month) - 1);
			return document.getElementById("usia").value = months;
		}
	});
</script>
