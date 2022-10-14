<?php
    namespace Controllers;
    
    use DAO\DuenoDAO as DuenoDAO; 
    use Models\Dueno as Dueno;
    use DAO\GuardianDAO as GuardianDAO; 
    use Models\Guardian as Guardian;
    

    class HomeController
    {
        private $duenoDAO;
        private $guardianDAO;

        public function __construct()
        {
            $this->duenoDAO = new DuenoDAO();
            $this->guardianDAO = new GuardianDAO();
        }

        public function Index($message = "")
        {
            if (isset($_SESSION["loggedUser"])) {

                if ($_SESSION["type"] == "d") {
                    $usuario = New Dueno();
                    $usuario = $this->duenoDAO->GetByName($_SESSION["loggedUser"]);
                    require_once(VIEWS_PATH."maindueno.php");

                } else if ($_SESSION["type"] == "g"){
                    $usuario = New Guardian();
                    $usuario = $this->guardianDAO->GetByName($_SESSION["loggedUser"]);
                    require_once(VIEWS_PATH."mainguardian.php");
                }
            } else {
                require_once(VIEWS_PATH."home.php");
            }
        }

    
        public function registroGuardian(){
        require_once(VIEWS_PATH."registroguardian.php");
        }

        public function registroDueno(){
        require_once(VIEWS_PATH."registrodueno.php");
        }

        public function registroMascota(){
        require_once(VIEWS_PATH."agregarmascota.php");
        }

        public function ShowAddView()
        {
            require_once(VIEWS_PATH."validate-session.php");
            //require_once(VIEWS_PATH."add-cellphone.php");
        }

        public function Login($mail, $password)
        {

            //1. declarar dao guardian y dueno 
            //2. array merge con getAll de los dao como parametro
            
            $user = new Dueno();
            $user = $this->duenoDAO->GetByMail($mail);

            if ($user == null) {
                $user = new Guardian();
                $user = $this->guardianDAO->GetByMail($mail);
            }

            if(($user != null) && ($user->getPassword() === $password))
            {
                $_SESSION["loggedUser"] = $user->getNombre();
                $_SESSION["type"] = $user->getType();
                $_SESSION["id"] = $user->getId();

                echo "<script>alert('Logeado con éxito')</script>";

                $this->Index();
                //$this->ShowAddView();
                
            }
            else

                 echo "<script>alert('Datos incorrectos')</script>";
                //agregar mensaje de error 
                $this->Index();
        }
        
        public function Logout()
        {
            unset($_SESSION["loggedUser"]);
            session_destroy();
            echo "<script>alert('Deslogeado con éxito')</script>";
            $this->index();
        }
    }
?>