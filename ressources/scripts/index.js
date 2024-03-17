const galerie = document.getElementById('galerie');
const iconesUmami = {
    'Sucré': 'icone-sucre-sucre',
    'Aigre': 'icone-citron-aigre',
    'Amer': 'icone-cafe-amer',
    'Épicé': 'icone-piment-epice',
    'Salé': 'icone-sel-sale',
    'default': 'point-interrogation'
};
const nbCocktailsGalerie = 20;

document.addEventListener("DOMContentLoaded", async () => {
    const modeleHTML = await chargerModeleHTML("ressources/modeles/cocktail_carte.html");

    if (modeleHTML) {
        try {
            const response = await fetch(`../ressources/api/galerie.php?nombre=${nbCocktailsGalerie}`);
            if (!response.ok) {
                throw new Error('La requête a échoué');
            }
            const data = await response.json();
            afficherCocktails(data, modeleHTML);
            console.debug('Données stockées dans localStorage : ', data);
        } catch (error) {
            console.error('Erreur : ', error);
        }
    }
});

function afficherCocktails(data, modeleHTML) {
    data.forEach((cocktail) => {
        const nouveauCocktail = document.createElement('article');
        nouveauCocktail.classList.add('cocktail');
        nouveauCocktail.innerHTML = modeleHTML;

        const nomCocktail = nouveauCocktail.querySelector('.nom-cocktail');
        nomCocktail.textContent = cocktail.nom;

        const iconeJAime = nouveauCocktail.querySelector('.icone-jaime');
        iconeJAime.src = "ressources/images/icone-coeur-vide.svg";

        const iconeAlcool = nouveauCocktail.querySelector('.pastille-alcool');
        iconeAlcool.src = "ressources/images/pastille-alcool.svg";

        const umamiCocktail = nouveauCocktail.querySelector('.icone-saveur');
        umamiCocktail.src = `ressources/images/${iconesUmami[cocktail.umami]}.svg` || iconesUmami['default'];

        const imageCocktail = nouveauCocktail.querySelector('.illustration-cocktail');
        imageCocktail.src = `https://picsum.photos/seed/${nettoyerNomCocktail(cocktail.nom)}/200/300`;
        imageCocktail.loading = "lazy";

        const pastilleAlcool = nouveauCocktail.querySelector('.pastille-alcool');
        pastilleAlcool.style.filter = `hue-rotate(${Math.random() * 360}deg)`;

        const compteurJaime = nouveauCocktail.querySelector('.compteur-jaime');
        compteurJaime.textContent = cocktail.nb_likes;

        nouveauCocktail.addEventListener('click', () => {
            console.debug("id cocktail: ", cocktail.id_cocktail);
            chargerInformationsModale(cocktail.id_cocktail);
            sectionModale.style.display = "block";
        });

        galerie.appendChild(nouveauCocktail);
    });
}

function nettoyerNomCocktail(nom) {
    return nom.replace(/[^a-zA-Z0-9]/g, '');
}

function chargerInformationsModale(idCocktail) {
    // Envoyer une requête à l'API pour ce cocktail, exemple: "https://cocktailwizard.com/cocktail/{id}"
}
