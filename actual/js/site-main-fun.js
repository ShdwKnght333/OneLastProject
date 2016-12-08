function go(url) {
	window.location=url;
}


function show(id) {
	$("#"+id).show();
}


function hide(id) {
	$("#"+id).hide();
}



function focus(id) {
	$("#"+id).focus();
}

function disable(id) {
	$("#"+id).attr('disabled', true);
}

function enable(id) {
	$("#"+id).attr('disabled', false);
}

function blink(id) {
	$('#'+id).animate({backgroundColor:'#fed'}, 500);
	$('#'+id).animate({backgroundColor:'#ffffff'}, 750);
	//$('#tr_'+id).animate({opacity: 0.2 }, 500);	
}



function post(form) {
	$.ajax({
		type: 'POST',
		url: 'conf/post.php',
		data: $('#'+form).serialize(),
		success: function(result) {
			$('#result').html(result);
		}
	});
	return false;
}

function post_admin(form) {
	$.ajax({
		type: 'POST',
		url: '../conf/post_admin.php',
		data: $('#'+form).serialize(),
		success: function(result) {
			$('#result').html(result);
		}
	});
	return false;
}


function loading(id,val) {
	if (val==1) {
		$('#'+id).html('<img src="img/loading.gif" style="margin:0;padding:0;" />');
	} else {
		$('#'+id).html('');
	}
}

function loading_bar(id,val) {
	if (val==1) {
		$('#'+id).html('<img src="img/loading2.gif" alt="Loading" style="margin:0;padding:0px;margin-top:15px;" />');
	} else {
		$('#'+id).html('');
	}
}

function loading_order(id,val) {
	if (val==1) {
		$('#'+id).html('<script> $(document).ready(function() { $(".overlay").fadeToggle("fast"); }); </script><div class="overlay" style="display: none;"><div class="login-wrapper"><div class="login-content"><h1>Processing your order...</h1><center>(Please do not press <b>Refresh</b> or <b>Back</b> button)</small><br/></div></div></div>');
	} else {
		$('#'+id).html('');
	}
}

/*
$.post("../conf/post.php", { cmd: "add_cart", id: id }, 
        function(data) {
		$("#alert").html(data);
});
*/