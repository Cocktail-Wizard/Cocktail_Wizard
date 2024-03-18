// JavaScript pour gérer la soumission du formulaire et afficher les erreurs
document.getElementById("form-connexion").addEventListener("submit", (event) => {
    event.preventDefault();

    // Réinitialiser les erreurs
    const errorsContainer = document.getElementById("message-erreur");
    errorsContainer.innerHTML = "";

    // Envoyer les données du formulaire à l'API PHP
    let formData = new FormData(event.target);

    fetch("../ressources/api/connexion.php", {
        method: "POST",
        body: formData
    })
        .then(response => response.json())
        .then(errors => {
            // Afficher les erreurs
            if (errors.length > 0) {
                errors.forEach(error => {
                    let errorElement = document.createElement("p");
                    errorElement.innerText = error;
                    errorsContainer.appendChild(errorElement);
                });
            }
        })
        .catch(error => {
            console.error("Erreur lors de la soumission du formulaire:", error);
        });
});