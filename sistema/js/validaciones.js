
//========================================MARCA&CATEGORIA========================================
function enabletodomc(a) {
	var num;
	var dis;
	dis = a.value;
	num = a.id.substring(4);
	if (dis == "Editar") {
		a.value = "Cancelar";
		document.getElementById('save' + num).disabled = false;
		document.getElementById('nombre' + num).disabled = false;
		document.getElementById('bdele' + num).disabled = false;
	} else {
		a.value = "Editar";
		document.getElementById('save' + num).disabled = true;
		document.getElementById('nombre' + num).disabled = true;
		document.getElementById('bdele' + num).disabled = true;
	}
}
//========================================CLIENTES========================================
function enableliscli(a) {
	var num;
	var dis;
	dis = a.value;
	num = a.id.substring(4);
	if (dis == "Editar") {
		a.value = "Cancelar";
		document.getElementById('traux' + num).hidden = false;
		document.getElementById('save' + num).disabled = false;
		document.getElementById('nombre' + num).disabled = false;
		document.getElementById('apMaterno' + num).disabled = false;
		document.getElementById('apPaterno' + num).disabled = false;
		document.getElementById('bdele' + num).disabled = false;
		document.getElementById('telefono' + num).disabled = false;
		document.getElementById('direccion' + num).disabled = false;
		document.getElementById('ci' + num).disabled = false;
		document.getElementById('bdele' + num).hidden = false;
		document.getElementById('save' + num).hidden = false;
	} else {
		a.value = "Editar";
		document.getElementById('traux' + num).hidden = true;
		document.getElementById('save' + num).disabled = true;
		document.getElementById('nombre' + num).disabled = true;
		document.getElementById('apMaterno' + num).disabled = true;
		document.getElementById('apPaterno' + num).disabled = true;
		document.getElementById('bdele' + num).disabled = true;
		document.getElementById('telefono' + num).disabled = true;
		document.getElementById('direccion' + num).disabled = true;
		document.getElementById('ci' + num).disabled = true;
		document.getElementById('bdele' + num).hidden = true;
		document.getElementById('save' + num).hidden = true;
	}
}
//========================================USUARIOS========================================
function enablelisemp(a) {
	var num;
	var dis;
	dis = a.value;
	num = a.id.substring(4);
	if (dis == "Editar") {
		a.value = "Cancelar";
		document.getElementById('traux' + num).hidden = false;
		document.getElementById('save' + num).disabled = false;
		document.getElementById('nombre' + num).disabled = false;
		document.getElementById('apMaterno' + num).disabled = false;
		document.getElementById('apPaterno' + num).disabled = false;
		document.getElementById('bdele' + num).disabled = false;
		document.getElementById('telefono' + num).disabled = false;
		document.getElementById('direccion' + num).disabled = false;
		document.getElementById('ci' + num).disabled = false;
		document.getElementById('bdele' + num).hidden = false;
		document.getElementById('save' + num).hidden = false;
	} else {
		a.value = "Editar";
		document.getElementById('traux' + num).hidden = true;
		document.getElementById('save' + num).disabled = true;
		document.getElementById('nombre' + num).disabled = true;
		document.getElementById('apMaterno' + num).disabled = true;
		document.getElementById('apPaterno' + num).disabled = true;
		document.getElementById('bdele' + num).disabled = true;
		document.getElementById('telefono' + num).disabled = true;
		document.getElementById('direccion' + num).disabled = true;
		document.getElementById('ci' + num).disabled = true;
		document.getElementById('bdele' + num).hidden = true;
		document.getElementById('save' + num).hidden = true;
	}
}
//========================================PROVEEDORES========================================
function enablelispro(a) {
	var num;
	var dis;
	dis = a.value;
	num = a.id.substring(4);
	if (dis == "Editar") {
		a.value = "Cancelar";
		document.getElementById('save' + num).disabled = false;
		document.getElementById('nombre' + num).disabled = false;
		document.getElementById('direccion' + num).disabled = false;
		document.getElementById('bdele' + num).disabled = false;
	} else {
		a.value = "Editar";
		document.getElementById('save' + num).disabled = true;
		document.getElementById('nombre' + num).disabled = true;
		document.getElementById('direccion' + num).disabled = true;
		document.getElementById('bdele' + num).disabled = true;
	}
}
//BUSCADOR
function buscar_deshabilitados() {
	if (document.getElementById("opt_Unavailable").selected == true) {
		//Mensaje
		document.getElementById("h4_mensaje").hidden = true;
		//Disponible
		document.getElementById("tb_availables").style.display = 'none';
		document.getElementById("lbl_Available").hidden = true;
		//No disponible
		document.getElementById("tb_unavailables").style.display = 'contents';
		document.getElementById("lbl_Unavailable").hidden = false;
	}
	if (document.getElementById("opt_Available").selected == true) {
    //Mensaje
		document.getElementById("h4_mensaje").hidden = true;
		//Disponible
		document.getElementById("tb_availables").style.display = 'contents';
		document.getElementById("lbl_Available").hidden = false;
		//No Disponible	
		document.getElementById("tb_unavailables").style.display = 'none';
		document.getElementById("lbl_Unavailable").hidden = true;
	}
}
//FILTRO
function filtro(){
	if (document.getElementById("opt_Unavailable").selected == true) {
		//Disponible
		document.getElementById("tb_availables").hidden = true;
		document.getElementById("lbl_Available").hidden = true;	
		//No Disponible	
		document.getElementById("tb_unavailables").hidden = false;
		document.getElementById("lbl_Unavailable").hidden = false;
		//Titulos
		document.getElementById("lbl_des").hidden = true;
		document.getElementById("hr_des_sep").hidden = true;
		document.getElementById("lbl_hab").hidden = true;
		document.getElementById("hr_hab_sep").hidden = true;
	}
	if (document.getElementById("opt_Available").selected == true) {
		//Disponible
		document.getElementById("tb_availables").hidden = false;
		document.getElementById("lbl_Available").hidden = false;	
		//No Disponible	
		document.getElementById("tb_unavailables").hidden = true;
		document.getElementById("lbl_Unavailable").hidden = true;
		//Titulos
		document.getElementById("lbl_des").hidden = true;
		document.getElementById("hr_des_sep").hidden = true;
		document.getElementById("lbl_hab").hidden = true;
		document.getElementById("hr_hab_sep").hidden = true;
	}
}
//Controlando que no puedan insertar signos ni pegarlos
//M&CFormulario 
$('#mcform').keydown(function (e) {
	if (e.ctrlKey || e.altKey) {
		e.preventDefault();
		return false;
	}
});
$('#mcform').keypress(function (e) {
	if (e.ctrlKey || e.altKey) {
		e.preventDefault();
		return false;
	}
});
//Al principio solo lo ibamos a dejar para marca y categoria, pero bue, 
//que sea pa todas las tablas.
//M&CTabla
$('#mctable').keydown(function (e) {
	if (e.ctrlKey || e.altKey || e.keyCode == 13) {
		e.preventDefault();
		return false;
	}
});
$('#mctable').keypress(function (e) {
	if (e.ctrlKey || e.altKey || e.keyCode == 13) {
		e.preventDefault();
		return false;
	}
});
