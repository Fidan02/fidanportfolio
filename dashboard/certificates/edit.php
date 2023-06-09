<?php 
    ob_start();
    include('../includes/header.php'); 
    include('../../classes/CRUD.php');
    $errors = [];
    $crud = new CRUD;
    $certificates = $crud->read('certificates', ['column' => 'id', 'value' => $_GET['id']], 1);

    function imageValidation($image){
        $types = explode('.', $image);
        $type = end($types);
        $imageTypes = ['png', 'jpg', 'jpeg', 'webp'];
        
        return in_array($type, $imageTypes);
    }

    if(isset($_POST['update_certificate'])){
        $id = $_POST['id'];
        $certificate_title = $_POST['certificate_title'];
        $certificate_desc = $_POST['certificate_desc'];
        $certificate_company = $_POST['certificate_company'];
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
        $certificate_image = $_FILES['certificate_image'];
        $data = [
            'certificate_title' => $certificate_title,
            'certificate_desc' => $certificate_desc,
            'certificate_company' => $certificate_company,
            'start_date' => $start_date,
            'end_date' => $end_date,
        ];
    
        if(empty($certificate_title)){
            $errors[] = 'Certificate Title is empty!';
        }
        if(empty(strlen(trim($certificate_desc)))){
            $errors[] = 'Certificate Description is empty!';
        }
        if(empty($certificate_company)){
            $errors[] = 'Certificate Company is empty!';
        }
        if(empty($start_date)){
            $errors[] = 'Start-date Tools is empty!';
        }
        if(empty($end_date)){
            $errors[] = 'End-date is empty!';
        }
        
        if(isset($project_image['name']) && imageValidation($project_image['name'])){
            $data['project_image'] = time().$project_image['name'];
        }
        
        if(isset($certificate_image['name']) && imageValidation($certificate_image['name'])){
            $data['certificate_image'] = time().$certificate_image['name'];
        }

        if(count($errors) === 0){
            if($crud->update('certificates', $data, ['column' => 'id', 'value' => $id]) === true){
                if(isset($certificate_image['name']) && imageValidation($certificate_image['name'])){
                    if(move_uploaded_file($certificate_image['tmp_name'], 'images/'.time().$certificate_image['name'])){
                        unlink('images/'.$certificate_image[0]['certificate_image']);
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
    <?php if(isset($certificates) && is_array($certificates[0])): ?>
    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="certificate_title" class="form-label">Certificate Title</label>
            <input type="text" class="form-control" id="certificate_title" value="<?= $certificates[0]['certificate_title'] ?>" name="certificate_title">
        </div>
        <div class="mb-3">
            <label for="certificate_company" class="form-label">Company</label>
            <input type="text" class="form-control" id="certificate_company" value="<?= $certificates[0]['certificate_company'] ?>" name="certificate_company">
        </div>
        <div class="mb-3">
            <label for="certificate_image" name="certificate_image" class="form-label">Certificate Image</label>
            <input class="form-control" type="file" id="certificate_image" name="certificate_image">
            <input type="image" src="images/<?= $certificates[0]['certificate_image'] ?>" height="120" class="my-3 rounded" name="certificate_image">
        </div>
        <div class="mb-3">
            <label for="start_date" class="form-label">Start Date</label>
            <input type="date" class="form-control" id="start_date" name="start_date" value="<?= $certificates[0]['start_date'] ?>">
        </div>
        <div class="mb-3">
            <label for="end_date" class="form-label">End Date</label>
            <input type="date" class="form-control" id="end_date" value="<?= $certificates[0]['end_date'] ?>" name="end_date">
        </div>
        <div class="form-floating mb-3">
            <textarea class="form-control" placeholder="Write what you did..." id="certificate_desc" name="certificate_desc"><?= $certificates[0]['certificate_desc'] ?></textarea>
            <label for="certificate_desc">Certificate Description</label>
        </div>
        <input type="hidden" name="id" value="<?= $certificates[0]['id']?>">
        <button type="submit" name="update_certificate" class="btn btn-warning">Update</button>
    </form>
    <?php endif; ?>
</div>



<?php include('../includes/footer.php'); ?>

