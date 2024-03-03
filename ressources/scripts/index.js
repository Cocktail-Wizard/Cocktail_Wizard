const gallery = document.getElementById('gallery');

const cocktails = [
    "Margarita", "Martini", "Mojito", "Cosmopolitan", "Daiquiri", "Manhattan", "Old Fashioned",
    "Bloody Mary", "Piña Colada", "Negroni", "Long Island Iced Tea", "Mai Tai", "Caipirinha",
    "Sazerac", "Whiskey Sour", "Moscow Mule", "Pisco Sour", "Tom Collins", "White Russian",
    "Gimlet", "Mint Julep", "Singapore Sling", "Sidecar", "Blue Lagoon", "Tequila Sunrise",
    "Sex on the Beach", "Bellini", "Irish Coffee", "Mimosa", "Planter's Punch", "Hurricane",
    "White Lady", "Gin Fizz", "French 75", "Mai Tai", "Zombie", "Sea Breeze", "Lemon Drop Martini",
    "Black Russian", "Vodka Martini", "Long Beach Iced Tea", "Godfather", "Gin and Tonic",
    "Dark 'n' Stormy", "Tommy's Margarita", "Margarita Frozen", "Mai Tai", "Mai Tai", "Mai Tai"
];

document.addEventListener("DOMContentLoaded", () => {
    for (let i = 0; i < 5 * 4; i++) {
        let cocktailName = cocktails[Math.floor(Math.random() * cocktails.length)]

        // Creation des different elements
        let newCocktail = document.createElement('article');
        let newCocktailImage = document.createElement('img');
        let newCocktailName = document.createElement('figcaption');

        // Gestion de l'illustration du cocktail
        newCocktailImage.src = `https://picsum.photos/seed/${cocktailName.replace(/[^a-zA-Z0-9]/g, '')}/200/300`
        newCocktailImage.loading = "lazy"

        // Ajout de la legende de l'image
        newCocktailName.textContent = cocktailName;

        // Ajout de la classe cocktail
        newCocktail.classList.add('cocktail')

        // Regroupement des different elements
        newCocktail.appendChild(newCocktailImage);
        newCocktail.appendChild(newCocktailName);

        // Ajout du nouveau cocktail sur la page
        gallery.appendChild(newCocktail);
    }
});
