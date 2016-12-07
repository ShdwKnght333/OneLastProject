<?php
include "conf/config.php";

$langs_arr=array();
$getRss = mysql_query("SHOW COLUMNS FROM langs");
while ($rss = mysql_fetch_array($getRss)) {
    if ($rss['Field']!="id" && $rss['Field']!="name") {
        array_push($langs_arr,$rss['Field']);
    }
}
$lang=safe($_REQUEST['l']);
if (in_array($lang,$langs_arr)) {
    //@mysql_query("update options set option_value='".$lang."' where option_name='LANG_CODE'");
    $_SESSION['phpfood_lang']=$lang;
}
if (!$_SERVER['HTTP_REFERER']) $_SERVER['HTTP_REFERER']=SITEURL;
?>
<script>
window.location='<?php echo $_SERVER['HTTP_REFERER']?>';
</script>