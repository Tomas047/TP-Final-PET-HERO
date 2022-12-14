<?php require 'header.php' ?>
<?php require 'visitornav.php'?>

<main class="content">

<?php if ($alert!="") {?>

<div id="alert" class="<?php echo $alert['tipo'] ?>"><span><strong><?php echo $alert['mensaje']?></strong></span></div>

<?php } ?>

        <div id="formContainer">

<form id="registrodueño" action="<?php echo FRONT_ROOT."Dueno/Add"?>" class="activo" method="post">
                    
                    <fieldset class="formHeader">
                        <h3><p>Registrarse como Dueño</p></h3>
                    </fieldset>
    
                    <fieldset>
                        <input type="email" name="mail" placeholder="Email" autocomplete="off" required></input>
                        <input type="password" name="password" placeholder="Password" autocomplete="off" required></input>
                        <input type="password" name="passwordconfirm" placeholder="Confirmar Password" autocomplete="off" style="margin-bottom:1em;" required></input>
                        <input type="checkbox" id="checkbox" required></input> <span style="margin-left:-0.5em;">He leido y acepto los <a href="#"> términos y condiciones</a></span>
    
                        
                        <div id="botoneraForm" style="margin-top:0em;">
                            <button class="formButton" type="submit" >Ingresar</button>
                            <button class="formButton" type="reset" >Limpiar Campos</button></div>
    
                    </fieldset>
                            <a href="<?php echo FRONT_ROOT."Home"?>"><button id="goback"  type="button"><span id="backward">Volver al Home</span></button></a>
    
                </form>
     
        </div>


        <a name="servicios" id="registro"></a>
        <div class="contenedorLista"> 
            <ul>

            <li class="listContent">
                    <img class="listIcon" src="<?php echo IMG_PATH;?>catdog.png">
                    <div class="contenedorTexto">
                        <span>Completa el perfil de tu mascota y <strong>PET HERO</strong> te  mostrará 
                            los Guardianes que mejor se ajusten a sus necesidades.</span></div>
                </li>
                <li class="listContent">
                    <img class="listIcon" src="<?php echo IMG_PATH;?>personhome.png">
                    <div class="contenedorTexto">
                        <span>Regístrate como <strong>Guardián</strong>: dinos qué tipos de mascotas quieres cuidar,
                             tu disponibilidad y paga. <br> !Nosotros haremos el resto! </span></div>
                </li>
                <li class="listContent">
                    <img class="listIcon" src="<?php echo IMG_PATH;?>hombremujer.png">
                    <div class="contenedorTexto">
                        <span>Redacta reviews sobre los Guardianes que hayas contratado y ayuda a otros <strong>Dueños</strong> a
                           tener una mejor experiencia.
                        </div>
                </li>
            
            </ul>   
        </div>

      
</main>

<script>
if (!$("#alert").hasClass("")){
$("#alert").animate({bottom:"3%"},{duration:800}).delay(1000).animate({bottom:"-8%"},{duration:800});
}
</script>



<?php require 'footer.php' ?>