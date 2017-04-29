$(document).ready(function () {
    var rejestr = document.getElementById('rejestracja');
	rejestr.onclick = formView;
	var formRejCheck = document.getElementById('form-rej');
	formRejCheck.onsubmit = checkForm;
});

function checkForm () {
	var loginRej = document.getElementById("rej-login-i");
	if (!loginRej.value){
		loginRej.style.border = "1px solid red";
		loginRej.focus();
 		$("#header").after("<div class='err'>Pole Login nie może być puste!</div>");
        $('.err').click(rmErr);
		return false;
	} else {loginRej.style.border = "1px solid green";}

	var emailRej = document.getElementById("rej-email-i");
	if (!emailRej.value){
		emailRej.style.border = "1px solid red";
		emailRej.focus();
		$("#header").after("<div class='err'>Pole Email nie może być puste!</div>");
        $('.err').click(rmErr);
		return false;
	}else {emailRej.style.border = "1px solid green";}

	var password = document.getElementById("rej-haslo-i");
	var repPassword = document.getElementById("rej-haslo-rep-i");
	if (password.value.length < 6){
		$("#header").after("<div class='err'>Pole Hasło jest za krótkie (minimalna ilość znaków to 6).</div>");
        $('.err').click(rmErr);
		password.value = "";
		repPassword.value = "";
		password.style.border = "1px solid red";
		password.focus();
		return false;
	}

	if (password.value != repPassword.value){
		$("#header").after("<div class='err'>Powtórz hasło, musi być powtórzony dokładnie!</div>");
        $('.err').click(rmErr);
		password.value = "";
		repPassword.value = "";
		password.style.border = "1px solid red";
		repPassword.style.border = "1px solid red";
		password.focus();
		return false;
	}
}

function formView () {
	var formLog = document.getElementById("form-log");
	var formRej = document.getElementById("form-rej");
	formLog.style.display = "none";
	formRej.style.display = "block";
}

function rmErr() {
    if($('.err').length)
        $('.err').remove();
}