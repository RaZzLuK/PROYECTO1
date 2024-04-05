<?php
    if(isset($_SESSION['message'])) {
        $message_type = strpos($_SESSION['message'], 'Error') === 0 ? 'alert-danger' : 'alert-warning';
?>

    <div class="alert <?= $message_type ?> alert-dismissible fade show" role="alert">
        <?php if(strpos($_SESSION['message'], 'Error') === 0) : ?>
            <strong>Error:</strong>
        <?php endif; ?>
        <?= str_replace('Error:', '', $_SESSION['message']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

<?php 
    unset($_SESSION['message']);
    }
?>
