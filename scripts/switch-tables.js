document.addEventListener('DOMContentLoaded', function() {
    const newAuction = document.getElementById('new-auction');
    const auctioneerPanel = document.getElementById('auctioneer-panel');
    
    const newAuctionButton = document.getElementById('new-auction-button');
    const auctionCreateButton = document.getElementById('auction-create');

    const filterForm = document.getElementById('filter-form');


    function showNewAuctionTable() {
        newAuction.hidden = false;
        auctioneerPanel.hidden = true;
        newAuctionButton.style.display = "none";
        filterForm.style.display = "none";
        auctionCreateButton.hidden = false;
    }

    newAuctionButton.addEventListener('click', showNewAuctionTable);
});
