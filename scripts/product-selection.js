    document.addEventListener('DOMContentLoaded', function() {
        const availableProducts = document.getElementById('available_products');
        const selectedProducts = document.getElementById('selected_products');

        document.getElementById('add_product').addEventListener('click', function() {
            const selectedOptions = Array.from(availableProducts.selectedOptions);
            selectedOptions.forEach(option => {
                selectedProducts.appendChild(option);
            });
        });

        document.getElementById('remove_product').addEventListener('click', function() {
            const selectedOptions = Array.from(selectedProducts.selectedOptions);
            selectedOptions.forEach(option => {
                availableProducts.appendChild(option);
            });
        });
    });
