<section class="container mt-4 postes">
    <h1 class="text-center">Page d'accueil</h1>
    <div class="row justify-content-between g-3">
<?php
    foreach($postes as $poste):
?>
        <div class="col-md-4 col-12">
            <div class="card">
                <h2 class="card-header"><?=$poste->titre?></h2>
                <div class="card-body">
                    <p class="card-text"><?=$poste->description?></p>
                    <a href="/postes/details/<?=$poste->id?>" class="btn btn-primary">En savoir plus</a>
                </div>
            </div>
        </div>
<?php
    endforeach;
?>
    </div>
</section>
