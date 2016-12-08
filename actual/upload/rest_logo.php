<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>image</title>

<script language="JavaScript" type="text/javascript">

	
	function fileCheck(id){
		var src = document.getElementById(id).value;
		var goodExt = /[^/].(?:jpg)/i;
		if(src.match(goodExt)){
			return true;
		}else{
			alert('Please select JPG images.');
			return false;
		}
	}
	
	function switchWiev(show,hide){
		document.getElementById(show).style.display = '';
		document.getElementById(hide).style.display = 'none';
	}
	
	function submitform() {
		document.photo_form.submit();
	}

	
</script>
	
<style>
h1 {
	font-size: 14px;
	color: red;
	font-family: Arial;
}
</style>	
	
</head>

<body bgcolor="#FFFFFF" text="#000000" topmargin="0" leftmargin="0">


<?
define ("MAX_SIZE","200"); 

function getExtension($str) {
         $i = strrpos($str,".");
         if (!$i) { return ""; }
         $l = strlen($str) - $i;
         $ext = substr($str,$i+1,$l);
         return $ext;
}


if ($_FILES['image']['name']!="") {
	$image=$_FILES['image']['name'];
	

 	if ($image) 
 	{
 		$filename = stripslashes($_FILES['image']['name']);
  		$extension = getExtension($filename);
 		$extension = strtolower($extension);
 		
 		//eğer daha öncedne yüklenmiş varsa temizle
 		$img="tmp/".$_REQUEST['id'].'.jpg';
 		if (file_exists($img)) unlink($img);
 		$img="tmp/".$_REQUEST['id'].'.gif';
 		if (file_exists($img)) unlink($img);
 		$img="tmp/".$_REQUEST['id'].'.png';
 		if (file_exists($img)) unlink($img);
 		

 	if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif")) 
 		{
 			echo '<h1>Wrong format!</h1>';
 			$errors=1;
 		}
 		else
 		{
	 	$size=filesize($_FILES['image']['tmp_name']);

	if ($size > MAX_SIZE*1024)
	{
		echo '<h1>Image max. size must 300kb!</h1>';		
		$errors=1;
	}
	
	
	
	//$sizes = getimagesize($_FILES['image']['tmp_name']);

	//$imagesizes=$sizes[0]."x".$sizes[1];

	
	$image_name=$_REQUEST['id'].'.jpg';
	$newname="../logos/".$image_name;
	if ($errors==0) {
		$copied = copy($_FILES['image']['tmp_name'], $newname);
				if (!$copied) 
				{
				echo '<h1>Upload error</h1>';
				$errors=1;
				}
			}
		}
	}
	
	if ($errors>0) {
		echo "<script>window.setTimeout('changeurl();',1000); function changeurl(){window.location='".$_SERVER["PHP_SELF"]."?id=".$_REQUEST['id']."'}</script>";
		exit;
	} else {
		chmod($newname, 0777);
		
		$source=$newname;
		$thumb_size = 100;

		$size = getimagesize($source);
		$width = $size[0];
		$height = $size[1];
	
	
		$new_im = ImageCreatetruecolor(200,150);
		$im = imagecreatefromjpeg($source);
		imagecopyresampled($new_im,$im,0,0,$x,$y,200,150,$width,$height);
		imagejpeg($new_im,$newname,100);	
		//imagejpeg($new_im,null,100); //Direk resmi basar
		
		
		echo '<h1 style="color:green;margin:0;padding:0;">Image uploaded</h1>';
		echo "<script>
		parent.document.getElementById('rest_logo').src = '../logos/".$image_name."?id=".time()."';
		</script>";
	}
			
	
}


?>

<div id="imageform">
<form name="photo_form" id="photo_form" action="<?=$_SERVER["PHP_SELF"]?>" enctype="multipart/form-data" method="post" onsubmit="switchWiev('dialog','imageform');">
<input type="hidden" name="id" id="id" value="<?=$_REQUEST['id']?>">
<font face="Arial" size="2">
<input type="file" name="image" id="image"  accept="image/jpeg" onchange="if(fileCheck(this.id)==true){  switchWiev('dialog','imageform');  submitform();}" ><br /> Image formats: .jpg (max. 300kb.) width:200px  height:150px
</font>
</form>
</div>

<div id="dialog" style="display:none;height:100%;vertical-align:middle;">
<img src="../img/loading.gif" align="middle" alt="" />
</div>

</body>
</html>
