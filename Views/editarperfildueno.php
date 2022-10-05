<?php require 'header.php' ?>
<?php require 'visitornav.php'?>



<main class="content">

<div id="formContainer">

    <form id="editarperfil" action="<?php echo FRONT_ROOT."Dueno/EditProfile"?>" method="post" class="activo" style="height: 39em">
        <fieldset class="formHeader">
            <h3><p>Editar Mi Perfil</p></h3>
        </fieldset>

                <fieldset>
                    <label for="informacionpersonal" ><strong><span>Información Personal</span></strong></label><br>
                    <input type="text" id="nombre" name="nombre" placeholder="Nombre">
                    <input type="text" id="apellido" name="apellido" placeholder="Apellido">
                    <input type="number" class="number" id="edad" name="edad" placeholder="Edad" min="18" max="90">
                </fieldset>

                <fieldset>
                    <label for="fotoperfil"><strong><span>Foto de Perfil</span></strong></label><br>
                     <input type="file" id="fotoperfil" name="fotoperfil" accept="image/*">
                </fieldset>
              
                    <div id="botoneraForm">
                        <button class="formButton" type="submit"  >Guardar Info</button>
                        <button class="formButton" type="reset" >Limpiar Campos</button></div>    

    </form>

    <a href="../index.php"><button id="goback"  type="button" style="transform:translate(-2em)"><span id="backward" >Volver al Home</span></button></a>


</div>

</main>


<?php require 'footer.php' ?>