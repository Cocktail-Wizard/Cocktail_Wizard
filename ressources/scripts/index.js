const nbCocktailsGalerie = 20;
const ordreCommentaires = 'date';
const galerie = document.getElementById('galerie');

const iconesUmami = {
    'Sucré': 'icone-sucre-sucre',
    'Aigre': 'icone-citron-aigre',
    'Amer': 'icone-cafe-amer',
    'Épicé': 'icone-piment-epice',
    'Salé': 'icone-sel-sale',
    'default': 'point-interrogation'
};

document.addEventListener("DOMContentLoaded", async () => {
    const modeleHTML = await chargerModeleHTML("ressources/modeles/cocktail_carte.html");

    if (modeleHTML) {
        try {
            const reponse = await fetch(`../ressources/api/galerie.php?nombre=${nbCocktailsGalerie}`);
            if (!reponse.ok) {
                throw new Error('La requête a échoué');
            }

            const data = await reponse.json();
            afficherCocktails(data, modeleHTML);
            console.debug("Données récuperées de l'API de la galerie : ", data);
        } catch (error) {
            console.error('Erreur : ', error);
        }
    }
});

function afficherCocktails(data, modeleHTML) {
    data.forEach((cocktail) => {
        const nouveauCocktail = document.createElement('article');
        nouveauCocktail.classList.add('cocktail');
        nouveauCocktail.innerHTML = modeleHTML;

        const nomCocktail = nouveauCocktail.querySelector('.nom-cocktail');
        nomCocktail.textContent = cocktail.nom;

        const iconeJAime = nouveauCocktail.querySelector('.icone-jaime');
        iconeJAime.src = "ressources/images/icone-coeur-vide.svg";

        const iconeAlcool = nouveauCocktail.querySelector('.pastille-alcool');
        iconeAlcool.src = "ressources/images/pastille-alcool.svg";

        const umamiCocktail = nouveauCocktail.querySelector('.icone-saveur');
        umamiCocktail.src = `ressources/images/${iconesUmami[cocktail.umami]}.svg` || iconesUmami['default'];

        const imageCocktail = nouveauCocktail.querySelector('.illustration-cocktail');
        imageCocktail.src = `https://picsum.photos/seed/${nettoyerNomCocktail(cocktail.nom)}/200/300`;
        imageCocktail.loading = "lazy";

        const pastilleAlcool = nouveauCocktail.querySelector('.pastille-alcool');
        pastilleAlcool.style.filter = `hue-rotate(${Math.random() * 360}deg)`;

        const compteurJaime = nouveauCocktail.querySelector('.compteur-jaime');
        compteurJaime.textContent = cocktail.nb_likes;

        nouveauCocktail.addEventListener('click', () => {
            console.debug("id cocktail: ", cocktail.id_cocktail);
            chargerInformationsModale(cocktail.id_cocktail);
            sectionModale.style.display = "block";
            chargerCommentairesModale(cocktail.id_cocktail, ordreCommentaires);
        });

        galerie.appendChild(nouveauCocktail);
    });
}

function nettoyerNomCocktail(nom) {
    return nom.replace(/[^a-zA-Z0-9]/g, '');
}

async function chargerInformationsModale(idCocktail) {
    try {
        const reponse = await fetch(`../ressources/api/modale_cocktail.php?id=${idCocktail}`);
        if (!reponse.ok) {
            throw new Error('La requête a échoué');
        }

        const data = await reponse.json();
        console.debug("Données récuperées de l'API du cocktail : ", data);

        if (data === null) {
            console.debug(`Cocktail invalide! (${idCocktail})`);
            return;
        }

        const auteur = document.getElementById('auteur');
        auteur.innerText = `@${data.auteur}`;

        const jaimes = document.getElementById('compteur-jaime');
        jaimes.innerText = data.nb_like;

        const titre = document.getElementById('titre-cocktail');
        titre.innerText = data.nom;

        const preparation = document.getElementById('preparation');
        preparation.innerText = data.preparation;
    } catch (error) {
        console.error('Erreur : ', error);
    }
}

async function chargerCommentairesModale(idCocktail, ordre) {
    try {
        const reponse = await fetch(`../ressources/api/modale_commentaires.php?id=${idCocktail}&orderby=${ordre}`);
        if (!reponse.ok) {
            throw new Error('La requête a échoué');
        }

        const data = await reponse.json();
        console.debug("Données récuperées de l'API des commentaires : ", data)

        if (data === null) {
            console.debug(`Cocktail invalide! (${idCocktail})`);
            return;
        }
    } catch (error) {
        console.error('Erreur : ', error);
    }
}
