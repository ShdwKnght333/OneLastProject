// Get the modal
var modal = document.getElementById('id01');
var social_login = document.getElementById('id02');
var user_login = document.getElementById('id03');
var user_register = document.getElementById('id04');
var user_forget = document.getElementById('id05');
// When the user clicks anywhere outside of the modal, close it
	window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

function logindisplay(){
	document.getElementById('id03').style.display='block';
	document.getElementById('id02').style.display='none';
	document.getElementById('header_titles').innerHTML="Login";
}
function registerdisplay(){
	document.getElementById('id04').style.display='block';
	document.getElementById('id02').style.display='none';
	document.getElementById('header_titles').innerHTML="Register";
}
function forgetdisplay(){
	document.getElementById('id05').style.display='block';
	document.getElementById('id03').style.display='none';
	document.getElementById('header_titles').innerHTML="Forget Password";
}
function yoback(){
	document.getElementById('id02').style.display='block';
	document.getElementById('id03').style.display='none';
	document.getElementById('id04').style.display='none';
	document.getElementById('id05').style.display='none';
	document.getElementById('header_titles').innerHTML="Login to Foodzoned";
}

