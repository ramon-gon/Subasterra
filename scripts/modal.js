document.querySelectorAll('.assign-btn').forEach(button => {
  button.addEventListener('click', event => {
      event.preventDefault();
      const productId = button.getAttribute("data-product-id");
      const modal = document.getElementById(`auction-modal-confirm_${productId}`);
      const modalClose = document.getElementById(`close-modal_${productId}`);
      const denyAssignButton = modal.querySelector(`#not-assign`);

      modal.style.display = "block";

      modalClose.onclick = function() {
          modal.style.display = "none";
      };

      denyAssignButton.onclick = function () {
          modal.style.display = "none";
      };

      window.onclick = function(event) {
          if (event.target == modal) {
              modal.style.display = "none";
          }
      };
  });
});
