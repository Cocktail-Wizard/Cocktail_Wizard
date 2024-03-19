// Récuperation de la section de la boite modale dans le DOM
const sectionModale = document.getElementById("contenant-modale");

document.addEventListener("DOMContentLoaded", async () => {
    // Récuperation et utilisation du modèle de boite modale
    const modeleHTML = await chargerModeleHTML("ressources/modeles/cocktail_modale.html");

    if (modeleHTML) {
        sectionModale.innerHTML = modeleHTML;

        let span = document.getElementById("fermer");

        // Fermer la boite modale quand un utilisateur clique sur la croix
        span.onclick = () => {
            sectionModale.style.display = "none";
        }

        // Fermer la boite modale quand un utilisateur clique en dehors
        window.onclick = (event) => {
            if (event.target == sectionModale) {
                sectionModale.style.display = "none";
                sectionModale.innerHTML = modeleHTML;
            }
        }
    }
});
