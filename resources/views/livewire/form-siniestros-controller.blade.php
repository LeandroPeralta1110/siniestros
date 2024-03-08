<div>
    <h1>IVESS - Formulario de Denuncia de Siniestro</h1>
    <div class="container-form">
        <div class="grid-container">
            <div class="resizable-grid">
                <div class="tab">
                    <button class="tablinks" onclick="openTab(event, 'Empresa_/_Sucursal')">Empresa / Sucursal</button>
                    <button class="tablinks" onclick="openTab(event, 'Vehículo')">Vehículo</button>
                    <button class="tablinks" onclick="openTab(event, 'Lugar_del_Siniestro')">Lugar del Siniestro</button>
                    <button class="tablinks" onclick="openTab(event, 'Descripcion_siniestro')">Descripcion del Siniestro</button>
                    <button class="tablinks" onclick="openTab(event, 'datos_del_tercero')">Datos personales del tercero</button>
                </div>
            </div>
            <div class="second-grid">
                <form id="formulario" action="{{ route('submit.form') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div id="Empresa_/_Sucursal" class="tabcontent">
                        <h2>Empresa / Sucursal</h2>
                        <label for="Hora_y_dia_de_la_Creacion_del_Formulario_Siniestro">Hora y día del Siniestro:</label><br>
                        <input type="datetime-local" id="Hora_y_dia_de_la_Creacion_del_Formulario_Siniestro" name="Hora_y_dia_de_la_Creacion_del_Formulario_Siniestro" required><br>
                        <label for="nom_ape_chofer" class="mt-4">Nombre y apellido del chofer:</label><br>
                        <input type="text" id="nombreApellidoChofer" name="nombreApellidoChofer" placeholder="Ingrese nombre y apellido del chofer" required><br>
                        <label for="DNIchofer"class="mt-4">DNI del chofer:</label><br>
                        <input type="text" id="DNIchofer" name="DNIchofer" placeholder="Ingrese DNI del chofer" required ><br>
                        <label for="legajoChofer"class="mt-4">Legajo:</label><br>
                        <input type="number" id="legajoChofer" name="legajoChofer" placeholder="Ingrese legajo del chofer" required ><br>
                        <label for="telChof"class="mt-4">Telefono del chofer:</label><br>
                        <input type="tel" id="telChof" name="telChof" placeholder="Ingrese telefono del chofer" required><br>
                        <label for="nom_ape_ayudante"class="mt-4">Nombre y apellido del ayudante:</label><br>
                        <input type="text" id="nom_ape_ayudante" name="nom_ape_ayudante" required><br>
                        <!-- Imágenes DNI chofer -->
                        <label class="mt-8">Imagenes DNI chofer</label>
                        <div class="grid grid-cols-1 mt-5 mx-7">
                            <img id="imagenSeleccionada1" style="max-height: 300px;">           
                        </div>
                        <div class='flex items-center justify-center w-full'>
                            <label class='flex flex-col border-4 border-dashed w-full h-32 hover:bg-gray-100 hover:border-purple-300 group'>
                                <div class='flex flex-col items-center justify-center pt-7'>
                                    <svg class="w-10 h-10 text-purple-400 group-hover:text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    <p class='text-sm text-gray-400 group-hover:text-purple-600 pt-1 tracking-wider'>Seleccione DNI FRENTE</p>
                                </div>
                                <input name="imagen1" id="imagen1" type='file' class="hidden" required />
                            </label>
                        </div>
                        <div class="grid grid-cols-1 mt-5 mx-7">
                            <img id="imagenSeleccionada2" style="max-height: 300px;">           
                        </div>
                        <div class='flex items-center justify-center w-full'>
                            <label class='flex flex-col border-4 border-dashed w-full h-32 hover:bg-gray-100 hover:border-purple-300 group'>
                                <div class='flex flex-col items-center justify-center pt-7'>
                                    <svg class="w-10 h-10 text-purple-400 group-hover:text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    <p class='text-sm text-gray-400 group-hover:text-purple-600 pt-1 tracking-wider'>Seleccione DNI DORSO</p>
                                </div>
                                <input name="imagen2" id="imagen2" type='file' class="hidden" required/>
                            </label>
                        </div>
                    </div>
                    
                    <!-- Campos de Vehículo -->
                    <div id="Vehículo" class="tabcontent">
                        <h2>Vehículo</h2>
                        <label for="patente-vehiculo">Patente del vehículo:</label><br>
                        <input type="text" id="patente-vehiculo" name="patente-vehiculo" placeholder="Ingrese patente del vehiculo" required><br>
                        <label for="interno-vehiculo"class="mt-4">Interno del vehiculo:</label><br>
                        <input type="text" id="interno-vehiculo" name="interno-vehiculo" placeholder="Ingrese Interno del vehiculo" required><br>
                        <label for="cargamento-vehiculo"class="mt-4">Cargamento:</label><br>
                        <select id="cargamento-vehiculo" name="cargamento-vehiculo" required>
                            <option value="con">Con cargamento</option>
                            <option value="sin">Sin cargamento</option>
                        </select><br>
                        <label for="daños-vehiculo"class="mt-4">Daños del vehiculo:</label><br>
                        <input type="text" id="daños-vehiculo" name="daños-vehiculo" placeholder="Ingrese daños del vehiculo" required><br>
                        <div class="grid grid-cols-1 mt-5 mx-7">
                            <img id="selecDaños1" style="max-height: 300px;">           
                        </div>
                        <div class='flex items-center justify-center w-full'>
                            <label class='flex flex-col border-4 border-dashed w-full h-32 hover:bg-gray-100 hover:border-purple-300 group'>
                                <div class='flex flex-col items-center justify-center pt-7'>
                                    <svg class="w-10 h-10 text-purple-400 group-hover:text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    <p class='text-sm text-gray-400 group-hover:text-purple-600 pt-1 tracking-wider'>Seleccione DAÑO 1</p>
                                </div>
                                <input name="daños1" id="daños1" type='file' class="hidden" required/>
                            </label>
                        </div>
                        <div class="grid grid-cols-1 mt-5 mx-7">
                            <img id="selecDaños2" style="max-height: 300px;">           
                        </div>
                        <div class='flex items-center justify-center w-full'>
                            <label class='flex flex-col border-4 border-dashed w-full h-32 hover:bg-gray-100 hover:border-purple-300 group'>
                                <div class='flex flex-col items-center justify-center pt-7'>
                                    <svg class="w-10 h-10 text-purple-400 group-hover:text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    <p class='text-sm text-gray-400 group-hover:text-purple-600 pt-1 tracking-wider'>Seleccione DAÑO 2</p>
                                </div>
                                <input name="daños2" id="daños2" type='file' class="hidden" required />
                            </label>
                        </div>
                    </div>

                    <div id="Lugar_del_Siniestro" class="tabcontent">
                        <h2>Lugar del Siniestro</h2>
                        <label for="localidad_sini">Localidad del Siniestro:</label><br>
                        <input type="text" id="localidad_sini" name="localidad_sini" placeholder="Ingrese localidad del siniestro" required><br>
                        <label for="calle_sini"class="mt-4">Ubicacion/Calle del Siniestro:</label><br>
                        <input type="text" id="calle_sini" name="calle_sini" placeholder="Ingrese calle del siniestro" required><br>
                        <label for="altura_sini"class="mt-4">Altura del Siniestro:</label><br>
                        <input type="text" id="altura_sini" name="altura_sini" placeholder="Ingrese alturas del siniestro" required><br>
                        <label for="interseccion_sini"class="mt-4">Interseccion/entrecalle del Siniestro:</label><br>
                        <input type="text" id="interseccion_sini" name="interseccion_sini" placeholder="Ingrese Interseccion/entrecalle del siniestro" required><br>
                        <label for="direccion-vial"class="mt-4">Direccion vial:</label><br>
                        <select id="direccion-vial" name="direccion-vial" required>
                            <option value="mano">Mano</option>
                            <option value="contra-mano">Contra mano</option>
                        </select><br>
                    </div>

                    <div id="Descripcion_siniestro" class="tabcontent">
                        <h2>Descripcion del Siniestro</h2>
                        <label for="nombre-tercero">Nombre y apellido del tercero:</label><br>
                        <input type="text" id="nombre-tercero" name="nombre-tercero" placeholder="Ingrese nombre y apellido del tercero" required><br>
                        <label for="vehiculo-tercero"class="mt-4">Vehiculo del tercero:</label><br>
                        <select id="vehiculo-tercero" name="vehiculo-tercero" required>
                            <option value="automovil">Automovil</option>
                            <option value="Cupe">Cupe</option>
                            <option value="Camioneta">Camioneta</option>
                            <option value="Camion">Camion</option>
                            <option value="Camion_con_Acoplado">Camion con Acoplado</option>
                            <option value="Bicicleta">Bicicleta</option>
                            <option value="Motocicleta">Motocicleta</option>
                            <option value="Otro">Otro</option>
                        </select><br>
                        <label for="pos-registro"class="mt-4">Poseia registro de conducir:</label><br>
                        <select id="pos-registro" name="pos-registro" required>
                            <option value="Si">Si</option>
                            <option value="No">No</option>
                        </select><br>
                        <label for="pos-documentacion"class="mt-4">Poseia documentacion del vehiculo:</label><br>
                        <select id="pos-documentacion" name="pos-documentacion" required>
                            <option value="Si">Si</option>
                            <option value="No">No</option>
                        </select><br>
                        <label for="pos-poliza" class="mt-4">Poseía póliza:</label><br>
                        <select id="pos-poliza" name="pos-poliza" required>
                            <option value="Si">Si</option>
                            <option value="No">No</option>
                        </select><br>
                        <!-- Segundo select (inicialmente oculto) -->
                        <div id="poliza-tipo">
                            <label for="pos-poliza-tipo" class="mt-4">Qué tipo de póliza:</label><br>
                            <select id="pos-poliza-tipo" name="pos-poliza-tipo">
                                <option value="completo">Completo</option>
                                <option value="tercero">Tercero</option>
                            </select><br>
                        </div>
                        <label for="vehiculo-tipo" class="mt-4">Vehiculo Personal/Alquiler:</label><br>
                        <select id="vehiculo-tipo" name="vehiculo-tipo" required>
                            <option value="Personal">Personal</option>
                            <option value="Alquiler">Alquiler</option>
                        </select><br>
                        <label for="pos-acompañantes" class="mt-4">Poseia acompañantes:</label><br>
                        <select id="pos-acompañantes" name="pos-acompañantes" required>
                            <option value="Si">Si</option>
                            <option value="No">No</option>
                        </select><br>

                        <div id="cant-acomp">
                            <label for="pos-cant-acomp" class="mt-4">Cuantos acompañantes:</label><br>
                            <input type="number" id="pos-cant-acomp" name="pos-cant-acomp" placeholder="Ingrese cantidad de acompañantes"><br>
                        </div>

                        <div id="pos-menor">
                            <label for="pos-menor-acomp" class="mt-4">Algun acompañante era menor:</label><br>
                            <select id="pos-menor-acomp" name="pos-menor-acomp">
                                <option value="Si">Si</option>
                                <option value="No">No</option>
                            </select><br>
                        </div>

                        <div id="pos-daños">
                            <label for="pos-daños-acomp" class="mt-4">Algun acompañante sufrio daños:</label><br>
                            <select id="pos-daños-acomp" name="pos-daños-acomp">
                                <option value="Si">Si</option>
                                <option value="No">No</option>
                            </select><br>
                        </div>

                        <div id="pos-desc-daños">
                            <label for="pos-desc-daños-acomp" class="mt-4">Descripcion de los daños del acompañante:</label><br>
                            <input type="text" id="pos-desc-daños-acomp" name="pos-desc-daños-acomp" placeholder="Ingrese descripcion de los daños del acompañante">
                        </div>

                        <label for="int-pol"class="mt-4">Hubo intervencion Policial:</label><br>
                        <select id="int-pol" name="int-pol" required>
                            <option value="Si">Si</option>
                            <option value="No">No</option>
                        </select><br>

                        <label for="int-med"class="mt-4">Hubo intervencion Medica:</label><br>
                        <select id="int-med" name="int-med" required>
                            <option value="Si">Si</option>
                            <option value="No">No</option>
                        </select><br>

                        <label for="por-daños"class="mt-4">Porcentaje del daño del vehiculo del tercero:</label><br>
                        <input type="text" id="por-daños" name="por-daños" value="%">

                        <label for="tip-choque"class="mt-4">Tipo de choque:</label><br>
                        <select id="tip-choque" name="tip-choque" required>
                            <option value="frontal">Frontal</option>
                            <option value="trasero">Trasero</option>
                            <option value="lateral">Lateral</option>
                            <option value="superior">Superior</option>
                        </select><br>
                        
                        <label for="desc-daños"class="mt-4">Descripcion de los daños:</label><br>
                        <input type="text" id="desc-daños" name="desc-daños" placeholder="Ingrese descripcion de los daños" required><br>
                    </div>

                    <div id="datos_del_tercero" class="tabcontent">
                        <h2>Datos personales del Tercero</h2>
                        <label for="dni-tercero">DNI del tercero:</label><br>
                        <input type="text" id="dni-tercero" name="dni-tercero" placeholder="Ingrese DNI del tercero" required><br>
                        <label for="gen-tercero"class="mt-4">Genero del tercero:</label><br>
                        <select id="gen-tercero" name="gen-tercero" required>
                            <option value="hombre">Hombre</option>
                            <option value="mujer">Mujer</option>
                        </select><br>

                        <label for="patente-tercero"class="mt-4">Patente del vehiculo del tercero:</label><br>
                        <input type="text" id="patente-tercero" name="patente-tercero" placeholder="Ingrese patente del vehiculo del tercero" required><br>

                        <label for="desc-vehiculo-tercero"class="mt-4">Marca, modelo, color y año del vehículo del tercero:</label><br>
                        <input type="text" id="desc-vehiculo-tercero" name="desc-vehiculo-tercero" placeholder="Ingrese descripcion del vehiculo del tercero" required><br>

                        <label for="domic-tercero"class="mt-4">Domicilio del tercero:</label><br>
                        <input type="text" id="domic-tercero" name="domic-tercero" placeholder="Ingrese domicilio del tercero" required><br>

                        <label for="tel-tercero"class="mt-4">Telefono de contacto del tercero:</label><br>
                        <input type="tel" id="tel-tercero" name="tel-tercero" placeholder="Ingrese Telefono del tercero" required><br>

                        <label for="com-seguro-tercero"class="mt-4">Compañia de seguros del tercero:</label><br>
                        <input type="tel" id="com-seguro-tercero" name="com-seguro-tercero" placeholder="Ingrese compañia de seguro del tercero"><br>

                        <label for="obs-adic"class="mt-4">Observaciones adicionales</label><br>
                        <input type="tel" id="obs-adic" name="obs-adic" placeholder="Ingrese observaciones adicionales"><br>
                    </div>
                    
                    <!-- Botón de envío del formulario -->
                    <input type="submit" value="Enviar" style="display: none;">
                </form>
            </div>
        </div>
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(document).ready(function (e) {   
            $('#imagen1').change(function(){            
                let reader = new FileReader();
                reader.onload = (e) => { 
                    $('#imagenSeleccionada1').attr('src', e.target.result); 
                }
                reader.readAsDataURL(this.files[0]); 
            });

            $('#imagen2').change(function(){            
                let reader = new FileReader();
                reader.onload = (e) => { 
                    $('#imagenSeleccionada2').attr('src', e.target.result); 
                }
                reader.readAsDataURL(this.files[0]); 
            });

            $('#daños1').change(function(){            
                let reader = new FileReader();
                reader.onload = (e) => { 
                    $('#selecDaños1').attr('src', e.target.result); 
                }
                reader.readAsDataURL(this.files[0]); 
            });

            $('#daños2').change(function(){            
                let reader = new FileReader();
                reader.onload = (e) => { 
                    $('#selecDaños2').attr('src', e.target.result); 
                }
                reader.readAsDataURL(this.files[0]); 
            });

            $('#formulario').on('input', function () {
        var allInputs = $(this).find(':input');
        var allInputsFilled = true;
        allInputs.each(function () {
            if ($(this).prop('required') && !$(this).val()) {
                allInputsFilled = false;
                return false; // Break out of the loop
            }
        });
        if (allInputsFilled) {
            $('input[type="submit"]').show();
        } else {
            $('input[type="submit"]').hide();
        }
        });

        $('#pos-poliza').change(function () {
        if ($(this).val() === 'Si') {
            $('#poliza-tipo').show();
        } else {
            $('#poliza-tipo').hide();
        }
    });

    $('#pos-acompañantes').change(function () {
        if ($(this).val() === 'Si') {
            $('#cant-acomp').show();
            $('#pos-menor').show();
            $('#pos-daños').show();
        } else {
            $('#cant-acomp').hide();
            $('#pos-menor').hide();
            $('#pos-daños').hide();
            $('#pos-desc-daños').hide();
        }
    });

    $('#pos-daños-acomp').change(function () {
        if ($(this).val() === 'Si') {
            $('#pos-desc-daños').show();
        } else {
            $('#pos-desc-daños').hide();
        }
    });

        });
    </script>
    <script>
function openTab(evt, tabName) {
var i, tabcontent, tablinks;
tabcontent = document.getElementsByClassName("tabcontent");
for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
}
tablinks = document.getElementsByClassName("tablinks");
for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
}
document.getElementById(tabName).style.display = "block";
evt.currentTarget.className += " active"; // Agrega la clase "active" al botón seleccionado
}
</script>