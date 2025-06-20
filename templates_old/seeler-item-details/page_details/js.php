<!--begin::Page Vendors(used by this page)-->
<!--begin::Page Vendors(used by this page)-->
<!-- <script src="../backend_assets/plugins/custom/datatables/datatables.bundle.js"></script> -->
<script src="frontend_assets/assets/global/plugins/select2/js/select2.full.min.js?v=<?php echo $version; ?>"
    type="text/javascript"></script>
<!--end::Page Vendors-->
<!-- <script src="../backend_assets/ckeditor/ckeditor.js"></script> -->
<!--end::Page Vendors-->
<script src="templates/seeler-item-details/controller.js?v=<?php echo $version; ?>"></script>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        // Handle image upload and removal
        const imageUploadContainer = document.querySelector(".image-upload-container")
        const uploadButtons = document.querySelectorAll(".upload-btn")

        // Handle image removal
        imageUploadContainer.addEventListener("click", (e) => {
            if (e.target.closest(".btn-danger")) {
                const imagePreview = e.target.closest(".image-preview")
                if (imagePreview) {
                    imagePreview.remove()
                    // Add a new upload button if less than 3 total slots
                    const totalSlots = document.querySelectorAll(".image-preview, .upload-btn").length
                    if (totalSlots < 3) {
                        const newUploadBtn = document.createElement("button")
                        newUploadBtn.type = "button"
                        newUploadBtn.className = "btn btn-outline-secondary upload-btn"
                        newUploadBtn.innerHTML = '<i class="bi bi-plus-lg"></i>'
                        imageUploadContainer.appendChild(newUploadBtn)
                    }
                }
            }
        })

        // Handle form submission
        const form = document.getElementById("itemDetailsForm")
        form.addEventListener("submit", (e) => {
            e.preventDefault()
            // Add your form submission logic here
            console.log("Form submitted")
        })
    })

    // Add click handler for address items
    document.querySelectorAll('.address-item').forEach(item => {
        item.addEventListener('click', () => {
            // Handle address selection
            console.log('Address selected:', item.querySelector('h2').textContent);
        });
    });
    document.addEventListener("DOMContentLoaded", () => {
        const categoryItems = document.querySelectorAll(".category-item")

        categoryItems.forEach((item) => {
            item.addEventListener("click", function () {
                // Remove active class from all items
                categoryItems.forEach((i) => i.classList.remove("active"))

                // Add active class to clicked item
                this.classList.add("active")
            })
        })
    })
</script>