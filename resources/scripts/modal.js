// Get the modal
var modal = document.getElementById("modal-wrapper");

// Get the <span> element that closes the modal
var span = document.getElementById("close");

document.addEventListener("DOMContentLoaded", () => {
    var gallery = document.getElementsByClassName('cocktail');

    // When the user clicks on a cocktail, open the modal
    Array.from(gallery).forEach((cocktail) => {
        cocktail.addEventListener('click', () => {
            modal.style.display = "block";
        })
    })
});

// When the user clicks on <span> (x), close the modal
span.onclick = () => {
    modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = (event) => {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
