<?php
    namespace Controllers;

    use DAO\GuardianDAO as GuardianDAO;
    use Models\Guardian as Guardian;

    class GuardianController
    {
        private $GuardianDAO;

        public function __construct()
        {
            $this->GuardianDAO = new GuardianDAO();
        }

        /*public function ShowAddView()
        {
            require_once(VIEWS_PATH."validate-session.php");
            require_once(VIEWS_PATH."add-Guardian.php");
        }
        */

        public function ShowListView()
        {
           // require_once(VIEWS_PATH."validate-session.php");
            $GuardianList = $this->GuardianDAO->getAll();

            require_once(VIEWS_PATH."listaguardianes.php");
        }

        public function Add($password,$passwordconfirm, $mail)
        {
            //require_once(VIEWS_PATH."validate-session.php");

            if ($password==$passwordconfirm){  //Valida que las contraseñas sean iguales
                
                    if(!$this->mailExiste($mail)){ //Valida que el email no exista

                    $Guardian = new Guardian();
                    $Guardian->setPassWord($password);
                    $Guardian->setMail($mail);

                    $this->GuardianDAO->Add($Guardian);

                    $_SESSION["type"] = $Guardian->getType();
                    $_SESSION["id"] = $Guardian->getId();

                    require_once(VIEWS_PATH."editarperfilguardian.php");
                    }
                    else{
                        echo "<script>alert('El email ya existe')</script>";
                        require_once(VIEWS_PATH."registroguardian.php");}
            }
            else{
                echo "<script>alert('Las contraseñas no coinciden')</script>";
                require_once(VIEWS_PATH."registroguardian.php"); }

            //$this->ShowAddView();
        }

      
        public function mailExiste($mail)
        {
            $GuardianList= $this->GuardianDAO->getAll();
            foreach ($GuardianList as $Guardian) {
                if ($mail == $Guardian->getMail()) {
                    return true;
                }
            }
            return false;
        }

        public function EditProfile($nombre,$apellido,$edad,$fotoperfil,$remuneracion,$tipoperro,$disponibilidad)
        {

            $PerfilGuardian = new Guardian();
            $PerfilGuardian->setNombre($nombre);
            $PerfilGuardian->setApellido($apellido);
            $PerfilGuardian->setEdad($edad);
            $PerfilGuardian->setFotoPerfil($fotoperfil);
            $PerfilGuardian->setRemuneracion($remuneracion);
            $PerfilGuardian->setTipoPerro($tipoperro);
            $PerfilGuardian->setDisponibilidad($disponibilidad);
            
            $this->GuardianDAO->EditProfile($PerfilGuardian);

            $_SESSION["loggedUser"] = $nombre;

            echo "<script>alert('Perfil creado con éxito')</script>";


            header('location:../index.php');

        }

        

        public function Remove($id)
        {
            //require_once(VIEWS_PATH."validate-session.php");
            
            $this->GuardianDAO->Remove($id);

            //$this->ShowListView();
        }
    }
?>