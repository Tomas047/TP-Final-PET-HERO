<?php
    namespace Controllers;
    
    use DAO\DuenoDAO as DuenoDAO; 
    use Models\Dueno as Dueno;
    use DAO\GuardianDAO as GuardianDAO; 
    use Exception;
    use Throwable;
    use Models\Guardian as Guardian;
    use Controllers\MascotaController as MascotaController;
    use Models\Mascota as Mascota;
    use Controllers\ReservaController as ReservaController;
    use Models\Reserva as Reserva;
    use DAO\ReservaDAO as ReservaDAO;
    

    class HomeController
    {
        private $duenoDAO;
        private $guardianDAO;

        public function __construct()
        {
            try {
                $this->duenoDAO = new DuenoDAO();
                $this->guardianDAO = new GuardianDAO();
            } catch (Exception $e) {
                $alert=['tipo'=>"error",'mensaje'=>"Error"];
                $controllerHome = new HomeController();
                $controllerHome->index($alert);
            }
            
        }


        public function Index($alert = "")
        {
            try {
                if (isset($_SESSION["loggedUser"])) {

                    if ($_SESSION["type"] == "d") {
                        $usuario = New Dueno();
                        $usuario = $this->duenoDAO->GetById($_SESSION["id"]);
                        $controllerMascota = new MascotaController();
                        $cantidadMascotas = $controllerMascota->countMascotas($_SESSION["id"])[0];
                        $controllerReserva = new ReservaController();
                        $cantidadReservasFin = $controllerReserva->CountReservas($_SESSION["id"])[0];
                        $chatDisponibles = $controllerReserva->TieneChats($_SESSION["id"]);
                        require_once(VIEWS_PATH."maindueno.php");

                    } else if ($_SESSION["type"] == "g"){
                        $usuario = New Guardian();
                        $usuario = $this->guardianDAO->GetById($_SESSION["id"]);
                        $reservaDao = new ReservaDAO();
                        $reservas = $reservaDao->getDatosReservaGuardian($_SESSION["id"]);
                        $controllerReserva = new ReservaController();
                        $chatDisponibles = $controllerReserva->TieneChats($_SESSION["id"]);

                        require_once(VIEWS_PATH."mainguardian.php");
                    }
                } else {
                    require_once(VIEWS_PATH."home.php");
                }
            } catch (Exception $e) {
                $alert=['tipo'=>"error",'mensaje'=>"Error"];
                $controllerHome = new HomeController();
                $controllerHome->error($alert);
            }
            
        }

    
        public function registroGuardian($alert = ""){
            require_once(VIEWS_PATH."registroguardian.php");
        }

        public function registroDueno($alert = ""){
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
            try {
                
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
                    $_SESSION["fotoPerfil"] = $user->getFotoPerfil();

                    $alert=['tipo'=>"exito",'mensaje'=>"Logeado con Éxito"];


                    $this->Index($alert);
                    //$this->ShowAddView();
                    
                } else {
                    $alert=['tipo'=>"error",'mensaje'=>"Datos Incorrectos"];
                }
                //agregar mensaje de error 
                
                $this->Index($alert);
            } catch (Exception $e) {
                $alert=['tipo'=>"error",'mensaje'=>"Error"];
                $controllerHome = new HomeController();
                $controllerHome->index($alert);
            }
            
        }
        
        public function Logout()
        {
            unset($_SESSION["loggedUser"]);
            session_destroy();
            $alert=['tipo'=>"exito",'mensaje'=>"Deslogeado con Éxito"];
            $this->Index($alert);
        }

        public function Error($alert=''){

            require_once(VIEWS_PATH."error.php");

        }
    }
?>