const nbCocktailsGalerie = 20;
const ordreCommentaires = 'date';
const galerie = document.getElementById('galerie');
const iconesUmami = {
    'Sucré': 'icone-sucre-sucre',
    'Aigre': 'icone-citron-aigre',
    'Amer': 'icone-cafe-amer',
    'Épicé': 'icone-piment-epice',
    'Salé': 'icone-sel-sale',
    'default': 'point-interrogation'
};

async function faireRequete(url) {
    try {
        const reponse = await fetch(url);
        if (!reponse.ok) {
            throw new Error('La requête a échoué');
        }
        return await reponse.json();
    } catch (error) {
        console.error('Erreur : ', error);
        return null;
    }
}

document.addEventListener("DOMContentLoaded", async () => {
    const modeleHTML = await chargerModeleHTML("ressources/modeles/cocktail_carte.html");

    if (modeleHTML) {
        try {
            const data = await faireRequete(`${API_URL}/cocktails/tri/like`);
            if (data) {
                afficherCocktails(data, modeleHTML);
            }
        } catch (error) {
            console.error('Erreur : ', error);
        }
    }
});

function afficherCocktails(data, modeleHTML) {
    const fragment = document.createDocumentFragment();
    const modeleTemp = document.createElement('div');

    modeleTemp.innerHTML = modeleHTML;

    const modeleClone = modeleTemp.firstElementChild.cloneNode(true);

    data.forEach((cocktail) => {
        const nouveauCocktail = modeleClone.cloneNode(true);

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

        nouveauCocktail.addEventListener('click', (event) => {
            const idCocktail = event.currentTarget.dataset.idCocktail;
            sectionModale.style.display = "block";
            chargerInformationsModale(idCocktail);
            chargerCommentairesModale(idCocktail, ordreCommentaires);
        });

        nouveauCocktail.dataset.idCocktail = cocktail.id_cocktail;
        fragment.appendChild(nouveauCocktail);
    });

    galerie.appendChild(fragment);
}

function nettoyerNomCocktail(nom) {
    return nom.replace(/[^a-zA-Z0-9]/g, '');
}

async function chargerInformationsModale(idCocktail) {
    try {
        const data = await faireRequete(`../ressources/api/modale_cocktail.php?id=${idCocktail}`);
        if (data === null) {
            return;
        }

        const auteur = document.getElementById('auteur');
        auteur.innerText = `@${data.auteur}`;

        const jaimes = document.getElementById('compteur-jaime');
        jaimes.innerText = data.nb_like;

        const titre = document.getElementById('titre-cocktail');
        titre.innerText = data.nom;

        const description = document.getElementById('description');
        description.innerText = data.desc;

        const preparation = document.getElementById('preparation');
        preparation.innerText = data.preparation;

        const date = document.getElementById('date-publication');
        date.innerText = data.date;

        const ingredients = document.getElementById('ingredients');
        ingredients.innerHTML = '';

        data.ingredients_cocktail.forEach((ingredient) => {
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
    } catch (error) {
        console.error('Erreur : ', error);
    }
}

async function chargerCommentairesModale(idCocktail, ordre) {
    const modeleHTML = await chargerModeleHTML("ressources/modeles/modale_commentaire.html");

    if (modeleHTML) {
        try {
            const data = await faireRequete(`../ressources/api/modale_commentaires.php?id=${idCocktail}&orderby=${ordre}`);
            if (data === null) {
                return;
            }

            console.debug("Données récuperées de l'API des commentaires : ", data);

            const listeCommentaires = document.getElementById('commentaires');
            listeCommentaires.innerHTML = '';

            data.forEach((commentaire) => {
                const nouveauCommentaireTemp = document.createElement('li');

                nouveauCommentaireTemp.innerHTML = modeleHTML;

                const nouveauCommentaire = nouveauCommentaireTemp.firstElementChild.cloneNode(true);

                const auteurCommentaire = nouveauCommentaire.querySelector('.auteur');
                auteurCommentaire.innerText = `@${commentaire.auteur}`;

                const dateCommentaire = nouveauCommentaire.querySelector('.date');
                dateCommentaire.innerText = commentaire.date_publication;

                const messageCommentaire = nouveauCommentaire.querySelector('.contenu');
                messageCommentaire.innerText = commentaire.message;

                listeCommentaires.appendChild(nouveauCommentaire);
            });

        } catch (error) {
            console.error('Erreur : ', error);
        }
    }
}
