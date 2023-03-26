<?php 
    session_start(); 
    
    $personPages = [
        '/fidanportfolio/dashboard/index.php',
        '/fidanportfolio/dashboard/testimonials/index.php',
        '/fidanportfolio/dashboard/profile.php',
    ];
    $currentPage = $_SERVER['SCRIPT_NAME'];

    if(isset($_SESSION['is_loggedin']) && $_SESSION['is_loggedin'] == 1){
            if(isset($_SESSION['role']) && $_SESSION['role'] === 'person'){
                if(!in_array($currentPage, $personPages)){
                    die('You do not have permission to view this section!');
                }
            }
        }else{
            header('Location: http://localhost/fidanportfolio/errorPage.php');
        }

    if(isset($_GET['action']) && $_GET['action'] === 'logout'){
        unset($_SESSION['id']);
        unset($_SESSION['fullname']);
        unset($_SESSION['email']);
        unset($_SESSION['is_loggedin']);
        unset($_SESSION['role']);

        header('Location: http://localhost/fidanportfolio/');
    }

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
        <?php include('../assets/css/dashboard.css') ?>
        <?php include('../../assets/css/cards.css') ?>
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
                        <a class="nav-link text-light" href="http://localhost/fidanportfolio/dashboard/">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-light" href="http://localhost/fidanportfolio/dashboard/projects/">Projects</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-light" href="http://localhost/fidanportfolio/dashboard/events/">Events</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-light" href="http://localhost/fidanportfolio/dashboard/skills/">Skills</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-light" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            More
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="http://localhost/fidanportfolio/dashboard/testimonials/">Testimonials</a></li>
                            <li><a class="dropdown-item" href="http://localhost/fidanportfolio/dashboard/certificates/">Certificates</a></li>
                            <li><a class="dropdown-item" href="http://localhost/fidanportfolio/dashboard/education/">Education</a></li>
                            <li><a class="dropdown-item" href="http://localhost/fidanportfolio/dashboard/experience/">Experience</a></li>
                            <li><a class="dropdown-item" href="http://localhost/fidanportfolio/dashboard/hobbies/">Hobbies</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-light" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Other
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="http://localhost/fidanportfolio/">Portfolio</a></li>
                        <li><a class="dropdown-item" href="http://localhost/fidanportfolio/dashboard/profile.php">Profile</a></li>
                        <li><a class="dropdown-item" href="?action=logout">Sign Out</a></li>
                    </ul>
                </li>
                </ul>
            </div>
        </div>
    </nav>