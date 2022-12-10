<?php
class ingresosModel{
    public $conexion;
    public function __construct(){
       $this->conexion = new mysqli('localhost','root','','api');
        mysqli_set_charset($this->conexion,'utf8');
    }

    public function getIngresos($id_ingreso=null){
        $where = ($id_ingreso == null) ? "" : " WHERE id_ingreso='$id_ingreso'";
        $ingresos=[];
        $sql="SELECT * FROM ingresos ".$where;
        $registros = mysqli_query($this->conexion,$sql);
        while ($row = mysqli_fetch_assoc($registros)){
            array_push($ingresos,$row);
        }
        return $ingresos;
        }

        public function saveIngresos($nombre,$D_salario,$estado){
            $valida = $this->validateIngresos($nombre,$D_salario,$estado);
            $resultado=['Error','ya existe un ingreso con las mismas caracteristicas'];
            if (count($valida)==0) {
                $sql="INSERT INTO ingresos(nombre,D_salario,estado) VALUES ('$nombre','$D_salario','$estado')";
                mysqli_query($this->conexion,$sql);
                $resultado=['success','ingreso guardado'];
            }
            return $resultado;
        }

        public function updateIngreso($id_ingreso,$nombre,$D_salario,$estado){
            $existe= $this->getIngresos($id_ingreso);
            $resultado=['Error','No existe el ingreso con ID '.$id_ingreso];
            if (count($existe)>0) {
                $valida = $this->validateIngresos($nombre,$D_salario,$estado);
                $resultado=['Error','ya existe un ingreso con las mismas caracteristicas'];
                if (count($valida)==0){
                    $sql="UPDATE ingresos SET nombre='$nombre',D_salario='$D_salario',estado='$estado' WHERE id_ingreso='$id_ingreso'";
                    mysqli_query($this->conexion,$sql);
                    $resultado=['success','ingreso actualizado'];
                }
            }           
            return $resultado;
        }
        public function deleteIngreso($id_ingreso){
            $valida = $this->getIngresos($id_ingreso);
            $resultado=['Error','No existe el ingreso con ID '.$id_ingreso];
            if (count($valida)>0) {
                $sql="DELETE FROM ingresos WHERE id_ingreso='$id_ingreso'";
                mysqli_query($this->conexion,$sql);
                $resultado=['success','ingreso eliminado'];
            }
            return $resultado;
        }   
        public function validateIngresos($nombre,$D_salario,$estado){
            $ingresos=[];
            $sql="SELECT * FROM ingresos WHERE  nombre='$nombre' AND D_salario='$D_salario' AND estado='$estado' ";
            $registros = mysqli_query($this->conexion,$sql);
            while ($row = mysqli_fetch_assoc($registros)){
                array_push($ingresos,$row);
            }
            return $ingresos;
            }
    }



