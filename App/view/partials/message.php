<?php
if (isset($_SESSION['message_success'])) {
?>
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
        <?= $_SESSION['message_success'] ?>
    </div>
<?php
    unset($_SESSION['message_success']);
}
if (isset($_SESSION['message_error'])) {
    ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <?= $_SESSION['message_error'] ?>
        </div>
    <?php
        unset($_SESSION['message_error']);
    }

?>