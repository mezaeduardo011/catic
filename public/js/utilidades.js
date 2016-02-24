function showElementos(divName){
    hide(divName,0);
        show(divName, 1000);    
}

function hiddenElementos(divName){
    hide(divName,0);
}


  function letras(e) { // 1
  tecla = (document.all) ? e.keyCode : e.which; // 2
  if (tecla==8) return true; // 3
  if (tecla==9) return true; // 3
  if (tecla==11) return true; // 3
  patron = /[A-Za-zñÑ'áéíóúÁÉÍÓÚàèìòùÀÈÌÒÙâêîôûÂÊÎÔÛÑñäëïöüÄËÏÖÜ\s\t]/; // 4
  
  te = String.fromCharCode(tecla); // 5
  return patron.test(te); // 6
  } 
  function numeros(e) {
  k = (document.all) ? e.keyCode : e.which;
  if (k==8 || k==0) return true;
  patron = /\d/;
  n = String.fromCharCode(k);
  return patron.test(n);
  }

    function format(input)
{
var num = input.value.replace(/\./g,'');
if(!isNaN(num)){
num = num.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1.');
num = num.split('').reverse().join('').replace(/^[\.]/,'');
input.value = num;
}
  
else{ alert('Solo se permiten numeros');
input.value = input.value.replace(/[^\d\.]*/g,'');
}
}  
function borrarCheckbox(){
  for (i=0;i<document.registro_persona.elements.length;i++)
          if(document.registro_persona.elements[i].type == "checkbox"){
         document.registro_persona.elements[i].checked=0; 
      }
 }