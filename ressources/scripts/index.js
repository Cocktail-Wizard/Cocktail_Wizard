const MODELE_CARTE_COCKTAIL = "ressources/modeles/cocktail_carte.html";
const galerie = document.getElementById('galerie');
const nombreCocktailsAffiches = 20;
const iconesUmami = {
    'Sucré': 'icone-sucre-sucre',
    'Aigre': 'icone-citron-aigre',
    'Amer': 'icone-cafe-amer',
    'Épicé': 'icone-piment-epice',
    'Salé': 'icone-sel-sale',
    'default': 'point-interrogation'
};

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

            // Définir le nom
            const nomCocktail = nouveauCocktail.querySelector('#nom-cocktail');
            nomCocktail.textContent = cocktail.nom;

            // Afficher l'icone du profil gustatif
            const umamiCocktail = nouveauCocktail.querySelector('#icone-saveur');
            umamiCocktail.src = `ressources/images/${iconesUmami[cocktail.umami]}.svg` || iconesUmami['default'];

            const imageCocktail = nouveauCocktail.querySelector('#illustration-cocktail');
            imageCocktail.src = `https://picsum.photos/seed/${cocktail.nom.replace(/[^a-zA-Z0-9]/g, '')}/200/300`;
            imageCocktail.loading = "lazy";

            // Ajouter le cocktail à la galerie
            galerie.appendChild(nouveauCocktail);
        });
    }
});
