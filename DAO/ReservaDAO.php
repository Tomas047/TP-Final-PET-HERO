<?php
    namespace DAO;

    use DAO\IReservaDAO as IReservaDAO;
    use Models\Reserva as Reserva;
    use DAO\Connection as Connection;
    use \Exception as Exception;

    class ReservaDAO implements IReservaDAO
    {
        private $ReservaList = array();
        private $tableName = "reserva";

        public function Add(Reserva $Reserva)
        {
            try {
                $query = "INSERT INTO ".$this->tableName." (id_dueno, id_guardian, id_mascota, fecha_inicio, fecha_final, estado) VALUES (:id_dueno, :id_guardian, :id_mascota, :fecha_inicio, :fecha_final, :estado);";
                
                
                $parameters["id_dueno"] = $_SESSION["id"];
                $parameters["id_guardian"] = $Reserva->getIdGuardian();
                $parameters["id_mascota"] = $Reserva->getIdMascota();
                $parameters["fecha_inicio"] = $Reserva->getFechaInicio();
                $parameters["fecha_final"] = $Reserva->getFechaFinal();
                $parameters["estado"] = "Pendiente";

                var_dump($Reserva->getFechaInicio());

                $this->connection = Connection::GetInstance();

                $this->connection->ExecuteNonQuery($query, $parameters);

            } catch (Excepcion $ex){
                throw $ex;
            }
               
        }

        public function Remove($id)
        {            
            try {
                $query = "delete from ".$this->tableName." WHERE ID_RESERVA = :id_reserva;";

                $parameters["id_reserva"] = $id;

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
                $this->ReservaList = array();
                
                $query = "SELECT * FROM ".$this->tableName;

                $this->connection = Connection::GetInstance();
                $resultSet = $this->connection->Execute($query);

                foreach ($resultSet as $row){
                    $Reserva = new Reserva();
                    $Reserva->setId($row["id_reserva"]);
                    $Reserva->setIdDueno($row["id_dueno"]);
                    $Reserva->setIdGuardian($row["id_guardian"]);
                    $Reserva->setFechaInicio($row["fecha_inicio"]);
                    $Reserva->setFechaFinal($row["fecha_final"]);
                    $Reserva->setEstado($row["estado"]);

                    array_push($this->ReservaList, $Reserva);
                }

                return $this->ReservaList;
            }catch(Exception $ex){
                return $ex;
            }
        }

        public function GetById($id){
            try{
                $query = "SELECT * FROM ".$this->tableName." WHERE ID_RESERVA = :id_reserva;";

                $parameters["id_reserva"] = $id;

                $this->connection = Connection::GetInstance();

                $result=$this->connection->Execute($query,$parameters);

                //var_dump($result);
                $Reserva = new Reserva();
                $Reserva->setId($row[0]["id_reserva"]);
                $Reserva->setIdDueno($row[0]["id_dueno"]);
                $Reserva->setIdGuardian($row[0]["id_guardian"]);
                $Reserva->setFechaInicio($row[0]["fecha_inicio"]);
                $Reserva->setFechaFinal($row[0]["fecha_final"]);
                $Reserva->setEstado($row[0]["estado"]);

                return $Reserva;
            }catch(Exception $ex){
                return $ex;
            }
        }

        public function GetByIdGuardian($id){
           
            try{
                $this->ReservaList = array();
                
                $query = "SELECT * FROM ".$this->tableName." WHERE ID_GUARDIAN = :id_guardian;";

                $parameters["id_guardian"] = $id;

                $this->connection = Connection::GetInstance();
                $resultSet = $this->connection->Execute($query,$parameters);

                foreach ($resultSet as $row){
                    $Reserva = new Reserva();
                    $Reserva->setId($row["id_reserva"]);
                    $Reserva->setIdDueno($row["id_dueno"]);
                    $Reserva->setIdGuardian($row["id_guardian"]);
                    $Reserva->setIdMascota($row["id_mascota"]);
                    $Reserva->setFechaInicio($row["fecha_inicio"]);
                    $Reserva->setFechaFinal($row["fecha_final"]);
                    $Reserva->setEstado($row["estado"]);

                    array_push($this->ReservaList, $Reserva);
                }

                return $this->ReservaList;
            }catch(Exception $ex){
                return $ex;
            }
        }

        public function updateEstado ($idReserva,$estado){

            try {

                $query = "UPDATE ".$this->tableName." SET estado=:estado WHERE id_reserva=:id_reserva ;";
                
                $parameters["estado"] = $estado;
                $parameters["id_reserva"] = $idReserva;
               
                
                $this->connection = Connection::GetInstance();

                $this->connection->ExecuteNonQuery($query, $parameters);

            } catch (Excepcion $ex){
                throw $ex;
            }


        }

        public function getDatosReserva($idGuardian){

            try{
                $this->DatosReservaList = array();
                
                $query = "select m.nombre as nombre_mascota, m.raza, m.edad, m.foto_perfil, d.nombre, r.id_reserva, r.estado, r.fecha_inicio, r.fecha_final from dueno d inner join reserva r on d.id_dueno=r.id_dueno inner join mascota m on r.id_mascota=m.id_mascota where r.id_guardian=:id_guardian;";

                $parameters["id_guardian"] = $idGuardian;

                $this->connection = Connection::GetInstance();
                $resultSet = $this->connection->Execute($query,$parameters);
                //var_dump($resultSet);
                $DatosReserva = array();

                foreach ($resultSet as $row){
                    
                    $DatosReserva["m.nombre"] = $row["nombre_mascota"];
                    $DatosReserva["m.raza"] = $row["raza"];
                    $DatosReserva["m.edad"] = $row["edad"];
                    $DatosReserva["m.foto_perfil"] = $row["foto_perfil"];
                    $DatosReserva["d.nombre"] = $row["nombre"];
                    $DatosReserva["r.id_reserva"] = $row["id_reserva"];
                    $DatosReserva["r.estado"] = $row["estado"];
                    $DatosReserva["r.fecha_inicio"] = $row["fecha_inicio"];
                    $DatosReserva["r.fecha_final"] = $row["fecha_final"];
                    array_push($this->DatosReservaList, $DatosReserva);
                }

                return $this->DatosReservaList;
            }catch(Exception $ex){
                return $ex;
            }

        }
    }


?>