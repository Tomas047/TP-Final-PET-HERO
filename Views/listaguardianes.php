<?php require 'header.php' ?>
<?php require 'usernav.php'?>

<main class="content">

    <div id="mainContainer" class="">
                
                <section>
                       
                    <div class="sectioncontent">

                    <summary><span><strong> Lista de Guardianes </span></strong></summary>
                    <table>
                        
                        <tr> <th><span>Foto</span></th> <th><span>Nombre</span></th><th><span>Tarifa diaria</span></th><th><span>Tipo de Perro</span></th> 
                        <th><span>Reputación</span></th></tr>
                        <tr class="espacio"><td></td></tr>
                        
                        <?php foreach($GuardianList as $guardian){ ?>
                

                            <tr><td>
                        <img  class ="imgperfilchica" src="<?php echo IMG_PATH;?>avatardefault.png">
                        </td><td><span><?php echo ucwords($guardian->getNombre()); ?></span></td><td><span><?php echo $guardian->getRemuneracion(); ?></span></td>
                        <td><span><?php echo implode(", ",$guardian->getTipoPerro()); ?></span></td><td><span><?php echo ""; ?></span></td>
                        <td>
                        <button class="formButton" type="submit" >Ver Perfil</button></td></tr>
                        <tr class="espacio"><td></td></tr>
                        
                                <?php } ?>
                        </table>

                    </div>
                     </section>

                     <a href="<?php echo FRONT_ROOT."Home"?>">
                     <button id="goback" type="button"><span id="backward">Volver al Home</span></button></a>


    </div>

</main>



<?php require 'footer.php' ?>