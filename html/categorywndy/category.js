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

