// JavaScript pour gérer la soumission du formulaire et afficher les erreurs
document.getElementById("form-connexion").addEventListener("submit", (event) => {
    event.preventDefault();

    // Réinitialiser les erreurs
    const errorsContainer = document.getElementById("message-erreur");
    errorsContainer.innerHTML = "";

    // Envoyer les données du formulaire à l'API PHP
    let formData = new FormData(event.target);
    let infoConnexion = {};
    formData.forEach((value, key) => {
        infoConnexion[key] = value;
    });
    let json = JSON.stringify(infoConnexion);

    fetch("https://cocktailwizard.azurewebsites.net/api/users/authentification", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: json
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = "https://cocktailwizard.azurewebsites.net/galerie";
            } else {
                data.errors.forEach(error => {
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
