<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>跨域POST消息发送</title>

</head>

<body>

<textarea id="message"></textarea>
<input type="button" value="发送" onclick="sendPost()">

<{$id}>

<iframe src="http://m.9939.com/temp.html" id="otherPage" style="display:none"></iframe>


<script type="text/JavaScript">
function sendPost(){
var iframeWin = document.getElementById("otherPage").contentWindow;
iframeWin.postMessage( document.getElementById("message").value, "http://m.9939.com");
}

</script>

</body>
</html>
