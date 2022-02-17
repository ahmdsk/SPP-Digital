<?php

class Database
{
    private $host  = "localhost";
    private $user  = "root";
    private $pass  = "";
    private $db_nm = "db_spp";
    public $conn  = "";

    public function __construct()
    {
        try {
            $this->conn = new PDO("mysql:host=$this->host;dbname=$this->db_nm", $this->user, $this->pass);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Koneksi gagal: " . $e->getMessage();
        }
    }

    // tampil semua data
    public function tampil($tbl)
    {
        $data = $this->conn->prepare("SELECT * FROM $tbl");
        $data->execute();
        return $data;
    }

    // get Status
    function getStatus($status)
    {
        $nisn = $_SESSION['nisn'];
        $bayar = $this->conn->prepare("SELECT status FROM pembayaran WHERE nisn='$nisn' AND status='$status'");
        $bayar->execute();

        return $bayar->rowCount();
    }
}

$db = new Database();
