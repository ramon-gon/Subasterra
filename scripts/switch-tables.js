document.addEventListener('DOMContentLoaded', function() {
    const newAuction = document.getElementById('new-auction');
    const auctioneerPanel = document.getElementById('auctioneer-panel');
    
    const newAuctionButton = document.getElementById('new-auction-button');
    const auctionCreateButton = document.getElementById('auction-create');

    function showNewAuctionTable() {
        newAuction.hidden = false;
        auctioneerPanel.hidden = true;
        newAuctionButton.style.display = "none";
        auctionCreateButton.hidden = false;
    }

    function showAuctioneerPanel() {
        newAuction.hidden = true;
        auctioneerPanel.hidden = false;
        newAuctionButton.style.display = "flex";
        auctionCreateButton.hidden = true;
    }

    newAuctionButton.addEventListener('click', showNewAuctionTable);
});
