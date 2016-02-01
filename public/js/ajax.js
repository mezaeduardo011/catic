/** Construye un objeto Ajax.
* @return objetoAjax (object) Devuelve un objeto Ajax.*/
function createAjax(){
    var objetoAjax=false;
    try {        
        objetoAjax = new ActiveXObject("Msxml2.XMLHTTP");/*Para navegadores distintos a internet explorer*/
    } 
    catch (e) {
        try {            
            objetoAjax = new ActiveXObject("Microsoft.XMLHTTP");/*Para explorer*/
        }
        catch (E) {
            objetoAjax = false;
        }
    }
    if (!objetoAjax && typeof XMLHttpRequest!='undefined') 
        objetoAjax = new XMLHttpRequest();    
    return objetoAjax;
}

/** Envia y ejecuta el objeto Ajax.
* @param metodo (string) Indica el método bien sea GET o POST.
* @param paginaMasArgumento (string) Indica la ruta + el archivo (+ los valores si el método es GET).
* @param funcionResponse (string) Nombre de la función donde será devuelta la respuesta del llamado Ajax.
* @param valores (string) Valores si el método es POST.
* @param capaContenedora (string) Identificador del elemento contenedor donde mostrará un mensaje de espera.
* @param isObj (string) Si este valor es TRUE indica que la respuesta será un objeto JSON.
* @return null*/
function send_ajax( metodo, paginaMasArgumento, funcionResponse, valores, capaContenedora, isObj  ){//var jsonObj = JSON.parse(ajax.responseText); alert(jsonObj.empresas); 
 var ajax=createAjax();	
    ajax.open (metodo, paginaMasArgumento , true);
    ajax.onreadystatechange = function(){
        if (ajax.readyState==1 && capaContenedora !=null){ 
		var node="Cargando...<IMG src='../../../"+appOrg+"/img/loading.gif' border='0'>";
                document.getElementById(capaContenedora).innerHTML=node;
	}        
        else if (ajax.readyState==4){
            if (capaContenedora !=null)
                document.getElementById(capaContenedora).innerHTML="";
            if(ajax.status==200 &&  ajax.responseText!='')		
		if (isObj==null)
                	eval(funcionResponse+'("'+ajax.responseText.replace(/^\s*|\s*$/g,"")+'");');		            
		else if(isObj==true){//alert(ajax.responseText);
			eval(funcionResponse+'('+ajax.responseText+');');		
		}	
            else if(ajax.status==404)
                alert("La direccion no existe");            
            else if(ajax.responseText=='')
                alert('La petición no generó respuesta...'+ajax.status);            
            else
                alert("Error: "+ajax.status);            
        }
    }
    ajax.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    ajax.send(valores);
    return;
}

/** Construye lista de valores que serán enviados por ajax 
* a partir de los elementos de captura de datos que hay en un elemento contenedor.
* @param oContainer (object) Objeto contenedor de los elementos de captura de datos.
* @return resp (string) Cadena de caracteres representando la lista de valores que serán enviados por ajax.*/
function request(oContainer){
	var resp='';
	var objsInput=oContainer.getElementsByTagName("input");
	var objsRadioCheck=[];	
	var k=0;
	for(i=0;i<objsInput.length;i++)
	    	if (objsInput[i].getAttribute('type')!='button' && objsInput[i].getAttribute('type')!='submit' && 
		objsInput[i].getAttribute('type')!='radio' && objsInput[i].getAttribute('type')!='checkbox' && 
		objsInput[i].disabled==false)
			resp+=objsInput[i].name+'='+objsInput[i].value+'&';		
		else if (objsInput[i].getAttribute('type')=='radio' || objsInput[i].getAttribute('type')=='checkbox')
			objsRadioCheck[k++]=objsInput[i];	
	if (objsRadioCheck.length>0){
		var key=0;
		var keyAux=0;
		var strRadioCheckName=objsRadioCheck[0].name;		
		var mObjsRadioCheck=[];
        	mObjsRadioCheck[key]=[];
		mObjsRadioCheck[key][keyAux++]=objsRadioCheck[0];
		for(i=1;i<objsRadioCheck.length;i++)
			if (strRadioCheckName==objsRadioCheck[i].name){			
				while (strRadioCheckName==objsRadioCheck[i].name){
					mObjsRadioCheck[key][keyAux++]=objsRadioCheck[i++];
					if (i==objsRadioCheck.length)
						break;				
				}
				if (i==objsRadioCheck.length)
					break;										
				else{
					strRadioCheckName=objsRadioCheck[i--].name;
					keyAux=0;
					mObjsRadioCheck[++key]=[];
				}				
			}
			else{
				strRadioCheckName=objsRadioCheck[i--].name;
				keyAux=0;
				mObjsRadioCheck[++key]=[];
			}		
		for(i=0;i<mObjsRadioCheck.length;i++)
			for(j=0;j<mObjsRadioCheck[i].length;j++)
				if (mObjsRadioCheck[i][j].checked)
					resp+=mObjsRadioCheck[i][j].name+'='+mObjsRadioCheck[i][j].value+'&';
	}
	var objsSelect=oContainer.getElementsByTagName("select");
	for(i=0;i<objsSelect.length;i++)  
		if (objsInput[i].disabled==false)
			resp+=objsSelect[i].name+'='+objsSelect[i].value+'&';
	var objsTextArea=oContainer.getElementsByTagName("textarea");
	for(i=0;i<objsTextArea.length;i++)  
		if (objsInput[i].disabled==false)
			resp+=objsTextArea[i].name+'='+objsTextArea[i].value+'&';
	return resp.substring(0,resp.length-1);
}

/*function sendAjaxJQuery(pagina, metodo, data){
    $.ajax({
       
        url:pagina, //Url a donde la enviaremos
        type:metodo, //Metodo que usaremos
        contentType:false, //Debe estar en false para que pase el objeto sin procesar
        data:data, //Le pasamos el objeto que creamos con los archivos
        processData:false, //Debe estar en false para que JQuery no procese los datos a enviar
        cache:false //Para que el formulario no guarde cache
    }).done(function(msg){ 
        if(msg =='No se pudo cargar el archivo'){
            alert('Error: No se pudo cargar el archivo. Intente nuevamente.');
        }else if(msg =='formato invalido'){
            alert('Error: Formato invalido. debe cargar el archivo en formato pdf');
        }else{
            document.getElementById('id_subir_archivo').style.display='none';
        }
        $("#cargado").append(msg); //Mostrara los archivos cargados en el div con el id "Cargados"
    });
    
}*/
