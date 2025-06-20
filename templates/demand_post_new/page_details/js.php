<!--begin::Page Vendors(used by this page)-->
<!--begin::Page Vendors(used by this page)-->
<!-- <script src="../backend_assets/plugins/custom/datatables/datatables.bundle.js"></script> -->
<script src="frontend_assets/assets/global/plugins/select2/js/select2.full.min.js?v=<?php echo $version; ?>"
    type="text/javascript"></script>
<!--end::Page Vendors-->
<!-- <script src="../backend_assets/ckeditor/ckeditor.js"></script> -->
<!--end::Page Vendors-->
<script src="templates/demand_post_new/controller.js?v=<?php echo $version; ?>"></script>
<script>
    // Initialize all tooltips on page load
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
</script>
