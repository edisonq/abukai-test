<?php
$number= filter_input(INPUT_GET, "number", FILTER_SANITIZE_STRING);

echo '<h1>'.$number.'</h1>';

?>