<!-- 1 Seller Post Category Start -->
<div class="category-body">
    <div class="container-fluid px-4 pt-4 pb-3">
        <!-- Header -->
        <div class="d-flex align-items-center justify-content-between mb-4">
            <!-- <button class="btn p-2" aria-label="Go back"> -->
            <i class="bi bi-arrow-left fs-4"></i>
            <!-- </button> -->
            <h1 class="fs-4 fw-semibold mb-0">Choose a Category</h1>
            <!-- <button class="btn p-2" aria-label="Search"> -->
            <i class="bi bi-search fs-4"></i>
            <!-- </button> -->
        </div>

        <!-- Progress Steps -->
        <div class="d-flex justify-content-center mb-4">
            <div class="progress-steps">
                <div class="step active">1</div>
                <div class="step-line"></div>
                <div class="step">2</div>
                <div class="step-line"></div>
                <div class="step">3</div>
            </div>
        </div>

        <!-- Step Labels -->
        <div class="text-center mb-4">
            <div class="d-inline-flex gap-4">
                <span class="text-primary">Choose Category</span>
                <span class="text-secondary">Item details</span>
                <span class="text-secondary">Address Details</span>
            </div>
        </div>

        <!-- Categories List -->
        <div class="categories-list mb-4">
            <button class="category-item" data-category="batteries">
                <div class="d-flex align-items-center gap-2">
                    <div class="radio-circle"></div>
                    <span>Batteries</span>
                </div>
                <i class="bi bi-battery"></i>
            </button>

            <button class="category-item" data-category="books">
                <div class="d-flex align-items-center gap-2">
                    <div class="radio-circle"></div>
                    <span>Books</span>
                </div>
                <i class="bi bi-book"></i>
            </button>

            <button class="category-item" data-category="cardboards">
                <div class="d-flex align-items-center gap-2">
                    <div class="radio-circle"></div>
                    <span>Cardboards</span>
                </div>
                <i class="bi bi-box"></i>
            </button>

            <button class="category-item" data-category="ewaste">
                <div class="d-flex align-items-center gap-2">
                    <div class="radio-circle"></div>
                    <span>E waste</span>
                </div>
                <i class="bi bi-plug"></i>
            </button>

            <button class="category-item active" data-category="newspaper">
                <div class="d-flex align-items-center gap-2">
                    <div class="radio-circle"></div>
                    <span>Newspaper</span>
                </div>
                <i class="bi bi-newspaper"></i>
            </button>

            <button class="category-item" data-category="furniture">
                <div class="d-flex align-items-center gap-2">
                    <div class="radio-circle"></div>
                    <span>Furniture</span>
                </div>
                <i class="bi bi-lamp"></i>
            </button>

            <button class="category-item" data-category="glass">
                <div class="d-flex align-items-center gap-2">
                    <div class="radio-circle"></div>
                    <span>Glass</span>
                </div>
                <i class="bi bi-cup"></i>
            </button>

            <button class="category-item" data-category="other">
                <div class="d-flex align-items-center gap-2">
                    <div class="radio-circle"></div>
                    <span>Other</span>
                </div>
                <i class="bi bi-scissors"></i>
            </button>
        </div>

        <!-- Continue Button -->
        <button class="btn btn-primary w-100 py-3 fw-medium">Continue</button>
    </div>
</div>
<!-- Seller Post Category End -->
<!-- Seeler Item Ddetails Start -->
<div class="container-fluid px-0 seeler-item-details-bg">
    <!-- Header -->
    <header class="header py-3 px-3">
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-3">
                <a href="#" class="btn btn-link text-dark p-0">
                    <i class="bi bi-arrow-left fs-4"></i>
                </a>
                <h1 class="h5 mb-0">Item Details</h1>
            </div>
            <button class="btn btn-link text-dark p-0">
                <i class="bi bi-info-circle fs-4"></i>
            </button>
        </div>
    </header>

    <!-- Main Content -->
    <main class="px-3 pb-4">
        <!-- Progress Steps -->
        <div class="progress-steps d-flex justify-content-center align-items-center gap-2 my-4">
            <div class="step-circle completed">
                <i class="bi bi-check-lg"></i>
            </div>
            <div class="step-line completed"></div>
            <div class="step-circle active">2</div>
            <div class="step-line"></div>
            <div class="step-circle">3</div>
        </div>

        <!-- Form -->
        <form id="itemDetailsForm">
            <div class="mb-3">
                <label for="postName" class="form-label">Post Name</label>
                <input type="text" class="form-control" id="postName" placeholder="Eg - Paper">
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <input type="text" class="form-control" id="description" placeholder="Eg - Its is made up of ..">
            </div>

            <div class="mb-3">
                <label for="brand" class="form-label">Brand</label>
                <input type="text" class="form-control" id="brand" placeholder="Eg - Lenovo">
            </div>

            <div class="mb-3">
                <label for="quantity" class="form-label">Quantity</label>
                <input type="text" class="form-control" id="quantity" placeholder="Eg - 12 kg">
            </div>

            <div class="mb-3">
                <label for="price" class="form-label">Expected Price</label>
                <div class="position-relative">
                    <input type="text" class="form-control" id="price" placeholder="Eg - 2000">
                    <button type="button"
                        class="btn btn-link position-absolute end-0 top-50 translate-middle-y text-secondary">
                        <i class="bi bi-info-circle"></i>
                    </button>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label">Add item images</label>
                <div class="d-flex gap-3 image-upload-container">
                    <div class="position-relative image-preview">
                        <img src="https://hebbkx1anhila5yf.public.blob.vercel-storage.com/WNDY_CLIENT_FILE-IvCpejek0vLiof2dBYxPWzy6Pjoz3s.png"
                            alt="Item preview" class="img-fluid rounded-15">
                        <button type="button"
                            class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1 p-1 rounded-circle">
                            <i class="bi bi-x"></i>
                        </button>
                    </div>
                    <button type="button" class="btn btn-outline-secondary upload-btn">
                        <i class="bi bi-plus-lg"></i>
                    </button>
                    <button type="button" class="btn btn-outline-secondary upload-btn">
                        <i class="bi bi-plus-lg"></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100">Continue</button>
        </form>
    </main>
</div>
<!-- 2 Seeler Item Details End -->

<!-- 3 Address Manager section start -->
<div class="container py-4">
    <!-- Header -->
    <div class="d-flex align-items-center mb-4">
        <a href="#" class="back-button">←</a>
        <h1 class="h4 mb-0">Manage Address</h1>
    </div>

    <!-- Progress Steps -->
    <div class="d-flex justify-content-center align-items-center mb-5">
        <div class="d-flex flex-column align-items-center">
            <div class="progress-step">✓</div>
            <div class="step-text">Choose Category</div>
        </div>
        <div class="progress-line"></div>
        <div class="d-flex flex-column align-items-center">
            <div class="progress-step">✓</div>
            <div class="step-text">Item details</div>
        </div>
        <div class="progress-line"></div>
        <div class="d-flex flex-column align-items-center">
            <div class="progress-step" style="background-color: #ffeedf; color: #b5753e;">3</div>
            <div class="step-text">Address Details</div>
        </div>
    </div>

    <!-- Address List -->
    <div class="address-list">
        <div class="address-item">
            <div class="default-label">Default</div>
            <h2 class="h5 mb-2">Home</h2>
            <p class="address-text">17037 Una Mountains, Raustad 73857-1656, Howe Greens France, North Jena</p>
            <i class="bi bi-chevron-right chevron-icon"></i>
        </div>

        <div class="address-item">
            <h2 class="h5 mb-2">Office</h2>
            <p class="address-text">17037 Una Mountains, Raustad 73857-1656, Howe Greens France, North Jena</p>
            <i class="bi bi-chevron-right chevron-icon"></i>
        </div>

        <div class="address-item">
            <h2 class="h5 mb-2">Other</h2>
            <p class="address-text">17037 Una Mountains, Raustad 73857-1656, Howe Greens France, North Jena</p>
            <i class="bi bi-chevron-right chevron-icon"></i>
        </div>
    </div>

    <!-- Notice Box -->
    <div class="notice-box">
        Your last used address has been selected by default
    </div>

    <!-- Add New Address Button -->
    <button class="add-address-btn">
        Add a new address+
    </button>
</div>
<!-- Address Manager section End -->