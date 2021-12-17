#!/bin/bash

docker run -d --restart=always -p 80:8080 -v "$PWD":/usr/src/myapp -w /usr/src/myapp thecodingmachine/php:8.1-v4-slim-cli php -S 0.0.0.0:8080 index.php
