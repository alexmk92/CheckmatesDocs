<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Meta tags for mobile support -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <!-- Stylesheets, include Bootstrap first and then process override styles -->
    <link rel="stylesheet" type="text/css" href="./public/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="./public/css/main.css" />

    <!-- Include any scripts that the site will require to function... -->
    <script type="text/javascript" src="./public/lib/jquery-1.11.2.min.js"></script>
    <script type="text/javascript" src="./public/lib/bootstrap.min.js"></script>
    <script type="text/javascript" src="./public/lib/functions.js"></script>

    <title><?php echo empty($title) ? "CheckMates API Documentation" : $title; ?></title>
</head>

<body>
<section class="content-fluid">