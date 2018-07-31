<?php

include 'head.php';
 ?>

 <title>Mail</title>
</head>
<body>
  <form class="" action="treatment.php" method="post">
    <label for="recipient">To</label>
    <br>
    <input type="text" name="recipient" value="" id="recipient">
    <br>
    <label for="sender">From</label>
    <br>
    <input type="text" name="sender" value="" id="sender">
    <br>
    <label for="password">Password</label>
    <br>
    <input type="password" name="password" value="" id="password">
    <br>
    <label for="subject">Subject</label>
    <br>
    <input type="text" name="subject" value="" id="subject">
    <br>
    <label for="message">your message test</label>
    <br>
    <textarea name="message" rows="8" cols="80" id="message"></textarea>
    <br>
    <input type="submit" name="submit" value="Send">
  </form>
</body>
</html>
