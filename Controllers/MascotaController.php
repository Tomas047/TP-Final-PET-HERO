<?php
    namespace Controllers;

    use DAO\MascotaDAO as MascotaDAO;
    use Models\Mascota as Mascota;

    class MascotaController
    {
        private $MascotaDAO;

        public function __construct()
        {
            $this->MascotaDAO = new MascotaDAO();
        }

        /*public function ShowAddView()
        {
            require_once(VIEWS_PATH."validate-session.php");
            require_once(VIEWS_PATH."add-Mascota.php");
        }

        public function ShowListView()
        {
            require_once(VIEWS_PATH."validate-session.php");
            $MascotaList = $this->MascotaDAO->getAll();
            
            require_once(VIEWS_PATH."Mascota-list.php");
        }*/

        public function Add($nombre, $edad, $tipo, $indicaciones, $fotoperfil)
        {
            //require_once(VIEWS_PATH."validate-session.php");


            // 1.  <!------------------Validar Contraseñas----------------> 

            // 2.  <!------------------Verificar que no existe UserName----------------> 

            // 3. <!------------------Verificar que no exista Email----------------->

            $Mascota = new Mascota();
            $Mascota->setNombre($nombre);
            //$Mascota->setApellido($apellido);
            $Mascota->setEdad($edad);
            $Mascota->setFotoPerfil($fotoperfil);
            $Mascota->setTipoPerro($tipo);
            $Mascota->setIndicaciones($indicaciones);

            $this->MascotaDAO->Add($Mascota);

            require_once(VIEWS_PATH."agregarmascota.php");

            //$this->ShowAddView();
        }

        public function EditProfile($nombre,$edad,$tipo, $indicaciones,$fotoperfil)
        {

            $PerfilMascota = new Mascota();
            $PerfilMascota->setNombre($nombre);
            //$PerfilMascota->setApellido($apellido);
            $PerfilMascota->setEdad($edad);
            $PerfilMascota->setFotoPerfil($fotoperfil);
            $Mascota->setTipoPerro($tipo);
            $Mascota->setIndicaciones($indicaciones);
            
            $this->MascotaDAO->EditProfile($PerfilMascota);

            require_once(VIEWS_PATH."listamascotas.php");

        }

        public function Remove($id)
        {
            //require_once(VIEWS_PATH."validate-session.php");
            
            $this->MascotaDAO->Remove($id);

            //$this->ShowListView();
        }
    }
?>