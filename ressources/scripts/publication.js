const allIngredients = ["Vodka", "Rhum", "Gin", "Tequila", "Whiskey", "Triple sec", "Sirop simple", "Jus de citron", "Jus de lime", "Jus d'orange", "Jus de canneberge", "Grenadine", "Jus de pomme", "Jujutsu Kaisen"];
const boutonAjouterIngredient = document.getElementById('ajouter-ingredient');
const nouvelIngredientNom = document.getElementById("ingredient-nom");
const nouvelIngredientQtt = document.getElementById("ingredient-quantite");
const nouvelIngredientUnite = document.getElementById("ingredient-unit");

const modal = document.getElementById('monModal');

// Fonction pour ajouter un ingrédient à la liste d'ingrédients
function addIngredientToList(name, amount, unit) {
    const ingredientList = modal.querySelector("#liste-ingredients");
    const listItem = document.createElement("div");
    const button = document.createElement('button');

    button.classList.add('remove_ingredient');

    const img = document.createElement('img');
    img.classList.add('btn-icon');
    img.src = '../ressources/images/minus.svg';
    img.alt = '+';
    button.appendChild(img);

    button.addEventListener('click', function (event) {
        removeIngredient(this, event);
    });

    listItem.appendChild(button);
    listItem.appendChild(document.createTextNode(`${amount} ${unit} ${name}`));
    ingredientList.appendChild(listItem);

    // Effacer les zones de texte SEULMENT quand un ingredient est rajouté
    nouvelIngredientNom.value = "";
    nouvelIngredientQtt.value = "";
    nouvelIngredientUnite.value = "";
}

// Evenement dans le formulaire lors du clic sur le bouton "+"
boutonAjouterIngredient.addEventListener("click", function (event) {
    // Obtenir la valeur du champ de saisie du nom de l'ingrédient
    const enteredIngredient = nouvelIngredientNom.value.trim().toLowerCase();
    const enteredAmount = nouvelIngredientQtt.value.trim();
    const enteredUnit = nouvelIngredientUnite.value.trim();

    // Vérifier si l'ingrédient saisi figure dans la liste de tous les ingrédients (insensible au minuscule/majuscule)
    if (!allIngredients.some(ingredient => ingredient.toLowerCase() === enteredIngredient)) {
        // Changer la couleur du champ de saisie en rouge et appliquer l'animation d"erreur
        nouvelIngredientNom.classList.add("invalid-input");

        // Supprimer la classe invalid-input après la fin de l'animation (pour pas que la case reste rouge)
        nouvelIngredientNom.addEventListener("animationend", removeInvalidClass);
    }

    // Vérifier si la quantité saisie est numérique dans "enteredAmount"
    if (isNaN(parseFloat(enteredAmount))) {
        // Changer la couleur du champ de saisie en rouge et appliquer l'animation d'erreur
        nouvelIngredientQtt.classList.add("invalid-input");

        // Supprimer la classe invalid-input après la fin de l'animation
        nouvelIngredientQtt.addEventListener("animationend", removeInvalidClass);
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
    let input = event.target;
    let reader = new FileReader();
    reader.onload = function () {
        let dataURL = reader.result;
        let preview = document.getElementById('preview');
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
function removeIngredient(element, event) {
    event.preventDefault();
    element.parentNode.remove();
}
