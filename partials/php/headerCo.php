<!-- HEADER -->
<header>
    <div class="contener">
        <div id="header-wrap">
            <div id="header-logo">
                <a href="../../../">ZI<span>GAMING</span></a>
            </div>
            <div id="search-wrapper">
                <form method="GET" action="../../pages/recherche">
                    <div id="dropdown-menu">
                        <select name="filtre_console" class="search-filtre">
                            <option value="0">Tout</option>
                            <option value="PS4">PS4</option>
                            <option value="PS3">PS3</option>
                            <option value="Xbox One">Xbox One</option>                        
                            <option value="Xbox 360">Xbox 360</option>
                            <option value="PC">PC</option>
                        </select>
                    </div>
                    <input type="search" name="recherche" placeholder="Rechercher" class="search-bar"/>
                    <button type="submit" class="search-button"><i class="fas fa-search"></i></button>
                </form>
            </div>
            <div id="header-connection">
                <a class="header-link" href="../../pages/annonceAdd/">
                    <button type="submit" class="header-co-contour" name="annonce-btn">
                        <i class="fas fa-plus"></i>
                    </button>
                </a>
                <a class="header-link" href="../../pages/receptionMessage/">
                    <button type="submit" class="header-co-contour" name="chat-btn">
                        <i class="fas fa-comments"></i>
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