// Liste d'ingrédients d'exemple
const allIngredients = ["Vodka", "Rhum", "Gin", "Tequila", "Whiskey", "Triple sec", "Sirop simple", "Jus de citron", "Jus de lime", "Jus d'orange", "Jus de canneberge", "Grenadine", "Jus de pomme", "Jujutsu Kaisen"];
let selectedIngredients = [];

// Fonction pour filtrer et afficher les ingrédients
function filterIngredients() {
    const searchValue = document.getElementById("searchBox").value.toLowerCase();
    const ingredientList = document.getElementById("ingredientList");
    ingredientList.innerHTML = '';

    if (searchValue.trim() !== '') {
        ingredientList.style.display = "block"; // Afficher la liste des ingrédients
    } else {
        ingredientList.style.display = "none"; // Cacher la liste des ingrédients si la zone de recherche est vide
    }

    const filteredIngredients = allIngredients.filter(ingredient => !selectedIngredients.includes(ingredient) && ingredient.toLowerCase().includes(searchValue));

    filteredIngredients.forEach(ingredient => {
        const ingredientItem = document.createElement("div");
        ingredientItem.textContent = ingredient;
        ingredientItem.classList.add("ingredient-item");
        ingredientItem.addEventListener("click", (event) => {
            event.stopPropagation(); // Empêcher la propagation de l'événement jusqu'au document
            selectIngredient(ingredient);
        });
        ingredientList.appendChild(ingredientItem);
    });
}

// Fonction pour sélectionner un ingrédient et l'ajouter à la boîte
function selectIngredient(ingredient) {
    selectedIngredients.push(ingredient);
    updateSelectedIngredients();
}

// Fonction pour désélectionner un ingrédient et le supprimer de la boîte
function unselectIngredient(ingredient) {
    const index = selectedIngredients.indexOf(ingredient);
    if (index !== -1) {
        selectedIngredients.splice(index, 1);
        updateSelectedIngredients();
    }
}

// Fonction pour mettre à jour l'affichage des ingrédients sélectionnés
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
    selectedIngredientsDiv.style.display = "block"; // Assurer que la boîte des ingrédients sélectionnés est visible
}

// Fonction pour effacer tous les ingrédients sélectionnés
function clearSelectedIngredients() {
    selectedIngredients = [];
    updateSelectedIngredients();
}

// Fonction pour gérer les clics en dehors de la zone de texte
document.addEventListener("click", function (event) {
    const searchBox = document.getElementById("searchBox");
    const ingredientList = document.getElementById("ingredientList");

    if (event.target !== searchBox && event.target !== ingredientList) {
        ingredientList.style.display = "none"; // Cacher la liste des ingrédients lorsqu'on clique en dehors de la zone de texte
    }
});

// Appel initial pour afficher tous les ingrédients
filterIngredients();
updateSelectedIngredients(); // Afficher les ingrédients initialement sélectionnés
