<?php
file_put_contents("output/" . (string)time() . "access.log",json_encode($_SERVER,JSON_PRETTY_PRINT));
?>
