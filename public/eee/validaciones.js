//esto captura el ID del formulario al cual se le aplicaran las validaciones.
//dichas validaciones son al campo por nombre 
$('#registro_persona').bootstrapValidator({
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
		 }	  		 
}

});
