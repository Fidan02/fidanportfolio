<?php 
    ob_start();
    include('../includes/header.php'); 
    include('../../classes/CRUD.php');
    $errors = [];
    $crud = new CRUD;
    $education = $crud->read('education', ['column' => 'id', 'value' => $_GET['id']], 1);

    function imageValidation($image){
        $types = explode('.', $image);
        $type = end($types);
        $imageTypes = ['png', 'jpg', 'jpeg', 'webp'];
        
        return in_array($type, $imageTypes);
    }

    if(isset($_POST['update_education'])){
        $id = $_POST['id'];
        $uni_name = $_POST['uni_name'];
        $education_major = $_POST['education_major'];
        $uni_link = $_POST['uni_link'];
        $start_date = $_POST['start_date'];
        $graduation_date = $_POST['graduation_date'];
        $education_description = $_POST['education_description'];
        $education_image = $_FILES['education_image'];
        $data = [
            'uni_name' => $uni_name, 
            'education_major' => $education_major, 
            'uni_link' => $uni_link,
            'start_date' => $start_date,
            'graduation_date' => $graduation_date,
            'education_description' => $education_description
        ];
    
        if(empty($uni_name)){
            $errors[] = 'University Title is empty!';
        }
        if(empty($education_major)){
            $errors[] = 'Education Major is empty!';
        }
        if(empty($start_date)){
            $errors[] = 'Start-date is empty!';
        }
        if(empty($graduation_date)){
            $errors[] = 'Graduation-date is empty!';
        }
        if(empty($uni_link)){
            $errors[] = 'University link is empty!';
        }
        if(filter_var($uni_link, FILTER_VALIDATE_URL) == false){
            $errors[] = 'Link is invalid!';
        }
        
        if(isset($education_image['name']) && imageValidation($education_image['name'])){
            $data['education_image'] = time().$education_image['name'];
        }

        if(count($errors) === 0){
            if($crud->update('education', $data, ['column' => 'id', 'value' => $id]) === true){
                if(isset($education_image['name']) && imageValidation($education_image['name'])){
                    if(move_uploaded_file($education_image['tmp_name'], 'uni_images/'.time().$education_image['name'])){
                        unlink('uni_images/'.$education[0]['education_image']);
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
    <?php if(isset($education) && is_array($education[0])): ?>
        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="uni_name" class="form-label">University</label>
                <input type="text" class="form-control" id="uni_name" name="uni_name" value="<?= $education[0]['uni_name'] ?>">
            </div>
            <div class="mb-3">
                <label for="education_major" class="form-label">Major</label>
                <input type="text" class="form-control" id="education_major" name="education_major" value="<?= $education[0]['education_major'] ?>">
            </div>
            <div class="mb-3">
                <label for="education_image" class="form-label">University Image</label>
                <input class="form-control" type="file" id="education_image" name="education_image">
                <input type="image" src="uni_images/<?= $education[0]['education_image'] ?>" height="120" class="my-3 rounded" name="education_image">
            </div>
            <div class="mb-3">
                <label for="uni_link" class="form-label">University Link</label>
                <input type="text" class="form-control" id="uni_link" name="uni_link" value="<?= $education[0]['uni_link'] ?>">
            </div>
            <div class="mb-3">
                <label for="start_date" class="form-label">Start Date</label>
                <input type="date" class="form-control" id="start_date" name="start_date" value="<?= $education[0]['start_date'] ?>">
            </div>
            <div class="mb-3">
                <label for="graduation_date" class="form-label">Graduation Date</label>
                <input type="date" class="form-control" id="graduation_date" name="graduation_date" value="<?= $education[0]['graduation_date'] ?>">
            </div>
            <div class="form-floating mb-3">
                <textarea class="form-control text-dark" placeholder="Write GPA, scholarship and any other achievements" id="education_description" name="education_description">
                <?= $education[0]['education_description']; ?>
                </textarea>
                <label for="education_description">University Description</label>
            </div>
            <input type="hidden" name="id" value="<?= $education[0]['id']?>">
            <button type="submit" name="update_education" class="btn btn-warning">Update</button>
        </form>
        <?php else: ?>
            <p>Education does not exist</p>
        <?php endif; ?>
</div>



<?php include('../includes/footer.php'); ?>