//esto captura el ID del formulario al cual se le aplicaran las validaciones.
//dichas validaciones son al campo por nombre
// $('#registro_persona').formValidation({
// 	 framework: 'bootstrap',
//      feedbackIcons: {
//          valid: 'glyphicon glyphicon-ok',
//          invalid: 'glyphicon glyphicon-remove',
//          validating: 'glyphicon glyphicon-refresh'
//      },
//      fields: {
//          nombre: {
//              validators: {
//                   notEmpty: { // No puede ser vacio
//                      message: 'El primer nombre es requerido.'
//                  }
//              }
//          },
//          apellido: {
//              validators: {
//                   notEmpty: { // No puede ser vacio
//                      message: 'El primer apellido es requerido.'
//                  }
//              }
//          },
//         sexo: {
//              validators: {
//                   notEmpty: { // No puede ser vacio
//                      message: 'Debe seleccionar un sexo.'
//                  }
//              }
//          },
//         fecha_nacimiento: {
//              validators: {
//                   notEmpty: { // No puede ser vacio
//                      message: 'Debe introducir una fecha de nacimiento.'
//                  }
//              }
//          },   
//           cedula: {
//              validators: {

//                  notEmpty: { // No puede ser vacio
//                      message: 'Debe introducir una cédula.'
//                  },
//                  stringLength: {
//                      max: 10,
//                      message: 'La cédula no debe tener mas de 8 numeros'
//                  }                 
//              }
//          },
//         fecha_ingreso: {
//              validators: {
//                  notEmpty: { // No puede ser vacio
//                      message: 'Debe introducir una fecha de ingreso en el ministerio.'
//                  }               
//              }
//          },
//         estado: {
//              validators: {
//                  notEmpty: { // No puede ser vacio
//                      message: 'Por favor seleccione un estado.'
//                  }               
//              }
//          },
//         direccion: {
//              validators: {
//                  notEmpty: { // No puede ser vacio
//                      message: 'Por favor seleccione una parroquia.'
//                  }               
//              }
//          },
//         ubicacion: {
//              validators: {
//                  notEmpty: { // No puede ser vacio
//                      message: 'Debe introducir una ubicación.'
//                  }               
//              }
//          }                   

// }
// });
$('#infoExtra').formValidation({
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
                     message: 'El primer nombre es rasdasdasasequerido.'
                 },
                 regexp: { // Solo estos caracteres pueden ser usados
                     regexp: /^[ABCDEFGHIJKLMNÑOPQRSTUVWXYZabcdefghijklmnñopqrstuvwxyz]+$/,
                     message: 'El nombre solo puede contener letras.'
                 }
             }
         },
          nombre2: {
             validators: {
                 regexp: { // Solo estos caracteres pueden ser usados
                     regexp: /^[ABCDEFGHIJKLMNÑOPQRSTUVWXYZabcdefghijklmnñopqrstuvwxyz]+$/,
                     message: 'El nombre solo puede contener letras.'
                 }
             }
         },
         apellido: {
             validators: {
                  notEmpty: { // No puede ser vacio
                     message: 'El primer apellido es requerido.'
                 },
                 regexp: { // Solo estos caracteres pueden ser usados
                     regexp: /^[ABCDEFGHIJKLMNÑOPQRSTUVWXYZabcdefghijklmnñopqrstuvwxyz]+$/,
                     message: 'El apellido solo puede contener letras.'
                 }
             }
         },
          apellido2: {
             validators: {
                 regexp: { // Solo estos caracteres pueden ser usados
                     regexp: /^[ABCDEFGHIJKLMNÑOPQRSTUVWXYZabcdefghijklmnñopqrstuvwxyz]+$/,
                     message: 'El apellido solo puede contener letras.'
                 }
             }
         },
        sexo: {
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
          cedula: {
             validators: {
                 regexp: { // Solo estos caracteres pueden ser usados
                     regexp: /^[0-9]+$/,
                     message: 'La cedula solo puede contener numeros.'
                 },
                 stringLength: {
                     max: 8,
                     message: 'La cédula no debe tener mas de 8 numeros'
                 }                 
             }
         }
}
});

$('#my-wizard')
.ace_wizard({
  //step: 2 //optional argument. wizard will jump to step "2" at first
  //buttons: '.my-action-buttons' //which is possibly located somewhere else and is not a sibling of wizard
})
.on('actionclicked.fu.wizard' , function(e, data) {
         
   //info.direction
   
   //use e.preventDefault to cancel
 
    var fv=$('#registro_persona').data('formValidation'), //Instancia del validador

    step=data.step, //Paso en el que nos encontramos

    // El contenedor en el que se encuentra el form
    $container = $('#registro_persona').find('.step-pane[data-step="' + step +'"]');

     // Validate the container
     fv.validateContainer($container);
      var isValidStep = fv.isValidContainer($container);
      
      if (isValidStep === false || isValidStep === null) {
        e.preventDefault();
    }else{
         send_registro_persona();
         showElementos('modificarDatos');
         send_consulta_info();
     }
})
.on('changed.fu.wizard', function() {

  
})
.on('finished.fu.wizard', function(e) {
   send_registro_InfoAdicional();

}).on('stepclick.fu.wizard', function(e) {

   //e.preventDefault();//this will prevent clicking and selecting steps
});

function show(idObj, effectType, time){//effectType can be:'blind','bounce','clip','drop','explode','fold','highlight','puff','pulsate','scale','shake','size' ó 'slide'
    if (effectType=='slow' || IsNumeric(effectType))//The function 'IsNumeric' are in FDSoil/js/numero.js
        $( "#"+idObj ).fadeIn(effectType);     
    else{
        var options = {};// most effect types need no options passed by default
        if (effectType=='scale')
            options = { percent: 0 };        
        else if (effectType=='size')
            options = { to: { width: 200, height: 60 }};        
        $( "#"+idObj ).show( effectType, options, time); 
    }
}

function hide(idObj, effectType, time){//effectType can be:'blind','bounce','clip','drop','explode','fold','highlight','puff','pulsate','scale','shake','size' ó 'slide'
    if (effectType=='slow' || IsNumeric(effectType))//The function 'IsNumeric' are in FDSoil/js/numero.js
        $( "#"+idObj ).fadeOut(effectType);     
    else{
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
