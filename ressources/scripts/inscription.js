// JavaScript pour gérer la soumission du formulaire et afficher les erreurs
document.getElementById("form-inscription").addEventListener("submit", (event) => {
    event.preventDefault();

    // Réinitialiser les erreurs
    let errorsContainer = document.getElementById("messErreur");
    errorsContainer.innerHTML = "";

    // Envoyer les données du formulaire à l'API PHP
    let formData = new FormData(event.target);

    fetch("../ressources/api/inscription.php", {
        method: "POST",
        body: formData
    })
        .then(response => response.json())
        .then(errors => {
            // Afficher les erreurs
            if (errors.length > 0) {
                errors.forEach(error => {
                    let errorElement = document.createElement("p");
                    errorElement.textContent = error;
                    errorsContainer.appendChild(errorElement);
                });
            } else {
                // Rediriger vers la page de connexion si l'inscription est réussie (à changer)
                window.location.href = "connexion.html";
            }
        })
        .catch(error => {
            console.error("Erreur lors de la soumission du formulaire:", error);
        });
});
