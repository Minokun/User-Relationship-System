<?php  if (!defined("IS_INITPHP")) exit("Access Denied!");  /* INITPHP Version 1.0 ,Create on 2016-01-15 14:27:00, compiled from ../app/web/template/test/navigation.htm */ ?>


<!doctype html>

<html>

  <head>

    <meta charset="UTF-8">

    <title>Basic SSE Example</title>

  </head>

  <body>

    <pre id="x">Initializing...</pre>

    <script>

    var es = new EventSource("http://127.0.0.1/wzad/app.php?m=test&c=test&a=test");

    es.addEventListener("message", function(e){

      document.getElementById("x").innerHTML += "\n" + e.data;

      },false);

    </script>

  </body>

</html>

