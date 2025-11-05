<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo (isset($pageTitle)) ? $pageTitle : 'Primjer CMS-a'; ?></title>
    <!--[if IE]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <script src="js/custom-jquery.js"></script>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/fonts/fonts.css">
    <link rel="stylesheet" href="css/main.css">
    <!--[if lt IE 8]>
    <link rel="stylesheet" href="css/ie6-7.css">
    <![endif]-->
</head>
<!-- # header.inc.php -->
<body>
    <header>
        <h1>Primjer CMS-a<span>napravite vlastiti blog</span></h1>
        <nav>
            <ul>
                <li><a href="index.php">Naslovnica</a></li><li><a href="#">Arhiva</a></li><li><a href="contact.php">Kontakt</a></li><li><?php if ($user) { echo '<a href="logout.php">Logout</a>'; } else { echo '<a href="login.php">Login</a>'; } ?></li><li><a href="#">Registracija</a></li>
            </ul>
        </nav>
    </header>