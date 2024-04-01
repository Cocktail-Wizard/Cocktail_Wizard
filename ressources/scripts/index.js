const ordreCommentaires = 'date';
const ordreCocktails = 'date';
const galerie = document.getElementById('galerie');
const barreRecherche = document.getElementById('barre-recherche');
const finAttenteEcriture = 1000; // 1 seconde
const iconesUmami = {
    'Sucré': 'icone-sucre-sucre',
    'Aigre': 'icone-citron-aigre',
    'Amer': 'icone-cafe-amer',
    'Épicé': 'icone-piment-epice',
    'Salé': 'icone-sel-sale',
    'default': 'point-interrogation'
};

let chronoEcriture;
let modeleCarteCocktail;

document.addEventListener('DOMContentLoaded', async () => {
    modeleCarteCocktail = await chargerModeleHTML('ressources/modeles/cocktail_carte.html');
    const username = getCookie("username");
    console.debug("Username:", username);

    if (!modeleCarteCocktail) return;

    // Rendre la constante immuable
    Object.freeze(modeleCarteCocktail);

    try {
        const data = await faireRequete('/api/cocktails/tri/like');
        if (data) {
            afficherCocktails(data, modeleCarteCocktail);
        }
    } catch (error) {
        console.error('Erreur : ', error);
    }

    barreRecherche.addEventListener('input', () => {
        clearTimeout(chronoEcriture);
        chronoEcriture = setTimeout(chercherCocktail, finAttenteEcriture);
    });
});

function afficherCocktails(data, modeleHTML) {
    const fragment = document.createDocumentFragment();
    const modeleTemp = document.createElement('div');
    modeleTemp.innerHTML = modeleHTML;
    const modeleClone = modeleTemp.firstElementChild.cloneNode(true);

    data.forEach((cocktail) => {
        if (!cocktail) return;

        const nouveauCocktail = modeleClone.cloneNode(true);

        const nomCocktail = nouveauCocktail.querySelector('.nom-cocktail');
        nomCocktail.textContent = cocktail.nom;

        const iconeJAime = nouveauCocktail.querySelector('.icone-jaime');
        iconeJAime.src = 'ressources/images/icone-coeur-vide.svg';

        const iconeAlcool = nouveauCocktail.querySelector('.icone-pastille-alcool');
        iconeAlcool.src = 'ressources/images/pastille-alcool.svg';

        const umamiCocktail = nouveauCocktail.querySelector('.icone-saveur');
        umamiCocktail.src = `ressources/images/${iconesUmami[cocktail.profil_saveur]}.svg` || `${iconesUmami['default']}.svg`;

        const imageCocktail = nouveauCocktail.querySelector('.illustration-cocktail');
        imageCocktail.src = `https://picsum.photos/200/300`;
        imageCocktail.loading = 'lazy';

        const pastilleAlcool = nouveauCocktail.querySelector('.icone-pastille-alcool');
        pastilleAlcool.style.filter = `hue-rotate(${Math.random() * 360}deg)`;

        const compteurJaime = nouveauCocktail.querySelector('.compteur-jaime');
        compteurJaime.textContent = cocktail.nb_like;

        const infobulleCocktail = nouveauCocktail.querySelector('.text-infobulle');
        infobulleCocktail.textContent = cocktail.alcool_principale;

        nouveauCocktail.addEventListener('click', (event) => {
            const idCocktail = event.currentTarget.dataset.idCocktail;
            sectionModale.style.display = 'block';
            chargerInformationsModale(cocktail);
            chargerCommentairesModale(idCocktail, ordreCommentaires);
        });

        nouveauCocktail.dataset.idCocktail = cocktail.id_cocktail;

        fragment.appendChild(nouveauCocktail);
    });

    galerie.appendChild(fragment);
}

async function chargerInformationsModale(cocktail) {
    actualiserTextElementParId('auteur', `@${cocktail.auteur}`);
    actualiserTextElementParId('compteur-jaime', cocktail.nb_like);
    actualiserTextElementParId('titre-cocktail', cocktail.nom);
    actualiserTextElementParId('description', cocktail.desc);
    actualiserTextElementParId('preparation', cocktail.preparation);
    actualiserTextElementParId('date-publication', cocktail.date);

    const ingredients = document.getElementById('ingredients');
    ingredients.innerHTML = '';

    cocktail.ingredients_cocktail.forEach((ingredient) => {
        const ligneIngredient = document.createElement('li');
        const quantiteIngredient = document.createElement('span');
        const uniteIngredient = document.createElement('span');
        const nomIngredient = document.createElement('span');

        quantiteIngredient.innerText = ingredient.quantite;
        uniteIngredient.innerText = ingredient.unite;
        nomIngredient.innerText = ingredient.ingredient;

        ligneIngredient.appendChild(quantiteIngredient);
        ligneIngredient.appendChild(uniteIngredient);
        ligneIngredient.appendChild(nomIngredient);

        ingredients.appendChild(ligneIngredient);
    });
}

async function chargerCommentairesModale(idCocktail) {
    const modeleHTML = await chargerModeleHTML('ressources/modeles/modale_commentaire.html');

    if (modeleHTML) {
        try {
            const data = await faireRequete('/api/cocktails/' + idCocktail + '/commentaires');
            if (data === null) {
                return;
            }

            const listeCommentaires = document.getElementById('commentaires');
            listeCommentaires.innerHTML = '';

            data.forEach((commentaire) => {
                const nouveauCommentaireTemp = document.createElement('li');

                nouveauCommentaireTemp.innerHTML = modeleHTML;

                const nouveauCommentaire = nouveauCommentaireTemp.firstElementChild.cloneNode(true);

                const auteurCommentaire = nouveauCommentaire.querySelector('.auteur');
                auteurCommentaire.innerText = `@${commentaire.auteur}`;

                const dateCommentaire = nouveauCommentaire.querySelector('.date');
                dateCommentaire.innerText = commentaire.date;

                const messageCommentaire = nouveauCommentaire.querySelector('.contenu');
                messageCommentaire.innerText = commentaire.contenu;

                listeCommentaires.appendChild(nouveauCommentaire);
            });

        } catch (error) {
            console.error('Erreur : ', error);
        }
    }
}

async function chercherCocktail() {
    const recherche = barreRecherche.value.replace(/[^a-zA-Z0-9]/g, '_');
    const endpoint = recherche ? `/recherche/${recherche}` : '';
    const data = await faireRequete(`/api/cocktails/tri/${ordreCocktails}${endpoint}`);

    if (data) {
        galerie.innerHTML = '';
        afficherCocktails(data, modeleCarteCocktail);
    }
}
