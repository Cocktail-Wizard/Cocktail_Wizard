const ordreCommentaires = 'date';
const galerie = document.getElementById('galerie');
const barreRecherche = document.getElementById('barre-recherche');
const boutonOrdre = document.getElementById('ordre-tri');
const boutonOrdreIcone = document.getElementById('ordre-tri-icone');
const finAttenteEcriture = 1000; // 1 seconde
const monBar = document.getElementById('lien-monbar');


let ordreCocktails = 'like';

let chronoEcriture;
let modeleCarteCocktail;

document.addEventListener('DOMContentLoaded', async () => {


    modeleCarteCocktail = await chargerModeleHTML('ressources/modeles/cocktail_carte.html');

    if (!modeleCarteCocktail) return;

    // Rendre la constante immuable
    Object.freeze(modeleCarteCocktail);

    ordonnerCocktails();

    barreRecherche.addEventListener('input', () => {
        clearTimeout(chronoEcriture);
        chronoEcriture = setTimeout(chercherCocktail, finAttenteEcriture);
    });

    boutonOrdre.addEventListener('click', () => {
        ordonnerCocktails();
    });
});

function afficherCocktails(data) {
    const fragment = document.createDocumentFragment();
    const modeleTemp = document.createElement('div');
    modeleTemp.innerHTML = modeleCarteCocktail;
    const modeleClone = modeleTemp.firstElementChild.cloneNode(true);

    data.forEach((cocktail) => {
        if (!cocktail) return;

        const nouveauCocktail = modeleClone.cloneNode(true);

        const nomCocktail = nouveauCocktail.querySelector('.nom-cocktail');
        nomCocktail.textContent = cocktail.nom;

        const iconeJAime = nouveauCocktail.querySelector('.icone-jaime');
        iconeJAime.src = 'ressources/images/icone-coeur-' + (cocktail.liked ? 'plein' : 'vide') + '.svg';

        const iconeAlcool = nouveauCocktail.querySelector('.icone-pastille-alcool');
        iconeAlcool.src = 'ressources/images/pastille-alcool.svg';

        const umamiCocktail = nouveauCocktail.querySelector('.icone-saveur');
        umamiCocktail.src = `ressources/images/${iconesUmami[cocktail.profil_saveur] ?? iconesUmami['default']}.svg`;

        const imageCocktail = nouveauCocktail.querySelector('.illustration-cocktail');
        imageCocktail.src = 'https://equipe105.tch099.ovh/images?image=' + cocktail.img_cocktail;
        imageCocktail.loading = 'lazy';

        const pastilleAlcool = nouveauCocktail.querySelector('.icone-pastille-alcool');
        pastilleAlcool.style.filter = `hue-rotate(${Math.random() * 360}deg)`;

        const compteurJaime = nouveauCocktail.querySelector('.compteur-jaime');
        compteurJaime.textContent = cocktail.nb_like;

        const infobulleCocktail = nouveauCocktail.querySelector('.text-infobulle');
        infobulleCocktail.textContent = cocktail.alcool_principale;

        nouveauCocktail.addEventListener('click', (event) => {
            const idCocktail = event.currentTarget.dataset.idCocktail;
            sectionModale.style.display = 'block';
            chargerInformationsModale(cocktail);
            chargerCommentairesModale(idCocktail, ordreCommentaires);
            chargerCommenter(cocktail.id_cocktail);
        });

        nouveauCocktail.dataset.idCocktail = cocktail.id_cocktail;

        fragment.appendChild(nouveauCocktail);
    });

    galerie.appendChild(fragment);
}

async function chargerInformationsModale(cocktail) {
    actualiserTextElementParId('auteur', `@${cocktail.auteur}`);
    actualiserTextElementParId('compteur-jaime', cocktail.nb_like);
    actualiserTextElementParId('titre-cocktail', cocktail.nom);
    actualiserTextElementParId('description', cocktail.desc);
    actualiserTextElementParId('preparation', cocktail.preparation);
    actualiserTextElementParId('date-publication', cocktail.date);


    const imageCocktail = document.getElementById('illustration');
    imageCocktail.src = 'https://equipe105.tch099.ovh/images?image=' + cocktail.img_cocktail;

    if (utilisateur) {
        actualiserTextElementParId('auteur-commentaire', utilisateur);
    } else {
        actualiserTextElementParId('text-auteur', 'Vous devez être connecté(e) pour commenter.');
    }

    const ingredients = document.getElementById('ingredients');
    ingredients.innerHTML = '';

    const iconeJAime = document.getElementById('icone-jaime');
    iconeJAime.src = 'ressources/images/icone-coeur-' + (cocktail.liked ? 'plein' : 'vide') + '.svg';

    const spanJAime = document.getElementById('affichage-jaime');

    if (utilisateur) {
        spanJAime.addEventListener('click', async () => {
            fetch('/api/cocktails/like', {
                method: cocktail.liked ? 'DELETE' : 'POST',
                body: JSON.stringify({
                    id_cocktail: cocktail.id_cocktail,
                    username: utilisateur
                }),
                headers: { 'Content-Type': 'application/json; charset=UTF-8' }
            }
            ).then((response) => {
                if (response.ok) {
                    const comptJaime = document.querySelector('article[data-id-cocktail="' + cocktail.id_cocktail + '"] .compteur-jaime');
                    const iconeJaimeCarte = document.querySelector('article[data-id-cocktail="' + cocktail.id_cocktail + '"] .icone-jaime');
                    cocktail.nb_like = cocktail.liked ? cocktail.nb_like - 1 : cocktail.nb_like + 1;
                    comptJaime.textContent = cocktail.nb_like;
                    cocktail.liked = !cocktail.liked;
                    iconeJAime.src = 'ressources/images/icone-coeur-' + (cocktail.liked ? 'plein' : 'vide') + '.svg';
                    iconeJaimeCarte.src = 'ressources/images/icone-coeur-' + (cocktail.liked ? 'plein' : 'vide') + '.svg';
                    actualiserTextElementParId('compteur-jaime', cocktail.nb_like);
                }
            })
        });
    }

    cocktail.ingredients_cocktail.forEach((ingredient) => {
        const ligneIngredient = document.createElement('li');
        const quantiteIngredient = document.createElement('span');
        const uniteIngredient = document.createElement('span');
        const nomIngredient = document.createElement('span');

        quantiteIngredient.innerText = ingredient.quantite;
        uniteIngredient.innerText = ingredient.unite;
        nomIngredient.innerText = ingredient.ingredient;

        ligneIngredient.appendChild(quantiteIngredient);
        ligneIngredient.appendChild(uniteIngredient);
        ligneIngredient.appendChild(nomIngredient);

        ingredients.appendChild(ligneIngredient);
    });
}

async function chargerCommentairesModale(idCocktail) {
    const modeleHTML = await chargerModeleHTML('ressources/modeles/modale_commentaire.html');

    if (modeleHTML) {
        try {
            const data = await faireRequete(`/api/cocktails/${idCocktail}/commentaires`);
            if (!data) return;

            const listeCommentaires = document.getElementById('commentaires');
            listeCommentaires.innerHTML = '';

            data.forEach((commentaire) => {
                const nouveauCommentaireTemp = document.createElement('li');

                nouveauCommentaireTemp.innerHTML = modeleHTML;

                const nouveauCommentaire = nouveauCommentaireTemp.firstElementChild.cloneNode(true);

                const auteurCommentaire = nouveauCommentaire.querySelector('.auteur');
                auteurCommentaire.innerText = `@${commentaire.auteur}`;

                const dateCommentaire = nouveauCommentaire.querySelector('.date');
                dateCommentaire.innerText = commentaire.date;

                const messageCommentaire = nouveauCommentaire.querySelector('.contenu');
                messageCommentaire.innerText = commentaire.contenu;

                listeCommentaires.appendChild(nouveauCommentaire);
            });

        } catch (error) {
            console.error('Erreur : ', error);
        }
    }
}

async function chercherCocktail() {
    const recherche = barreRecherche.value.replace(/[^a-zA-Z0-9]/g, '_');
    const endpoint = recherche ? `/recherche/${recherche}` : '';
    const user = utilisateur ? '?user=' + utilisateur : '';
    const data = await faireRequete(`/api/cocktails/tri/${ordreCocktails}${endpoint}${user}`);

    if (data) {
        galerie.innerHTML = '';
        afficherCocktails(data);
    }
}

async function ordonnerCocktails() {
    ordreCocktails = ordreCocktails === 'like' ? 'date' : 'like';

    chercherCocktail();

    if (ordreCocktails === 'like') {
        boutonOrdreIcone.src = 'ressources/images/icone-coeur-plein.svg';
        boutonOrdre.title = 'Trier par date';
    } else {
        boutonOrdreIcone.src = 'ressources/images/icone-calendrier.svg';
        boutonOrdre.title = 'Trier par popularité';
    }
}

function chargerCommenter(id_cocktail) {
    const formulaire = document.getElementById('formulaire-commentaire');

    formulaire.addEventListener('submit', async (event) => {
        event.preventDefault();

        if (!utilisateur) {
            window.location.href = '/connexion';
            return;
        }

        // Nettoyer les caractères spéciaux
        const contenu = document.getElementById('commentaire').value.toString().replace(/[^\x00-\xFF]/g, '').trim();

        if (!contenu) return;

        const data = {
            username: utilisateur,
            id_cocktail: id_cocktail,
            commentaire: contenu
        };

        fetch('/api/cocktails/commentaires', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        }).then((reponse) => {
            if (reponse.ok) {
                chargerCommentairesModale(id_cocktail);
                document.getElementById('commentaire').value = '';
            }
        });
    });
}
