<?php

    $tes = "hallo";

    echo $tes . '<br>';
    $pw = password_hash($tes, PASSWORD_DEFAULT);
    echo password_verify($tes, $pw);