<?php require_once 'validate-session.php'?> 

<?php require 'header.php' ?>
<?php require 'usernav.php'?>

<link rel="stylesheet" href="<?php echo CSS_PATH;?>bootstrap.css">
<!-- incluyo bootstrap-->
<link href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker3.css" rel="stylesheet"/>

<main class="content">

<?php if ($alert!="") {?>

<div id="alert" class="<?php echo $alert['tipo'] ?>"><span><strong><?php echo $alert['mensaje']?></strong></span></div>

<?php } ?>

    <div id="mainContainer" class="">

                
    <section style="width:52em;padding:3em 0 0 0">
                        
                        <summary><span style=" position:relative; bottom:2em;"><strong> Mi Perfil </span></strong></summary>
                        <div class="sectioncontent">

                            <div class="profilecard" id="perfilguardian">

                                <div class="mainprofileinfo">
                                    
                                <?php if ($usuario->getFotoPerfil()){ ?>

                                    <img class="imgperfilgrande" src="<?php echo FRONT_ROOT.$usuario->getFotoPerfil();?>" style="border: 1px solid gray">

                                <?php }else{ ?>

                                <img class="imgperfilgrande" src="<?php echo IMG_PATH;?>avatardefault.png">

                                    <?php } ?>
                                    <span><?php echo ucwords($usuario->getNombre());?></span>
                                    <span><?php echo ucwords($usuario->getApellido());?></span>
                                    <span>Reputacion</span>
                                    <span><?php if($usuario->getPuntaje()){ echo $usuario->getPuntaje();}else{echo'?';}echo '/10';?> </span>
                                </div>

                                <div class="secondaryprofileinfo">

                                    <div class="infopersonal">
                                        <span> Información Personal</span>
                                        <div class="separador"></div>
                                        <span>Edad: <strong><?php echo $usuario->getEdad();?></strong></span>
                                        <span>Email: <strong><?php echo $usuario->getMail();?></strong></span>
                                    </div>

                                    <div class="infoguardian">

                                        <span>Información Guardián</span>
                                        <div class="separador"></div>
                                        <span>Tipo de Perro: <strong><?php echo $usuario->getTamano();?></strong></span>
                                        <span>Remuneracion por Día: <strong><?php echo $usuario->getRemuneracion();?></strong></span>
                                        <span>Disponibilidad: <?php if($usuario->getDisponibilidad()=='Plena'||$usuario->getDisponibilidad()=='Fines De Semana'){
                                            ?> <strong><?php echo $usuario->getDisponibilidad()?></strong>  <?php
                                        }else{ ?> </span>
                                           
                                        <?php include (VIEWS_PATH."disponibilidad.php") ?>
                                    
                                        <div class="container" style="width:26%;">
                                                <input style="cursor: pointer; border: 1px solid rgba(64, 114, 8, 0.1); position:relative; bottom:2.3em; right:3em; !important; border-radius: 3%; background-color:
                                                rgba(235, 241, 146, 0.733);"
                                            type="text" class="form-control date" placeholder="Ver fechas" name="fechas" id="calendario" autocomplete="off"
                                            data-date-start-date="0d" data-date-end-date="+1m" value="" required readonly><br> 
                                            </div>
                                            <?php } ?>

                                        
                                    </div>

                                </div>

                            </div>
                            <a href="<?php echo FRONT_ROOT."Guardian/EditPRofile"?>"><button class="formButton" style="padding:0.3em 1em; position:relative; left:19em; bottom:5em;">Editar</button></a>

                        </div>
                    </section>


                    <section style="width:50em; height:12em"> 
                    <div class="sectioncontent">

                        <summary><span style=" position:relative; bottom:-1.5em;"><strong> Menú </span></strong></summary>
                        
                        <div style="display:flex;flex-direction:column">                    

                        <a href="<?php echo FRONT_ROOT ?>Guardian/ShowProfile/<?php echo $_SESSION['id']?>">
                        <button style="" class="buttonHome">Ver Perfil Público</button></a>

                        <a href="<?php echo FRONT_ROOT."Chat/mostrarChat"?>">
                        <button style="" class="buttonHome" <?php if (!$chatDisponibles){echo 'Disabled';}?>>Ver Chats</button></a>

                         </div>
                    
                    </div>
                </section>


                    <section style="width:80em">

                    <details class="estilizado" style="margin-top:1.5em;margin-bottom:-1em;"><summary><span><strong>Reservas Confirmadas</strong></span></summary>

                    <div class="sectioncontent">
                            
                        <table>
                        
                        <tr> <th><span>Foto</span></th> <th><span>Nombre</span></th><th><span>Nombre Dueño</span></th><th><span>Raza</span></th> 
                        <th><span>Días</span></th><th><span>Fecha Inicio</span></th><th><span>Fecha Fin</span></th></tr>
                        <tr class="espacio"><td></td></tr>

                        <?php foreach($reservas as $reserva) { if($reserva["r.estado"]=='Confirmada'){?>

                            <?php $dateInicio=date_create_from_format('Y-m-d',$reserva['r.fecha_inicio']);
                            $dateFinal=date_create_from_format('Y-m-d',$reserva['r.fecha_final']);
                            $diasReserva=date_diff($dateInicio,$dateFinal)->d+1; ?>

                        
                        <tr><td><img  class ="imgperfilchica" src="<?php echo FRONT_ROOT.$reserva["m.foto_perfil"]?>"></td><td><span><?php echo $reserva["m.nombre"]; ?></span></td>
                        <td><span><?php echo $reserva["d.nombre"]; ?></span></td><td><span><?php echo ucwords($reserva["m.raza"]); ?></span></td><td><span><?php echo $diasReserva; ?></span></td>
                        <td><span><?php echo $reserva["r.fecha_inicio"]; ?></span></td><td><span><?php echo $reserva["r.fecha_final"]; ?></span></td>

                        <td>
                        
                        <form action="<?php echo FRONT_ROOT."Mascota/ShowProfile"?>" style="display:inline;">
                        <input type="number" value="<?php echo $reserva['m.id_mascota'];?>" name="id_mascota" style="display:none">    
                        <button class="formButton" type="submit" style="">Ver Info</button></form></td></tr>
                        <tr class="espacio"><td></td></tr>


                        <?php }} ?>

                        </table>
                        
                    </div>

                        </details>

                    </section>



                    <?php $mostrarSectionPendientes=false;
                        foreach($reservas as $reserva){

                        if ($reserva["r.estado"]=='Pendiente'){
                            $mostrarSectionPendientes=true;
                        }} 

                        if($mostrarSectionPendientes){
                        ?>

                    <section style="width:80em">

                    <details class="estilizado" style="margin-top:1.5em;margin-bottom:-1em;"><summary><span><strong>Reservas sin Aceptar</strong></span></summary>

                    <div class="sectioncontent">
                            
                        <table>
                        
                        <tr> <th><span>Foto</span></th> <th><span>Nombre</span></th><th><span>Nombre Dueño</span></th><th><span>Raza</span></th> 
                        <th><span>Días</span></th><th><span>Fecha Inicio</span></th><th><span>Fecha Fin</span></th></tr>
                        <tr class="espacio"><td></td></tr>


                        <?php foreach($reservas as $reserva) { if($reserva["r.estado"]=='Pendiente'){?>

                            <?php $dateInicio=date_create_from_format('Y-m-d',$reserva['r.fecha_inicio']);
                            $dateFinal=date_create_from_format('Y-m-d',$reserva['r.fecha_final']);
                            $diasReserva=date_diff($dateInicio,$dateFinal)->d+1; ?>

                        
                        <tr><td><img  class ="imgperfilchica" src="<?php echo FRONT_ROOT.$reserva["m.foto_perfil"]?>"></td><td><span><?php echo $reserva["m.nombre"]; ?></span></td>
                        <td><span><?php echo $reserva["d.nombre"]; ?></span></td><td><span><?php echo ucwords($reserva["m.raza"]); ?></span></td><td><span><?php echo $diasReserva; ?></span></td>
                        <td><span><?php echo $reserva["r.fecha_inicio"]; ?></span></td><td><span><?php echo $reserva["r.fecha_final"]; ?></span></td>

                        
                        <form action="<?php echo FRONT_ROOT."Reserva/updateEstado"?>">
                        <input type="number" name="idReserva" value="<?php echo $reserva["r.id_reserva"];?>" style="display:none"></input>
                        <input type="text" name="estado" value="Aceptada" style="display:none"></input>
                        <input type="text" style="display:none" name="mascota[]" value="<?php echo ucwords($reserva['m.nombre']).",".ucwords($reserva['m.raza']).",".$reserva['m.id_mascota'];?>"></input>                         
                        <input type="text" value="<?php echo $reserva['r.fecha_inicio'];?>" name="fecha_inicio" style="display:none">    
                        <input type="text" value="<?php echo $reserva['r.fecha_final'];?>" name="fecha_final" style="display:none">    
                        <input type="text" value="<?php echo $_SESSION['id'];?>" name="idGuardian" style="display:none">  
                        <td><button class="formButton" type="submit">Aceptar</button>
                        </form>

                        <form action="<?php echo FRONT_ROOT."Reserva/updateEstado"?>" style="display:inline;">
                        <input type="number" name="idReserva" value="<?php echo $reserva["r.id_reserva"];?>" style="display:none"></input>
                        <input type="text" name="estado" value="Cancelada" style="display:none"></input>
                        <button class="formButton" type="submit" style="">Cancelar</button>
                        </form>

                        <form action="<?php echo FRONT_ROOT."Mascota/ShowProfile"?>" style="display:inline;">
                        <input type="number" value="<?php echo $reserva['m.id_mascota'];?>" name="id_mascota" style="display:none">    
                        <button class="formButton" type="submit" style="">Ver Info</button></form>

                        </td>

                        <tr class="espacio"><td></td></tr>


                        <?php }} ?>

                        </table>
                        
                    </div>
                        </details>
                    </section>



                    <?php } ?>
                    <?php $mostrarSectionAceptadas=false;
                        foreach($reservas as $reserva){

                        if ($reserva["r.estado"]=='Aceptada'){
                            $mostrarSectionAceptadas=true;
                        }} 

                        if($mostrarSectionAceptadas){
                        ?>

                    <section style="width:80em">
                    <details class="estilizado" style="margin-top:1.5em;margin-bottom:-1em;"><summary><span><strong>Reservas Pendientes de Pago</strong></span></summary>
                    <div class="sectioncontent">
                            
                        <table>
                        
                        <tr> <th><span>Foto</span></th> <th><span>Nombre</span></th><th><span>Nombre Dueño</span></th><th><span>Raza</span></th> 
                        <th><span>Días</span></th><th><span>Fecha Inicio</span></th><th><span>Fecha Fin</span></th></tr>
                        <tr class="espacio"><td></td></tr>


                        <?php foreach($reservas as $reserva) { if($reserva["r.estado"]=='Aceptada'){?>

                            <?php $dateInicio=date_create_from_format('Y-m-d',$reserva['r.fecha_inicio']);
                            $dateFinal=date_create_from_format('Y-m-d',$reserva['r.fecha_final']);
                            $diasReserva=date_diff($dateInicio,$dateFinal)->d+1; ?>

                        
                        <tr><td><img  class ="imgperfilchica" src="<?php echo FRONT_ROOT.$reserva["m.foto_perfil"]?>"></td><td><span><?php echo $reserva["m.nombre"]; ?></span></td>
                        <td><span><?php echo $reserva["d.nombre"]; ?></span></td><td><span><?php echo ucwords($reserva["m.raza"]); ?></span></td><td><span><?php echo $diasReserva; ?></span></td>
                        <td><span><?php echo $reserva["r.fecha_inicio"]; ?></span></td><td><span><?php echo $reserva["r.fecha_final"]; ?></span></td>

                        
                        <td>
                        <form action="<?php echo FRONT_ROOT."Reserva/updateEstado"?>" style="display:inline;">
                        <input type="number" name="idReserva" value="<?php echo $reserva["r.id_reserva"];?>" style="display:none"></input>
                        <input type="text" name="estado" value="Cancelada" style="display:none"></input>
                        <button class="formButton" type="submit" style="">Cancelar</button>
                        </form>
                        
                        <form action="<?php echo FRONT_ROOT."Mascota/ShowProfile"?>" style="display:inline;">
                        <input type="number" value="<?php echo $reserva['m.id_mascota'];?>" name="id_mascota" style="display:none">    
                        <button class="formButton" type="submit" style="">Ver Info</button></form>
                        </td>

                        <tr class="espacio"><td></td></tr>


                        <?php }} ?>

                        </table>
                        
                    </div>
                        </details>
                    </section>

                    <?php } ?>

                       

    </div>

</main>

<?php require 'datepickervista.php' ?>


<script>

$('.date').datepicker('setDatesDisabled',fechasNoDisponiblesJS);  //funcion de datepicker que setea fechas no disponibles
                                                                    //el dueño solo puede elegir de entre las fechas seleccionadas por el guardian
</script>

<script>
if (!$("#alert").hasClass("")){
$("#alert").animate({bottom:"3%"},{duration:800}).delay(1000).animate({bottom:"-8%"},{duration:800});
}
</script>


<?php require 'footer.php' ?>