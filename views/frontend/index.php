<h1>sdvfh fsf</h1>

<section class="postes">
    <div class="postes-list">
<?php
    foreach($postes as $poste):
?>
        <div class="card">
            <h2><?=$poste->titre?></h2>
        </div>
<?php
    endforeach;
?>
    </div>
</section>
