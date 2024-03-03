function genererListeCocktails(names) {
    let cocktails = [];

    const descriptions = [
        "Un cocktail classique à base de tequila, de liqueur d'orange et de jus de citron vert, servi dans un verre à margarita avec du sel sur le rebord.",
        "Un cocktail élégant à base de gin (ou de vodka) et de vermouth, traditionnellement servi avec une olive ou un zeste de citron.",
        "Un cocktail rafraîchissant à base de rhum, de menthe fraîche, de sucre, de jus de citron vert et d'eau gazeuse, servi avec des feuilles de menthe en garniture.",
        "Un cocktail sophistiqué à base de vodka, de triple sec, de jus de canneberge et de jus de citron vert, servi avec une tranche de citron vert en garniture.",
        "Un cocktail tropical à base de rhum, de jus de citron vert, de sucre et de fruits frais comme l'ananas et la noix de coco, servi avec une tranche d'ananas et une cerise en garniture.",
        "Un cocktail classique à base de whisky, de vermouth sucré, d'amer et de cerise, servi dans un verre à cocktail avec une cerise en garniture.",
        "Un cocktail robuste à base de bourbon, de sucre, d'eau, d'amer et d'une tranche d'orange en garniture.",
        // Ajoutez d'autres descriptions ici...
    ];

    const preparations = [
        "Frottez le rebord d'un verre à margarita avec un quartier de citron vert, puis trempez-le dans du sel. Mélangez la tequila, la liqueur d'orange et le jus de citron vert avec des glaçons dans un shaker. Versez dans le verre et garnissez d'une tranche de citron vert.",
        "Remplissez un verre à mélange de glaçons pour le refroidir. Ajoutez le gin et le vermouth, puis remuez jusqu'à ce que le mélange soit bien refroidi. Versez dans un verre à martini et ajoutez une olive ou un zeste de citron pour garnir.",
        "Dans un verre, écrasez légèrement les feuilles de menthe avec le sucre et le jus de citron vert. Remplissez le verre de glace pilée et ajoutez le rhum. Complétez avec de l'eau gazeuse et mélangez doucement. Garnissez de feuilles de menthe.",
        "Mélangez tous les ingrédients dans un shaker avec des glaçons. Secouez vigoureusement, puis filtrez dans un verre à martini. Garnissez d'une tranche de citron vert.",
        "Mélangez tous les ingrédients dans un shaker avec des glaçons. Secouez vigoureusement, puis filtrez dans un verre rempli de glace pilée. Garnissez d'une tranche d'ananas et d'une cerise.",
        "Mélangez le whisky, le vermouth sucré et l'amer dans un verre à mélange avec des glaçons. Remuez jusqu'à ce que bien refroidi. Filtrez dans un verre à cocktail et ajoutez une cerise en garniture.",
        "Dans un verre, mélangez le sucre et l'eau jusqu'à ce que le sucre soit dissous. Ajoutez le bourbon et l'amer. Remplissez de glace et garnissez d'une tranche d'orange.",
        // Ajoutez d'autres préparations ici...
    ];

    const saveursUmami = [
        "Sucré",
        "Aigre",
        "Amer",
        "Épicé",
        "Salé",
    ];

    for (let i = 0; i < names.length; i++) {
        cocktails.push({
            "id_cocktail": i,
            "nom": names[i],
            "description": descriptions[i % descriptions.length],
            "preparation": preparations[i % preparations.length],
            "nb_likes": Math.floor(Math.random() * 1000),
            "date_publication": getRandomDate(new Date(2015, 0, 1), new Date()),
            "verre_service": "Verre is good",
            "classique": true,
            "umami": saveursUmami[i % saveursUmami.length]
        });
    }

    return cocktails;
}

// Fonction pour générer une date aléatoire entre deux dates
function getRandomDate(start, end) {
    return new Date(start.getTime() + Math.random() * (end.getTime() - start.getTime()));
}

function genererMotAleatoire(n) {
    const characters = 'abcdefghijklmnopqrstuvwxyz';
    let result = '';
    const charactersLength = characters.length;

    for (let i = 0; i < n; i++) {
        result += characters.charAt(Math.floor(Math.random() * charactersLength));
    }
    return result;
}
