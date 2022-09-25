<?php require 'header.php' ?>
<?php require 'visitornav.php'?>


<main class="content">

<div id="formContainer">

    <form id="editarmascota" action="" class="activo">

        <fieldset class="formHeader">
            <h3><p>Agregar Mascota</p></h3>
        </fieldset>

                <fieldset>
                        <label for="informacionbasica"><span><strong>Información Básica</strong></span></label>
                    <input type="text" name="nombre" placeholder="Nombre de la Mascota" required>
                    <input type="number" class="number" name="edad" placeholder="Edad de la Mascota" min="0" required>
                </fieldset>

                <fieldset>
                    <label for="tipoperro"><strong><span>Tipo de Perro</span></strong></label><br>
                    <label for="grande" class="labelcheckbox"><span>Grande</span></label>
                    <input id="checkbox" type="checkbox" name="tipoperro" id="grande" value="grande">
                    <label for="mediano" class="labelcheckbox"><span>Mediano</span></label>
                    <input id="checkbox" type="checkbox" name="tipoperro" id="mediano" value="mediano">
                    <label for="chico" class="labelcheckbox"><span>Chico</span></label>
                    <input id="checkbox" type="checkbox" name="tipoperro" id="chico" value="chico">
                </fieldset>

                <fieldset>
                    <label for="consideraciones"><span><strong>Consideraciones / Cuidados especiales</strong></span></label>
                    <textarea name="consideraciones" id="consideraciones" placeholder="Ingrese aquí información sobre consideraciones o cuidados especiales." required></textarea>
                </fieldset>
                
                <fieldset><label for="fichamedica"><strong><span>Foto de la Mascota</span></strong></label><br>
                     <input type="file" id="fichamedica" name="fichamedica" accept="image/*" required>
                </fieldset>

                <fieldset><label for="fichamedica"><span><strong>Video de la Mascota </strong> (Opcional)</span></label><br>
                     <input type="file" id="fichamedica" name="fichamedica" accept="video/*">
                </fieldset>


                <fieldset><label for="fotomascota"><strong><span>Ficha Médica</span></strong></label><br>
                     <input type="file" id="fotomascota" name="fotomascota" accept="image/*" required>
                </fieldset>

                     <div id="botoneraForm">
                     <button class="formButton" type="submit" >Guardar Info</button>
                     <button class="formButton" type="reset" >Limpiar Campos</button></div>

                     <a href="index.php"><button id="goback"  type="button"><span id="backward">Volver al Home</span></button></a>
    

    </form>

</div>

</main>



<?php require 'footer.php' ?>