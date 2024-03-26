// JavaScript pour gérer la soumission du formulaire et afficher les erreurs
document.getElementById("form-inscription").addEventListener("submit", (event) => {
    event.preventDefault();

    // Réinitialiser les erreurs
    let errorsContainer = document.getElementById("messErreur");
    errorsContainer.innerHTML = "";

    // Envoyer les données du formulaire à l'API PHP
    let formData = new FormData(event.target);

    fetch("/api/users", {
        method: "POST",
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            console.log(data);
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

        })
        .catch(error => {
            console.error("Erreur lors de la soumission du formulaire:", error);
        });
});

/*
if (errors.length > 0) {
                errors.forEach(error => {
                    let errorElement = document.createElement("p");
                    errorElement.textContent = error;
                    errorsContainer.appendChild(errorElement);
                });
            } else {
                // Rediriger vers la page de connexion si l'inscription est réussie (à changer)
                window.location.href = "/connexion";
            }
*/
