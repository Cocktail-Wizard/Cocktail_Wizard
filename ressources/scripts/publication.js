const allIngredients = ["Vodka", "Rhum", "Gin", "Tequila", "Whiskey", "Triple sec", "Sirop simple", "Jus de citron", "Jus de lime", "Jus d'orange", "Jus de canneberge", "Grenadine", "Jus de pomme", "Jujutsu Kaisen"];

let ingredientName = "";
let ingredientAmount = "";
let ingredientUnit = "";

const modal = document.getElementById('monModal');

// Fonction pour ajouter un ingrédient à la liste d'ingrédients
function addIngredientToList(name, amount, unit) {
    const ingredientList = modal.querySelector("#liste-ingredients");
    const listItem = document.createElement("div");
    listItem.innerHTML = `<button id="remove_ingredient" onclick="removeIngredient(this)"><img  class="btn-icon" src="../ressources/images/minus.svg"
                                    alt="+"></button> ${amount} ${unit} ${name} `;
    ingredientList.appendChild(listItem);

    // Effacer les zones de texte SEULMENT quand un ingredient est rajouté
    document.getElementById("ingredient-nom").value = "";
    document.getElementById("ingredient-quantite").value = "";
    document.getElementById("ingredient-unit").value = "";
}

// Evenement dans le formulaire lors du clic sur le bouton "+"
document.getElementById("ajouter-ingredient").addEventListener("click", function (event) {
    // Obtenir la valeur du champ de saisie du nom de l'ingrédient
    const enteredIngredient = document.getElementById("ingredient-nom").value.trim().toLowerCase();
    const enteredAmount = document.getElementById("ingredient-quantite").value.trim();
    const enteredUnit = document.getElementById("ingredient-unit").value.trim();

    // Vérifier si l'ingrédient saisi figure dans la liste de tous les ingrédients (insensible au minuscule/majuscule)
    if (!allIngredients.some(ingredient => ingredient.toLowerCase() === enteredIngredient)) {
        // Changer la couleur du champ de saisie en rouge et appliquer l'animation d"erreur
        const ingredientInput = document.getElementById("ingredient-nom");
        ingredientInput.classList.add("invalid-input");

        // Supprimer la classe invalid-input après la fin de l'animation (pour pas que la case reste rouge)
        ingredientInput.addEventListener("animationend", removeInvalidClass);
    }

    // Vérifier si la quantité saisie est numérique dans "enteredAmount"
    if (isNaN(parseFloat(enteredAmount))) {
        // Changer la couleur du champ de saisie en rouge et appliquer l'animation d'erreur
        const amountInput = document.getElementById("ingredient-quantite");
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

// // Lorsque l'utilisateur clique n'importe où en dehors du modal, le fermer
// window.onclick = function (event) {
//     if (event.target == modal) {
//         modal.style.display = "none";
//     }
// }

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

// function removeIngredient(button) {
//     // Accéder à l'élément parent du bouton, qui est le conteneur de l'ingrédient
//     console.log(button);
//     const listItem = button.parentElement;
//     // Supprimer cet élément de la liste d'ingrédients
//     listItem.remove();
// }
function removeIngredient(element) {
    element.parentNode.remove();
}
