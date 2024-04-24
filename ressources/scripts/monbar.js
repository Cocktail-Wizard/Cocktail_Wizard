const cocktailsClassiques = document.getElementById('conteneur-classique');
const cocktailsPersonnels = document.getElementById('conteneur-favoris');
const cocktailsCommunautaires = document.getElementById('conteneur-communautaires');
const ordreCommentaires = 'date';

let pageClassique = 1;
let pageFavoris = 1;
let pageCommunaute = 1;
const nbCocktailCharger = 6;

let dernierChargementClassique = 0;
let dernierChargementFavoris = 0;
let dernierChargementCommunaute = 0;

let modeleCarteCocktail;

//on vas chercher la liste d'ingredient dans la bd
let allIngredients = [];

async function getTousIngredients() {
    allIngredients = await faireRequete('/api/ingredients');
}

let selectedIngredients = [];


/**
 * Filtre et affiche les ingrédients en fonction de la valeur de recherche fournie.
 * Met à jour la liste des ingrédients disponibles en fonction de la saisie dans la barre de recherche.
 * Affiche les ingrédients filtrés dans une boîte déroulante et permet à l'utilisateur de sélectionner un ingrédient.
 * Les ingrédients déjà sélectionnés ne sont pas inclus dans les résultats.
 *
 * @function filterIngredients
 * @returns {void}
 */
function filterIngredients() {
    const searchValue = document.getElementById('boite-recherche').value.toLowerCase().trim();
    const listeIngredients = document.getElementById('liste-ingredients');

    // Affiche la liste uniquement si la recherche n'est pas vide
    listeIngredients.style.display = searchValue !== '' ? 'block' : 'none';
    // filtre les ingrédients en fonction de la recherche et des ingrédients déjà sélectionnés

    const filteredIngredients = allIngredients.filter(ingredient => !selectedIngredients.includes(ingredient) && ingredient.toLowerCase().includes(searchValue));


    // Efface le contenu précédent de la liste d'ingrédients
    listeIngredients.innerHTML = '';

    if (searchValue !== '') {
        if (filteredIngredients === null || filteredIngredients.length === 0) {
            // Affiche "Aucun résultat..." si aucun ingrédient n'est trouvé
            const noResultItem = document.createElement('div');
            noResultItem.textContent = 'Aucun résultat...';
            listeIngredients.appendChild(noResultItem);
        } else {
            // Crée et ajoute les ingrédients filtrés à la liste d'ingrédients
            filteredIngredients.forEach(ingredient => {
                const ingredientItem = document.createElement('div');
                ingredientItem.textContent = ingredient;
                ingredientItem.classList.add('ingredient-item');
                ingredientItem.addEventListener('click', (event) => {
                    selectIngredient(ingredient);
                    const ingredientClique = event.target.textContent;
                    ajouterIngredientBD(ingredientClique);
                });
                listeIngredients.appendChild(ingredientItem);
            });
        }
    }
}


// Ajoute un événement keyup à la barre de recherche pour filtrer les ingrédients à chaque frappe de touche
document.getElementById('boite-recherche').addEventListener('keyup', filterIngredients);



/**
 * Sélectionne un ingrédient et le rajoute à la liste des ingrédients sélectionnés.
 * Met à jour l'affichage des ingrédients sélectionnés et filtre les ingrédients disponibles pour éviter les doublons.
 *
 * @function selectIngredient
 * @param {string} ingredient - L'ingrédient à sélectionner.
 * @returns {void}
 */
function selectIngredient(ingredient) {
    selectedIngredients.push(ingredient);
    updateSelectedIngredients();
    filterIngredients(); //update le dropdown pour pas pouvoiur rajouter 100 fois la meme chose
}

/**
 * Désélectionne un ingrédient de la liste des ingrédients sélectionnés.
 * Met à jour l'affichage des ingrédients sélectionnés et filtre les ingrédients disponibles.
 *
 * @function unselectIngredient
 * @param {string} ingredient - L'ingrédient à désélectionner.
 * @returns {void}
 */
function unselectIngredient(ingredient) {
    const index = selectedIngredients.indexOf(ingredient);
    if (index !== -1) {
        selectedIngredients.splice(index, 1);
        updateSelectedIngredients();
        filterIngredients(); //update le dropdown pour rajouter l'element si deselectionner
    }
}

/**
 * Met à jour l'affichage des ingrédients sélectionnés dans la boîte dédiée.
 * Affiche chaque ingrédient sélectionné avec la possibilité de le désélectionner.
 * Assure que la boîte des ingrédients sélectionnés est visible même si elle est vide.
 *
 * @function updateSelectedIngredients
 * @returns {void}
 */
function updateSelectedIngredients() {

    const selectedIngredientsDiv = document.getElementById('ingredients-selectionne');
    selectedIngredientsDiv.innerHTML = '';

    selectedIngredients.forEach(ingredient => {
        const ingredientBox = document.createElement('span');
        ingredientBox.textContent = ingredient;
        ingredientBox.classList.add('ingredients-selectionne');
        ingredientBox.addEventListener('click', (event) => {
            unselectIngredient(ingredient);
            const ingredientClique = event.target.textContent;
            enleverIngredientBD(ingredientClique);
        });
        selectedIngredientsDiv.appendChild(ingredientBox);
    });
    selectedIngredientsDiv.style.display = 'flex'; // s'ssurer que la boîte des ingrédients sélectionnés est visible meme si vide
}

/**
 * Écouteur d'événements qui se déclenche lorsqu'un clic est effectué n'importe où sur le document.
 * Gère la fermeture de la liste des ingrédients déroulante si le clic est en dehors de la zone de recherche ou de la liste des ingrédients.
 * Assure que la liste des ingrédients reste visible tant que l'utilisateur ne clique pas en dehors de celle-ci.
 *
 * @event click
 * @param {Object} event - L'événement de clic déclenché.
 * @returns {void}
 */
document.addEventListener('click', function (event) {
    const boiteRecherche = document.getElementById('boite-recherche');
    const listeIngredients = document.getElementById('liste-ingredients');

    if (event.target !== boiteRecherche && event.target !== listeIngredients) {
        // Verifier si le clic n'est pas à l'intérieur de la liste
        if (!selectedIngredients.includes(event.target.textContent)) {
            listeIngredients.style.display = 'none'; // Ferme la liste si oui
        }
    } else {
        //s'assure que la liste reste visible tant que l'utilisateur clique pas a l'exterieur
        if (listeIngredients.style.display !== 'block') {
            filterIngredients();
        }
    }
});

/**
 * Appel initial pour afficher tous les ingrédients disponibles et les ingrédients sélectionnés.
 *
 * @function initialSetup
 * @returns {void}
 */
async function initialSetup() {

    getTousIngredients();
    const listIng = await faireRequete(`/api/ingredients?user=${utilisateur}`);
    if (listIng) {
        selectedIngredients = listIng;
    }
    filterIngredients(); // Appel initial pour afficher tous les ingrédients disponibles
    updateSelectedIngredients(); // Affiche initialement les ingrédients sélectionnés
}




/**
 * Écouteur d'événements qui se déclenche lorsque le DOM est entièrement chargé.
 * Initialise les fonctionnalités de recherche d'ingrédients, charge le modèle HTML pour la carte de cocktail,
 * récupère les données des cocktails depuis une API et affiche les cocktails sur la page.
 *
 * @event DOMContentLoaded
 * @param {Object} event - L'événement DOMContentLoaded déclenché.
 * @returns {void}
 */
document.addEventListener('DOMContentLoaded', async () => {
    inputRechercheIngredient = document.getElementById('boite-recherche');
    inputRechercheIngredient.addEventListener('input', filterIngredients);

    initialSetup();

    modeleCarteCocktail = await chargerModeleHTML('../ressources/modeles/cocktail_carte.html');

    if (!modeleCarteCocktail) {
        console.error('Impossible de charger le modèle de carte de cocktail.');
        return;
    }

    Object.freeze(modeleCarteCocktail);

    chargerCocktails();

    cocktailsClassiques.addEventListener('scroll', function () {
        if (cocktailsClassiques.scrollLeft + cocktailsClassiques.clientWidth >= cocktailsClassiques.scrollWidth - 2 && dernierChargementClassique !== cocktailsClassiques.scrollWidth) {
            pageClassique++;
            chargerCocktailsScroll(1);
            dernierChargementClassique = cocktailsClassiques.scrollWidth;
        }
    });

    cocktailsPersonnels.addEventListener('scroll', function () {
        if (cocktailsPersonnels.scrollLeft + cocktailsPersonnels.clientWidth >= cocktailsPersonnels.scrollWidth - 2 && dernierChargementFavoris !== cocktailsPersonnels.scrollWidth) {
            pageFavoris++;
            chargerCocktailsScroll(2);
            dernierChargementFavoris = cocktailsPersonnels.scrollWidth;
        }
    });

    cocktailsCommunautaires.addEventListener('scroll', function () {
        if (cocktailsCommunautaires.scrollLeft + cocktailsCommunautaires.clientWidth >= cocktailsCommunautaires.scrollWidth - 2 && dernierChargementCommunaute !== cocktailsCommunautaires.scrollWidth) {
            pageCommunaute++;
            chargerCocktailsScroll(3);
            dernierChargementCommunaute = cocktailsCommunautaires.scrollWidth;
        }
    });
});
async function chargerCocktailsScroll(type) {
    if (type == 1) {
        const data = await faireRequete(`/api/cocktails?user=${utilisateur}&type=classiques&page=${pageClassique}-${nbCocktailCharger}`);
        if (data) {
            afficherCocktailsPerso(data, modeleCarteCocktail, cocktailsClassiques);
        }
    } else if (type == 2) {
        const data = await faireRequete(`/api/cocktails?user=${utilisateur}&type=favoris&page=${pageFavoris}-${nbCocktailCharger}`);
        if (data) {
            afficherCocktailsPerso(data, modeleCarteCocktail, cocktailsPersonnels);
        }
    } else {
        const data = await faireRequete(`/api/cocktails?user=${utilisateur}&type=communaute&page=${pageCommunaute}-${nbCocktailCharger}`);
        if (data) {
            afficherCocktailsPerso(data, modeleCarteCocktail, cocktailsCommunautaires);
        }
    }
}


/**
 * Charge les données des cocktails depuis une API
 * /api/users/{username}/recommandations/type/{classiques/favoris/communaute}
 */
async function chargerCocktails() {
    pageClassique = 1;
    pageFavoris = 1;
    pageCommunaute = 1;
    const [dataClassique, dataFavoris, dataCommunaute] = await Promise.all([
        faireRequete(`/api/cocktails?user=${utilisateur}&type=classiques&page=${pageClassique}-${nbCocktailCharger}`),
        faireRequete(`/api/cocktails?user=${utilisateur}&type=favoris&page=${pageFavoris}-${nbCocktailCharger}`),
        faireRequete(`/api/cocktails?user=${utilisateur}&type=communaute&page=${pageCommunaute}-${nbCocktailCharger}`)
    ]);

    cocktailsClassiques.innerHTML = '';
    if (dataClassique) {
        afficherCocktailsPerso(dataClassique, modeleCarteCocktail, cocktailsClassiques);
    }
    cocktailsPersonnels.innerHTML = '';
    if (dataFavoris) {
        afficherCocktailsPerso(dataFavoris, modeleCarteCocktail, cocktailsPersonnels);
    }

    cocktailsCommunautaires.innerHTML = '';
    if (dataCommunaute) {
        afficherCocktailsPerso(dataCommunaute, modeleCarteCocktail, cocktailsCommunautaires);
        cocktailsCommunautaires.scrollTo(0, 0);
    }
}

/**
 * Affiche les cocktails sur la page en utilisant les données fournies et le modèle HTML spécifié.
 * Chaque cocktail est affiché avec son nom, icône "j'aime", icône d'alcool principal, icône de profil gustatif,
 * image, couleur de pastille alcool, nombre de mentions "j'aime", et la fonctionnalité pour ouvrir la boîte modale.
 * Les cocktails sont ajoutés aux sections classiques, personnels et communautaires.
 *
 * @function afficherCocktails
 * @param {Array} data - Les données des cocktails à afficher.
 * @param {HTMLElement} modeleHTML - Le modèle HTML pour la carte de cocktail.
 * @returns {void}
 */
function afficherCocktailsPerso(data, modeleHTML, divParent) {
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
        iconeJAime.src = 'ressources/images/icone-coeur-' + (cocktail.liked ? 'plein' : 'vide') + '.svg';

        const iconeAlcool = nouveauCocktail.querySelector('.icone-pastille-alcool');
        iconeAlcool.src = 'ressources/images/pastille-alcool.svg';

        const umamiCocktail = nouveauCocktail.querySelector('.icone-saveur');
        umamiCocktail.src = `ressources/images/${iconesUmami[cocktail.profil_saveur] ?? iconesUmami['default']}.svg`;
        umamiCocktail.title = cocktail.profil_saveur;

        const imageCocktail = nouveauCocktail.querySelector('.illustration-cocktail');
        imageCocktail.src = 'https://equipe105.tch099.ovh/images?image=' + cocktail.img_cocktail;
        imageCocktail.loading = 'lazy';
        if (cocktail.ingManquant !== null && cocktail.ingManquant > 0) {
            imageCocktail.style.filter = 'grayscale(100%)';
            const ingManquant = nouveauCocktail.querySelector('.ingredient-manquant');
            ingManquant.style.display = 'block';
            ingManquant.textContent = 'Il vous manque ' + cocktail.ingManquant + ' ingrédient' + (cocktail.ingManquant > 1 ? 's' : '');
        }

        const pastilleAlcool = nouveauCocktail.querySelector('.icone-pastille-alcool');
        pastilleAlcool.style.filter = `hue-rotate(${genererDegreDepuisString(cocktail.alcool_principale)}deg)`;

        const compteurJaime = nouveauCocktail.querySelector('.compteur-jaime');
        compteurJaime.textContent = cocktail.nb_like;

        const infobulleCocktail = nouveauCocktail.querySelector('.text-infobulle');
        infobulleCocktail.textContent = cocktail.alcool_principale;
        infobulleCocktail.href = cocktail.lien_saq;

        nouveauCocktail.addEventListener('click', (event) => {
            const idCocktail = event.currentTarget.dataset.idCocktail;
            sectionModale.style.display = 'block';
            chargerInformationsModale(cocktail);
            chargerCommentairesModale(idCocktail, ordreCommentaires);
            chargerCommenter(cocktail.id_cocktail);
        });

        nouveauCocktail.dataset.idCocktail = cocktail.id_cocktail;

        fragment.appendChild(nouveauCocktail);
    });

    divParent.appendChild(fragment);

}

/**
 * Nettoie le nom du cocktail en supprimant tous les caractères spéciaux, sauf les lettres de l'alphabet (minuscules et majuscules) et les chiffres.
 *
 * @function nettoyerNomCocktail
 * @param {string} nom - Le nom du cocktail à nettoyer.
 * @returns {string} - Le nom du cocktail nettoyé.
 */
function nettoyerNomCocktail(nom) {
    return nom.replace(/[^a-zA-Z0-9]/g, '');
}

async function chargerCommentairesModale(idCocktail) {
    const modeleHTML = await chargerModeleHTML('ressources/modeles/modale_commentaire.html');

    if (modeleHTML) {
        try {
            const data = await faireRequete(`/api/cocktails/commentaires?cocktail=${idCocktail}`);
            if (!data) return;

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

async function chargerInformationsModale(cocktail) {
    actualiserTextElementParId('auteur', `@${cocktail.auteur}`);
    actualiserTextElementParId('compteur-jaime', cocktail.nb_like);
    actualiserTextElementParId('titre-cocktail', cocktail.nom);
    actualiserTextElementParId('description', cocktail.desc);
    actualiserTextElementParId('preparation', cocktail.preparation);
    actualiserTextElementParId('date-publication', cocktail.date);


    const imageCocktail = document.getElementById('illustration');
    imageCocktail.src = 'https://equipe105.tch099.ovh/images?image=' + cocktail.img_cocktail;

    if (utilisateur) {
        actualiserTextElementParId('auteur-commentaire', utilisateur);
    } else {
        actualiserTextElementParId('text-auteur', 'Vous devez être connecté(e) pour commenter.');
    }

    const ingredients = document.getElementById('ingredients');
    ingredients.innerHTML = '';

    const iconeJAime = document.getElementById('icone-jaime');
    iconeJAime.src = 'ressources/images/icone-coeur-' + (cocktail.liked ? 'plein' : 'vide') + '.svg';

    const spanJAime = document.getElementById('affichage-jaime');

    if (utilisateur) {
        spanJAime.addEventListener('click', async () => {
            fetch('/api/cocktails/like', {
                method: cocktail.liked ? 'DELETE' : 'POST',
                body: JSON.stringify({
                    id_cocktail: cocktail.id_cocktail,
                    username: utilisateur
                }),
                headers: { 'Content-Type': 'application/json; charset=UTF-8' }
            }
            ).then((response) => {
                if (response.ok) {
                    const comptJaime = document.querySelector('article[data-id-cocktail="' + cocktail.id_cocktail + '"] .compteur-jaime');
                    const iconeJaimeCarte = document.querySelector('article[data-id-cocktail="' + cocktail.id_cocktail + '"] .icone-jaime');
                    cocktail.nb_like = cocktail.liked ? cocktail.nb_like - 1 : cocktail.nb_like + 1;
                    comptJaime.textContent = cocktail.nb_like;
                    cocktail.liked = !cocktail.liked;
                    iconeJAime.src = 'ressources/images/icone-coeur-' + (cocktail.liked ? 'plein' : 'vide') + '.svg';
                    iconeJaimeCarte.src = 'ressources/images/icone-coeur-' + (cocktail.liked ? 'plein' : 'vide') + '.svg';
                    actualiserTextElementParId('compteur-jaime', cocktail.nb_like);
                    chargerCocktails();
                }
            })
        });
    }

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

    if (!utilisateur) return;

    // Afficher le bouton supprimer si l'utilisateur est l'auteur du cocktail
    const boutonSupprimer = document.getElementById('bouton-supprimer');
    boutonSupprimer.style.display = cocktail.auteur === utilisateur ? 'block' : 'none';

    boutonSupprimer.addEventListener('click', async () => {
        if (window.confirm('Voulez-vous vraiment supprimer ce cocktail?') === false) return;

        fetch('/api/cocktails', {
            method: 'DELETE',
            body: JSON.stringify({
                id_cocktail: cocktail.id_cocktail,
                username: utilisateur
            }),
            headers: { 'Content-Type': 'application/json; charset=UTF-8' }
        }).then((response) => {
            if (response.ok) {
                window.location.href = '/';
            }
        });
    });
}

function chargerCommenter(id_cocktail) {
    const formulaire = document.getElementById('formulaire-commentaire');

    formulaire.addEventListener('submit', async (event) => {
        event.preventDefault();

        if (!utilisateur) {
            window.location.href = '/connexion';
            return;
        }

        // Nettoyer les caractères spéciaux
        const contenu = document.getElementById('commentaire').value.toString().replace(/[^\x00-\xFF]/g, '').trim();

        if (!contenu) return;

        const data = {
            username: utilisateur,
            id_cocktail: id_cocktail,
            commentaire: contenu
        };

        fetch('/api/cocktails/commentaires', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        }).then((reponse) => {
            if (reponse.ok) {
                chargerCommentairesModale(id_cocktail);
                document.getElementById('commentaire').value = '';
            }
        });
    });
}

function ajouterIngredientBD(nomIngredient) {
    const username = utilisateur;
    const data = {
        username,
        nomIngredient
    };

    const requestOptions = {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    };

    fetch(`/api/users/ingredients`, requestOptions)
        .then(response => {
            if (!response.ok) {
                throw new Error('Erreur lors de la requête.');
            }
            chargerCocktails();
            if (response.status === 204) {
                return null;
            }
            return response.json();
        })
        .then(data => {
            console.log('Ingrédient ajouté avec succès :', data);
        })
        .catch(error => {
            console.error('Erreur lors de l\'ajout de l\'ingrédient :', error);
        });
}

function enleverIngredientBD(nomIngredient) {
    const username = utilisateur;
    const data = {
        username,
        nomIngredient
    };

    const requestOptions = {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    };

    fetch(`/api/users/ingredients`, requestOptions)
        .then(response => {
            if (!response.ok) {
                throw new Error('Erreur lors de la requête.');
            }
            chargerCocktails();
            if (response.status === 204) {
                return null;
            }
            return response.json();
        })
        .then(data => {
            console.log('Ingrédient enlevé avec succès :', data);
        })
        .catch(error => {
            console.error('Erreur lors du retrait de l\'ingrédient :', error);
        });
}
