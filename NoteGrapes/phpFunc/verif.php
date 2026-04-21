<?php 

// + verificarDatos

    function verificarDatos($nom, $eml, $pas, $ps2, $conect){
    // Campos vacíos
        if(empty($nom) || empty($pas) || empty($eml) || empty($ps2)){
            echo "<script>alert('Los apartados estan vacios, porfavor de llenar el formulario');</script>";
            return false;
        }
    // Contraseñas no coinciden
        if($pas != $ps2){
            echo "<script>alert('Las contraseñas no coinciden');</script>";
            return false;
        }
    // Evitar usuarios duplicados
        $ver = "SELECT * FROM users WHERE nombre = '$nom' OR email = '$eml'";
        $resul = mysqli_query($conect, $ver);

        if (mysqli_num_rows($resul) > 0) {
            echo "<script>alert('Datos de su formulario ya son usados, favor de cambiar el nombre y/o correo colocados');</script>";
            return false;
        }
        //echo "2- esto se hizo en verif.php <br>";
        return true;
    }
    
// + verificarCodigo

    function verificarCodigo($eml, $cod, $conect){
    // Buscar el codigo del correo
        $ver = "SELECT * FROM tempusers WHERE correo = '$eml' ORDER BY tiempo_creado DESC LIMIT 1";
        $resul = mysqli_query($conect, $ver);
    // Comprobacion
        if (mysqli_num_rows($resul) > 0) {
            $filas = mysqli_fetch_assoc($resul);
            
        // Verificar vencimiento
            if(time() > $filas['vencimiento']){
                echo "<script>alert('El código de verificación ha expirado, vuelva a colocar sus datos de nuevo');</script>";
                return false;
            }
        //Verificar Código
            if(!password_verify($cod, $filas['codigo'])){
                echo "<script>alert('El código de verificación es incorrecto, vuelva a colocar sus datos de nuevo');</script>";
                return false;
            }else{
                echo "<script>alert('Código de verificación correcto');</script>";
                return true;
            }
        }else{
            echo "<script>alert('El correo no tiene codigo de verificacion, coloque los datos de la cuenta');</script>";
            return false;
        }
    }

// + encontrarDatos

    function encontrarDatos($nom, $col1, $col2, $conect){
    //Error del llamado a la funcion
        if(empty($nom)){
            echo '<script>alert("verif.php linea 56 ERROR:El campo de valor a buscar está vacío (nom), por favor ingrese un valor");</script>';
            return false;
        }
        if(empty($col1)){
            echo '<script>alert("verif.php linea 60 ERROR:El campo de columna a buscar está vacío (col1), por favor ingrese un valor");</script>';
            return false;
        }
    //Busqueda de datos (un solo campo)
        if(empty($col2)){
            $ver   = "SELECT * FROM users WHERE $col1 = '$nom'";
            $resul = mysqli_query($conect, $ver);
    
    //Busqueda de datos (dos campos)        
        }else{
            $ver   = "SELECT * FROM users WHERE $col1 = '$nom' OR $col2 = '$nom'";
            $resul = mysqli_query($conect, $ver);
            
        }
        $fila = mysqli_fetch_assoc($resul);

        if ($fila) {
            if($fila[$col1] == $nom){
                return $fila[$col1];
            }else{
                return $fila[$col1];
            }
        } else {
            return false;
        }  
    }
    function verificarContrasena($nom, $pas, $conect){
    //Error del llamado a la funcion
        if(empty($nom)){
            echo '<script>alert("verif.php linea 94 ERROR:El campo de valor a buscar está vacío (nom), por favor ingrese un valor");</script>';
            return false;
        }
        if(empty($pas)){
            echo '<script>alert("verif.php linea 98 ERROR:El campo de valor a buscar está vacío (pas), por favor ingrese un valor");</script>';
            return false;
        }
        if (str_contains($nom, '@')) {
            $ver = "SELECT * FROM users WHERE email = '$nom'";
        }else{
            $ver = "SELECT * FROM users WHERE nombre = '$nom'";
        }
    //Busqueda del usuario
        
        $resul = mysqli_query($conect, $ver);
        $fila = mysqli_fetch_assoc($resul);

        if ($fila) {
            if(password_verify($pas, $fila['contrasena'])){
                return true;
            }else{
                return false;
            }
        } else {
            return false;
        }  
    }

// + encontrarProyecto
    function encontrarProyecto($id, $conect){
        $ver    = "SELECT * FROM proyects WHERE id = $id";
        $result = mysqli_query($conect, $ver);
        $fila    = mysqli_fetch_assoc($result);
        if ($fila) {
            $oldTit = $fila['titulo'];
            $oldDes = $fila['descripcion'];
            return $fila;
        } else {
            return false;
        }
    }
// + EncontrarProyectoReciente
    function encontrarProyectoReciente($conect, $uId, $sel){
        //EDITAR AL CREAR LOS PERMISOSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSSS
        $ver = "SELECT $sel FROM proyects WHERE id_admin = $uId";
        $resul = mysqli_query($conect, $ver);
        $fila = mysqli_fetch_assoc($resul);
        if ($fila) {
            return $fila[$sel];
        } else {
            return false;
        }
    }
// + VerificarAdminProyecto
    function verificarAdminProyecto($conect, $uId, $pId){
        $ver = "SELECT id FROM proyects WHERE id = $pId AND id_admin = $uId";
        $resul = mysqli_query($conect, $ver);
        $fila = mysqli_fetch_assoc($resul);
        if ($fila) {
            return true;
        } else {
            return false;
        }
    }
// + obtenerValoresdelUsuario   
    function obtenerValoresdelUsuario($conect, $nom, $var){

        if (str_contains($nom, '@')) {
            $ver    = "SELECT $var FROM users WHERE email = '$nom'";
        } else{
            $ver    = "SELECT $var FROM users WHERE nombre = '$nom'";
        }
        
        $result = mysqli_query($conect, $ver);
        $fila    = mysqli_fetch_assoc($result);
        if ($fila) {
            return $fila[$var];
        } else {
            return false;
        }
    }

// + obtenerColor
    function obtenerColor($conect, $uId){
        $ver    = "SELECT color FROM users WHERE id = $uId";
        $result = mysqli_query($conect, $ver);
        $fila    = mysqli_fetch_assoc($result);
        if ($fila) {
            return $fila['color'];
        } else {
            return false;
        }
    }

// + obtenerProyectosUsuario
    function obtenerProyectosUsuario($conect, $uId, $col, $ord){
        if(empty($uId) || empty($col) || empty($ord)){
            return false;
        }
    
        $ver    = "SELECT * FROM proyects WHERE id_admin = $uId ORDER BY $col $ord";
        $result = mysqli_query($conect, $ver);
        
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }
?>