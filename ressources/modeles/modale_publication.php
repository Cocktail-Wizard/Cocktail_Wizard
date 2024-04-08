<!-- DOCTYPE pas nécessaire pas include avec php. Fuck linter -->
<!-- Modale pour la publication de cocktail -->
<!-- Le modal -->
<div id="mon-modal" class="modal fade">
    <div class="modal-dialog modal-xl">
        <!-- Contenu du modal -->
        <div id="publication-content" class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Créer un cocktail</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                <!-- symbole x pour fermer -->
            </div>

            <div class="modal-body" id="page-publication">

                <form>
                    <label for="nom-cocktail">Nom du cocktail:</label><br>
                    <textarea id="name-texte" name="nom-cocktail" rows="1" cols="50"></textarea><br>

                    <label for="ingredient-cocktail">Ingrédients:</label><br>
                    <div id="ingredient-input">
                        <div id="add-form">
                            <input type="text" id="ingredient-nom" placeholder="Nom de l'ingrédient...">
                            <input type="text" id="ingredient-quantite" placeholder="Quantité...">
                            <input type="text" id="ingredient-unit" placeholder="Unité...">

                            <button type="button" class="button-publish" id="ajouter-ingredient">
                                <img class="btn-icon" src="../ressources/images/plus.svg" alt="ajouter un ingredient">
                            </button>

                        </div>

                        <div id="liste-ingredients-publish"></div>

                    </div>

                    <br>

                    <label for="preparation-cocktail">Préparation:</label><br>
                    <textarea id="preparation-texte" name="preparation-cocktail" rows="4" cols="50"
                        placeholder="Expliquez-nous comment créer votre fabuleuse création, les étapes, la méthode et, si jamais vous avez des petites notes à rajouter, faites-nous en part!"></textarea><br>


                    <label for="description-cocktail">Description:</label><br>
                    <textarea id="description-texte" name="description-cocktail" rows="4" cols="50"
                        placeholder="Une description n'est pas nécessaire, mais elle permet à notre communauté de voir à travers vos yeux."></textarea><br>

                    <div id="dropdown-choices">
                        <label for="flavor-profile">Profil de saveur:</label>
                        <select name="flavor-profile" id="flavor">
                            <option value="acide">acide</option>
                            <option value="amer">amer</option>
                            <option value="epicé">epicé</option>
                            <option value="sale">salée</option>
                            <option value="sucre" selected>sucré</option>
                        </select>
                        <label for="main-alcool">Alcool principal:</label>
                        <select name="main-alcool" id="alcool">
                            <option value="apéritif">apéritif</option>
                            <option value="gin">gin</option>
                            <option value="liqueur">liqueur</option>
                            <option value="rhum">rhum</option>
                            <option value="tequila">tequila</option>
                            <option value="vodka" selected>vodka</option>
                            <option value="whiskey">whiskey</option>
                        </select>
                        <label for="type-glass">Verre de service:</label>
                        <select name="type-glass" id="glass">
                            <option value="balloon">balloon</option>
                            <option value="clay cup">clay cup</option>
                            <option value="collins">collins</option>
                            <option value="copper cup">copper cup</option>
                            <option value="coupe">coupe</option>
                            <option value="highball">highball</option>
                            <option value="marie-antoinette">marie-antoinette</option>
                            <option value="martini">martini</option>
                            <option value="nick & nora">nick & nora</option>
                            <option value="old-fashionned" selected>old-fashionned</option>
                        </select>
                    </div>

                    <br>

                    <label for="cocktail-image">Photo de votre cocktail:</label><br>
                    <input id="cocktail-image" type="file" accept="image/*" />
                    <img id="preview" src="#" alt="Votre image" />

                    <input type="button" id="bouton-publier" value=" Publier">
                </form>

            </div>
        </div>
    </div>
</div>