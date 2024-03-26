const sectionModale = document.getElementById("contenant-modale");

// Fonction pour réinitialiser la boîte modale
function reinitialiserModale(modeleHTML) {
    sectionModale.style.display = "none";
    sectionModale.innerHTML = modeleHTML;

    const span = document.getElementById("fermer");

    // Fermer la boite modale quand un utilisateur clique sur la croix
    span.addEventListener("click", () => {
        reinitialiserModale(modeleHTML);
    });
}

document.addEventListener("DOMContentLoaded", async () => {
    const modeleHTML = await chargerModeleHTML("ressources/modeles/cocktail_modale.html");

    if (modeleHTML) {
        reinitialiserModale(modeleHTML);

        // Fermer la boite modale quand un utilisateur clique en dehors
        window.addEventListener("click", (event) => {
            if (event.target === sectionModale) {
                reinitialiserModale(modeleHTML);
            }
        });
    }
});
