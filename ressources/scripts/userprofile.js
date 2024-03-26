// Récupérer le modal
var modal = document.getElementById("myModal");

// Récupérer les boutons qui ouvrent les pages modales
var infoBtn = document.getElementById("infoBtn");
var cocktailBtn = document.getElementById("cocktailBtn");
var supportBtn = document.getElementById("supportBtn");

// Récupérer l'élément <span> qui ferme le modal
var span = document.getElementsByClassName("close")[0];

// Récupérer les pages de contenu
var infoPage = document.getElementById("infoPage");
var mycocktailPage = document.getElementById("mycocktailPage");
var supportPage = document.getElementById("supportPage");

// Fonction pour afficher le modal et la page correspondante
function openModal(page) {
    modal.style.display = "block";
    infoPage.style.display = "none";
    mycocktailPage.style.display = "none";
    supportPage.style.display = "none";
    page.style.display = "block";
}

// S'assurer que ca sois la page Info personnelle lorsque le bouton Profile User est cliqué
document.getElementById("myBtn").onclick = function () {
    openModal(infoPage);
}

// Lorsque l'utilisateur clique sur les boutons pour ouvrir les pages correspondantes
infoBtn.onclick = function () {
    openModal(infoPage);
}

cocktailBtn.onclick = function () {
    openModal(mycocktailPage);
}

supportBtn.onclick = function () {
    openModal(supportPage);
}

// Lorsque l'utilisateur clique sur <span> (x), fermer le modal
span.onclick = function () {
    modal.style.display = "none";
}

// Lorsque l'utilisateur clique n'importe où en dehors du modal, le fermer
window.onclick = function (event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

// Envoyer un email directement à notre email de support
document.getElementById("contactForm").addEventListener("submit", function (event) {
    event.preventDefault();

    var message = document.getElementById("message").value;

    // Envoyer l'email
    var mailtoLink = "mailto:cocktailwizard.supp0rt@gmail.com?subject=Demande de support&body=" + encodeURIComponent(message);
    window.location.href = mailtoLink;
});

//CETTE PARTI AVEC LE EMAIL EST A COMPLETE
