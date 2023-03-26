<?php 
    ob_start();
    include('../includes/header.php'); 
    include('../../classes/CRUD.php');
    $errors = [];
    $crud = new CRUD;
    $skills = $crud->read('skills', ['column' => 'id', 'value' => $_GET['id']], 1);

    function imageValidation($image){
        $type = end(explode('.', $image));
        $imageTypes = ['png', 'jpg', 'jpeg', 'webp'];
        
        return in_array($type, $imageTypes);
    }

    if(isset($_POST['update_skill'])){
        $id = $_POST['id'];
        $skill_title = $_POST['skill_title'];
        $percentage = $_POST['percentage'];
        $skill_image = $_FILES['skill_image'];
        $data = ['skill_title' => $skill_title, 'percentage' => $percentage];
    
        if(empty($skill_title)){
            $errors[] = 'Skill Title is empty!';
        }
        if(empty($percentage)){
            $errors[] = 'Percentage is empty!';
        }
        
        if(isset($skill_image['name']) && imageValidation($skill_image['name'])){
            $data['skill_image'] = time().$skill_image['name'];
        }

        if(count($errors) == 0){
            if($crud->update('skills', $data, ['column' => 'id', 'value' => $id]) === true){
                if(isset($skill_image['name']) && imageValidation($skill_image['name'])){
                    if(move_uploaded_file($skill_image['tmp_name'], 'images/'.time().$skill_image['name'])){
                        unlink('images/'.$skill[0]['skill_image']);
                    }
                }
                header('Location: index.php?action=update&status=success');
            }else{
                $errors = "Something went wrong!";
            }
        }else if(count($errors) > 0){
            $_SESSION['project_errors'] = $errors;
            header("Location: edit.php?id=$id&action=update&status=unsuccessfull");
        }
    }
    ob_end_flush();
?>

<div class="container my-5">
    <?php if(isset($_GET['action']) && isset($_GET['status'])): ?>
        <?php if(($_GET['action'] == 'update') && ($_GET['status'] == 'unsuccessfull')): ?>
            <?php if(isset($_SESSION['project_errors'])): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?php foreach($_SESSION['project_errors'] as $error): ?>
                        <p><?php echo $error; ?></p>
                    <?php endforeach; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php unset($_SESSION['project_errors']); ?>
            <?php endif; ?>
        <?php endif; ?>
    <?php endif; ?>
    <?php if(isset($skills) && is_array($skills[0])): ?>
    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="skill_title" class="form-label">Skill Name</label>
            <input type="text" class="form-control" id="skill_title" name="skill_title" value="<?= $skills[0]['skill_title'] ?>">
        </div>
        <div class="mb-3">
            <label for="percentage" class="form-label">Percentage</label>
            <input type="number" class="form-control" id="percentage" max="100" name="percentage" value="<?= $skills[0]['percentage'] ?>">
        </div>
        <div class="mb-3">
            <label for="skill_image" class="form-label">Image</label>
            <input class="form-control" type="file" id="skill_image" name="skill_image">
            <input type="image" src="images/<?= $skills[0]['skill_image'] ?>" height="120" class="my-3 rounded" name="skill_image">
        </div>
        <input type="hidden" name="id" value="<?= $skills[0]['id']?>"> 
        <button type="submit" name="update_skill" class="btn btn-warning">Update</button>
    </form>
    <?php else: ?>
        <p>Skill does not exist</p>
    <?php endif; ?>
</div>



<?php include('../includes/footer.php'); ?>