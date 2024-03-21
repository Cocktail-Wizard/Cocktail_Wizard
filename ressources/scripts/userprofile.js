// Get the modal
var modal = document.getElementById("myModal");

// Get the buttons that open the modal pages
var infoBtn = document.getElementById("infoBtn");
var cocktailBtn = document.getElementById("cocktailBtn");
var supportBtn = document.getElementById("supportBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// Get the content pages
var infoPage = document.getElementById("infoPage");
var mycocktailPage = document.getElementById("mycocktailPage");
var supportPage = document.getElementById("supportPage");

// Function to show modal and corresponding page
function openModal(page) {
    modal.style.display = "block";
    infoPage.style.display = "none";
    mycocktailPage.style.display = "none";
    supportPage.style.display = "none";
    page.style.display = "block";
}

// Open the modal with the Info personnelle page when the Profile User button is clicked
document.getElementById("myBtn").onclick = function () {
    openModal(infoPage);
}

// When the user clicks on the buttons to open corresponding pages
infoBtn.onclick = function () {
    openModal(infoPage);
}

cocktailBtn.onclick = function () {
    openModal(mycocktailPage);
}

supportBtn.onclick = function () {
    openModal(supportPage);
}

// When the user clicks on <span> (x), close the modal
span.onclick = function () {
    modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function (event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

//envoyer un email directement a notre email de support
document.getElementById("contactForm").addEventListener("submit", function (event) {
    event.preventDefault();

    var message = document.getElementById("message").value;

    // Send email
    var mailtoLink = "mailto:cocktailwizard.supp0rt@gmail.com?subject=Support Request&body=" + encodeURIComponent(message);
    window.location.href = mailtoLink;
});
