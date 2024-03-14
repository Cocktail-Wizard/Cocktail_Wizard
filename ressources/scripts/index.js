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

// Générer la liste complète des cocktails
let nomsCocktails = [];

for (let i = 0; i < nombreCocktailsAffiches; i++) {
    const nomAleatoire = genererMotAleatoire(genererNombreAleatoire(6, 12));
    nomsCocktails.push(nomAleatoire);
}

const cocktails = genererListeCocktails(nomsCocktails);

document.addEventListener("DOMContentLoaded", async () => {
    const modeleHTML = await chargerModeleHTML("ressources/modeles/cocktail_carte.html");

    if (modeleHTML) {
        cocktails.forEach((cocktail) => {
            // Créer une copie du modèle HTML pour chaque cocktail
            const nouveauCocktail = document.createElement('article');
            nouveauCocktail.classList.add('cocktail')
            nouveauCocktail.innerHTML = modeleHTML;

            // Définir le nom
            const nomCocktail = nouveauCocktail.querySelector('.nom-cocktail');
            nomCocktail.textContent = cocktail.nom;

            // Afficher l'icone "j'aime"
            const iconeJAime = nouveauCocktail.querySelector('.icone-jaime');
            iconeJAime.src = "ressources/images/icone-coeur-vide.svg"

            // Afficher l'icone de l'alcool principal
            const iconeAlcool = nouveauCocktail.querySelector('.pastille-alcool');
            iconeAlcool.src = "ressources/images/pastille-alcool.svg";

            // Afficher l'icone du profil gustatif
            const umamiCocktail = nouveauCocktail.querySelector('.icone-saveur');
            umamiCocktail.src = `ressources/images/${iconesUmami[cocktail.umami]}.svg` || iconesUmami['default'];

            // Ajouter l'image du cocktail
            const imageCocktail = nouveauCocktail.querySelector('.illustration-cocktail');
            imageCocktail.src = `https://picsum.photos/seed/${cocktail.nom.replace(/[^a-zA-Z0-9]/g, '')}/200/300`;
            imageCocktail.loading = "lazy";

            // Choisir la couleur de la pastille pour l'alcool principal
            const pastilleAlcool = nouveauCocktail.querySelector('.pastille-alcool');
            pastilleAlcool.style.filter = `hue-rotate(${Math.random() * 360}deg)`;

            // Afficher le nombre de mentions "j'aime"
            const compteurJaime = nouveauCocktail.querySelector('.compteur-jaime');
            compteurJaime.textContent = cocktail.nb_likes;

            // Ajouter la fonctionnalité d'ouvrir la boite modale à la publication
            nouveauCocktail.addEventListener('click', () => {
                console.debug("id cocktail: ", cocktail.id_cocktail);
                chargerInformationsModale(cocktail.id_cocktail);
                sectionModale.style.display = "block";
            })

            // Ajouter le cocktail à la galerie
            galerie.appendChild(nouveauCocktail);
        });
    }
});

function chargerInformationsModale(idCocktail) {
    // Envoyer une requête à l'API pour ce cocktail, exemple: "https://cocktailwizard.com/cocktail/{id}"
}
