// Fonction pour charger le modèle HTML
async function chargerModeleHTML(url) {
    try {
        const reponse = await fetch(url);
        if (!reponse.ok) {
            throw new Error("Impossible de charger le modèle HTML.");
        }

        return await reponse.text();
    } catch (error) {
        console.error(`Erreur lors du chargement du modèle HTML <${url}> :`, error);
        return null;
    }
}
