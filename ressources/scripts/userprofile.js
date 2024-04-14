// Zone d'affichage des cartes cocktails
const mesCocktails = document.getElementById('conteneur-mes-cocktails');

// Récupérer le modal
var modal = document.getElementById("my-modal");

// Récupérer les boutons qui ouvrent les pages modales
var infoBtn = document.getElementById("info-btn");
var cocktailBtn = document.getElementById("cocktail-btn");
var supportBtn = document.getElementById("support-btn");
var submitBtn = document.getElementById("submit-btn");

// Récupérer l'élément <span> qui ferme le modal
// var span = document.getElementsByClassName("close")[0];

// Récupérer les pages de contenu
var infoPage = document.getElementById("infoPage");
var mycocktailPage = document.getElementById("mycocktailPage");
var supportPage = document.getElementById("supportPage");

let pageProfile = 1;
const cocktailParPageProfile = 6;
let dernierChargementProfile = 0;


document.addEventListener("DOMContentLoaded", function () {
    // Cacher les pages autres que la page d'informations de l'utilisateur
    document.getElementById("mycocktailPage").style.display = "none";
    document.getElementById("supportPage").style.display = "none";

    // Fonction pour afficher la page d'informations de l'utilisateur
    document.getElementById("info-btn").addEventListener("click", function () {
        document.getElementById("infoPage").style.display = "block";
        document.getElementById("mycocktailPage").style.display = "none";
        document.getElementById("supportPage").style.display = "none";
    });

    // Fonction pour afficher la page Mes cocktails
    document.getElementById("cocktail-btn").addEventListener("click", function () {
        document.getElementById("infoPage").style.display = "none";
        document.getElementById("mycocktailPage").style.display = "block";
        document.getElementById("supportPage").style.display = "none";
    });

    // Fonction pour afficher la page Support
    document.getElementById("support-btn").addEventListener("click", function () {
        document.getElementById("infoPage").style.display = "none";
        document.getElementById("mycocktailPage").style.display = "none";
        document.getElementById("supportPage").style.display = "block";
    });

    // Fonction pour se déconnecter
    document.getElementById("deconnexion").addEventListener("click", function () {
        fetch('/authentification', {
            method: 'DELETE'
        })
            .then(response => {
                if (response.ok) {
                    deleteCookie('username');
                    window.location.href = '/';
                } else {
                    throw new Error('La déconnexion a échoué.');
                }
            })
            .catch(error => console.error('Erreur lors de la déconnexion:', error));
    });

    fetch(`/api/users?user=${utilisateur}`)
    .then(response => response.json())
    .then(user => {
        document.getElementById('username').textContent = user.nom;
        document.getElementById('email').textContent = user.courriel;
        document.getElementById('cocktailCount').textContent = user.nb_cocktail_cree;
        document.getElementById('likeCount').textContent = user.nb_cocktail_favoris;
        document.getElementById('commentCount').textContent = user.nb_commentaire;
    })
    .catch(error => console.error('Erreur lors de la récupération des informations de l\'utilisateur:', error));

    mesCocktails.addEventListener('scroll', function() {

        if((mesCocktails.scrollLeft + mesCocktails.clientWidth) >= (mesCocktails.scrollWidth-2) && dernierChargementProfile != mesCocktails.scrollWidth) {
            pageProfile++;
            chargerCocktailsProfile();
            dernierChargementProfile = mesCocktails.scrollWidth;
        }
    });
});

$('#my-modal').on('hidden.bs.modal', function () {
    document.getElementById("infoPage").style.display = "block";
    document.getElementById("mycocktailPage").style.display = "none";
    document.getElementById("supportPage").style.display = "none";
    mesCocktails.innerHTML = '';
    pageProfile = 1;
});

$('#my-modal').on('show.bs.modal', function () {
    chargerCocktailsProfile();
});

async function chargerCocktailsProfile() {
    const data = await faireRequete(`/api/cocktails?auteur=${utilisateur}&page=${pageProfile}-${cocktailParPageProfile}`);

    if(data) {
        afficherCocktailsPerso(data, modeleCarteCocktail, mesCocktails);
    }
}
