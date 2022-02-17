<?php
    require_once '../Auth.php';

    $auth->logout();
    header("location: ../index?pesan=berhasil");