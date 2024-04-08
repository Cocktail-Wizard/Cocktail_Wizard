const boiteRecherche = document.getElementById('boite-recherche');
const cocktailsClassiques = document.getElementById('cocktails-classiques');
const cocktailsPersonnels = document.getElementById('cocktails-personnels');
const cocktailsCommunautaires = document.getElementById('cocktails-communautaires');
const listeIngredients = document.getElementById('liste-ingredients');

const nombreCocktailsAffiches = 10;

//on vas chercher la liste d'ingredient dans la bd
let allIngredients = [];
let selectedIngredients = [];

async function getTousIngredients() {
    allIngredients = await faireRequete('/api/ingredients');
}

// Ajoute un événement keyup à la barre de recherche pour filtrer les ingrédients à chaque frappe de touche
document.getElementById('boite-recherche').addEventListener('keyup', filterIngredients);

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
    listeIngredients.classList.toggle('hidden', searchValue === '');

    // filtre les ingrédients en fonction de la recherche et des ingrédients déjà sélectionnés
    const filteredIngredients = allIngredients.filter(ingredient =>
        !selectedIngredients.includes(ingredient) && ingredient.toLowerCase().includes(searchValue)
    );

    // Efface le contenu précédent de la liste d'ingrédients
    listeIngredients.innerHTML = '';

    if (filteredIngredients.length === 0) {
        // Affiche "Aucun résultat..." si aucun ingrédient n'est trouvé
        const noResultItem = document.createElement('div');
        noResultItem.textContent = 'Aucun résultat...';
        listeIngredients.appendChild(noResultItem);
    } else {
        // Crée et ajoute les ingrédients filtrés à la liste d'ingrédients
        const fragment = document.createDocumentFragment();
        filteredIngredients.forEach(ingredient => {
            const ingredientItem = document.createElement('div');
            ingredientItem.textContent = ingredient;
            ingredientItem.classList.add('ingredient-item');
            ingredientItem.addEventListener('click', (event) => {
                selectIngredient(ingredient);
                const ingredientClique = event.target.textContent;
                ajouterIngredientBD(ingredientClique);
            });
            fragment.appendChild(ingredientItem);
        });
        listeIngredients.appendChild(fragment);
    }
}

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

    const fragment = document.createDocumentFragment();

    selectedIngredients.forEach(ingredient => {
        const ingredientBox = document.createElement('span');
        ingredientBox.textContent = ingredient;
        ingredientBox.classList.add('ingredients-selectionne');
        ingredientBox.addEventListener('click', (event) => {
            unselectIngredient(ingredient);
            const ingredientClique = event.target.textContent;
            enleverIngredientBD(ingredientClique);
        });
        fragment.appendChild(ingredientBox);
    });

    selectedIngredientsDiv.appendChild(fragment);

    // s'assurer que la boîte des ingrédients sélectionnés est visible meme si vide
    selectedIngredientsDiv.style.display = selectedIngredients.length > 0 ? 'flex' : 'none';
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
    if (event.target !== boiteRecherche && event.target !== listeIngredients) {
        // Vérifier si le clic n'est pas à l'intérieur de la liste
        if (!event.target.closest('.ingredient-item')) {
            listeIngredients.style.display = 'none'; // Ferme la liste si oui
        }
    } else {
        // S'assurer que la liste reste visible tant que l'utilisateur ne clique pas à l'extérieur
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
    const listIng = await faireRequete(`/api/users/${utilisateur}/ingredients`);
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

    const modeleHTML = await chargerModeleHTML('../ressources/modeles/cocktail_carte.html');
    // Appels initiaux
    initialSetup();

    // if (modeleHTML) {
    //     try {
    //         const response = await fetch(`../ressources/api/galerie.php?nombre=${nombreCocktailsAffiches}`);
    //         if (!response.ok) {
    //             throw new Error('La requête a échoué');
    //         }
    //         const data = await response.json();
    //         afficherCocktails(data, modeleHTML);
    //     } catch (error) {
    //         console.error('Erreur : ', error);
    //     }
    // }
});

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
function afficherCocktails(data, modeleHTML) {
    data.forEach((cocktail) => {
        const nouveauCocktail = document.createElement('article');
        nouveauCocktail.classList.add('cocktail');
        nouveauCocktail.innerHTML = modeleHTML;

        const nomCocktail = nouveauCocktail.querySelector('.nom-cocktail');
        nomCocktail.textContent = cocktail.nom;

        // Afficher l'icone 'j'aime'
        const iconeJAime = nouveauCocktail.querySelector('.icone-jaime');
        iconeJAime.src = '../ressources/images/icone-coeur-vide.svg';

        // Afficher l'icone de l'alcool principal
        const iconeAlcool = nouveauCocktail.querySelector('.pastille-alcool');
        iconeAlcool.src = '../ressources/images/pastille-alcool.svg';

        // Afficher l'icone du profil gustatif
        const umamiCocktail = nouveauCocktail.querySelector('.icone-saveur');
        umamiCocktail.src = `../ressources/images/${iconesUmami[cocktail.umami]}.svg` || iconesUmami['default'];

        // Ajouter l'image du cocktail
        const imageCocktail = nouveauCocktail.querySelector('.illustration-cocktail');
        imageCocktail.src = `https://picsum.photos/seed/${nettoyerNomCocktail(cocktail.nom)}/200/300`;
        imageCocktail.loading = 'lazy';

        // Choisir la couleur de la pastille pour l'alcool principal
        const pastilleAlcool = nouveauCocktail.querySelector('.pastille-alcool');
        pastilleAlcool.style.filter = `hue-rotate(${Math.random() * 360}deg)`;

        // Afficher le nombre de mentions 'j'aime'
        const compteurJaime = nouveauCocktail.querySelector('.compteur-jaime');
        compteurJaime.textContent = cocktail.nb_likes;

        // Ajouter la fonctionnalité d'ouvrir la boite modale à la publication
        nouveauCocktail.addEventListener('click', () => {
            chargerInformationsModale(cocktail.id_cocktail);
            sectionModale.style.display = 'block';
        });

        // Ajouter le cocktail à la section 'classique'
        const nouveauCocktailClassique = nouveauCocktail.cloneNode(true);
        cocktailsClassiques.appendChild(nouveauCocktailClassique);

        // Ajouter le cocktail à la section 'personnel'
        const nouveauCocktailPersonnel = nouveauCocktail.cloneNode(true);
        cocktailsPersonnels.appendChild(nouveauCocktailPersonnel);

        // Ajouter le cocktail à la section 'communautaire'
        const nouveauCocktailCommunautaire = nouveauCocktail.cloneNode(true);
        cocktailsCommunautaires.appendChild(nouveauCocktailCommunautaire);
    });
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

function chargerInformationsModale(idCocktail) {
    // Envoyer une requête à l'API pour ce cocktail, exemple: 'https://cocktailwizard.com/cocktail/{id}'
}

function ajouterIngredientBD(nomIngredient) {
    const data = {
        username: utilisateur,
        nomIngredient
    };
    console.log(JSON.stringify(data));
    const requestOptions = {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
    };

    fetch(`/api/users/ingredients`, requestOptions)
        .then(response => {
            if (!response.ok) {
                throw new Error('Erreur lors de la requête.');
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
    const data = {
        utilisateur,
        nomIngredient
    };
    console.log(JSON.stringify(data));
    const requestOptions = {
        method: 'DELETE',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
    };

    fetch(`/api/users/ingredients`, requestOptions)
        .then(response => {
            if (!response.ok) {
                throw new Error('Erreur lors de la requête.');
            }
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
