<?php
    namespace DAO;

    use DAO\IMascotaDAO as IMascotaDAO;
    use Models\Mascota as Mascota;

    class MascotaDAO implements IMascotaDAO
    {
        private $MascotaList = array();
        private $fileName = ROOT."Data/Mascotas.json";

        public function Add(Mascota $Mascota)
        {
            $this->RetrieveData();
            
            $Mascota->setId($this->GetNextId());
            
            array_push($this->MascotaList, $Mascota);

            $this->SaveData();
        }

        public function EditProfile(Mascota $PerfilMascota){

            $this->RetrieveData();

            $id = count ($this->MascotaList); ///cuenta los elementos que hay y calcula el ultimo id,
                                              ///por ahora funciona, pero cuando se puedan borrar usuarios, no van a coincidir, 
                                              ///o el usuario puede registrarse y salir sin completar el perfil y generaria problemas tmb

            foreach ($this->MascotaList as $Mascota){

                if ($Mascota->getId()==$id){

                    $Mascota->setNombre($PerfilMascota->getNombre());
                    $Mascota->setApellido(NULL);
                    $Mascota->setEdad($PerfilMascota->getEdad());
                    $Mascota->setFotoPerfil($PerfilMascota->getFotoPerfil());
                    $Mascota->setMascotas($PerfilMascota->getTamano());
                    $Mascota->setHistorial($PerfilMascota->getIndicaciones());

                }
            }

            $this->SaveData();

        }

        public function GetAll()
        {
            $this->RetrieveData();

            return $this->MascotaList;
        }

        public function Remove($id)
        {            
            $this->RetrieveData();
            
            $this->MascotaList = array_filter($this->MascotaList, function($Mascota) use($id){                
                return $Mascota->getId() != $id;
            });
            
            $this->SaveData();
        }

        private function RetrieveData()
        {
             $this->MascotaList = array();

             if(file_exists($this->fileName))
             {
                 $jsonToDecode = file_get_contents($this->fileName);

                 $contentArray = ($jsonToDecode) ? json_decode($jsonToDecode, true) : array();
                 
                 foreach($contentArray as $content)
                 {
                     $Mascota = new Mascota();
                     $Mascota->setId($content["id"]);
                     $Mascota->setNombre($content["nombre"]);
                     $Mascota->setApellido(NULL);
                     $Mascota->setEdad($content["edad"]);
                     $Mascota->setFotoPerfil($content["fotoperfil"]);
                     $Mascota->setTamano($content["tamano"]);
                     $Mascota->setIndicaciones($content["indicaciones"]);
                     $Mascota->setIdDueno($content["idDueno"]);
                     $Mascota->setRaza($content["raza"]);
                     $Mascota->setEspecie($content["especie"]);

                     array_push($this->MascotaList, $Mascota);
                 }
             }
        }

        private function SaveData()
        {
            $arrayToEncode = array();

            foreach($this->MascotaList as $Mascota)
            {
                $valuesArray = array();
                $valuesArray["id"] = $Mascota->getId();
                $valuesArray["idDueno"] = $Mascota->getIdDueno();
                $valuesArray["nombre"] = $Mascota->getNombre();
                $valuesArray["edad"] = $Mascota->getEdad();
                $valuesArray["fotoperfil"] = $Mascota->getFotoPerfil();
                $valuesArray["tamano"] = $Mascota->getTamano();
                $valuesArray["indicaciones"] = $Mascota->getIndicaciones();
                $valuesArray["raza"] = $Mascota->getRaza();
                $valuesArray["especie"] = $Mascota->getEspecie();
                array_push($arrayToEncode, $valuesArray);
            }

            $fileContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);

            file_put_contents($this->fileName, $fileContent);
        }

        private function GetNextId()
        {
            $id = 0;

            foreach($this->MascotaList as $Mascota)
            {
                $id = ($Mascota->getId() > $id) ? $Mascota->getId() : $id;
            }

            return $id + 1;
        }
    }
?>