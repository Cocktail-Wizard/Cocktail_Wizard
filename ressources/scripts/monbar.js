const allIngredients = ["Vodka", "Rhum", "Gin", "Tequila", "Whiskey", "Triple sec", "Sirop simple", "Jus de citron", "Jus de lime", "Jus d'orange", "Jus de canneberge", "Grenadine", "Jus de pomme", "Jujutsu Kaisen"];
let selectedIngredients = [];

//Liste des ingredients (vas eventuellement etre update avec la bd)
function filterIngredients() {
    const searchValue = document.getElementById("searchBox").value.toLowerCase();
    const ingredientList = document.getElementById("ingredientList");
    ingredientList.innerHTML = '';

    //affiche la liste si la searchbar contient quelquechose
    if (searchValue.trim() !== '') {
        ingredientList.style.display = "block";
    } else {
        //cache le drop down si la barre de recherche est vide
        ingredientList.style.display = "none";
    }

    // filtre les ingredient en fonctions de la rechercher ET des element deja selectionner
    const filteredIngredients = allIngredients.filter(ingredient => !selectedIngredients.includes(ingredient) && ingredient.toLowerCase().includes(searchValue));

    //creation et ajout des ingredients selectionner a la boite d'ingredients
    filteredIngredients.forEach(ingredient => {
        const ingredientItem = document.createElement("div");
        ingredientItem.textContent = ingredient;
        ingredientItem.classList.add("ingredient-item");
        ingredientItem.addEventListener("click", () => selectIngredient(ingredient));
        ingredientList.appendChild(ingredientItem);
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
    selectedIngredientsDiv.style.display = "block"; // s'ssurer que la boîte des ingrédients sélectionnés est visible meme si vide
}

// Ferme la liste des ingrédients lorsque l'utilisateur clique à l'extérieur
document.addEventListener("click", function (event) {
    const searchBox = document.getElementById("searchBox");
    const ingredientList = document.getElementById("ingredientList");

    if (event.target !== searchBox && event.target !== ingredientList) {
        // Verifier si le clic n'est pas à l'intérieur de la liste
        if (!selectedIngredients.includes(event.target.textContent)) {
            ingredientList.style.display = "none"; // Ferme la liste si oui
        }
    } else {
        //s'assure que la liste reste visible tant que l'utilisateur clique pas a l'exterieur
        if (ingredientList.style.display !== "block") {
            filterIngredients();
        }
    }
});

// Initial call to display all ingredients
filterIngredients();
updateSelectedIngredients(); // Display initially selected ingredients
