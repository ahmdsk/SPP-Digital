<?php
    session_start();
    require_once 'Database.php';

    class Auth {
        public $lecture;
        public $student;
        public $data;
        
        public function login($uname, $pass, $priv){
            global $db;

            if($priv == "lecture"){
                $this->log = $db->conn->prepare("SELECT * FROM petugas WHERE email='$uname'");
                $this->log->execute();

                $this->data = $this->log->fetch(PDO::FETCH_ASSOC);

                if($this->log->rowCount() >= 1){
                    $hash = password_verify($pass, $this->data['password']);
                    
                    if($hash){
                        return $this->data;
                    }
                }
            } elseif($priv == "student"){
                $this->log = $db->conn->prepare("SELECT * FROM siswa WHERE nisn='$uname'");
                $this->log->execute();

                $this->data = $this->log->fetch(PDO::FETCH_ASSOC);

                if($this->log->rowCount() >= 1){
                    $hash = password_verify($pass, $this->data['password']);
                    
                    if($hash){
                        return $this->data;
                    }
                }
            }
        }

        public function logout(){
            session_start();
            session_destroy();
            session_unset();
        }

        public function cek_login($page){
            if(empty($_SESSION['username'])){
                header("location: $page");
            }else {
                
            }
        }
    }

    $auth = new Auth();