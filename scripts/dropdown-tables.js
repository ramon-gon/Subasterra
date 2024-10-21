document.querySelectorAll('.short-info-dropdown').forEach(function(row) {
    row.addEventListener('click', function() {
        let nextRow = this.nextElementSibling;
        if (nextRow && nextRow.classList.contains('detailed-info-content')) {
            nextRow.classList.toggle('detailed-info-expanded');
        }
    });
});
