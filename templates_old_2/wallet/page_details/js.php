<script src="frontend_assets/assets/global/plugins/icheck/icheck.min.js?v=<?php echo $version; ?>" type="text/javascript"></script>
<script>
        // Add click handlers for amount chips
        document.querySelectorAll('.amount-chip').forEach(chip => {
            chip.addEventListener('click', function () {
                const amount = this.innerText.replace('+', '').trim();
                document.querySelector('.form-control').value = amount;
            });
        });
    </script>


<script src="templates/wallet/controller.js?v=<?php echo $version; ?>"></script>