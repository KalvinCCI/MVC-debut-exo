<header class="sticky-top">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a href="/" class="navbar-brand">Php Objet</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a href="/" class="nav-link">Accueil</a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
<?php if(isset($_SESSION['user'])): ?>
                    <li class="nav-item">
                        <a href="/logout" class="btn btn-danger">Se déconnecter</a>
                    </li>
<?php else: ?>
                    <li class="nav-item">
                        <a href="/login" class="btn btn-light">Se connecter</a>
                    </li>
<?php endif ?>
                </ul>
            </div>
        </div>
    </nav>
</header>