<?php
    namespace DAO;

    use DAO\IDuenoDAO as IDuenoDAO;
    use Models\Dueno as Dueno;
    use DAO\Connection as Connection;
    use \Exception as Exception;

    class DuenoDAO implements IDuenoDAO
    {
        private $DuenoList = array();
        private $tableName = "dueno";

    
        public function Add(Dueno $Dueno)
        {

            try {
                $query = "INSERT INTO ".$this->tableName." (email, password) VALUES (:email, :password);";
                
                
                $parameters["email"] = $Dueno->getMail();
                $parameters["password"] = $Dueno->getPassWord();

                $this->connection = Connection::GetInstance();

                $this->connection->ExecuteNonQuery($query, $parameters);

            } catch (Excepcion $ex){
                throw $ex;
            }
            
        }

        public function SetProfile(Dueno $PerfilDueno,$tmp_name){

            try {
                if($tmp_name==""){    //si vengo de editar perfil y no añado una foto nueva, no la paso como parametro en la query

                    $query = "UPDATE ".$this->tableName." SET nombre=:nombre, apellido=:apellido, edad=:edad
                     WHERE id_dueno = :id_dueno;";

                    }else{

                        $query = "UPDATE ".$this->tableName." SET nombre=:nombre, apellido=:apellido, edad=:edad,
                         foto_perfil=:foto_perfil WHERE id_dueno = :id_dueno;";

                            $nombre_imagen= $PerfilDueno->getFotoPerfil();
                            $ruta="Upload/img".$nombre_imagen;
                            move_uploaded_file($tmp_name,$ruta);
                            $_SESSION["fotoPerfil"] =  $ruta;
                            $parameters["foto_perfil"] = $ruta;
        
                    }

                $parameters["nombre"] = $PerfilDueno->getNombre();
                $parameters["apellido"] = $PerfilDueno->getApellido();
                $parameters["edad"] = $PerfilDueno->getEdad();
                $parameters["id_dueno"] = $_SESSION["id"];
            
                $this->connection = Connection::GetInstance();

                $this->connection->ExecuteNonQuery($query, $parameters);

            } catch (Excepcion $ex){
                throw $ex;
            }
        }


        public function GetIdByMail($mail){

            try {

                $result = array();

                $query = "SELECT id_dueno from ".$this->tableName." WHERE EMAIL = :email;";
                
                
                $parameters["email"] = $mail;

                $this->connection = Connection::GetInstance();

                $result=$this->connection->Execute($query,$parameters);

                if(isset($result[0]['id_dueno'])){
                $id=$result[0]["id_dueno"];}
                else {return false;}

                return $id;

            } catch (Excepcion $ex){
                throw $ex;
            }

        }

        public function Remove($id)
        {            
            try {
                $query = "delete from ".$this->tableName." WHERE id_dueno = :id_dueno;";

                $parameters["id_dueno"] = $id;

                $this->connection = Connection::GetInstance();

                $result=$this->connection->ExecuteNonQuery($query,$parameters);

            } catch (Excepcion $ex){
                throw $ex;
            }
        }

        public function GetAll()
        {
            try{
                $this->DuenoList = array();
                
                $query = "SELECT * FROM ".$this->tableName;

                $this->connection = Connection::GetInstance();
                $resultSet = $this->connection->Execute($query);

                foreach ($resultSet as $row){
                    $Dueno = new Dueno();
                    $Dueno->setId($row["id_dueno"]);
                    $Dueno->setMail($row["email"]);
                    $Dueno->setNombre($row["nombre"]);
                    $Dueno->setApellido($row["apellido"]);
                    $Dueno->setEdad($row["edad"]);
                    $Dueno->setFotoPerfil($row["foto_perfil"]);
                    $Dueno->setPassWord($row["password"]);

                    array_push($this->DuenoList, $Dueno);
                }

                return $this->DuenoList;
            }catch(Exception $ex){
                return $ex;
            }
        }

        public function GetById($id){
            try{
                $query = "SELECT * FROM ".$this->tableName." WHERE ID_DUENO = :id_dueno;";

                $parameters["id_dueno"] = $id;

                $this->connection = Connection::GetInstance();

                $result=$this->connection->Execute($query,$parameters);

                $Dueno = new Dueno();
                $Dueno->setId($result[0]["id_dueno"]);
                $Dueno->setMail($result[0]["email"]);
                $Dueno->setNombre($result[0]["nombre"]);
                $Dueno->setApellido($result[0]["apellido"]);
                $Dueno->setEdad($result[0]["edad"]);
                $Dueno->setFotoPerfil($result[0]["foto_perfil"]);
                $Dueno->setPassWord($result[0]["password"]);

                return $Dueno;
            }catch(Exception $ex){
                return $ex;
            }
        }

        public function GetByMail($mail)
        {
            try{
                $query = "SELECT * FROM ".$this->tableName." WHERE email = :email;";

                $parameters["email"] = $mail;

                $this->connection = Connection::GetInstance();

                $result=$this->connection->Execute($query,$parameters);

                if (isset($result[0])) {
                    $Dueno = new Dueno();
                    $Dueno->setId($result[0]["id_dueno"]);
                    $Dueno->setMail($result[0]["email"]);
                    $Dueno->setNombre($result[0]["nombre"]);
                    $Dueno->setApellido($result[0]["apellido"]);
                    $Dueno->setEdad($result[0]["edad"]);
                    $Dueno->setFotoPerfil($result[0]["foto_perfil"]);
                    $Dueno->setPassWord($result[0]["password"]);
                } else {
                    $Dueno = null;
                }
                
                return $Dueno;
            }catch(Exception $ex){
                return $ex;
            }
        }
    }
?>