// JavaScript pour gérer la soumission du formulaire et afficher les erreurs
document.getElementById('form-inscription').addEventListener('submit', async (event) => {
    event.preventDefault();

    // Réinitialiser les erreurs
    let errorsContainer = document.getElementById('message-erreur');
    errorsContainer.innerHTML = '';

    // Envoyer les données du formulaire à l'API PHP
    let formData = new FormData(event.target);

    try {
        const response = await fetch("/api/users", {
            method: "POST",
            body: formData
        });
        const data = await response.json();

        // Afficher les erreurs
        if (Array.isArray(data) && data.length > 0) {
            data.forEach(error => {
                let errorElement = document.createElement("p");
                errorElement.textContent = error;
                errorsContainer.appendChild(errorElement);
            });
        }
        // Rediriger vers la page de connexion si l'inscription est réussie
        else {
            window.location.href = "/connexion";
        }
    } catch (error) {
        console.error('Erreur lors de la soumission du formulaire:', error);
    }
});
