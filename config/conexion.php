<?php
    session_start();
    class Conectar{
        protected $dbh;
        protected function Conexion(){
            try{
                $conectar=$this->dbh=new PDO("mysql:local=localhost;dbname=diinsel_helpdesk","root","");
                return $conectar;
            }
            catch(Exception $e){
                print "¡Error BD!: ".$e->getMessage();
                die();
            }
        }

        public function set_name(){
            return $this->dbh->query("SET NAMES 'utf8'");
        }
        
        public static function ruta(){
            return "http://localhost/PERSONAL_HelpDesk/";
        }
    }
?>