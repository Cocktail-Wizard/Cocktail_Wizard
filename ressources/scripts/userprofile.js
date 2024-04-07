// Récupérer le modal
var modal = document.getElementById("my-modal");

// Récupérer les boutons qui ouvrent les pages modales
var infoBtn = document.getElementById("info-btn");
var cocktailBtn = document.getElementById("cocktail-btn");
var supportBtn = document.getElementById("support-btn");
var submitBtn = document.getElementById("submit-btn");

// Récupérer l'élément <span> qui ferme le modal
var span = document.getElementsByClassName("close")[0];

// Récupérer les pages de contenu
var infoPage = document.getElementById("infoPage");
var mycocktailPage = document.getElementById("mycocktailPage");
var supportPage = document.getElementById("supportPage");


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
});

const username = getCookie('username');
//Sa devrait fonctionner une fois que la branche AjoutisLiked est mergé avec la branche develop
fetch(`/api/users/${username}`)
    .then(response => response.json())
    .then(user => {
        document.getElementById('username').textContent = user.nom;
        //document.getElementById('email').textContent = user.courriel;
        document.getElementById('cocktailCount').textContent = user.nb_cocktail_cree;
        document.getElementById('likeCount').textContent = user.nb_cocktail_favoris;
        document.getElementById('commentCount').textContent = user.nb_commentaire;
    })
    .catch(error => console.error('Erreur lors de la récupération des informations de l\'utilisateur:', error));

//récuperer les cocktails de l'utilisateur pour completer les infos
// fetch(`/api/users/${username}/cocktails`)
//     .then(response => response.json())
//     .then(cocktails => {
//         let totalLikes = 0;
//         cocktails.forEach(cocktail => {
//             // Pour chaque cocktail, récupérer le nombre de likes
//             fetch(`/api/cocktails/${cocktail.id}/likes`)
//                 .then(response => response.json())
//                 .then(data => {
//                     totalLikes += data.likeCount;
//                     // Mettre à jour le nombre total de likes
//                     document.getElementById('likeCount').textContent = totalLikes;
//                 })
//                 .catch(error => console.error('Erreur lors de la récupération du nombre de likes pour le cocktail', cocktail.id, ':', error));
//         });
//         document.getElementById('likeCount').textContent = cocktails.likeCount;
//         document.getElementById('cocktailCount').textContent = cocktails.cocktailCount;
//     })
//     .catch(error => console.error('Erreur lors de la récupération des cocktails de l\'utilisateur:', error));
