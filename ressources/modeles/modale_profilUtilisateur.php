<!-- DOCTYPE pas nécessaire pas include avec php. Fuck linter -->
<!-- Modale pour le profil utilisateur -->
<!-- la page modale -->
<div id="my-modal" class="modal">
    <div class="modal-dialog modal-xl">
        <!-- Contenue de la boite modale -->
        <div id="userprofile-content" class="modal-content">
            <div class="modal-header">
                <div id="userprofile-header">
                    <button id="info-btn">Info personnelle</button>
                    <button id="cocktail-btn">Mes cocktails</button>
                    <button id="support-btn">Support</button>
                </div>
                <button type="button" id="fuck-bootstrap" class="btn-close" data-bs-dismiss="modal"></button>
                <!-- symbole x pour fermer -->
            </div>

            <div class="modal-body">
                <div class="userinfo-body" id="infoPage">
                    <img src="../ressources/images/lionWizard.jpg" alt="Photo de profil de l'utilisateur">
                    <h3>Nom de l'utilisateur: <span id="username">Lilwizard</span></h3>
                    <p>Email : <span id="email">@mail</span></p>
                    <p>Nombre de likes : <span id="likeCount">0</span></p>
                    <p>Nombre de cocktails : <span id="cocktailCount">0</span></p>
                    <p>Nombre de commentaires : <span id="commentCount">0</span></p>
                    <div class="userprofile-footer" id="boutton-profile">
                        <button id="edit-btn">Modifier</button>
                        <button id="delete-btn">Supprimer</button>
                    </div>
                </div>

                <div class="mycocktail-body" id="mycocktailPage">
                    <div class="cocktail-container">
                        <!-- Les cartes de cocktail seront ajoutées ici -->
                    </div>
                </div>

                <div class="support-body" id="supportPage">

                    <h2 style="color: #7f5af0;">Contactez-nous</h2>

                    <form action="../ressources/email.php" method="post">
                        <label for="message">Message:</label><br>
                        <textarea id="message" name="message" rows="4" cols="50"></textarea><br>
                        <input id="submit-btn" type="submit" value="Envoyer">
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
