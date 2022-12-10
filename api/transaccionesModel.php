<?php
class transaccionesModel{
    public $conexion;
    public function __construct(){
       $this->conexion = new mysqli('localhost','root','','api');
        mysqli_set_charset($this->conexion,'utf8');
    }

    public function getTrasaccion($id_transaccion=null){
        $where = ($id_transaccion == null) ? "" : " WHERE id_transaccion='$id_transaccion'";
        $transacciones=[];
        $sql="SELECT * FROM transacciones ".$where;
        $registros = mysqli_query($this->conexion,$sql);
        while ($row = mysqli_fetch_assoc($registros)){
            array_push($transacciones,$row);
        }
        return $transacciones;
        }

        public function savetransacciones($id_empleado,$id_deducciones,$id_ingreso,$tipo_transaccion,$fecha,$monto,$estado,$id_asiento){
            $valida = $this->validatetransacciones($id_empleado,$id_deducciones,$id_ingreso,$tipo_transaccion,$fecha,$monto,$estado,$id_asiento);
            $resultado=['Error','ya existe una transaccion con las mismas caracteristicas'];
            if (count($valida)==0) {
                $sql="INSERT INTO transacciones(id_empleado,id_deducciones,id_ingreso,tipo_transaccion,fecha,monto,estado) VALUES ('$id_empleado','$id_deducciones','$id_ingreso','$tipo_transaccion','$fecha','$monto','$estado')";
                mysqli_query($this->conexion,$sql);
                $resultado=['success','transaccion guardada'];
            }
            return $resultado;
        }

        public function updatetransacciones($id_transaccion,$id_empleado,$id_deducciones,$id_ingreso,$tipo_transaccion,$fecha,$monto,$estado,$id_asiento){
            $existe= $this->getTrasaccion($id_transaccion);
            $resultado=['Error','No existe la transaccion con ID '.$id_transaccion];
            if (count($existe)>0) {
                $valida = $this->validatetransacciones($id_empleado,$id_deducciones,$id_ingreso,$tipo_transaccion,$fecha,$monto,$estado,$id_asiento);
                $resultado=['Error','ya existe una transaccion con las mismas caracteristicas'];
                if (count($valida)==0){
                    $sql="UPDATE transacciones SET id_empleado= '$id_empleado',id_deducciones='$id_deducciones',id_ingreso='$id_ingreso',tipo_transaccion='$tipo_transaccion',fecha='$fecha',monto='$monto',estado='$estado'WHERE id_transaccion='$id_transaccion'";
                    mysqli_query($this->conexion,$sql);
                    $resultado=['success','transacion actualizada'];
                }
            }           
            return $resultado;
        }
        public function deletetransacciones($id_transaccion){
            $valida = $this->getTrasaccion($id_transaccion);
            $resultado=['Error','No existe la transaccion con ID '.$id_transaccion];
            if (count($valida)>0) {
                $sql="DELETE FROM transacciones WHERE id_transaccion='$id_transaccion'";
                mysqli_query($this->conexion,$sql);
                $resultado=['success','transaccion eliminada'];
            }
            return $resultado;
        }   

        
        public function validatetransacciones($id_empleado,$id_deducciones,$id_ingreso,$tipo_transaccion,$fecha,$monto,$estado,$id_asiento){
            $transacciones=[];
            $sql="SELECT * FROM transacciones WHERE id_empleado= '$id_empleado'AND id_deducciones='$id_deducciones'AND id_ingreso='$id_ingreso' AND tipo_transaccion='$tipo_transaccion' AND fecha='$fecha' AND monto='$monto' AND estado='$estado' AND id_asiento='$id_asiento'";
            $registros = mysqli_query($this->conexion,$sql);
            while ($row = mysqli_fetch_assoc($registros)){
                array_push($transacciones,$row);
            }
            return $transacciones;
            }
    }



