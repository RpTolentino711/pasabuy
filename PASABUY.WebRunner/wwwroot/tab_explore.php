<!-- EXPLORE TAB (PHP COMPONENT) -->
<div id="tabExplore" style="display:none;">
    <h5 class="fw-bold mb-3">Explore Marketplace</h5>
    <div class="d-flex gap-2 mb-3">
        <select class="form-select form-select-sm rounded-pill" id="filterCondition"
            onchange="filterProducts()">
            <option value="All">All Conditions</option>
            <option value="Like New">Like New</option>
            <option value="Good">Good</option>
        </select>
        <select class="form-select form-select-sm rounded-pill" id="filterSort" onchange="filterProducts()">
            <option value="newest">Newest First</option>
            <option value="lowest">Price: Low to High</option>
            <option value="highest">Price: High to Low</option>
        </select>
    </div>
    <div id="exploreList">
        <div class="text-center py-5 text-muted fs-8 bg-white rounded-4 border p-4">
            <i class="fa-solid fa-compass fs-2 d-block mb-2 text-secondary opacity-50"></i>
            No items found in marketplace.
        </div>
    </div>
</div>
