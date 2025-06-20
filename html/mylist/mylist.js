// Sample data
const items = [
  {
    id: 1,
    title: "Bottle",
    type: "Plastic Bottles",
    weight: "2 kg",
    price: "Rs 200",
    status: "In Process",
    image: "https://via.placeholder.com/80",
  },
  {
    id: 2,
    title: "Bottle",
    type: "Plastic Bottles",
    weight: "2 kg",
    price: "Rs 200",
    status: "Closed",
    image: "https://via.placeholder.com/80",
  },
  {
    id: 3,
    title: "Bottle",
    type: "Plastic Bottles",
    weight: "2 kg",
    price: "Rs 200",
    status: "Open",
    image: "https://via.placeholder.com/80",
  },
  {
    id: 4,
    title: "Bottle",
    type: "Plastic Bottles",
    weight: "2 kg",
    price: "Rs 200",
    status: "Closed",
    image: "https://via.placeholder.com/80",
  },
  {
    id: 5,
    title: "Bottle",
    type: "Plastic Bottles",
    weight: "2 kg",
    price: "Rs 200",
    status: "In Process",
    image: "https://via.placeholder.com/80",
  },
]

// Function to render list items
function renderItems(filterValue = "all") {
  const listContainer = document.querySelector(".list-items")
  listContainer.innerHTML = ""

  const filteredItems = items.filter((item) => {
    if (filterValue === "all") return true
    return item.status.toLowerCase().replace(" ", "-") === filterValue
  })

  filteredItems.forEach((item) => {
    const itemElement = document.createElement("div")
    itemElement.className = "list-item d-flex gap-3"
    itemElement.innerHTML = `
            <img src="${item.image}" alt="${item.title}" class="flex-shrink-0">
            <div class="flex-grow-1">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="h5 mb-1">${item.title}</h3>
                    <span class="status">${item.status}</span>
                </div>
                <p class="text-secondary mb-1">${item.type}</p>
                <p class="text-secondary mb-1">${item.weight}</p>
                <p class="fw-bold mb-0">${item.price}</p>
            </div>
        `
    listContainer.appendChild(itemElement)
  })
}

// Add event listeners for filter buttons
document.querySelectorAll("[data-filter]").forEach((button) => {
  button.addEventListener("click", (e) => {
    // Remove active class from all buttons
    document.querySelectorAll("[data-filter]").forEach((btn) => {
      btn.classList.remove("btn-primary")
      btn.classList.add("btn-light")
    })

    // Add active class to clicked button
    button.classList.remove("btn-light")
    button.classList.add("btn-primary")

    // Filter items
    renderItems(e.target.dataset.filter)
  })
})

// Initial render
renderItems()

