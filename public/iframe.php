<?php
header("Content-type:text/html;charset=utf-8");
//得到参数
$userid = $_GET['userid'];
$username=$_GET['username'];
?>
<script>
    window.localStorage.removeItem("userid");
    window.localStorage.setItem("userid", '<?php echo $userid; ?>');
    window.localStorage.setItem("username", '<?php echo $username; ?>');
</script>