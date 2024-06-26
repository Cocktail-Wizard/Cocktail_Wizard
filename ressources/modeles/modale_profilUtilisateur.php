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
                    <button id="deconnexion">Déconnexion</button>
                    <img id="img-profile" title="Modifier l'image de profil" alt="Photo de profil de l'utilisateur">
                    <h3>Nom de l'utilisateur: <span id="username">Lilwizard</span></h3>
                    <p>Email : <span id="email">@mail</span></p>
                    <p>Nombre de likes : <span id="likeCount">0</span></p>
                    <p>Nombre de cocktails : <span id="cocktailCount">0</span></p>
                    <p>Nombre de commentaires : <span id="commentCount">0</span></p>
                    <div class="userprofile-footer" id="boutton-profile">
                        <button id="delete-btn">Supprimer</button>
                    </div>
                </div>

                <div class="mycocktail-body" id="mycocktailPage">
                    <div class="conteneur-carte-cocktail-profile" id="conteneur-mes-cocktails"></div>
                </div>

                <div class="support-body" id="supportPage">

                    <h2>Contactez-nous</h2>


                    <label for="message">Message:</label><br>
                    <textarea id="message" name="message" rows="4" cols="50"></textarea><br>
                    <input id="submit-btn" type="button" value="Envoyer" onclick="location.reload();">


                </div>
            </div>
        </div>
    </div>
</div>
