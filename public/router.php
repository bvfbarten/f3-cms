<?php

if (is_file(__DIR__ . $_SERVER["REQUEST_URI"])) {
  return false;
} else {
    require __DIR__ . '/index.php';
}
