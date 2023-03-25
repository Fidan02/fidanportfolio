<?php 
    ob_start();
    include('includes/header.php'); 
    // include('classes/CRUD.php');
    // $crud = new CRUD;
    $errors = [];
    $projects = $crud->read('projects', [], 4);
    $events = $crud->read('events');
    
    ob_end_flush();   
    
?>

<!-- Intro -->
<div class='container home-content my-5 row'>
    <div class="info col-xl-6 col-lg-6 col-md-6 col-sm-12">
        <div class="introduction">
        <h1>Welcome</h1>
        <h2>I am <span class="secondaryColor">Fidan</span></h2>
        <h2>I am a <span class="secondaryColor">Web Developer</span></h2>
        </div>
        <div class="links">
            <div class="link">
                <a href="https://github.com/Fidan02"><i class="fa-brands fa-github"></i></a>
            </div>
            <div class="link">
                <a href="https://www.linkedin.com/in/fidan-agushi-063a68217/"><i class="fa-brands fa-linkedin"></i></a>
            </div>
            <div class="link">
            <a href="https://twitter.com/FidanAgushi9"><i class="fa-brands fa-twitter"></i></a>
            </div>
        </div>
    </div>
    <div class="home-image col-xl-6 col-lg-6 col-md-6 col-sm-12">
        <img src="./assets/images/homepage_img.png" alt="Home Page IMG" class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
    </div>
</div>


<!-- Latest Projects -->

<div class="container latest-projects my-3">
    <div class="title">
        <h3>LATEST PROJECTS</h3>
        <div class="line"></div>
    </div>
    <div class="projects-container text-center">
        <?php if($projects && count($projects)): ?>
        <div class="projects container my-3">
            <?php foreach($projects as $project): ?>
                <div class="card p-0" style="width: 16rem;">
                    <img src="dashboard/projects/images/<?= $project['project_image'] ?>" class="card-img-top cardImgHeight" alt="<?= $project['project_title'] ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?= $project['project_title'] ?></h5>
                        <p class="card-text desc-scroll"><?= $project['project_desc'] ?></p>
                        <div class="">
                            <a class="projectbutton" href="singleproject.php?id=<?= $project['id'] ?>">More!</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
        <div class="container go-projects">
            <div>
            <a class="btn" href="projects.php">More  <i class="fa-solid fa-arrow-right"></i></a>
            </div>
        </div>
    </div>
</div>


<!-- Latest Events -->

<div class="container my-5">
    <div class="titleEvents">
        <h3>Latest Events</h3>
        <div class="line"></div>
    </div>
    <div class="projects-container text-center">
    <?php if($events && count($events)): ?>
        <div class="projects container my-3">
            <?php foreach($events as $event): ?>
                <div class="card cardEvent p-0" style="width: 16rem;">
                    <img src="dashboard/events/images/<?= $event['event_image'] ?>" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title titleEvent"><?= $event['event_title'] ?></h5>
                        <p class="card-text desc-scroll"><?= $event['event_desc'] ?></p>
                        <div class="">
                            <a class="eventbutton" href="singleevent.php?id=<?= $event['id'] ?>"">More!</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
        <div class="container go-events">
            <div>
            <a class="btn btn-events" href="events.php"><i class="fa-solid fa-arrow-left"></i>More</a>
            </div>
        </div>
    </div>
</div>





















<?php include('includes/footer.php'); ?>