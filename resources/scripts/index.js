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
    for (let i = 0; i < 25; i++) {
        // Creation des different elements
        let newCocktail = document.createElement('article');
        let newCocktailImage = document.createElement('img');
        let newCocktailName = document.createElement('figcaption');

        // Gestion de l'illustration du cocktail
        newCocktailImage.src = "https://picsum.photos/300/500"
        newCocktailImage.loading = "lazy"

        // Ajout de la legende de l'image
        newCocktailName.textContent = cocktails[Math.floor(Math.random() * cocktails.length)];

        // Regroupement des different elements
        newCocktail.appendChild(newCocktailImage);
        newCocktail.appendChild(newCocktailName);

        // Ajout du nouveau cocktail sur la page
        gallery.appendChild(newCocktail);
    }
});
