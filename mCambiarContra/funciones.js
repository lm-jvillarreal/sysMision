function validar(pass, pass_conf) {
    if (pass_conf == pass) {
        document.getElementById('pass_conf').style.background = '#2ecc71';
    }
    else{
    	document.getElementById('pass_conf').style.background = '#e74c3c';
    	$("#btn-guardar").prop("readonly",true);
    }
}