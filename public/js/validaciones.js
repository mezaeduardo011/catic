//esto captura el ID del formulario al cual se le aplicaran las validaciones.
//dichas validaciones son al campo por nombre 
$('#registro_persona').bootstrapValidator({
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
//esto captura el ID del formulario al cual se le aplicaran las validaciones.
//dichas validaciones son al campo por nombre 
$('#registro_hijo').bootstrapValidator({
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
