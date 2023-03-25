<?php 
    include('includes/header.php');
    // include('classes/CRUD.php');
    // $crud = new CRUD;
    $errors = [];
    $hobbies = $crud->read('hobbies');     
    $experience = $crud->read('experience');     
?>



<div class="container-fluid main-container row gap-2 my-5 justify-content-between">
    <?php if($hobbies && count($hobbies)): ?>
    <div class="container hobbies-container col-xl-2 col-lg-2 col-md-2 col-sm-12">
        <div class="hobbie-title my-4">
            <h5>HOBBIES</h5>
        </div>
        <?php foreach($hobbies as $hobbie): ?>
            <div class="hobbie-card mt-2">
                <h4 class="hobbie"><?= $hobbie['hobbie_title'] ?></h4>
            </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
    <?php if($experience && count($experience)): ?>
    <div class="experience-container col-xl-9 col-lg-9 col-md-9 col-sm-12">
        <div class="title">
            <h3>EXPERIENCE</h3>
            <div class="line"></div>
        </div>
        <div class="experience-card my-3">
        <?php foreach($experience as $exp): ?>
            <div class="card exp-card">
                <div class="card-body">
                    <h4 class="card-title exp-title"><?= $exp['experience_title'] ?></h4>
                    <h6 class="exp-title"><?= $exp['company'] ?></h6>
                    <p class="card-text"><?= $exp['experience_desc'] ?></p>
                    <p class="card-text">Period: 
                        <span class="badge bg-danger"><?= $exp['start_date'] ?></span> / 
                        <span class="badge bg-success"><?= $exp['end_date'] ?></span>
                    </p>
                </div>
            </div>
        <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>
</div>














<?php include('includes/footer.php'); ?>