$('#registro_persona').formValidation({
	framework: 'bootstrap',
    feedbackIcons: {
        valid: 'glyphicon glyphicon-ok',
        invalid: 'glyphicon glyphicon-remove',
        validating: 'glyphicon glyphicon-refresh'
    },
    fields: {
        nombre: {
            validators: {
                notEmpty: { // No puede ser vacio
                     message: 'El primer nombre es requerido.'
                 }
             }
         },
         apellido: {
             validators: {
                  notEmpty: { // No puede ser vacio
                     message: 'El primer apellido es requerido.'
                 }
             }
         },
        sexos: {
             validators: {
                  notEmpty: { // No puede ser vacio
                     message: 'Debe seleccionar un sexo.'
                 }
             }
         },
        fecha_nacimiento: {
             validators: {
                  notEmpty: { // No puede ser vacio
                     message: 'Debe introducir una fecha de nacimiento.'
                 }
             }
         },
         fecha_nacimiento_hijo: {
             validators: {
                  notEmpty: { // No puede ser vacio
                     message: 'Debe introducir una fecha de nacimiento.'
                 }
             }
         },    
          cedula: {
             validators: {

                 notEmpty: { // No puede ser vacio
                     message: 'Debe introducir una cédula.'
                 },
                 stringLength: {
                     max: 10,
                     message: 'La cédula no debe tener mas de 8 numeros'
                 }                 
             }
         },
        fecha_ingreso: {
             validators: {
                 notEmpty: { // No puede ser vacio
                     message: 'Debe introducir una fecha de ingreso en el ministerio.'
                 }               
             }
         },
        estado: {
             validators: {
                 notEmpty: { // No puede ser vacio
                     message: 'Por favor seleccione un estado.'
                 }               
             }
         },
        municipio: {
             validators: {
                 notEmpty: { // No puede ser vacio
                     message: 'Por favor seleccione un municipio.'
                 }               
             }
         },
        cargo: {
             validators: {
                 notEmpty: { // No puede ser vacio
                     message: 'Por favor seleccione un cargo.'
                 }               
             }
         },
        coordinacion: {
             validators: {
                 notEmpty: { // No puede ser vacio
                     message: 'Por favor seleccione un coordinacion.'
                 }               
             }
         },
        direccion: {
             validators: {
                 notEmpty: { // No puede ser vacio
                     message: 'Por favor seleccione una parroquia.'
                 }               
             }
         },
        ubicacion: {
             validators: {
                 notEmpty: { // No puede ser vacio
                     message: 'Debe introducir una ubicación.'
                 }               
             }
         },
        telefono:{
            validators: {
                        notEmpty:{
                            message:'Rellene este campo'
                        },
                        phone: {
                            country: 'VE',
                            message: 'Introduzca numero venezolano valido'
                        }
                    }
            },
        otro_telefono:{
            validators:{
                phone:{
                    country: 'VE',
                    message: 'Introduzca numero venezolano valido'
                }
            }
        },
        correo:{
            validators:{
                emailAddress:{
                    message: 'Correo Invalido'
                },
                notEmpty:{
                    message: 'Debe introducir un correo'
                }
            }
        }                  
    }
});

$('#my-wizard').ace_wizard({}).on('actionclicked.fu.wizard' , function(e, data) { 
    var fv=$('#registro_persona').data('formValidation'), //Instancia del validador
    step=data.step, //Paso en el que nos encontramos
    // El contenedor en el que se encuentra el form
    $container = $('#registro_persona').find('.step-pane[data-step="' + step +'"]');
     // Validar el contenedor
     fv.validateContainer($container);
     var isValidStep = fv.isValidContainer($container);
     if (isValidStep === false || isValidStep === null) {
        e.preventDefault();
     }else{
        showElementos('modificarDatos');
        send_consulta_info();
     }
})

.on('changed.fu.wizard', function(e,data) {
})

.on('finished.fu.wizard', function(e) {
   send_registro_InfoAdicional();
})

.on('stepclick.fu.wizard', function(e) {
   e.preventDefault();
});

function show(idObj, effectType, time){
    if (effectType=='slow' || IsNumeric(effectType)){
        $( "#"+idObj ).fadeIn(effectType);     
    }else{
        var options = {};
        if (effectType=='scale')
            options = { percent: 0 };        
        else if (effectType=='size')
        options = { to: { width: 200, height: 60 }};        
        $( "#"+idObj ).show( effectType, options, time); 
    }
}

function hide(idObj, effectType, time){
    if (effectType=='slow' || IsNumeric(effectType)){
        $( "#"+idObj ).fadeOut(effectType);     
    }else{
        var options = {};// most effect types need no options passed by default
        if (effectType=='scale')
            options = { percent: 0 };        
        else if (effectType=='size')
            options = { to: { width: 200, height: 60 }};        
        $( "#"+idObj ).hide( effectType, options, time); 
    }
}

function IsNumeric(n) {
  return !isNaN(parseFloat(n)) && isFinite(n);
}
