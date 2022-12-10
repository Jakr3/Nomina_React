<?php
class empleadoModel{
    public $conexion;
    public function __construct(){
       $this->conexion = new mysqli('localhost','root','','api');
        mysqli_set_charset($this->conexion,'utf8');
    }

    public function getEmpleados($id_empleado=null){
        $where = ($id_empleado == null) ? "" : " WHERE id_empleado='$id_empleado'";
        $empleados=[];
        $sql="SELECT * FROM empleados ".$where;
        $registros = mysqli_query($this->conexion,$sql);
        while ($row = mysqli_fetch_assoc($registros)){
            array_push($empleados,$row);
        }
        return $empleados;
        }

        public function saveEmpleados($cedula,$nombre,$salario,$id_nomina){
            $valida = $this->validateEmpleados($cedula,$nombre,$salario,$id_nomina);
            $resultado=['Error','ya existe un empleado con las mismas caracteristicas'];
            if (count($valida)==0) {
                $sql="INSERT INTO empleados(cedula,nombre,salario,id_nomina) VALUES ('$cedula','$nombre','$salario','$id_nomina')";
                mysqli_query($this->conexion,$sql);
                $resultado=['success','empleado guardado'];
            }
            return $resultado;
        }

        public function updateEmpleado($id_empleado,$cedula,$nombre,$salario,$id_nomina){
            $existe= $this->getEmpleados($id_empleado);
            $resultado=['Error','No existe el empleado con ID '.$id_empleado];
            if (count($existe)>0) {
                $valida = $this->validateEmpleados($cedula,$nombre,$salario,$id_nomina);
                $resultado=['Error','ya existe un empleado con las mismas caracteristicas'];
                if (count($valida)==0){
                    $sql="UPDATE empleados SET cedula='$cedula',nombre='$nombre',salario='$salario',id_nomina='$id_nomina' WHERE id_empleado='$id_empleado'";
                    mysqli_query($this->conexion,$sql);
                    $resultado=['success','empleado actualizado'];
                }
            }           
            return $resultado;
        }
        public function deleteEmpleado($id_empleado){
            $valida = $this->getEmpleados($id_empleado);
            $resultado=['Error','No existe el empleado con ID '.$id_empleado];
            if (count($valida)>0) {
                $sql="DELETE FROM empleados WHERE id_empleado='$id_empleado'";
                mysqli_query($this->conexion,$sql);
                $resultado=['success','empleado eliminado'];
            }
            return $resultado;
        }   
        public function validateEmpleados($cedula,$nombre,$salario,$id_nomina){
            $empleados=[];
            $sql="SELECT * FROM empleados WHERE cedula='$cedula' AND nombre='$nombre' AND salario='$salario'AND id_nomina='$id_nomina' ";
            $registros = mysqli_query($this->conexion,$sql);
            while ($row = mysqli_fetch_assoc($registros)){
                array_push($empleados,$row);
            }
            return $empleados;
            }
    }



