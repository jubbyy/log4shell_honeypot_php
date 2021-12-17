# log4shell_honeypot_php

This is a very simple honeypot using php container from thecodingmachine/php:8.1-v4-slim-cli 

just 3 stpes
1. create index.php file with this contents

create output folder with this command
<?php
file_put_contents("output/" . (string)time() . "access.log",json_encode($_SERVER,JSON_PRETTY_PRINT));
?>


2. mkdir $PWD/output


3. and finally run docker like this

$docker run -d --restart=always -p 80:8080 -v "$PWD":/usr/src/myapp -w /usr/src/myapp thecodingmachine/php:8.1-v4-slim-cli php -S 0.0.0.0:8080 index.php


Results

all web server access will drop a files (with timestamp) in your "output" folder


