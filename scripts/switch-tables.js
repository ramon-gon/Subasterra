document.addEventListener('DOMContentLoaded', function() {
    const newAuction = document.getElementById('new-auction');
    const auctioneerPanel = document.getElementById('auctioneer-panel');
    
    const newAuctionButton = document.getElementById('new-auction-button');
    const auctionCreateButton = document.getElementById('auction-create');

    // Mostrar tabla de nueva subasta y ocultar el panel de subastador
    function showNewAuctionTable() {
        newAuction.hidden = false;
        auctioneerPanel.hidden = true;
        newAuctionButton.hidden = true;
        auctionCreateButton.hidden = false;
    }

    // Volver a mostrar el panel del subastador
    function showAuctioneerPanel() {
        newAuction.hidden = true;
        auctioneerPanel.hidden = false;
        newAuctionButton.hidden = false;
        auctionCreateButton.hidden = true;
    }

    // Evento para mostrar la tabla de nueva subasta
    newAuctionButton.addEventListener('click', showNewAuctionTable);

    // En caso de que quieras alternar entre las tablas tras crear la subasta
    auctionCreateButton.addEventListener('click', showAuctioneerPanel);
});
