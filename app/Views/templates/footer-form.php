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
<!-- bootstrap-progressbar -->
<script src="<?= base_url('vendors/bootstrap-progressbar/bootstrap-progressbar.min.js') ?>"></script>
<!-- iCheck -->
<script src="<?= base_url('vendors/iCheck/icheck.min.js') ?>"></script>
<!-- bootstrap-daterangepicker -->
<script src="<?= base_url('vendors/moment/min/moment.min.js') ?>"></script>
<script src="<?= base_url('vendors/bootstrap-daterangepicker/daterangepicker.js') ?>"></script>
<!-- bootstrap-wysiwyg -->
<script src="<?= base_url('vendors/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js') ?>"></script>
<script src="<?= base_url('vendors/jquery.hotkeys/jquery.hotkeys.js') ?>"></script>
<script src="<?= base_url('vendors/google-code-prettify/src/prettify.js') ?>"></script>
<!-- jQuery Tags Input -->
<script src="<?= base_url('vendors/jquery.tagsinput/src/jquery.tagsinput.js') ?>"></script>
<!-- Switchery -->
<script src="<?= base_url('vendors/switchery/dist/switchery.min.js') ?>"></script>
<!-- Select2 -->
<script src="<?= base_url('vendors/select2/dist/js/select2.full.min.js') ?>"></script>
<!-- Parsley -->
<script src="<?= base_url('vendors/parsleyjs/dist/parsley.min.js') ?>"></script>
<script src="<?= base_url('vendors/parsleyjs/dist/i18n/id.js') ?>"></script>
<!-- Autosize -->
<script src="<?= base_url('vendors/autosize/dist/autosize.min.js') ?>"></script>
<!-- jQuery autocomplete -->
<script src="<?= base_url('vendors/devbridge-autocomplete/dist/jquery.autocomplete.min.js') ?>"></script>
<!-- starrr -->
<script src="<?= base_url('vendors/starrr/dist/starrr.js') ?>"></script>
<!-- Custom Theme Scripts -->
<script src="<?= base_url('js/custom.min.js') ?>"></script>
<!-- Toastr alert -->
<script src="<?= base_url('js/toastr.min.js') ?>"></script>
<!-- Sweet Alert 2 -->
<script src="<?= base_url('js/dist/sweetalert2.all.min.js'); ?>"></script>
<script src="<?= base_url('js/dist/myscript.js'); ?>"></script>

<script type="text/javascript">
    $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        // alert(fileName);
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });

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
</script>

</body>

</html>
