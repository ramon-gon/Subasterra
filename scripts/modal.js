const modal = document.getElementById("auction-modal-confirm");
const modalClose = document.getElementById("close-modal");
const denyAssignButton = document.getElementById("not-assign");

const modalOpenButtons = document.querySelectorAll(".assign-btn");
modalOpenButtons.forEach(btn => {
    btn.onclick = function(event) {
        event.preventDefault();
        modal.style.display = "block";
    };
});

modalClose.onclick = function() {
    modal.style.display = "none";
};

denyAssignButton.onclick = function () {
    modal.style.display = "none";
}

window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
};

