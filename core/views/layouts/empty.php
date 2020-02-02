<?php

?>
<head>
    <link rel="icon" type="image/png" href="/favicon.png" />
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?=$this->title?></title>

    <!-- Bootstrap core CSS -->
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="/assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">

    <!-- Custom styles -->
    <link href="/assets/css/style.css" rel="stylesheet">

    <!-- Bootstrap core JavaScript -->
    <script src="/assets/js/jquery-3.4.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="/assets/js/bootstrap.min.js"></script>

    <!--custom page JavaScript -->
    <?php foreach ($this->js as $js) { ?>
        <script src="/assets/js/<?=$js?>"></script>
    <?php } ?>

    <!--custom page CSS -->
    <?php foreach ($this->css as $css) { ?>
        <link href="/assets/css/<?=$css?>" rel="stylesheet">
    <?php } ?>



</head>
<body>
<div class="container">
    <?php include $this->basePath.$tplName.'.php' ?>
</div>
</body>
<!-- Footer -->
<?php require_once 'footer.php'?>

