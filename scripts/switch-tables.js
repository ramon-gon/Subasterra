document.addEventListener('DOMContentLoaded', function() {
    const newAuction = document.getElementById('new-auction');
    const auctioneerPanel = document.getElementById('auctioneer-panel');
    
    const newAuctionButton = document.getElementById('new-auction-button');
    const auctionCreateButton = document.getElementById('auction-create');

    const filterForm = document.getElementById('filter-form');

    const productsButton = document.getElementById('select-products');
    const auctionsButton = document.getElementById('select-auctions');
    const auctionsMenu = document.getElementById('auctions-menu');
    const productsMenu = document.getElementById('products-menu');

    function showNewAuctionTable() {
        newAuction.hidden = false;
        auctioneerPanel.hidden = true;
        newAuctionButton.style.display = "none";
        filterForm.style.display = "none";
        auctionCreateButton.hidden = false;
    }

    function showProductsMenu() {
        productsButton.style.borderBottom = "2px solid";
        productsMenu.style.display = "block";
        auctionsButton.style.borderBottom = "none";
        auctionsMenu.style.display = "none";
    }

    function showAuctionsMenu() {
        productsButton.style.borderBottom = "none";
        productsMenu.style.display = "none";
        auctionsButton.style.borderBottom = "2px solid";
        auctionsMenu.style.display = "block";
    }

    const urlParams = new URLSearchParams(window.location.search);
    const menu = urlParams.get('menu');

    if (menu === 'auctions') {
        showAuctionsMenu();
    } else {
        showProductsMenu(); // Muestra el menú de productos por defecto
    }

    newAuctionButton.addEventListener('click', showNewAuctionTable);
    productsButton.addEventListener('click', showProductsMenu);
    auctionsButton.addEventListener('click',showAuctionsMenu)
});
