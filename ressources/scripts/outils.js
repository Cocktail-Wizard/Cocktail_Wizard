const utilisateur = getCookie('username');

// Dictionnaire des icônes de saveur
const iconesUmami = {
    'Sucré': 'icone-sucre-sucre',
    'Acide': 'icone-citron-aigre',
    'Aigre': 'icone-citron-aigre',
    'Amer': 'icone-cafe-amer',
    'Épicé': 'icone-piment-epice',
    'Salé': 'icone-sel-sale',
    'default': 'point-interrogation'
};

// Fonction pour charger le modèle HTML
async function chargerModeleHTML(url) {
    try {
        const reponse = await fetch(url);
        if (!reponse.ok) {
            throw new Error('Impossible de charger le modèle HTML.');
        }

        return await reponse.text();
    } catch (error) {
        console.error(`Erreur lors du chargement du modèle HTML <${url}> :`, error);
        return null;
    }
}

async function faireRequete(url) {
    try {
        const reponse = await fetch(url);
        if (!reponse.ok) {
            throw new Error('La requête a échoué');
        }
        if (reponse.status === 204) {
            return null;
        }
        return await reponse.json();
    } catch (error) {
        console.error('Erreur : ', error);
        return null;
    }
}

function actualiserTextElementParId(id, nouvelle_valeur) {
    const element = document.getElementById(id);

    if (element) {
        element.innerText = nouvelle_valeur;
    }
}

function getCookie(nom) {
    const cookies = document.cookie.split(';');
    for (let i = 0; i < cookies.length; i++) {
        const cookie = cookies[i].trim();
        if (cookie.startsWith(nom + '=')) {
            return cookie.substring(nom.length + 1);
        }
    }
    return null;
}

function deleteCookie(nom) {
    document.cookie = `${nom}=; expires=Thu, 01 Jan 2001 00:00:00 UTC; path=/;`;
}

function genererDegreDepuisString(string) {
    let hash = 0;

    for (let i = 0; i < string.length; i++) {
        hash += string.charCodeAt(i);
    }

    const scaledNumber = hash % 361;

    return scaledNumber;
}
