document.addEventListener('DOMContentLoaded', function() {
    const newAuction = document.getElementById('new-auction');
    const auctioneerPanel = document.getElementById('auctioneer-panel');
    
    const newAuctionButton = document.getElementById('new-auction-button');
    const AuctionCreateButton = document.getElementById('auction-create');

    function showNewAuctionTable() {
        newAuction.hidden = false;
        auctioneerPanel.hidden = true;
        newAuctionButton.style.display = "none";
        AuctionCreateButton.hidden = false;
    }

    function showAuctioneerPanel() {
        newAuction.hidden = true;
        auctioneerPanel.hidden = false;
        newAuctionButton.style.display = "flex";
        AuctionCreateButton.hidden = true;
    }

    newAuctionButton.addEventListener('click', showNewAuctionTable);
    AuctionCreateButton.addEventListener('click', showAuctioneerPanel);
});