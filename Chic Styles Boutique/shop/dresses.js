document.addEventListener('DOMContentLoaded', () => {

    // Database of products
    let products = [];
    fetch("fetch_products.php?4").then(function(response) {
        return response.json();
    }).then(function(data) {
        products = data;
        // Initial render with "newest" as default
        sortProducts('newest');
        numShowing.innerText = "Showing " + products.length + " results";
    });
    

    const productList = document.getElementById('product-list');
    const sortDropdown = document.getElementById('sort');
    const numShowing = document.getElementById('num_showing');

    // Insert element into HTML
    function renderProducts(products) {
        productList.innerHTML = '';
        products.forEach(product => {
            const productItem = document.createElement('div');
            productItem.className = 'product-item';
            productItem.innerHTML = `
                <figure class="product-figure">
                    <div><a href="../product?${product.ProductID}" class="product-link">
                        <img src="../img/shop/${product.ProductImg}" alt="${product.ProductName}">
                    </a></div>
                    <figcaption>
                        <h3>${product.ProductName}</h3>
                        <p>AUD ${product.ProductPrice.toFixed(2)}</p>
                    </figcaption>
                </figure>
                <button class="view-detail-button" onclick="window.location.href='../product?${product.ProductID}'">View Detail</button>
            `;
            productList.appendChild(productItem);
        });
    }


    // sort logic
    function sortProducts(criteria) {
        let sortedProducts;
        if (criteria === 'newest') {
            sortedProducts = [...products].sort((a, b) => new Date(b.ProductDate) - new Date(a.ProductDate));
        } else if (criteria === 'oldest') {
            sortedProducts = [...products].sort((a, b) => new Date(a.ProductDate) - new Date(b.ProductDate));
        } else if (criteria === 'price-high') {
            sortedProducts = [...products].sort((a, b) => b.ProductPrice - a.ProductPrice);
        } else if (criteria === 'price-low') {
            sortedProducts = [...products].sort((a, b) => a.ProductPrice - b.ProductPrice);
        }
        renderProducts(sortedProducts);
    }

    // sort when changing dropdown menu
    sortDropdown.addEventListener('change', (e) => {
        sortProducts(e.target.value);
    });
});
