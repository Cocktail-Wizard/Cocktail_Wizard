const MODAL_TEMPLATE = "ressources/modeles/cocktail_modal.html";

// Récuperation de la section de la boite modale dans le DOM
let sectionModale = document.getElementById("modal-wrapper");

document.addEventListener("DOMContentLoaded", () => {
    // Récuperation et utilisation du modèle de boite modale
    fetch(MODAL_TEMPLATE)
        .then(reponse => {
            if (!reponse.ok) {
                throw new Error("Impossible de récuperer le modèle.");
            }
            return reponse.text();
        })
        .then(data => {
            sectionModale.innerHTML = data;
        })
        .then(() => {
            // Récupération des éléments du template après qu'ils aient été ajoutés au DOM
            let span = document.getElementById("close");

            span.onclick = () => {
                sectionModale.style.display = "none";
            }
        })
        .catch(error => {
            console.error("Il y'a eu une erreur lors de la récuperation :", error);
        });

    let gallery = document.getElementsByClassName('cocktail');

    // Quand un utilisateur clique sur un cocktail, ouvrir la boite modale
    Array.from(gallery).forEach((cocktail) => {
        cocktail.addEventListener('click', () => {
            sectionModale.style.display = "block";
        })
    })

    // Fermer la boite modale quant un utilisateur clique en dehors
    window.onclick = (event) => {
        if (event.target == sectionModale) {
            sectionModale.style.display = "none";
        }
    }
});
