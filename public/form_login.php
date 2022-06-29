<html>
<head>
    <title>huinya app 3</title>
</head>
<body>
<h1>huinya app 3</h1>
<form method="get">
    <label for="">login</label>
    <input name="login" />
    <label for="">pass</label>
    <input type="password" name="pass" />
    <input type="submit" />
</form>

</body>
</html>
<?php
if ($_GET['login'] == 'admin' && $_GET['pass'] == '123456') {
    $_SESSION['token'] = 'IrinaPerepelica';
}
