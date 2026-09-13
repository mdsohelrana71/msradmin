<div class="offcanvas offcanvas-end quick-view-offcanvas" tabindex="-1" id="quickViewModal" aria-labelledby="quickViewModalLabel">
    <div class="offcanvas-header border-bottom">
        <h4 class="offcanvas-title fw-bold" id="quickViewModalLabel">Quick View</h4>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>

    <div class="offcanvas-body p-3">
        <div id="quickViewLoading" class="text-center py-5 d-none">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>

        <div id="quickViewContent">
            <div class="mb-3">
                <img
                    id="qv-main-image"
                    src=""
                    alt="Product"
                    class="img-fluid rounded w-100 main-product-img">
            </div>

            <div class="product-details">
                <h5 id="qv-product-name" class="mb-3 fw-bold"></h5>

                <div class="mb-2 d-flex justify-content-between gap-3">
                    <label class="text-muted mb-0">Product Code:</label>
                    <p id="qv-product-code" class="mb-0 text-end"></p>
                </div>

                <div class="mb-2 d-flex justify-content-between gap-3">
                    <label class="text-muted mb-0">Price:</label>
                    <p id="qv-product-price" class="mb-0 fw-bold text-danger text-end"></p>
                </div>

                <div class="mb-3">
                    <label class="text-muted d-block mb-2">Color:</label>
                    <div id="qv-product-color" class="d-flex gap-2 flex-wrap"></div>
                </div>

                <div class="mb-2">
                    <label class="text-muted d-block mb-2">Size:</label>
                    <div id="qv-product-size" class="d-flex gap-2 flex-wrap"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="cart-footer p-3 border-top">
        <div class="cart-buttons pt-2 d-flex gap-2">
            <button type="button" class="btn flex-fill" id="qv-add-to-bag">
                Add To Bag
            </button>

            <a href="#" class="btn flex-fill" id="qv-full-details">
                Full Details
            </a>
        </div>
    </div>
</div>
