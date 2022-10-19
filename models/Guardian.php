<?php
    namespace Models;

    class Guardian extends Usuario {

        private $remuneracion;
        private $tamano;
        private $disponibilidad;
        private $comentarios;

        public function getRemuneracion()
        {
                return $this->remuneracion;
        }

     
        public function setRemuneracion($remuneracion): self
        {
                $this->remuneracion = $remuneracion;

                return $this;
        }

       
        public function getTamano()
        {
                return $this->tamano;
        }

       
        public function setTamano($tamano): self
        {
                $this->tamano = $tamano;

                return $this;
        }

       
        public function getDisponibilidad()
        {
                return $this->disponibilidad;
        }

        
        public function setDisponibilidad($disponibilidad): self
        {
                $this->disponibilidad = $disponibilidad;

                return $this;
        }

        
        public function getComentarios()
        {
                return $this->comentarios;
        }

       
        public function setComentarios($comentarios): self
        {
                $this->comentarios = $comentarios;

                return $this;
        }

        public function getType(){
                return "g";
        }
    }


?>