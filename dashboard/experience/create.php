<?php 
    ob_start();
    include('../includes/header.php'); 
    include('../../classes/CRUD.php');
    $errors = [];
    $crud = new CRUD;

    if(isset($_POST['create_exp'])){
        $experience_title = $_POST['experience_title'];
        $company = $_POST['company'];
        $experience_desc = $_POST['experience_desc'];
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
        $data = [
            'experience_title' => $experience_title, 
            'company' => $company, 
            'experience_desc' => $experience_desc,
            'start_date' => $start_date,
            'end_date' => $end_date,
        ];
    
        if(empty($experience_title) || empty($company) || 
            empty($experience_desc) || empty($start_date) || empty($end_date)){
            $errors[] = 'Some fields are empty! Fill them with info to proceed...';
        }

        if(count($errors) === 0){
            if($crud->create('experience', $data) === true){
                header('Location: index.php?action=create&status=success');
            }else{
                $errors = 'Something went wrong!'; 
            }
        }
    }
    ob_end_flush();
?>

<div class="container my-5">
    <?php if($errors): ?>
        <div class="alert alert-primary" role="alert">
            <ul class="list-unstyled">
                <?php foreach($errors as $error): ?>
                <li><i class="fa-solid fa-arrow-right"></i> <?= $error; ?></li>
                <?php endforeach;?>
            </ul>
        </div>
    <?php endif;?>
    <form action="<?php $_SERVER['PHP_SELF']?>" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="experience_title" class="form-label">Experience Title/Job Position</label>
            <input type="text" class="form-control" id="experience_title" name="experience_title">
        </div>
        <div class="mb-3">
            <label for="company" class="form-label">Company</label>
            <input type="text" class="form-control" id="company" name="company">
        </div>
        <div class="mb-3">
            <label for="start_date" class="form-label">Start Date</label>
            <input type="date" class="form-control" id="start_date" name="start_date">
        </div>
        <div class="mb-3">
            <label for="end_date" class="form-label">End Date</label>
            <input type="date" class="form-control" id="end_date" name="end_date">
        </div>
        <div class="form-floating mb-3">
            <textarea class="form-control" placeholder="Write what you did..." id="experience_desc" name="experience_desc"></textarea>
            <label for="experience_desc">Experience Description</label>
        </div>
        <button type="submit" name="create_exp" class="btn btn-success">Submit</button>
    </form>
</div>



<?php include('../includes/footer.php'); ?>

