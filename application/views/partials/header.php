<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Product Dashboard">
    <meta name="author" content="Phil Russel Dela Cruz">
    <!-- Bootstrap 5.1.3 -->
    <link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?=base_url();?>assets/css/style.css">
    <script src="<?=base_url()?>assets/js/bootstrap.bundle.min.js"></script>
    <script src="<?=base_url()?>assets/js/jquery.min.js"></script>
    <title>Product Dashboard</title>
</head>
<body>
    <nav class="navbar col-10 offset-1 navbar-expand-md navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?=base_url()?>">V88 Merchandise</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
<?php           if ($this->session->userdata('user_id'))
                {
?>                  <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="<?=base_url().'dashboard'?>">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?=base_url().'users/edit'?>">Profile</a>
                    </li>
<?php           }
?>
                </ul>
                <div class="d-flex">
                    <a href="<?= !isset($link) ? base_url().'logout' : base_url().$link ?>"><?= !isset($link) ? "Log Out" : ucfirst($link) ?></a>
                </div>
            </div>
        </div>
    </nav>
    