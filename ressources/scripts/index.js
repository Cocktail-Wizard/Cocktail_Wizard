const MODELE_CARTE_COCKTAIL = "ressources/modeles/cocktail_carte.html";
const galerie = document.getElementById('galerie');
const nombreCocktailsAffiches = 20;

// Fonction pour charger le modèle HTML
async function chargerModeleHTML() {
    try {
        const reponse = await fetch(MODELE_CARTE_COCKTAIL);
        if (!reponse.ok) {
            throw new Error("Impossible de charger le modèle HTML.");
        }

        return await reponse.text();
    } catch (error) {
        console.error("Erreur lors du chargement du modèle HTML :", error);
        return null;
    }
}

// Générer la liste complète des cocktails
let nomsCocktails = [];

for (let i = 0; i < nombreCocktailsAffiches; i++) {
    const nomAleatoire = genererMotAleatoire(getRandomInt(6, 12));
    nomsCocktails.push(nomAleatoire);
}

const cocktails = genererListeCocktails(nomsCocktails);

document.addEventListener("DOMContentLoaded", async () => {
    const modeleHTML = await chargerModeleHTML();

    if (modeleHTML) {
        cocktails.forEach((cocktail) => {
            // Créer une copie du modèle HTML pour chaque cocktail
            const nouveauCocktail = document.createElement('article');
            nouveauCocktail.classList.add('cocktail')
            nouveauCocktail.innerHTML = modeleHTML;

            // Remplacer les éléments du modèle HTML avec les données du cocktail
            const nomCocktailElement = nouveauCocktail.querySelector('#nom-cocktail');
            nomCocktailElement.textContent = cocktail.nom;

            const imageCocktailElement = nouveauCocktail.querySelector('#illustration-cocktail');
            imageCocktailElement.src = `https://picsum.photos/seed/${cocktail.nom.replace(/[^a-zA-Z0-9]/g, '')}/200/300`;
            imageCocktailElement.loading = "lazy";

            // Ajouter le cocktail à la galerie
            galerie.appendChild(nouveauCocktail);
        });
    }
});
