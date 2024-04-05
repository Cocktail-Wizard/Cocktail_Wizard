const allIngredients = await faireRequete('/api/ingredients');
const boutonAjouterIngredient = document.getElementById('ajouter-ingredient');
const nouvelIngredientNom = document.getElementById("ingredient-nom");
const nouvelIngredientQtt = document.getElementById("ingredient-quantite");
const nouvelIngredientUnite = document.getElementById("ingredient-unit");

const modal = document.getElementById('monModal');

// Fonction pour ajouter un ingrédient à la liste d'ingrédients
function addIngredientToList(name, amount, unit) {
    const ingredientList = modal.querySelector("#liste-ingredients-publish");
    const listItem = document.createElement("div");
    const button = document.createElement('button');

    listItem.id = "ingredient-rajoute";

    button.id = 'enlever-ingredient';
    button.classList.add('button-publish');

    const img = document.createElement('img');
    img.classList.add('btn-icon');
    img.src = '../ressources/images/minus.svg';
    img.alt = '-';

    // Ajouter l'image à l'intérieur du bouton
    button.appendChild(img);

    // Ajouter le bouton à l'élément listItem
    listItem.appendChild(button);

    // Ajouter l'élément listItem à la liste des ingrédients
    ingredientList.appendChild(listItem);

    button.addEventListener('click', function (event) {
        removeIngredient(this, event);
    });

    listItem.appendChild(button);
    listItem.appendChild(document.createTextNode(` ${amount} ${unit} ${name}`));
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

function removeIngredient(element, event) {
    event.preventDefault();
    element.parentNode.remove();
}

document.getElementById('bouton-publier').addEventListener('click', function (event) {
    event.preventDefault(); // Empêcher le comportement par défaut du formulaire

    // Crée et récupérer les valeurs pour le formulaire
    const nom = document.getElementById('name-texte').value;
    const description = document.getElementById('description-texte').value;
    const preparation = document.getElementById('preparation-texte').value;
    const typeVerre = document.getElementById('glass').value;
    const profilSaveur = document.getElementById('flavor').value;
    const nomAlcoolPrincipale = document.getElementById('alcool').value;
    const username = getCookie('username'); //ICI JE SUIS PAS SUR SI JE DOIT FAIRE `$utilisateur`
    const image = document.getElementById('preview').value;

    // Créer un tableau pour stocker les informations des ingrédients restants
    const ingredients = [];

    // Parcourir chaque div .ingredient dans #liste-ingredients-publish
    const ingredientElements = document.querySelectorAll('#liste-ingredients-publish .ingredient-rajoute');
    ingredientElements.forEach(element => {
        // Récupérer les informations de chaque ingrédient restant
        const nomIng = element.querySelector('.nomIng').textContent;
        const quantite = element.querySelector('.quantite').textContent;
        const unite = element.querySelector('.unite').textContent;

        // Ajouter ces informations au tableau des ingrédients restants
        ingredients.push({ nomIng, quantite, unite });
    });

    // Créer l'objet JSON à envoyer
    const formData = {
        nom,
        description,
        preparation,
        typeVerre,
        profilSaveur,
        nomAlcoolPrincipale,
        username,
        ingredients,
        image
    };

    // Envoyer les données au serveur
    fetch('/api/cocktail', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(formData)
    })
        .then(response => {
            if (!response.ok) {
                throw new Error('Erreur lors de la requête');
            }
            return response.json();
        })
        .then(data => {
            console.log(data); // Afficher la réponse du serveur
            window.location.href = '../pages/monbar.php';
        })
        .catch(error => {
            console.error('Erreur:', error);
        });
});
