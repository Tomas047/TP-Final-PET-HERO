<?php
    namespace DAO;

    use DAO\IGuardianDAO as IGuardianDAO;
    use Models\Guardian as Guardian;
    use DAO\Connection as Connection;
    use \Exception as Exception;

    class GuardianDAO implements IGuardianDAO
    {
        private $GuardianList = array();
        private $tableName = "guardian";

        public function Add(Guardian $Guardian)
        {
            try {
                $query = "INSERT INTO ".$this->tableName." (email, password) VALUES (:email, :password);";
                
                
                $parameters["email"] = $Guardian->getMail();
                $parameters["password"] = $Guardian->getPassWord();

                $this->connection = Connection::GetInstance();

                $this->connection->ExecuteNonQuery($query, $parameters);

            } catch (Excepcion $ex){
                throw $ex;
            }
               
        }


        public function EditProfile(Guardian $PerfilGuardian){

            try {

                $query = "UPDATE ".$this->tableName." SET nombre=:nombre, apellido=:apellido, edad=:edad, foto_perfil=:foto_perfil, tamano=:tamano, tarifa=:tarifa, disponibilidad=:disponibilidad WHERE id_guardian = ".$_SESSION["id"].";";
                
                $parameters["nombre"] = $PerfilGuardian->getNombre();
                $parameters["apellido"] = $PerfilGuardian->getApellido();
                $parameters["edad"] = $PerfilGuardian->getEdad();
                $parameters["foto_perfil"] = $PerfilGuardian->getFotoPerfil();
                $parameters["tamano"] = implode(",", $PerfilGuardian->getTamano());
                $parameters["tarifa"] = $PerfilGuardian->getRemuneracion();
                $parameters["disponibilidad"] = $PerfilGuardian->getDisponibilidad();
                //$parameters["reputacion"] = $PerfilGuardian->getReputacion
            
                $this->connection = Connection::GetInstance();

                $this->connection->ExecuteNonQuery($query, $parameters);

            } catch (Excepcion $ex){
                throw $ex;
            }
        }

        public function Remove($id)
        {            
            try {
                $query = "delete from ".$this->tableName." WHERE id_guardian = :id_guardian;";

                $parameters["id_guardian"] = $id;

                $this->connection = Connection::GetInstance();

                $result=$this->connection->ExecuteNonQuery($query,$parameters);

                //var_dump($id);
            } catch (Excepcion $ex){
                throw $ex;
            }
        }

        public function GetAll()
        {
            try{
                $this->GuardianList = array();
                
                $query = "SELECT * FROM ".$this->tableName;

                $this->connection = Connection::GetInstance();
                $resultSet = $this->connection->Execute($query);

                foreach ($resultSet as $row){
                    $Guardian = new Guardian();
                    $Guardian->setId($row["id_guardian"]);
                    $Guardian->setMail($row["email"]);
                    $Guardian->setNombre($row["nombre"]);
                    $Guardian->setApellido($row["apellido"]);
                    $Guardian->setEdad($row["edad"]);
                    $Guardian->setFotoPerfil($row["foto_perfil"]);
                    $Guardian->setPassWord($row["password"]);
                    $Guardian->setRemuneracion($row["tarifa"]);
                    $Guardian->setTamano($row["tamano"]);
                    $Guardian->setDisponibilidad($row["disponibilidad"]);

                    array_push($this->GuardianList, $Guardian);
                }

                return $this->GuardianList;
            }catch(Exception $ex){
                return $ex;
            }
        }

        public function GetIdByMail($mail){

            try {

                $result = array();

                $query = "SELECT id_guardian from ".$this->tableName." WHERE EMAIL = :email;";
                
                
                $parameters["email"] = $mail;

                $this->connection = Connection::GetInstance();

                $result=$this->connection->Execute($query,$parameters);

                $id=$result[0]["id_guardian"];
                //var_dump($id);
                return $id;

            } catch (Excepcion $ex){
                throw $ex;
            }

        }
        /*private function SaveData()
        {
            $arrayToEncode = array();

            foreach($this->GuardianList as $Guardian)
            {
                $valuesArray = array();
                $valuesArray["id"] = $Guardian->getId();
                $valuesArray["password"] = $Guardian->getPassWord();
                $valuesArray["mail"] = $Guardian->getMail();
                $valuesArray["nombre"] = $Guardian->getNombre();
                $valuesArray["apellido"] = $Guardian->getApellido();
                $valuesArray["edad"] = $Guardian->getEdad();
                $valuesArray["fotoperfil"] = $Guardian->getFotoPerfil();
                $valuesArray["tamano"] = $Guardian->getTamano();
                $valuesArray["remuneracion"] = $Guardian->getRemuneracion();
                $valuesArray["disponibilidad"] = $Guardian->getDisponibilidad();
                array_push($arrayToEncode, $valuesArray);
            }

            $fileContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);

            file_put_contents($this->fileName, $fileContent);
        }*/

        public function GetByMail($mail)
        {
            try{
                $query = "SELECT * FROM ".$this->tableName." WHERE email = :email;";

                $parameters["email"] = $mail;

                $this->connection = Connection::GetInstance();

                $result=$this->connection->Execute($query,$parameters);

                if(isset($result[0])) {

                $Guardian = new Guardian();
                $Guardian->setId($result[0]["id_guardian"]);
                $Guardian->setMail($result[0]["email"]);
                $Guardian->setNombre($result[0]["nombre"]);
                $Guardian->setApellido($result[0]["apellido"]);
                $Guardian->setEdad($result[0]["edad"]);
                $Guardian->setFotoPerfil($result[0]["foto_perfil"]);
                $Guardian->setPassWord($result[0]["password"]);
                $Guardian->setRemuneracion($result[0]["tarifa"]);
                $Guardian->setTamano($result[0]["tamano"]);
                $Guardian->setDisponibilidad($result[0]["disponibilidad"]);
                }else{
                    $Guardian = null;
                }

                return $Guardian;
            }catch(Exception $ex){
                return $ex;
            }
        }

        public function GetById($id){
            try{
                $query = "SELECT * FROM ".$this->tableName." WHERE ID_GUARDIAN = :id_guardian;";

                $parameters["id_guardian"] = $id;

                $this->connection = Connection::GetInstance();

                $result=$this->connection->Execute($query,$parameters);

                //var_dump($result);
                $Guardian = new Guardian();
                $Guardian->setId($result[0]["id_guardian"]);
                $Guardian->setMail($result[0]["email"]);
                $Guardian->setNombre($result[0]["nombre"]);
                $Guardian->setApellido($result[0]["apellido"]);
                $Guardian->setEdad($result[0]["edad"]);
                $Guardian->setFotoPerfil($result[0]["foto_perfil"]);
                $Guardian->setPassWord($result[0]["password"]);
                $Guardian->setRemuneracion($result[0]["tarifa"]);
                $Guardian->setTamano($result[0]["tamano"]);
                $Guardian->setDisponibilidad($result[0]["disponibilidad"]);

                return $Guardian;
            }catch(Exception $ex){
                return $ex;
            }
        }
    }
?>