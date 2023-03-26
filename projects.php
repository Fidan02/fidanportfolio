<?php 
    include('includes/header.php');
    $errors = [];
    $projects = $crud->read('projects');     
?>


<div class="event-title container my-5">
    <h1>PROJECTS</h1>
    <div class="event-line"></div>
</div>

<?php if($projects && count($projects)): ?> 
    <div class="container me-5 my-5">
        <div class="m-2 gap-5 row">
            <?php foreach($projects as $project): ?>
            <div class="card event-card col-xl-5 col-lg-5 col-md-5 col-sm-12 p-0">
                <img src="dashboard/projects/images/<?= $project['project_image'] ?>" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title"><?= $project['project_title'] ?></h5>
                    <p class="card-text desc-scroll"><?= $project['project_desc'] ?></p>
                    <a href="singleproject.php?id=<?= $project['id'] ?>" class="btn btn-event">More Info</a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?> 















<?php include('includes/footer.php'); ?>