<?php 
    ob_start();
    include('../includes/header.php'); 
    include('../../classes/CRUD.php');
    $errors = [];
    $crud = new CRUD;

    function imageValidation($image){
        $types = explode('.', $image);
        $type = end($types);
        $imageTypes = ['png', 'jpg', 'jpeg', 'webp'];
        
        return in_array($type, $imageTypes);
    }


    if(isset($_POST['create_certificate'])){
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
    
        if(empty($certificate_title) || empty($certificate_desc) ||
        empty($certificate_company) || empty($start_date) || empty($end_date)){
            $errors[] = 'Some fields are empty! Fill them with data to proceed...';
        }
        
        if(empty($certificate_image['name']) || !imageValidation($certificate_image['name'])){
            $errors[] = 'Image is empty or type is not supported!';
        }else{
            $data['certificate_image'] = time().$certificate_image['name'];
        }

        if(count($errors) === 0){
            if($crud->create('certificates', $data) === true){
                if(isset($certificate_image['name']) && imageValidation($certificate_image['name'])){
                    move_uploaded_file($certificate_image['tmp_name'], 'images/'.time().$certificate_image['name']);
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
            <label for="certificate_title" class="form-label">Certificate Title</label>
            <input type="text" class="form-control" id="certificate_title" name="certificate_title">
        </div>
        <div class="mb-3">
            <label for="certificate_company" class="form-label">Company</label>
            <input type="text" class="form-control" id="certificate_company" name="certificate_company">
        </div>
        <div class="mb-3">
            <label for="certificate_image" class="form-label">Certificate Image</label>
            <input class="form-control" type="file" id="certificate_image" name="certificate_image">
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
            <textarea class="form-control" placeholder="Write what you did..." id="certificate_desc" name="certificate_desc"></textarea>
            <label for="certificate_desc">Certificate Description</label>
        </div>
        <button type="submit" name="create_certificate" class="btn btn-success">Submit</button>
    </form>
</div>



<?php include('../includes/footer.php'); ?>

