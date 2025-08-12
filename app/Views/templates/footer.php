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
<!-- gauge.js -->
<script src="<?= base_url('vendors/gauge.js/dist/gauge.min.js') ?>"></script>
<!-- bootstrap-progressbar -->
<script src="<?= base_url('vendors/bootstrap-progressbar/bootstrap-progressbar.min.js') ?>"></script>
<!-- iCheck -->
<script src="<?= base_url('vendors/iCheck/icheck.min.js') ?>"></script>
<!-- Skycons -->
<script src="<?= base_url('vendors/skycons/skycons.js') ?>"></script>
<!-- Flot -->
<script src="<?= base_url('vendors/Flot/jquery.flot.js') ?>"></script>
<script src="<?= base_url('vendors/Flot/jquery.flot.pie.js') ?>"></script>
<script src="<?= base_url('vendors/Flot/jquery.flot.time.js') ?>"></script>
<script src="<?= base_url('vendors/Flot/jquery.flot.stack.js') ?>"></script>
<script src="<?= base_url('vendors/Flot/jquery.flot.resize.js') ?>"></script>
<!-- Flot plugins -->
<script src="<?= base_url('vendors/flot.orderbars/js/jquery.flot.orderBars.js') ?>"></script>
<script src="<?= base_url('vendors/flot-spline/js/jquery.flot.spline.min.js') ?>"></script>
<script src="<?= base_url('vendors/flot.curvedlines/curvedLines.js') ?>"></script>
<!-- DateJS -->
<script src="<?= base_url('vendors/DateJS/build/date.js') ?>"></script>
<!-- JQVMap -->
<script src="<?= base_url('vendors/jqvmap/dist/jquery.vmap.js') ?>"></script>
<script src="<?= base_url('vendors/jqvmap/dist/maps/jquery.vmap.world.js') ?>"></script>
<script src="<?= base_url('vendors/jqvmap/examples/js/jquery.vmap.sampledata.js') ?>"></script>
<!-- bootstrap-daterangepicker -->
<script src="<?= base_url('vendors/moment/min/moment.min.js') ?>"></script>
<script src="<?= base_url('vendors/bootstrap-daterangepicker/daterangepicker.js') ?>"></script>

<!-- Toastr alert -->
<script src="<?= base_url('js/toastr.min.js') ?>"></script>
<!-- Sweet Alert 2 -->
<script src="<?= base_url('js/dist/sweetalert2.all.min.js'); ?>"></script>
<script src="<?= base_url('js/dist/myscript.js'); ?>"></script>
<!-- Custom Theme Scripts -->
<script src="<?= base_url('js/custom.min.js') ?>"></script>

<!-- DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        let table = $('#datatable');

        if (table.length && !$.fn.DataTable.isDataTable('#datatable')) {
            table.DataTable({
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ entri",
                    info: "Menampilkan _START_ - _END_ dari _TOTAL_ entri",
                    zeroRecords: "Tidak ditemukan data",
                    paginate: {
                        previous: "← Sebelumnya",
                        next: "Berikutnya →"
                    }
                },
                pageLength: 10
            });
        }

        <?php
        // Toastr flashdata (CI4)
        if ($msg = session()->getFlashdata('success')): ?>
            toastr.success("<?= esc($msg) ?>");
        <?php elseif ($msg = session()->getFlashdata('error')): ?>
            toastr.error("<?= esc($msg) ?>");
        <?php elseif ($msg = session()->getFlashdata('psn')): // kompatibel dgn nama lama 
        ?>
            toastr.error("<?= esc($msg) ?>");
        <?php elseif ($msg = session()->getFlashdata('warning')): ?>
            toastr.warning("<?= esc($msg) ?>");
        <?php elseif ($msg = session()->getFlashdata('info')): ?>
            toastr.info("<?= esc($msg) ?>");
        <?php elseif ($msg = session()->getFlashdata('message')): // logout pakai 'message' 
        ?>
            toastr.info("<?= esc($msg) ?>");
        <?php endif; ?>

    });
</script>

</body>

</html>