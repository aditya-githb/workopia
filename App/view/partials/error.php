<?php
if (isset($errors)) {
    foreach ($errors as $err) {
?>
        <div class='message bg-red-100 p-3 my-3'><?=$err?></div>
<?php
    }
}
