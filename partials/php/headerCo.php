<!-- HEADER -->
<header>
    <div class="contener">
        <div id="header-wrap">
            <div id="header-logo">
                <a href="../../../">
                    <h1>ZI<span>GAMING</span></h1>
                </a>
            </div>
            <form method="GET" action="../../pages/recherche">
        <!--    <select id="filtre-console" name="filtre-console">
                <option value="no">--Please choose an console--</option>
                <option value="ps4">PS4</option>
                <option value="ps3">PS3</option>
                <option value="XBOXONE">XBOXONE</option>
                <option value="xbox360">xbox360</option>
            </select>-->
                <input type="search" name="recherche" placeholder="Rechercher" class="search-bar"/>
                <input type="submit" value="Valider" class="search-button"/>
            </form>
            <div id="header-connection">
                <a class="header-link" href="../../pages/annonceAdd/">
                    <button type="submit" class="header-co-contour" name="annonce-btn">
                        <i class="fas fa-plus"></i>
                    </button>
                </a>
                <a class="header-link" href="../../pages/profil/index.php?id=<?php echo $_SESSION['id']?>">
                    <button type="submit" class="header-co-contour" name="login-btn">
                        <i class="far fa-user-circle"></i>
                    </button>
                </a>
            </div>
        </div>
    </div>
</header>