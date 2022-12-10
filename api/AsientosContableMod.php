<?php
class AsientosContableMod{
    public $conexion;
    public function __construct(){
       $this->conexion = new mysqli('localhost','root','','api');
        mysqli_set_charset($this->conexion,'utf8');
    }

    public function getAsientos($id_asiento=null){
        $where = ($id_asiento == null) ? "" : " WHERE id_asiento='$id_asiento'";
        $Asientos_contables=[];
        $sql="SELECT * FROM asientos_contables ".$where;
        $registros = mysqli_query($this->conexion,$sql);
        while ($row = mysqli_fetch_assoc($registros)){
            array_push($Asientos_contables,$row);
        }
        return $Asientos_contables;
        }

        public function saveAsiento($descripcion,$id_empleado,$cuenta,$tipo_movimiento,$monto){
            $valida = $this->validaAsientos($descripcion,$id_empleado,$cuenta,$tipo_movimiento,$monto);
            $resultado=['Error','ya existe un empleado con las mismas caracteristicas'];
            if (count($valida)==0) {
                $sql="INSERT INTO asientos_contables(descripcion,id_empleado,cuenta,tipo_movimiento,fecha,monto,estado) VALUES ('$descripcion','$id_empleado','$cuenta','$tipo_movimiento','$fecha','$monto','$estado')";
                mysqli_query($this->conexion,$sql);
                $resultado=['success','Asiento guardada'];
            }
            return $resultado;
        }

        public function updateAsiento($id_asiento,$descripcion,$id_empleado,$cuenta,$tipo_movimiento,$fecha,$monto,$estado){
            $existe= $this->getAsientos($id_asiento);
            $resultado=['Error','No existe el empleado con ID '.$id_asiento];
            if (count($existe)>0) {
                $valida = $this->validaAsientos($descripcion,$id_empleado,$cuenta,$tipo_movimiento,$fecha,$monto,$estado);
                $resultado=['Error','ya existe un empleado con las mismas caracteristicas'];
                if (count($valida)==0){
                    $sql="UPDATE asientos_contables SET descripcion='$descripcion',id_empleado='$id_empleado',cuenta='$cuenta',tipo_movimiento='$tipo_movimiento',fecha='$fecha',monto='$monto',estado='$estado' WHERE id_asiento='$id_asiento'";
                    mysqli_query($this->conexion,$sql);
                    $resultado=['success','Asientos actualizados'];
                }
            }           
            return $resultado;
        }
        public function deleteAsiento($id_asiento){
            $valida = $this->getAsientos($id_asiento);
            $resultado=['Error','No existe el empleado con ID '.$id_asiento];
            if (count($valida)>0) {
                $sql="DELETE FROM asientos_contables WHERE id_asiento='$id_asiento'";
                mysqli_query($this->conexion,$sql);
                $resultado=['success','empleado eliminado'];
            }
            return $resultado;
        }   
        public function validaAsientos($descripcion,$id_empleado,$cuenta,$tipo_movimiento,$monto){
            $Asientos_contables=[];
            $sql="SELECT * FROM asientos_contables WHERE descripcion= '$descripcion'AND id_empleado='$id_empleado'AND cuenta='$cuenta' AND tipo_movimiento='$tipo_movimiento'AND monto='$monto'";
            $registros = mysqli_query($this->conexion,$sql);
            while ($row = mysqli_fetch_assoc($registros)){
                array_push($Asientos_contables,$row);
            }
            return $Asientos_contables;
            }
    }


    