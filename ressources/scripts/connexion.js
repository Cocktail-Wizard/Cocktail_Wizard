// JavaScript pour gérer la soumission du formulaire et afficher les erreurs
document.getElementById('form-connexion').addEventListener('submit', async (event) => {
    event.preventDefault();

    // Réinitialiser les erreurs
    const errorsContainer = document.getElementById('message-erreur');
    errorsContainer.innerHTML = '';

    // Envoyer les données du formulaire à l'API PHP
    let formData = new FormData(event.target);

    try {
        const response = await fetch("/authentification", {
            method: "POST",
            body: formData
        });
        const data = await response.json();

        if (data.success) {
            const { username } = data;
            document.cookie = `username=${username}; path=/`;
            window.location.href = "/galerie";
        } else {
            data.errors.forEach(error => {
                let errorElement = document.createElement('p');
                errorElement.textContent = error;
                errorsContainer.appendChild(errorElement);
            });
        }
    } catch (error) {
        console.error('Erreur lors de la soumission du formulaire:', error);
    }
});
