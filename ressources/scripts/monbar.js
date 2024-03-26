const cocktailsClassiques = document.getElementById("cocktails-classiques");
const cocktailsPersonnels = document.getElementById("cocktails-personnels");
const cocktailsCommunautaires = document.getElementById("cocktails-communautaires");

const nombreCocktailsAffiches = 10;
const iconesUmami = {
    'Sucré': 'icone-sucre-sucre',
    'Aigre': 'icone-citron-aigre',
    'Amer': 'icone-cafe-amer',
    'Épicé': 'icone-piment-epice',
    'Salé': 'icone-sel-sale',
    'default': 'point-interrogation'
};

const allIngredients = ["Vodka", "Rhum", "Gin", "Tequila", "Whiskey", "Triple sec", "Sirop simple", "Jus de citron", "Jus de lime", "Jus d'orange", "Jus de canneberge", "Grenadine", "Jus de pomme", "Jujutsu Kaisen"];
let selectedIngredients = [];

//Liste des ingredients (vas eventuellement etre update avec la bd)
function filterIngredients() {
    const searchValue = document.getElementById("boite-recherche").value.toLowerCase();
    const liste-ingredients = document.getElementById("liste-ingredients");
    liste - ingredients.innerHTML = '';

    //affiche la liste si la searchbar contient quelquechose
    if (searchValue.trim() !== '') {
        liste - ingredients.style.display = "block";
    } else {
        //cache le drop down si la barre de recherche est vide
        liste - ingredients.style.display = "none";
    }

    // filtre les ingredient en fonctions de la rechercher ET des element deja selectionner
    const filteredIngredients = allIngredients.filter(ingredient => !selectedIngredients.includes(ingredient) && ingredient.toLowerCase().includes(searchValue));

    //creation et ajout des ingredients selectionner a la boite d'ingredients
    filteredIngredients.forEach(ingredient => {
        const ingredientItem = document.createElement("div");
        ingredientItem.textContent = ingredient;
        ingredientItem.classList.add("ingredient-item");
        ingredientItem.addEventListener("click", () => selectIngredient(ingredient));
        liste - ingredients.appendChild(ingredientItem);
    });
}

//fonction pour selctionner un ingredient
function selectIngredient(ingredient) {
    selectedIngredients.push(ingredient);
    updateSelectedIngredients();
    filterIngredients(); //update le dropdown pour pas pouvoiur rajouter 100 fois la meme chose
}

//fonction pour deselectionenr un ingredient
function unselectIngredient(ingredient) {
    const index = selectedIngredients.indexOf(ingredient);
    if (index !== -1) {
        selectedIngredients.splice(index, 1);
        updateSelectedIngredients();
        filterIngredients(); //update le dropdown pour rajouter l'element si deselectionner
    }
}

//fonction qui met a jour l'affichage des element selectionner
function updateSelectedIngredients() {
    const selectedIngredientsDiv = document.getElementById("selectedIngredients");
    selectedIngredientsDiv.innerHTML = '';

    selectedIngredients.forEach(ingredient => {
        const ingredientBox = document.createElement("span");
        ingredientBox.textContent = ingredient;
        ingredientBox.classList.add("selected-ingredient");
        ingredientBox.addEventListener("click", () => unselectIngredient(ingredient));
        selectedIngredientsDiv.appendChild(ingredientBox);
    });
    selectedIngredientsDiv.style.display = "flex"; // s'ssurer que la boîte des ingrédients sélectionnés est visible meme si vide
}

// Ferme la liste des ingrédients lorsque l'utilisateur clique à l'extérieur
document.addEventListener("click", function (event) {
    const boite-recherche = document.getElementById("boite-recherche");
    const liste-ingredients = document.getElementById("liste-ingredients");

    if (event.target !== boite - recherche && event.target !== liste - ingredients) {
        // Verifier si le clic n'est pas à l'intérieur de la liste
        if (!selectedIngredients.includes(event.target.textContent)) {
            liste - ingredients.style.display = "none"; // Ferme la liste si oui
        }
    } else {
        //s'assure que la liste reste visible tant que l'utilisateur clique pas a l'exterieur
        if (liste - ingredients.style.display !== "block") {
            filterIngredients();
        }
    }
});

// Initial call to display all ingredients
filterIngredients();
updateSelectedIngredients(); // Display initially selected ingredients

document.addEventListener("DOMContentLoaded", async () => {
    inputRechercheIngredient = document.getElementById('boite-recherche');
    inputRechercheIngredient.addEventListener('input', filterIngredients);

    const modeleHTML = await chargerModeleHTML("../ressources/modeles/cocktail_carte.html");

    if (modeleHTML) {
        try {
            const response = await fetch(`../ressources/api/galerie.php?nombre=${nombreCocktailsAffiches}`);
            if (!response.ok) {
                throw new Error('La requête a échoué');
            }
            const data = await response.json();
            afficherCocktails(data, modeleHTML);
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

        // Afficher l'icone "j'aime"
        const iconeJAime = nouveauCocktail.querySelector('.icone-jaime');
        iconeJAime.src = "../ressources/images/icone-coeur-vide.svg";

        // Afficher l'icone de l'alcool principal
        const iconeAlcool = nouveauCocktail.querySelector('.pastille-alcool');
        iconeAlcool.src = "../ressources/images/pastille-alcool.svg";

        // Afficher l'icone du profil gustatif
        const umamiCocktail = nouveauCocktail.querySelector('.icone-saveur');
        umamiCocktail.src = `../ressources/images/${iconesUmami[cocktail.umami]}.svg` || iconesUmami['default'];

        // Ajouter l'image du cocktail
        const imageCocktail = nouveauCocktail.querySelector('.illustration-cocktail');
        imageCocktail.src = `https://picsum.photos/seed/${nettoyerNomCocktail(cocktail.nom)}/200/300`;
        imageCocktail.loading = "lazy";

        // Choisir la couleur de la pastille pour l'alcool principal
        const pastilleAlcool = nouveauCocktail.querySelector('.pastille-alcool');
        pastilleAlcool.style.filter = `hue-rotate(${Math.random() * 360}deg)`;

        // Afficher le nombre de mentions "j'aime"
        const compteurJaime = nouveauCocktail.querySelector('.compteur-jaime');
        compteurJaime.textContent = cocktail.nb_likes;

        // Ajouter la fonctionnalité d'ouvrir la boite modale à la publication
        nouveauCocktail.addEventListener('click', () => {
            chargerInformationsModale(cocktail.id_cocktail);
            sectionModale.style.display = "block";
        });

        // Ajouter le cocktail à la section "classique"
        const nouveauCocktailClassique = nouveauCocktail.cloneNode(true);
        cocktailsClassiques.appendChild(nouveauCocktailClassique);

        // Ajouter le cocktail à la section "personnel"
        const nouveauCocktailPersonnel = nouveauCocktail.cloneNode(true);
        cocktailsPersonnels.appendChild(nouveauCocktailPersonnel);

        // Ajouter le cocktail à la section "communautaire"
        const nouveauCocktailCommunautaire = nouveauCocktail.cloneNode(true);
        cocktailsCommunautaires.appendChild(nouveauCocktailCommunautaire);
    });
}

function nettoyerNomCocktail(nom) {
    return nom.replace(/[^a-zA-Z0-9]/g, '');
}

function chargerInformationsModale(idCocktail) {
    // Envoyer une requête à l'API pour ce cocktail, exemple: "https://cocktailwizard.com/cocktail/{id}"
}
