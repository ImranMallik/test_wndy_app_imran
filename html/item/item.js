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

