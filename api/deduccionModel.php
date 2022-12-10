<?php
class deduccionModel{
    public $conexion;
    public function __construct(){
       $this->conexion = new mysqli('localhost','root','','api');
        mysqli_set_charset($this->conexion,'utf8');
    }

    public function getDeduccion($id_deducciones=null){
        $where = ($id_deducciones == null) ? "" : " WHERE id_deducciones='$id_deducciones'";
        $deducciones=[];
        $sql="SELECT * FROM deducciones ".$where;
        $registros = mysqli_query($this->conexion,$sql);
        while ($row = mysqli_fetch_assoc($registros)){
            array_push($deducciones,$row);
        }
        return $deducciones;
        }

        public function saveDeduccion($nombre,$D_salario,$estado){
            $valida = $this->validateIDeduccion($nombre,$D_salario,$estado);
            $resultado=['Error','ya existe una Deduccion con las mismas caracteristicas'];
            if (count($valida)==0) {
                $sql="INSERT INTO deducciones (nombre,D_salario,estado) VALUES ('$nombre','$D_salario','$estado')";
                mysqli_query($this->conexion,$sql);
                $resultado=['success','deduccion guardada'];
            }
            return $resultado;
        }

        public function updateDeduccion($id_deducciones,$nombre,$D_salario,$estado){
            $existe= $this->getDeduccion($id_deducciones);
            $resultado=['Error','No existe el Deduccion con ID '.$id_deducciones];
            if (count($existe)>0) {
                $valida = $this->validateIDeduccion($nombre,$D_salario,$estado);
                $resultado=['Error','ya existe un Deduccion con las mismas caracteristicas'];
                if (count($valida)==0){
                    $sql="UPDATE deducciones SET nombre='$nombre',D_salario='$D_salario',estado='$estado' WHERE id_deducciones='$id_deducciones'";
                    mysqli_query($this->conexion,$sql);
                    $resultado=['success','deducciones actualizada'];
                }
            }           
            return $resultado;
        }
        public function deleteDeduccion($id_deducciones){
            $valida = $this->getDeduccion($id_deducciones);
            $resultado=['Error','No existe el ingreso con ID '.$id_deducciones];
            if (count($valida)>0) {
                $sql="DELETE FROM deducciones WHERE id_deducciones='$id_deducciones'";
                mysqli_query($this->conexion,$sql);
                $resultado=['success','deducciones eliminadas'];
            }
            return $resultado;
        }   
        public function validateIDeduccion($nombre,$D_salario,$estado){
            $deducciones=[];
            $sql="SELECT * FROM deducciones WHERE  nombre='$nombre' AND D_salario='$D_salario'AND estado='$estado' ";
            $registros = mysqli_query($this->conexion,$sql);
            while ($row = mysqli_fetch_assoc($registros)){
                array_push($deducciones,$row);
            }
            return $deducciones;
            }
    }



