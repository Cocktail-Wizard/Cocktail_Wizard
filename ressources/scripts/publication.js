const allIngredients = ["Vodka", "Rhum", "Gin", "Tequila", "Whiskey", "Triple sec", "Sirop simple", "Jus de citron", "Jus de lime", "Jus d'orange", "Jus de canneberge", "Grenadine", "Jus de pomme", "Jujutsu Kaisen"];

let ingredientName = "";
let ingredientAmount = "";
let ingredientUnit = "";

// Fonction pour ajouter un ingrédient à la liste d'ingrédients
function addIngredientToList(name, amount, unit) {
    const ingredientList = document.getElementById("ingredient_list");
    const listItem = document.createElement("div");
    listItem.innerHTML = `<button id="remove_ingredient" onclick="removeIngredient(this)"><img  class="btn-icon" src="../images/minus.svg"
                                    alt="+"></button> ${amount} ${unit} ${name} `;
    ingredientList.appendChild(listItem);

    // Effacer les zones de texte SEULMENT quand un ingredient est rajouté
    document.getElementById("ingredient_name").value = "";
    document.getElementById("ingredient_amount").value = "";
    document.getElementById("ingredient_unit").value = "";
}

// Fonction pour afficher le modal et la page de publication
function openModal(page) {
    modal.style.display = "block";
    page.style.display = "block";

    // Remplir les champs de saisie avec les valeurs précédemment saisies (garder les ingredients si l'utilisatuer ferme la page modale)
    document.getElementById("ingredient_name").value = ingredientName;
    document.getElementById("ingredient_amount").value = ingredientAmount;
    document.getElementById("ingredient_unit").value = ingredientUnit;
}

// Wait for the DOM to be fully loaded
document.addEventListener("DOMContentLoaded", function () {
    var modal = document.getElementById("myModal");

    // Function to handle closing the modal
    function closeModal() {
        modal.style.display = "none";
    }

    // Attach onclick handler to close button after the modal has been loaded
    function attachCloseHandler() {
        var span = document.querySelector(".close");
        if (span) {
            span.onclick = closeModal;
        } else {
            console.error("Close button element not found");
        }
    }

    attachCloseHandler();

    // Event listener for clicking the add_ingredient button
    document.getElementById("add_ingredient").addEventListener("click", function (event) {
        // Your existing code for adding ingredients
    });
});

// Variable declarations moved outside the DOMContentLoaded event
var modal = document.getElementById("myModal");


// Evenement dans le formulaire lors du clic sur le bouton "+"
document.getElementById("add_ingredient").addEventListener("click", function (event) {
    // Obtenir la valeur du champ de saisie du nom de l'ingrédient
    const enteredIngredient = document.getElementById("ingredient_name").value.trim().toLowerCase();
    const enteredAmount = document.getElementById("ingredient_amount").value.trim();
    const enteredUnit = document.getElementById("ingredient_unit").value.trim();

    // Vérifier si l'ingrédient saisi figure dans la liste de tous les ingrédients (insensible au minuscule/majuscule)
    if (!allIngredients.some(ingredient => ingredient.toLowerCase() === enteredIngredient)) {
        // Changer la couleur du champ de saisie en rouge et appliquer l'animation d"erreur
        const ingredientInput = document.getElementById("ingredient_name");
        ingredientInput.classList.add("invalid-input");

        // Supprimer la classe invalid-input après la fin de l'animation (pour pas que la case reste rouge)
        ingredientInput.addEventListener("animationend", removeInvalidClass);
    }

    // Vérifier si la quantité saisie est numérique dans "enteredAmount"
    if (isNaN(parseFloat(enteredAmount))) {
        // Changer la couleur du champ de saisie en rouge et appliquer l'animation d'erreur
        const amountInput = document.getElementById("ingredient_amount");
        amountInput.classList.add("invalid-input");

        // Supprimer la classe invalid-input après la fin de l'animation
        amountInput.addEventListener("animationend", removeInvalidClass);
    }

    // Si les deux conditions sont remplies, ajouter l'ingrédient à la liste
    if (allIngredients.some(ingredient => ingredient.toLowerCase() === enteredIngredient) && !isNaN(parseFloat(enteredAmount))) {
        addIngredientToList(enteredIngredient, enteredAmount, enteredUnit);
    }

    // Empêcher le comportement par défaut du bouton (pour ne pas fermer la modale)
    event.preventDefault();

});


function removeInvalidClass(event) {
    event.target.classList.remove("invalid-input");
}

// Lorsque l'utilisateur clique n'importe où en dehors du modal, le fermer
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

// Fonction pour supprimer un ingrédient de la liste
function removeIngredient(element) {
    element.parentNode.remove();
}
