<?php
    if (isset($_SESSION['message'])) :
        foreach ($_SESSION['message'] as $status => $message) :
?>
<div class="container alert alert-<?=$status=='success'?'success':'danger'?>" role="alert">
    <?=$message?>
</div>
<?php
            unset($_SESSION['message'][$status]);
        endforeach;
    endif;
?>