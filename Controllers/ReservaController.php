<?php
    namespace Controllers;

    use Models\Guardian as Guardian;
    use Models\Reserva as Reserva;
    use Controllers\GuardianController as GuardianController;
    use Controllers\HomeController as HomeController;
    use Controllers\CuponController as CuponController;
    use DAO\ReservaDAO as ReservaDAO;
    use Exception;
    use Throwable;


    class ReservaController
    {
        private $ReservaDAO;

        public function __construct()
        {
            try {
                $this->ReservaDAO = new ReservaDAO();
            } catch (Exception $e) {
                $alert=['tipo'=>"error",'mensaje'=>"Error"];
                $controllerHome = new HomeController();
                $controllerHome->index($alert);
            }
            
        }

        public function Add($fechaInicio, $fechaFinal, $idGuardian, $idDueno,$mascota = "")
        {
            try {
                $controllerGuardian = new GuardianController();
                $controllerHome = new HomeController();


                date_default_timezone_set('America/Argentina/Buenos_Aires'); //seteo la zona horaria

                $inicio = \date_create_from_format("Y-m-d",$fechaInicio);
                $fin = \date_create_from_format("Y-m-d",$fechaFinal);


                if($fechaInicio and $fechaFinal != ''){
                    if (!$mascota == ""){
                        $idMascota = explode(",", $mascota[0])[2];
                    if ($inicio<=$fin) { 
                        if($this->comprobarDisponibilidad($inicio,$fin,$idGuardian)){
                         if ($this->comprobarRaza($mascota)) {
                                if($this->comprobarRazaPorFecha($fechaInicio, $fechaFinal, $mascota,$idGuardian)){
                                    $reserva = new Reserva();
                                    $reserva->setIdDueno($idDueno);
                                    $reserva->setIdGuardian($idGuardian);
                                    $reserva->setFechaInicio($fechaInicio);
                                    $reserva->setFechaFinal($fechaFinal);
                                    $reserva->setIdMascota($idMascota);

                                    $this->ReservaDAO->Add($reserva);

                                    $alert=['tipo'=>"exito",'mensaje'=>"Reserva Creada con Éxito"];
                                    
                                    $controllerHome->Index($alert);
                                } else {
                                    $alert=['tipo'=>"error",'mensaje'=>"El Guardián tiene una Reserva con otra Raza en la Fecha Indicada."];
                                    $controllerGuardian->ShowProfile($idGuardian,$alert);
                                }
                            } else {
                                $alert=['tipo'=>"error",'mensaje'=>"Las Mascotas indicadas son de distintas razas"];
                                $controllerGuardian->ShowProfile($idGuardian,$alert);
                            }
                        } else {


                    //echo "<script>alert('El Guardián no se encuentra disponible en las fechas indicadas')</script>";

                    $alert=['tipo'=>"error",'mensaje'=>"El Guardián no se encuentra disponible en las fechas indicadas"];
                    $controllerGuardian->ShowProfile($idGuardian,$alert);

                    }
                } else {

                    $alert=['tipo'=>"error",'mensaje'=>"La Fecha Final debe ser posterior a la Fecha Inicial"];
                    $controllerGuardian->ShowProfile($idGuardian,$alert);
                }}else{

                    $alert=['tipo'=>"error",'mensaje'=>"Debe indicar una Mascota para la Reserva"];
                    $controllerGuardian->ShowProfile($idGuardian,$alert);
                }}else{
                    $alert=['tipo'=>"error",'mensaje'=>"Debe indicar las Fechas para la Reserva"];
                    $controllerGuardian->ShowProfile($idGuardian,$alert);

                }

            } catch (Exception $e) {
                $alert=['tipo'=>"error",'mensaje'=>"Error al crear reserva"];
                $controllerHome = new HomeController();
                $controllerHome->index($alert);
            }
            
        }

        public function comprobarDisponibilidad($fechaInicio,$fechaFinal,$idGuardian){
            try {
                $controllerGuardian = new GuardianController();
                $disponibilidad = $controllerGuardian->disponibilidadById($idGuardian);
                    if ($disponibilidad=='Plena'){return true;}else{

                        if ($disponibilidad=='Fines De Semana'){

                            $dateDiff = $fechaInicio->diff($fechaFinal);

                            if($dateDiff->d>1){
                                return false;

                            }else{
                                return true;
                            }

                        }else{

                            $arregloDisponibilidad = explode(",",$disponibilidad);

                            $unDia = new \DateInterval ("P1D");

                            for($fecha=$fechaInicio;$fecha<=$fechaFinal;$fecha->add($unDia)){

                                $fechaFormateada= date_format($fecha,"Y-m-d");

                                if(!\in_array($fechaFormateada,$arregloDisponibilidad)){

                                    return false;
                                }
                            }
                            return true;}}
            } catch (Exception $e) {
                $alert=['tipo'=>"error",'mensaje'=>"Error"];
                $controllerHome = new HomeController();
                $controllerHome->index($alert);
            }
            
        }

        public function comprobarRaza($mascota){

            try {
                $raza = array();
                
                foreach ($mascota as $value) {
                    $item = explode(",", $value);
                    array_push($raza, $item[1]);
                }

                $primeraRaza = $raza[0];

                foreach($raza as $item){
                    if($primeraRaza != $item){
                        return false;
                    }
                }

                return true;
            } catch (Exception $e) {
                $alert=['tipo'=>"error",'mensaje'=>"Error"];
                $controllerHome = new HomeController();
                $controllerHome->index($alert);
            }
            

        }

        public function comprobarRazaPorFecha($fechaInicio, $fechaFinal, $mascota,$idGuardian){
            
            try {
                $arregloRazas = $this->ReservaDAO->getListaRazas($fechaInicio, $fechaFinal,$idGuardian);

                if($arregloRazas){
                $raza = array();
                
                $raza = explode(",", $mascota[0]);

                if(strtolower($arregloRazas[0]["raza"]) != strtolower($raza[1])){
                    return false;
                }
                }

                return true;
            } catch (Exception $e) {
                $alert=['tipo'=>"error",'mensaje'=>"Error"];
                $controllerHome = new HomeController();
                $controllerHome->index($alert);
            }
            

        }

        public function updateEstado($idReserva,$estado,$mascota = '',$fecha_inicio = '',$fecha_final = '',$idGuardian=''){

            try {
                // comprobacion si no tiene ya reservas aceptadas con otras razas
                if ($estado == "Aceptada") {
                    if($this->comprobarRazaPorFecha($fecha_inicio,$fecha_final,$mascota,$idGuardian)){

                        $CuponController = new CuponController();
                        $idCupon = $CuponController->Add($idReserva);
                        $mailUsuario = $CuponController->encontrarMail($idReserva);
                        $nombreUsuario = $CuponController->encontrarNombre($idReserva);
                        $CuponController->enviarCupon($idCupon, $mailUsuario,$nombreUsuario);
                    }else{

                    $alert=['tipo'=>"error",'mensaje'=>"Tienes una Reserva con otra Raza en la Fecha Indicada"];

                    $controllerHome = new HomeController();
                    $controllerHome->index($alert);
                        return null;
                    } 
                    //Agregar para enviar mail
                }

                $this->ReservaDAO->updateEstado($idReserva,$estado);

                $alert=['tipo'=>"exito",'mensaje'=>"Estado Reserva Actualizado"];

                $controllerHome = new HomeController();
                $controllerHome->index($alert);
            } catch (Exception $e) {
                $alert=['tipo'=>"error",'mensaje'=>"Error al cambiar el estado de la reserva"];
                $controllerHome = new HomeController();
                $controllerHome->index($alert);
            }
        }        

        public function countReservas ($idDueno){

            try {
                
                $cantidadReservas = $this->ReservaDAO->ContarReservasFinalizadas($idDueno);
                
                return $cantidadReservas;
            } catch (Exception $e) {
                $alert=['tipo'=>"error",'mensaje'=>"Error"];
                $controllerHome = new HomeController();
                $controllerHome->index($alert);
            }
           
        }

        
        public function TieneChats($idUsuario){

            try {

                $ChatDisponibles = $this->ReservaDAO->TieneChats($idUsuario);
                return $ChatDisponibles;

            } catch (Exception $e) {
                $alert=['tipo'=>"error",'mensaje'=>'Error 123'];
                $controllerHome = new HomeController();
                $controllerHome->index($alert);
            }
            }
    }
?>