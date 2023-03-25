<?php
    include('includes/header.php'); 
    // include('classes/CRUD.php');
    // $crud = new CRUD;
    $errors = [];
    $education = $crud->read('education');
    $certificates = $crud->read('certificates');
?>


<!-- Education -->

<div class="container secondaryColor my-5">
    <h1>Education</h1>
    <div class="about-line"></div>
</div>

<?php if($education && count($education)): ?>
    <div class="container bg-light card mb-3 p-0">
        <div class="row g-0">
            <?php foreach($education as $edu):?>
                <div class="col-md-4 overflow-hidden">
                    <img src="dashboard/education/uni_images/<?= $edu['education_image'] ?>" class="img-fluid rounded h-100 object-fit-cover" alt="...">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <div class="container d-flex justify-content-around">
                            <h5 class="card-title"><?= $edu['uni_name'] ?> <span><a href="<?= $edu['uni_link'] ?>" class="primaryColor" target="_blank"><i class="fa-solid fa-school"></i></a></span></h5>
                            <p><span class="badge bg-success"><?= $edu['start_date'] ?></span> / <span class="badge bg-danger"><?= $edu['graduation_date'] ?></span></p>
                        </div>
                        <div class="container d-flex justify-content-center">
                            <h3 class="primaryColor"><?= $edu['education_major'] ?></h3>
                        </div>
                        <p class="card-text text-dark desc-scroll p-4"><?= $edu['education_description'] ?></p>
                    </div>
                </div>
            <?php endforeach;?>
        </div>
    </div>
<?php endif; ?>


<!-- Certificates -->

<div class="container secondaryColor my-5">
    <h1>Certificates</h1>
    <div class="about-line"></div>
</div>


<?php if($certificates && count($certificates)): ?>
    <div class="container bg-light card mb-3 p-0">
        <div class="row g-0">
            <?php foreach($certificates as $cert):?>
                <div class="col-md-4 overflow-hidden">
                    <img src="dashboard/certificates/images/<?= $cert['certificate_image'] ?>" class="img-fluid rounded h-100 object-fit-cover" alt="...">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <div class="container d-flex justify-content-around">
                            <h5 class="card-title"><?= $cert['certificate_company'] ?> </h5>
                            <p><span class="badge bg-success"><?= $cert['start_date'] ?></span> / <span class="badge bg-danger"><?= $cert['end_date'] ?></span></p>
                        </div>
                        <div class="container d-flex justify-content-center">
                            <h3 class="primaryColor"><?= $cert['certificate_title'] ?></h3>
                        </div>
                        <p class="card-text text-dark desc-scroll p-4"><?= $cert['certificate_desc'] ?></p>
                    </div>
                </div>
            <?php endforeach;?>
        </div>
    </div>
<?php endif; ?>















<?php include('includes/footer.php'); ?>