<?php 
    include('includes/header.php');
    // include('classes/CRUD.php');
    // $crud = new CRUD;
    $errors = [];
    $skills = $crud->read('skills');     
?>

<div class="container my-5 title">
    <h2>SKILLS</h2>
    <div class="line"></div>
</div>

<?php if($skills && count($skills)): ?>
    <div class="container">
        <div class="container my-5 gap-5 row justify-content-center">
            <?php foreach($skills as $skill): ?>
            <div class="card skill-card col-xl-5 col-lg-5 col-md-5 col-sm-12 p-0">
                <img src="dashboard/skills/images/<?= $skill['skill_image'] ?>" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title skill-title"><?= $skill['skill_title'] ?></h5>
                    <div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-bar" style="width: <?= $skill['percentage'] ?>%"><?= $skill['percentage'] ?>%</div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>
















<?php include('includes/footer.php'); ?>