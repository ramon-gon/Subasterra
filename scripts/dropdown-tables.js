document.querySelectorAll('.short-info-dropdown').forEach(function(row) {
    row.addEventListener('click', function() {
        const nextRow = this.nextElementSibling;
        const arrowIcon = this.querySelector('.arrow-icon img'); 

        if (nextRow && nextRow.classList.contains('detailed-info-content')) {
            nextRow.classList.toggle('detailed-info-expanded');

            if (nextRow.classList.contains('detailed-info-expanded')) {
                arrowIcon.src = '/images/arrow-down.svg'; 
            } else {
                arrowIcon.src = '/images/arrow-right.svg';
            }
        }
    });
});