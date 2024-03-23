const allIngredients = ["Vodka", "Rhum", "Gin", "Tequila", "Whiskey", "Triple sec", "Sirop simple", "Jus de citron", "Jus de lime", "Jus d'orange", "Jus de canneberge", "Grenadine", "Jus de pomme", "Jujutsu Kaisen"];

// Set "OZ" as the default value for the unit select dropdown
document.getElementById("unit_select").value = "oz";

let ingredientName = "";
let ingredientAmount = "";
let ingredientUnit = "";

// Filtrer les ingrédients en fonction de la recherche de l'utilisateur
function filterIngredients(searchValue) {
    return allIngredients.filter(ingredient =>
        ingredient.toLowerCase().includes(searchValue.toLowerCase())
    );
}


// Fonction pour ajouter un ingrédient à la liste d'ingrédients
function addIngredientToList(name, amount, unit) {
    const ingredientList = document.getElementById("ingredient_list");
    const listItem = document.createElement("div");
    listItem.textContent = `${name} ${amount} ${unit}`;
    ingredientList.appendChild(listItem);
}


// Get the modal
var modal = document.getElementById("myModal");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// Function to show modal and corresponding page
function openModal(page) {
    modal.style.display = "block";
    page.style.display = "block";

    // Remplir les champs de saisie avec les valeurs précédemment saisies
    document.getElementById("ingredient_name").value = ingredientName;
    document.getElementById("ingredient_amount").value = ingredientAmount;
    document.getElementById("unit_select").value = ingredientUnit;
}

// Open the modal with the Info personnelle page when the Profile User button is clicked
document.getElementById("myBtn").onclick = function () {
    openModal(publicationPage);
}

// When the user clicks on <span> (x), close the modal
span.onclick = function () {
    modal.style.display = "none";
}

// Prevent modal from closing and form submission when clicking on the "+" button
document.getElementById("add_ingredient").addEventListener("click", function (event) {
    // Get the value of the ingredient name input field
    const enteredIngredient = document.getElementById("ingredient_name").value.trim().toLowerCase();
    const enteredAmount = document.getElementById("ingredient_amount").value.trim();
    const enteredUnit = document.getElementById("unit_select").value.trim();

    // Check if the entered ingredient is in the list of all ingredients (case-insensitive)
    if (!allIngredients.some(ingredient => ingredient.toLowerCase() === enteredIngredient)) {
        // Change the color of the input field to red and apply the shake animation
        const ingredientInput = document.getElementById("ingredient_name");
        ingredientInput.classList.add("invalid-input");

        // Remove the invalid-input class after the animation completes
        ingredientInput.addEventListener("animationend", removeInvalidClass);
    }

    // Check if the entered amount is numerical
    if (isNaN(parseFloat(enteredAmount))) {
        // Change the color of the input field to red and apply the shake animation
        const amountInput = document.getElementById("ingredient_amount");
        amountInput.classList.add("invalid-input");

        // Remove the invalid-input class after the animation completes
        amountInput.addEventListener("animationend", removeInvalidClass);
    }

    // If both conditions are met, add the ingredient to the list
    if (allIngredients.some(ingredient => ingredient.toLowerCase() === enteredIngredient) && !isNaN(parseFloat(enteredAmount))) {
        addIngredientToList(enteredIngredient, enteredAmount, enteredUnit);
    }

    // Prevent the default behavior of the button (form submission or link navigation)
    event.preventDefault();
});


function removeInvalidClass(event) {
    event.target.classList.remove("invalid-input");
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function (event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

function previewImage(event) {
    var input = event.target;
    var reader = new FileReader();
    reader.onload = function () {
        var dataURL = reader.result;
        var preview = document.getElementById('preview');
        preview.src = dataURL;
    };
    reader.readAsDataURL(input.files[0]);
}

filterIngredients();
updateSelectedIngredients();
