<?php
    namespace DAO;

    use DAO\IDuenoDAO as IDuenoDAO;
    use Models\Dueno as Dueno;

    class DuenoDAO implements IDuenoDAO
    {
        private $DuenoList = array();
        private $fileName = ROOT."Data/Duenos.json";

        public function comprobarUser(Dueno $Dueno)
        {
            $this->RetrieveData();

            foreach ($this->DuenoList as $UnDueno) {
                if ($Dueno->getUserName() == $UnDueno->getUserName()) {
                    return true;
                }
            }

            return false;
        }

        public function comprobarMail(Dueno $Dueno)
        {
            $this->RetrieveData();

            foreach ($this->DuenoList as $UnDueno) {
                if ($Dueno->getMail() == $UnDueno->getMail()) {
                    return true;
                }
            }

            return false;
        }


        public function Add(Dueno $Dueno)
        {
            $this->RetrieveData();
            
            $Dueno->setId($this->GetNextId());
            
            if (!$this->comprobarUser($Dueno) ) {
                if (!$this->comprobarMail($Dueno)) {
                    array_push($this->DuenoList, $Dueno);

                    $this->SaveData();
                } else {
                    echo "<script>alert('¡La dirección de mail ya está en uso!')</script>";
                    require_once(VIEWS_PATH."home.php");
                }
            } else {
                echo "<script>alert('¡El usuario ya existe!')</script>";
                require_once(VIEWS_PATH."home.php");
            }
            
        }

        public function EditProfile(Dueno $PerfilDueno){

            $this->RetrieveData();

            $id = count ($this->DuenoList); ///cuenta los elementos que hay y calcula el ultimo id,
                                               ///por ahora funciona, pero cuando se puedan borrar usuarios, no van a coincidir, 
                                              ///o el usuario puede registrarse y salir sin completar el perfil y generaria problemas tmb

            foreach ($this->DuenoList as $Dueno){

                if ($Dueno->getId()==$id){

                    $Dueno->setNombre($PerfilDueno->getNombre());
                    $Dueno->setApellido($PerfilDueno->getApellido());
                    $Dueno->setEdad($PerfilDueno->getEdad());
                    $Dueno->setFotoPerfil($PerfilDueno->getFotoPerfil());
                    $Dueno->setMascotas($PerfilDueno->getMascotas());
                    $Dueno->setHistorial($PerfilDueno->getHistorial());

                }
            }

            $this->SaveData();

        }

        public function GetAll()
        {
            $this->RetrieveData();

            return $this->DuenoList;
        }

        public function Remove($id)
        {            
            $this->RetrieveData();
            
            $this->DuenoList = array_filter($this->DuenoList, function($Dueno) use($id){                
                return $Dueno->getId() != $id;
            });
            
            $this->SaveData();
        }

        private function RetrieveData()
        {
             $this->DuenoList = array();

             if(file_exists($this->fileName))
             {
                 $jsonToDecode = file_get_contents($this->fileName);

                 $contentArray = ($jsonToDecode) ? json_decode($jsonToDecode, true) : array();
                 
                 foreach($contentArray as $content)
                 {
                     $Dueno = new Dueno();
                     $Dueno->setId($content["id"]);
                     $Dueno->setUserName($content["username"]);
                     $Dueno->setPassWord($content["password"]);
                     $Dueno->setMail($content["mail"]);
                     $Dueno->setNombre($content["nombre"]);
                     $Dueno->setApellido($content["apellido"]);
                     $Dueno->setEdad($content["edad"]);
                     $Dueno->setFotoPerfil($content["fotoperfil"]);
                     $Dueno->setMascotas($content["mascotas"]);
                     $Dueno->setHistorial($content["historial"]);

                     array_push($this->DuenoList, $Dueno);
                 }
             }
        }

        private function SaveData()
        {
            $arrayToEncode = array();

            foreach($this->DuenoList as $Dueno)
            {
                $valuesArray = array();
                $valuesArray["id"] = $Dueno->getId();
                $valuesArray["username"] = $Dueno->getUserName();
                $valuesArray["password"] = $Dueno->getPassWord();
                $valuesArray["mail"] = $Dueno->getMail();
                $valuesArray["nombre"] = $Dueno->getNombre();
                $valuesArray["apellido"] = $Dueno->getApellido();
                $valuesArray["edad"] = $Dueno->getEdad();
                $valuesArray["fotoperfil"] = $Dueno->getFotoPerfil();
                $valuesArray["mascotas"] = $Dueno->getMascotas();
                $valuesArray["historial"] = $Dueno->getHistorial();
                array_push($arrayToEncode, $valuesArray);
            }

            $fileContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);

            file_put_contents($this->fileName, $fileContent);
        }

        private function GetNextId()
        {
            $id = 0;

            foreach($this->DuenoList as $Dueno)
            {
                $id = ($Dueno->getId() > $id) ? $Dueno->getId() : $id;
            }

            return $id + 1;
        }
    }
?>