<!DOCTYPE html>
<?php 
    require_once('phpFunc/conexion.php');
    require_once('phpFunc/verif.php');
    session_start();

// + Verificar sesión iniciada    
    if(!isset($_SESSION['username']) || !isset($_SESSION['login'])){
        header('Location: index.html');
        exit();
    }
    $nom = $_SESSION['username'];

// + Verificar id enviado
    if(!isset($_GET['id'])){
        echo "<script>alert('Error al cargar datos del proyecto.');
        window.location.href = 'menuPrin.php';</script>";
        exit();
    }
    $proyecto = $_GET['id'];
    $_SESSION['latestProyect'] = $proyecto;

// + Cargar datos del proyecto (Titulo y Descripción)
    $resP = encontrarProyecto($proyecto, $conect);

    if(!$resP){
        echo "<script>alert('No se encontró el proyecto.');
            window.location.href = 'menuPrin.php';</script>";
        exit();
    }
    $tit = $resP['titulo'];
    $des = $resP['descripcion'];

// + Verificar si el proyecto pertenece al usuario
//TEMPORALLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLLL
    $uId = $_SESSION['id'];
    $resV = verificarAdminProyecto($conect, $uId, $proyecto);
    if(!$resV){
        echo "<script>alert('No tienes permiso para editar este proyecto.');
        window.location.href = 'menuPrin.php';</script>";
    }

// + Cargar tareas del proyecto

// + Cargar colores del proyecto
    $col = $_SESSION['color'];
?>
<html lang="es" class="<?php echo $col; ?>">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/general.css">
        <link rel="stylesheet" href="css/design.css">
        <link rel="stylesheet" href="css/colors.css">
        <link rel="icon" type="image/png" sizes="32x32" href="images/grape.png">
        <title>Maquetación</title>
    </head>
    <section class="patUp">
        <script src="jscript/buttonColors.js" defer></script>
        <body class="bodyPrin">
            <main id="mainPrin">
                <section class="mainCont">
                    <aside class="mainAsid">

                        <div id="asidCont">
                            <section class="logoCuen">
                                <a href="optsUsuario.php">
                                    <p class="logText"><?php echo $nom; ?></p>
                                    <img src="images/grape.png" alt="Cuenta">
                                </a>     
                            </section>
                            <div class="lin">
                              <hr>   
                            </div>
                            <section class="logoCuen">
                                <a href="menuPrin.php">
                                    <p class="logText">Ir al menu</p>
                                    <img src="images/grape.png" alt="Cuenta"> 
                                </a>
                            </section>
                            <div class="lin">
                              <hr>   
                            </div>
                            <section class="logoCuen">
                                <a href="listProyect.php">
                                    <p class="logText">Mis proyectos</p>
                                    <img src="images/grape.png" alt="Cuenta"> 
                                </a>
                            </section>
                            <div class="lin">
                              <hr>   
                            </div>
                            <section class="logoCuen">
                                <a href="editProyect.php?id=<?php echo $proyecto; ?>">
                                    <p class="logText">Editar proyecto</p>
                                    <img src="images/grape.png" alt="Cuenta"> 
                                </a>
                            </section>
                            <div class="lin">
                              <hr>   
                            </div>
                            <section class="logoCuen">
                                <a href="index.html">
                                    <p class="logText">Guardar cambios</p>
                                    <img src="images/grape.png" alt="Cuenta"> 
                                </a>
                            </section>
                            <div class="lin">
                              <hr>   
                            </div>
                        </div>


                    </aside>
                    <section id="mainHH">
                        <header id="mainHead">
                            <div id="headTitl">
                                <h4><?php echo htmlspecialchars($tit, ENT_QUOTES, 'UTF-8'); ?></h4>
                            </div>
                            <div id="headDesc">
                                <textarea disabled name="" id="desc"><?php echo htmlspecialchars($des, ENT_QUOTES, 'UTF-8'); ?></textarea>
                            </div>
                        </header>
                        <section class="mainHom">
                            <div class="cont">
                                <div id="item1" class="homework">
                                    <div class="homCont">
                                        <div class="homFch">
                                            <input type="date">
                                        </div>
                                        <div class="homTitle">
                                            <h5>Titulo</h5>
                                        </div>
                                        <div class="homLines">
                                            <hr class="homHr">
                                        </div>

                                        <div class="homPoints">

                                            <div class="homChb">
                                                <input class="chBox" id="t1" type="checkbox"> 
                                            </div>
                                            <div class="homSp">
                                                <label class="noSelect" for="t1">
                                                    <span class="homTxt">Punto1</span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="homLines2">
                                            <hr class="homHr">
                                        </div>

                                        <div class="homPoints">

                                            <div class="homChb">
                                                <input class="chBox" id="t2" type="checkbox"> 
                                            </div>
                                            <div class="homSp">
                                                <label class="noSelect" for="t2">
                                                    <span class="homTxt">Punto2</span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="homLines2">
                                            <hr class="homHr">
                                        </div>

                                        <div class="homPoints">

                                            <div class="homChb">
                                                <input class="chBox" id="t3" type="checkbox"> 
                                            </div>
                                            <div class="homSp">
                                                <label class="noSelect" for="t3">
                                                    <span class="homTxt">Punto3</span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="homLines2">
                                            <hr class="homHr">
                                        </div>

                                        <div class="homPoints">

                                            <div class="homChb">
                                                <input class="chBox" id="t4" type="checkbox"> 
                                            </div>
                                            <div class="homSp">
                                                <label class="noSelect" for="t4">
                                                    <span class="homTxt">Punto4</span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="homLines2">
                                            <hr class="homHr">
                                        </div>

                                        <div class="homLines">
                                            <hr class="homHr">
                                        </div>
                                        <div class="homImg">
                                            <div class="imgH">Imagen</div>
                                        </div>
                                    </div>
                                    
                                </div>
                                
                                <div id="item1" class="homework">
                                    <div class="homCont">
                                    <a href="crearTarea.php">Crear tarea + </a>
                                    </div>
                                </div>
                            </div>
                            
                                
                                
                            
                        </section> 
                    </section>
                </section>
            </main>
            
        </body>
    </section>
</html>    