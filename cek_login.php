<?php

require_once 'Auth.php';

$email = $_POST['username'];
$pass  = $_POST['password'];

if(!empty($email) && !empty($pass)){
    if($auth->login($email, $pass, "lecture")){
        $_SESSION['id_petugas'] = $auth->data['id_petugas'];
        $_SESSION['email']      = $auth->data['email'];
        $_SESSION['level']      = $auth->data['level'];

        if($_SESSION['level'] == "admin"){
            header("location: admin/index?pesan=berhasil");
        } elseif($_SESSION['level'] == "petugas"){
            header("location: petugas/index?pesan=berhasil");
        } else {
            header("location: index?pesan=gagal");
        }
    }elseif($auth->login($email, $pass, "student")){
        $_SESSION['nama'] = $auth->data['nama'];
        $_SESSION['nisn'] = $auth->data['nisn'];

        header("location: siswa/index?pesan=berhasil");
    }else{
        header("location: index?pesan=tidak_ditemukan");
    }
}else{
    header("location: index?pesan=kosong");
}