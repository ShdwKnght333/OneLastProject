<?php
if ($_SESSION['restarea']!="Active") {
    echo "<script>document.location.href='login.php'</script>";
    exit;
}
?>