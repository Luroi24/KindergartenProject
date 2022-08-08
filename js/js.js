const prevBtns = document.querySelectorAll(".btn-prev");
const nextBtns = document.querySelectorAll(".btn-nxt");
const progress = document.getElementById("progress");
const formSteps = document.querySelectorAll(".form-step");
const progressSteps = document.querySelectorAll(".progress-step");
const hasPartner = document.getElementById("der_cony_no");

let formStepsNum = 0;

nextBtns.forEach(btn =>{
	btn.addEventListener("click", () => {
		if(!checkVal()){
			if(formStepsNum == 2 && hasPartner.checked == true){
				formStepsNum+=2;
			}else{
				formStepsNum++;
			}
			updateFormsSteps();
			updateProgressBar();
		}
	});
});

prevBtns.forEach(btn =>{
	btn.addEventListener("click", () => {
		if(formStepsNum == 4 && hasPartner.checked == true){
			formStepsNum-=2;
		}else{
			formStepsNum--;
		}
		updateFormsSteps();
		updateProgressBar();
	});
});

function checkVal(){
	let errors = 0;
	let campos = document.querySelectorAll(".form-step-active .needs-validation");
	const regExTxt = /^[a-zA-ZÀ-ÿ\u00f1\u00d1\s]*$/;
	const regExFol = /(?:P[PE]|\d\d)\d\d\d\d\d\d\d\d/i;
	const regExCURP = /[A-Z][A-Z][A-Z][A-Z]\d\d\d\d\d\d[A-Z][A-Z][A-Z][zA-Z][A-Z][A-Z][A-Z0-9][A-Z0-9]/gi;
	for( i = 0; i < campos.length ; i++){
		campos[i].classList.contains("is-invalid") && campos[i].classList.remove("is-invalid");
		if(campos[i].id.endsWith("pat") || campos[i].id.endsWith("mat") || campos[i].id.endsWith("nombres") || campos[i].id.endsWith("calle") || campos[i].id.endsWith("plaza")){
			if(!regExTxt.test(campos[i].value)){
				campos[i].classList.add("is-invalid");
				errors++;
			}
		}
		else if(campos[i].id == "folio"){
			const invFol = document.getElementById("inv-fol");
			if(campos[i].value.length < 10 || !regExFol.test(campos[i].value)){
				campos[i].classList.add("is-invalid");
				invFol.innerHTML = "Debe de tener 10 dígitos. Puede comenzar por 'PE' o 'PP'";
				errors++;
			}else if(checkFolio(campos[i].value)){
				campos[i].classList.add("is-invalid");
				invFol.innerHTML = "El folio introducido ya ha sido registrado";
				errors++;
			}
		}
		else if(campos[i].id.endsWith("CURP")){
			if(campos[i].value.length < 18 || !regExCURP.test(campos[i].value)){
				campos[i].classList.add("is-invalid");
				errors++;
			}
		}
		else if(campos[i].id == "grupo"){
			const valTxtGroup = document.getElementById("group-val");
			if(!checkAvailability()){
				campos[i].classList.add("is-invalid");
				valTxtGroup.innerHTML = "No hay suficientes lugares en este grupo"
				errors++;
			}
		}
		else if(campos[i].type == "number"){
			if(campos[i].value < 0){
				campos[i].classList.add("is-invalid");
				errors++;
			}
		}
		else if(campos[i].id == "kid_age"){
			const ageMonths = document.getElementById("kid_age_months");
			if((ageMonths.value < 6 && campos[i].value==0) || (campos[i].value > 6 || campos[i].value < 0)){
				ageMonths.classList.add("is-invalid");
				campos[i].classList.add("is-invalid");
				document.getElementById("invalid-age").style.display = "block";
				errors++;
			}
			else{
				document.getElementById("invalid-age").style.display = "none";
				ageMonths.classList.remove("is-invalid");
			}
		}
		if(!campos[i].checkValidity()){
			if(campos[i].id == "resp_img"){
				if(!document.getElementById("resp_hide").classList.contains("d-none")){
					campos[i].classList.add("is-invalid");
					errors++;
				}
			}
			else{
				campos[i].classList.add("is-invalid");
				errors++;
			}
		}
	}
	return errors;
}

function updateFormsSteps(){
	const revision = document.getElementById("revision");
	const btnsgroup = document.querySelectorAll(".btns-group.remove-on-check");
	const inputs = document.querySelectorAll(".form-control:not(#kid_age,#kid_age_months),.form-select");
	const btns_revision = document.getElementById("btns-revision");
	const hide_on_revision = document.querySelectorAll(".hide-on-revision");

	formSteps.forEach(formStep =>{
		formStep.classList.contains("form-step-active") &&
		formStep.classList.remove("form-step-active");
	});
	// Parte de la revision de información
	if(formStepsNum == 4){
		revision.classList.remove("d-none");
		btns_revision.classList.remove("d-none");
		formSteps.forEach(formStep =>{
			formStep.classList.add("form-step-active");
		});
		if(hasPartner.checked == true){
			document.getElementById("conyuge").classList.remove("form-step-active");
		}
		hide_on_revision.forEach(hide_on_revision =>{
			hide_on_revision.classList.add("d-none");
		});
		btnsgroup.forEach(btnsgroup =>{
			btnsgroup.classList.add("d-none");
		});
		inputs.forEach(inputs =>{
			inputs.setAttribute('disabled','');
		});
	}
	// Avance del formulario normalmente
	else{
		revision.classList.add("d-none");
		btns_revision.classList.add("d-none");
		hide_on_revision.forEach(hide_on_revision =>{
			hide_on_revision.classList.remove("d-none");
		});
		btnsgroup.forEach(btnsgroup =>{
			btnsgroup.classList.remove("d-none");
		});
		inputs.forEach(inputs =>{
			inputs.removeAttribute('disabled');
		});
		formSteps[formStepsNum].classList.add("form-step-active");
	}
}

function updateProgressBar(){
	progressSteps.forEach((progressSteps,idx)=>{
		if(idx <= formStepsNum){
			progressSteps.classList.add("progress-step-active");
		}
		else{
			progressSteps.classList.remove("progress-step-active");
		}
	});
	
	const progressActive = document.querySelectorAll(".progress-step-active");
	progress.style.width = ((progressActive.length - 1)/(progressSteps.length - 1)*100 + "%");
}

document.getElementsByTagName("form")[0].onkeypress = function(e) {
    var key = e.charCode || e.keyCode || 0;     
    if (key == 13) {
      e.preventDefault();
    }
  }

/* Funciones de cálculo automático */

function calcularEdad() {
  	const dateOfBirth = new Date(document.getElementById('kid_birthday').value); 
	const date = dateOfBirth.getTime();
	var month = dateOfBirth.getMonth();
	var currMonth = new Date().getMonth();
  	const now = new Date().getTime();
  	var age = Math.floor((now - date ) / (1000 * 60 * 60 * 24 * 365.25));
    (document.getElementById('kid_age')).value = age;
	if( currMonth >= month){
		(document.getElementById('kid_age_months')).value = currMonth - month;
	} else{
		(document.getElementById('kid_age_months')).value = 12 + currMonth - month;
	}
}

/* Image related JS */

const inpFile = document.querySelectorAll(".inpFile");
const previewContainer = document.querySelectorAll(".image-preview");

inpFile.forEach(inpFile=>{
	inpFile.addEventListener("change", function(){
	   const file = this.files[0];
	   const clsImg = this.nextElementSibling.firstElementChild;
	   const clsTxt = this.nextElementSibling.firstElementChild.nextElementSibling;
		if(file){
			const reader = new FileReader();
			clsTxt.style.display="none";
			clsImg.style.display = "block";

			reader.addEventListener("load",function(){
				clsImg.setAttribute("src",this.result);
			});
			reader.readAsDataURL(file);
	}else{
			clsTxt.style.display=null;
			clsImg.style.display = null;
			clsImg.setAttribute("src","")
		}
	});
});

function showResponsible() {
	const respAct = document.getElementById("resp_hide");
	if(document.getElementById('der_resp_si').checked){
		respAct.classList.remove("d-none");
	}else{
		respAct.classList.add("d-none");
	}
}

// Code related to folio and availability validation

function checkFolio(folio) {
	var flag = false;
	$.ajax({
		url:"php/infoValidate.php", // RECUPERA EL PHP DESDE DONDE ESTÉ EL HTML.
		method: "POST",
		data: {folio:folio,valid:'1'},
		async: false, 

		success:function(respAX){
			if(respAX=='0'){  // No existe el folio
			}else{ // Existe el folio
				flag = true;
			}
		}
	});
	return flag;
}

const chosenGroup = document.getElementById("grupo");
chosenGroup.onchange = checkAvailability;

function checkAvailability(){
	flag = true;
	$.ajax({
		url:"php/infoValidate.php",
		method: "POST",
		data: {group:chosenGroup.value,valid:'2'}, 
		async: false,

		success:function(respAX){
			if(respAX == 0 ) flag = false;
		}
	});
	return flag;
}

const subButton = document.getElementById("subButton");

subButton.onclick = submitImages;
function submitImages(){
	const folio = document.getElementById("folio");
	var fd1 = new FormData();
	var fd2 = new FormData();
	var fd3 = new FormData();
	var fd4 = new FormData();

	var files1 = $('#kid_img')[0].files[0];
	var files2 = $('#der_img')[0].files[0];
	var files3 = $('#resp_img')[0].files[0];
	var files4 = $('#cony_img')[0].files[0];

	fd1.append('file',files1);
	fd2.append('file',files2);
	fd3.append('file',files3);
	fd4.append('file',files4);

	var fd;
	for(i = 0; i < 4; i++){
		if(i==0){ fd = fd1; }
		else if(i==1) {fd = fd2; }
		else if(i==2) {fd = fd3; }
		else {fd = fd4; }
		var nombre = folio.value+"_"+i;
		fd.append('nom',nombre);
		$.ajax({
			url:"php/sendImages.php",
			type: "POST",
			data: fd,
			contentType:false,
			processData:false,

			success:function(resAX){
				if(resAX == 0){
					alert("Hubo un error con las fotografias");
				}
			}

		});
	}

	decrementAvailability();
}

function decrementAvailability(){
	$.ajax({
		url:"php/infoValidate.php",
		method: "POST",
		data: {group:chosenGroup.value,valid:3}, 
		async: false,

		success:function(respAX){
			if(respAX == 0 ) flag = false;
		}
	});
}