<?php
session_start();
require_once '../modelo/utilidades/Session.php';
$pagActual = 'listarUsuariosInactivos';
$session = new Session($pagActual);
$session->Session($pagActual);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Usuarios Inactivos</title>
        <meta charset="utf-8">
        <link rel="shortcut icon" href="../img/favicon.ico" type="image/x-icon">
        <link rel="stylesheet" type="text/css" href="../css/reset.css">
        <link rel="stylesheet" type="text/css" href="../css/main_responsive.css">
        <link rel="stylesheet" type="text/css" href="../css/stylesNavTop.css">
        <link rel="stylesheet" href="../css/font-awesome.min.css">
        <script type="text/javascript" src="../js/script.js"></script>
        <script type="text/javascript" src="../js/script2.js"></script>
        <script type="text/javascript" src="../js/jquery.js"></script>
        <script type="text/javascript" src="../js/carouFredSel.js"></script>
        <script type="text/javascript" src="../js/main.js"></script>
        <link rel="stylesheet" href="../js/jquery.dataTables.css">
        <script type="text/javascript" src="../js/jquery-2.1.1.min.js"></script>
        <script type="text/javascript" src="../js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="../js/table.js"></script>
        <link rel="stylesheet" type="text/css" href="../fonts/fonts.css">
        <link href="../js/toastr.css" rel="stylesheet"/>
        <script src="../js/toastr.js"></script>
        <script src="../js/validaciones.js"></script>
        <link rel="stylesheet" type="text/css" href="../css/component.css" />
    <script src="../js/modernizr.custom.js"></script>
    </head>
    <body oncontextmenu="return false" onkeydown="checkData(event)">
    <script>
 function checkData(e) {
      if(e.shiftKey) {
        return false;
      }
      if(e.ctrlKey) {
        return false;
      }
      if(e.altKey) {
        return false;
      }
    };
    </script>
     <div id='cssmenu'>
        <form id="frmPicture" name="frmChangePicture" action="../controlador/ControladorUsuarios.php" method="post" enctype="multipart/form-data">
          <input type="hidden" name="Change" value="1">  
          <input type="file" id="filein" class="file" name="cambiaImagen" onchange="submit();" style="display:none">  
      </form>
         <?php 
     require_once '../modelo/utilidades/browser.php';
        $browser = new browser();
        $navegador = $browser->getBrowser($_SERVER['HTTP_USER_AGENT']);
          if($navegador!='Google Chrome' && $navegador!='Safari'){
          ?>
           <script language="JavaScript" type="text/javascript">
                    window.onload = function () {
                        Command: toastr["error"]("<?php echo 'Esta utilizando '.$navegador.'<br> Para una correcta visualización utilice Google Chrome o Safai' ?>")

                        toastr.options = {
                            "closeButton": false,
                            "debug": false,
                            "newestOnTop": false,
                            "progressBar": false,
                            "positionClass": "toast-top-full-width",
                            "preventDuplicates": false,
                            "onclick": null,
                            "showDuration": "300",
                            "hideDuration": "1000",
                            "timeOut": "9000",
                            "extendedTimeOut": "1000",
                            "showEasing": "swing",
                            "hideEasing": "linear",
                            "showMethod": "fadeIn",
                            "hideMethod": "fadeOut"
                        }
                    }
            </script>
          <?php } ?>      
  
        <ul>

       <?php if ($_SESSION['rol'] == 'Administrador'){ ?>
          <li><a href="javascript:backup('backup')"><span><i class="fa fa-database fa-lg"></i> BackUp</span></a>
            <script language=javascript>
            function backup(URL) {
                window.open(URL, "backup", "width=1190,height=645,top=30,left=30,scrollbars=NO");
            }
           </script> 
           </li> 
      <?php } ?>

    <?php if ($_SESSION['rol'] == 'Gerente' || $_SESSION['rol'] == 'Administrador'){ ?>

          <li><a href="javascript:reporte('reportes')"><span><i class="fa fa-file-text fa-lg"></i> Reportes</span></a>
            <script language=javascript>
            function reporte(URL) {
                window.open(URL, "reportes", "width=1200,height=645,top=30,left=30,scrollbars=NO");
            }
           </script> 
           </li> 
      <?php } ?>
           <li class='active has-sub'><a id="priOpc"><span><i class="fa fa-cog fa-lg fa-spin"></i> Opciones</span></a>
              <ul>
                 <li><a href='modificarContrasena'><span><i class="fa fa-key fa-lg"></i> Cambiar Contraseña</span></a>       
                 </li>
                 <li><a id="loadImg" href="javascript:function()"><span><i class="fa fa-picture-o fa-lg"></i> Actualizar Foto</span></a>              
                 </li>
              </ul>
           </li>  
           <li><a href='../controlador/ControladorLogin.php?idCerrar=HastaLuego'><span><i class="fa fa-power-off fa-lg"></i> Cerrar Sesión</span></a></li>     
        </ul>
          <script type="text/javascript">
            //bind click
            $('#loadImg').click(function(event) {
              $('#filein').click();
            });
        </script>
    </div>    
       <header>
            <?php
            require_once '../modelo/dao/LoginDAO.php';
            require_once '../modelo/dao/PermisosDAO.php';
            require_once '../modelo/utilidades/Conexion.php';
            require_once '../facades/FacadeLogin.php';
            require_once '../facades/FacadePermisos.php';
            $facadePermmisos = new FacadePermisos;
            $menuGeneral = $facadePermmisos->menuGeneral($_SESSION['rol']);
            $proyecto = $facadePermmisos->permisoProyecto($_SESSION['rol']);
            $novedad = $facadePermmisos->permisoNovedad($_SESSION['rol']);
            $persona = $facadePermmisos->permisoPersonal($_SESSION['rol']);
            $audita = $facadePermmisos->permisoAuditoria($_SESSION['rol']);
            $clientes = $facadePermmisos->permisoCliente($_SESSION['rol']);
            $roles = $facadePermmisos->permisoRoles($_SESSION['rol']);
            ?>       
            <div class="wrapper">
            <?php if (isset($_GET['errorPermiso'])) { ?>
            <script language="JavaScript" type="text/javascript">
                window.onload = function () {
                    Command: toastr["error"]("<?php echo $_GET['errorPermiso']; ?>")

                    toastr.options = {
                        "closeButton": false,
                        "debug": false,
                        "newestOnTop": false,
                        "progressBar": false,
                        "positionClass": "toast-top-full-width",
                        "preventDuplicates": false,
                        "onclick": null,
                        "showDuration": "300",
                        "hideDuration": "1000",
                        "timeOut": "5000",
                        "extendedTimeOut": "1000",
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut"
                    }
                }
        <?php } ?>
        </script>
                <a href="listarProyectos"><img src="../img/logo.png" class="logo" id="lg" onLoad="nomeImagem()" width="190px" height="110px"></a>
                <a href="#" class="menu_icon" id="menu_icon"></a>
               <nav>
                            <?php
                            require_once '../modelo/utilidades/Menu.php';
                            $menu = new Menu;
                            $menu->permisosMenu();
                            ?>               
                </nav>
                <ul class="social">
                    <li><a class="fb" href="https://www.facebook.com/productivitymanager"></a></li>
                    <li><a class="twitter" href="https://twitter.com/Productivity_Mg"></a></li>
                    <li><a class="gplus" href="mailto:productivitymanagersoftware@gmail.com"></a></li>
                </ul>
                <div class="logoFoto">
                    <div><img src="../fotos/<?php echo $_SESSION['foto'];?>"></div>
                    <p style="text-align:right; font-size:12px; font-family: sans-serif; font-weight:bold; color: white"><br><br><br><br><br>
                        <?php
                        echo 'Bienvenido(a) ' . $_SESSION['nombre'];
                        ?>
                    </p>
                </div>
        </header>        
        <div class="wrapper">
          
            <nav class="migas"><br>
                <span itemscope >
                    <a href="listarProyectos" title="Ir a la página de inicio" itemprop="url"><span itemprop="title">Inicio</span></a>  > 
                    <span itemprop="child" itemscope>            
                        <strong>Lista General de Usuarios Inactivos</strong> 
                    </span> 
                </span>         
            </nav>
            <br><br>
            <h2 class="h330">Usuarios Inactivos:</h2>
            <?php
        if (isset($_GET['modificado'])) {
            echo '<script> 
                Command: toastr["success"]("'.$_GET['modificado'].'", "Enhorabuena")
            toastr.options = {
              "closeButton": false,
              "debug": false,
              "newestOnTop": false,
              "progressBar": false,
              "positionClass": "toast-top-right",
              "preventDuplicates": false,
              "onclick": null,
              "showDuration": "300",
              "hideDuration": "1000",
              "timeOut": "5000",
              "extendedTimeOut": "1000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
            }
            </script>';
        };
        ?>
            <br>  
            <table id="tabla" class="display" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Código<br></th>                
                        <th>Identificación</th>
                        <th>Nombre</th>
                        <th>Apellido</th> 
                        <th>E-Mail</th>                           
                        <th>Tipo de Rol</th>                
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tfoot>
                    <tr>
                        <th>Código</th>                
                        <th>Identificación</th>
                        <th>Nombre</th>
                        <th>Apellido</th>  
                        <th>E-Mail</th>                           
                        <th>Tipo de Rol</th>                
                        <th>Acciones</th>
                    </tr>
                </tfoot>

                <tbody>   
<!--                <script>
                 Command: toastr["warning"]("Desea Eliminar Este Usuario?<br /><br /><button type='button'style='display:inline' class='btn clear'>Si</button><button type='button' style='display:inline' class='btn clear'>No</button>")
                toastr.options = {
                  "closeButton": false,
                  "debug": false,
                  "newestOnTop": false,
                  "progressBar": false,
                  "positionClass": "toast-top-right",
                  "preventDuplicates": false,
                  "onclick": null,
                  "showDuration": "300",
                  "hideDuration": "1000",
                  "timeOut": "5000",
                  "extendedTimeOut": "1000",
                  "showEasing": "swing",
                  "hideEasing": "linear",
                  "showMethod": "fadeIn",
                  "hideMethod": "fadeOut"
                }  
                </script>-->
<script>
    function confirmacion() {
                        if (confirm('Seguro que desea activar este usuario')) {
                            return true;
                        } else {
                            return false;
                        }
                    }
                </script>
                <?php
                require_once '../modelo/dto/UsuarioDTO.php';
                require_once '../modelo/dao/UsuarioDAO.php';          
                require_once '../facades/FacadeUsuarios.php';   
                require_once '../modelo/utilidades/Conexion.php';
                $facadeUsuario = new FacadeUsuarios;                 
                $todos = $facadeUsuario->listarUsuariosInactivos();                    
                foreach ($todos as $user) {
                    ?>
                    <tr><td><?php echo $user['idUsuario']; ?> </td>
                        <td><?php echo $user['identificacion']; ?> </td>
                        <td> <?php echo $user['nombres']; ?> </td>
                        <td><?php echo $user['apellidos']; ?></td>                      
                        <td><?php echo $user['email']; ?></td>  
                        <td><?php echo $user['rol']; ?></td>
                        <td>      
                            <a class="me" title="Consultar Usuario" href="../controlador/ControladorUsuarios.php?idConsultarInactivo=<?php echo $user['idUsuario']; ?>"><img class="iconos" src="../img/verBino.png"></a>                
                            <a name="activar" title="Activar Usuario" class="me"  href="../controlador/ControladorUsuarios.php?idActivar=<?php echo $user['idUsuario']; ?>" onclick=" return confirmacion()"><img class="iconos" src="../img/darAltaUsuario.png"></a>                           
                    </tr>                         
                    <?php
                }
                if (isset($_GET['mensaje3'])) {
                    echo "<script>alert('" . $_GET['mensaje3'] . "')</script>";
                }
                ?>                      
                </tbody>
            </table>   
            <div id="verUsuario" class="modalDialog" title="Ver Usuario">
                <div><a href="#close" title="Cerrar" class="close">X</a><br>
                    <?php
                    echo '<table id="muestraDatos" style="width:400px;"><tr><th>Datos de Usuario</th><th><img class="fotoUsuario" src="../fotos/' . $_SESSION['datosUsuarioInactivo']['foto']  . '"></th></tr>';                    
                    echo '<tr><td>Cargo:</td><td>' . $_SESSION['datosUsuarioInactivo']['rol']  . '</td></tr>';
                    echo '<tr><td>Área/Sector:</td><td>' . $_SESSION['datosUsuarioInactivo']['nombreArea']  . '</td></tr>';
                    echo '<tr><td>Código:</td><td>' . $_SESSION['datosUsuarioInactivo']['idUsuario'] . '</td></tr>';
                    echo '<tr><td>Identificación:</td><td> ' . $_SESSION['datosUsuarioInactivo']['identificacion']  . '</td></tr>';
                    echo '<tr><td>Nombres:</td><td>' . $_SESSION['datosUsuarioInactivo']['nombres']  . '</td></tr>';
                    echo '<tr><td>Apellidos:</td><td>' . $_SESSION['datosUsuarioInactivo']['apellidos']  . '</td></tr>';
                    echo '<tr><td>Dirección:</td><td>' . $_SESSION['datosUsuarioInactivo']['direccion']  . '</td></tr>';
                    echo '<tr><td>Teléfono:</td><td>' . $_SESSION['datosUsuarioInactivo']['telefono']  . '</td></tr>';
                    echo '<tr><td>Fecha de Nacimiento:</td><td>' . $_SESSION['datosUsuarioInactivo']['fechaNacimiento']  . '</td></tr>';
                    echo '<tr><td>Correo Electronico:</td><td ><a id="mails" title="Enviar Correo a:" href="mailto:' . $_SESSION['datosUsuarioInactivo']['email']  . '">'. $_SESSION['datosUsuarioInactivo']['email']  .'</td></tr>';
                    echo '</table>';
                    ?>                                
                </div>                    
            </div>
        </div>
        <footer class="footer-distributed">
            <div class="footer-left">
                            <span><img src="../img/logoEscala.png" width="210" height="120"></span>
                <p class="footer-links">
                                    <a href="../index.php">Inicio</a>
                    ·
                                        <a href="../nuestrosClientes.html">Clientes</a>
                                        ·
                                        <a href="../index.php">¿Quienes Somos?</a>                   
                    ·
                                        <a href="../contactecnos">Contacto</a>
                </p>
                <p class="footer-company-name">Productivity Manager &copy; 2015</p>
            </div>
            <div class="footer-center">
                <div>
                    <i class="fa fa-map-marker"></i>
                    <p><span>Calle 65 No 13 - 21</span> Bogotá, Colombia</p>
                </div>
                <div>
                    <i class="fa fa-phone"></i>
                    <p>+57 301 5782659</p>
                </div>
                <div>
                    <i class="fa fa-envelope"></i>
                    <p><a href="mailto:productivitymanagersoftware@gmail.com">productivitymanagersoftware@gmail.com</a></p>
                </div>
            </div>
            <div class="footer-right">
                <p class="footer-company-about">
                    <span>Productivity Manager</span>
                    Para aumentar la Productividad es absolutamente necesario incorporar a los mejores trabajadores
                </p>
                <div class="footer-icons">
                                    <a href="https://www.facebook.com/productivitymanager"><img src="../img/facebookFoot.png"></a>
                                    <a href="https://twitter.com/Productivity_Mg"><img src="../img/twitterFoot.png"></a>                 
                                    <a href="mailto:productivitymanagersoftware@gmail.com"></i><img src="../img/gmailFoot.png"></a>
                </div>
            </div>
        </footer>   
    </body>
</html>
