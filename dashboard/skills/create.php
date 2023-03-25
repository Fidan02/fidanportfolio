<?php 
    ob_start();
    include('../includes/header.php'); 
    include('../../classes/CRUD.php');
    $errors = [];
    $crud = new CRUD;

    function imageValidation($image){
        $type = end(explode('.', $image));
        $imageTypes = ['png', 'jpg', 'jpeg', 'webp'];
        
        return in_array($type, $imageTypes);
    }


    if(isset($_POST['create_skill'])){
        $skill_title = $_POST['skill_title'];
        $percentage = $_POST['percentage'];
        $skill_image = $_FILES['skill_image'];
        $data = ['skill_title' => $skill_title, 'percentage' => $percentage];
    
        if(empty($skill_title) || empty($percentage)){
            $errors[] = 'Some fields are empty! Fill them with data to proceed...';
        }
        
        if(empty($skill_image['name']) || !imageValidation($skill_image['name'])){
            $errors[] = 'Image is empty or type is not supported!';
        }else{
            $data['skill_image'] = time().$skill_image['name'];
        }

        if(count($errors) === 0){
            if($crud->create('skills', $data) === true){
                if(isset($skill_image['name']) && imageValidation($skill_image['name'])){
                    move_uploaded_file($skill_image['tmp_name'], 'images/'.time().$skill_image['name']);
                }
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
    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="skill_title" class="form-label">Skill Name</label>
            <input type="text" class="form-control" id="skill_title" name="skill_title">
        </div>
        <div class="mb-3">
            <label for="percentage" class="form-label">Percentage</label>
            <input type="number" class="form-control" id="percentage" max="100" name="percentage">
        </div>
        <div class="mb-3">
            <label for="skill_image" class="form-label">Image</label>
            <input class="form-control" type="file" id="skill_image" name="skill_image">
        </div>
        <button type="submit" name="create_skill" class="btn btn-success">Submit</button>
    </form>
</div>



<?php include('../includes/footer.php'); ?>