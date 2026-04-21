<?php 
// + actualizarProyecto
    function actualizarProyecto($conect, $tit, $des, $pro){
        if(empty($pro) || !is_numeric($pro)){
            echo "<script>alert('ERROR actualizarProyecto()');</script>";
            return false;
        }
        if (empty($tit)){
            echo "<script>alert('Complete el campo de título para aplicar los cambios.');</script>";
            return false;
        }
        $sen = "UPDATE proyects SET titulo = '$tit', descripcion = '$des' WHERE id = $pro";
        $res = mysqli_query($conect, $sen);

        if (!$res) {
            echo "<script>alert('Error al guardar los cambios.');</script>";
            return false;
        }

        return true;
    }

// + actualizarColor
    function actualizarColor($conect, $col, $uId){
        $ver = "UPDATE users SET color = '$col' WHERE id = $uId";
        $resul = mysqli_query($conect, $ver);

        if ($resul) {
            return true;
        }else{
            return false;
        }
    }
?>