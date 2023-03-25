<?php
    session_start();
    include('classes/CRUD.php');
    $crud = new CRUD;
?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Personal Portfolio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        <?php include('assets/css/styles.css') ?>
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand text-light fw-bolder" href="http://localhost/fidanportfolio/">FIDAN AGUSHI</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                <a class="nav-link text-light" href="./index.php">Home</a>
                </li>
                <li class="nav-item">
                <a class="nav-link text-light" href="./about.php">About</a>
                </li>
                <li class="nav-item">
                <a class="nav-link text-light" href="./events.php">Events</a>
                </li>
                <li class="nav-item">
                <a class="nav-link text-light" href="./projects.php">Projects</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-light" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        More
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="./skills.php">Skills</a></li>
                        <li><a class="dropdown-item" href="./education.php">Education</a></li>
                        <li><a class="dropdown-item" href="./experience.php">Experience</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-light" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Profile
                    </a>
                    <ul class="dropdown-menu">
                        <?php if(isset($_SESSION['is_loggedin']) && $_SESSION['is_loggedin'] == true): ?>
                            <li><a class="dropdown-item"  href="http://localhost/fidanportfolio/dashboard/">Dashboard</a></li>
                        <?php else: ?>
                            <li><a class="dropdown-item" href="./register.php">Register</a></li>
                            <li><a class="dropdown-item" href="./login.php">Login</a></li>
                        <?php endif; ?>
                    </ul>
                </li>
            </ul>
            </div>
        </div>
    </nav>