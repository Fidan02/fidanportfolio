<?php 
    ob_start();
    include('../includes/header.php'); 
    include('../../classes/CRUD.php');
    $errors = [];
    $crud = new CRUD;
    $experience = $crud->read('experience', ['column' => 'id', 'value' => $_GET['id']], 1);

    if(isset($_POST['update_exp'])){
        $id = $_POST['id'];
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
    
        if(empty($experience_title)){
            $errors[] = 'Experience Title is empty!';
        }
        if(empty($experience_desc)){
            $errors[] = 'Experience description is empty!';
        }
        if(empty($company)){
            $errors[] = 'Company name is empty!';
        }
        if(empty($start_date)){
            $errors[] = 'Start-Date is empty!';
        }
        if(empty($end_date)){
            $errors[] = 'End-Date is empty!';
        }
        

        if(count($errors) === 0){
            if($crud->update('experience', $data, ['column' => 'id', 'value' => $id]) === true){
                header('Location: index.php?action=update&status=success');
            }else{
                $errors[] = "Something went wrong!";
            }
        }else if(count($errors) > 0){
            $_SESSION['exp_erros'] = $errors;
            header("Location: edit.php?id=$id&action=update&status=unsuccessfull");
        }
    }
    ob_end_flush();
?>

<div class="container my-5">
    <?php if(isset($_GET['action']) && isset($_GET['status'])): ?>
        <?php if(($_GET['action'] == 'update') && ($_GET['status'] == 'unsuccessfull')): ?>
            <?php if(isset($_SESSION['exp_erros'])): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?php foreach($_SESSION['exp_erros'] as $error): ?>
                        <p><?php echo $error; ?></p>
                    <?php endforeach; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php unset($_SESSION['exp_erros']); ?>
            <?php endif; ?>
        <?php endif; ?>
    <?php endif; ?>

    <?php if(isset($experience) && is_array($experience[0])): ?>
    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="experience_title" class="form-label">Experience Title/Job Position</label>
            <input type="text" class="form-control" id="experience_title" name="experience_title" value="<?= $experience[0]['experience_title'] ?>">
        </div>
        <div class="mb-3">
            <label for="company" class="form-label">Company</label>
            <input type="text" class="form-control" id="company" value="<?= $experience[0]['company'] ?>" name="company">
        </div>
        <div class="mb-3">
            <label for="start_date" class="form-label">Start Date</label>
            <input type="date" class="form-control" id="start_date" value="<?= $experience[0]['start_date'] ?>" name="start_date">
        </div>
        <div class="mb-3">
            <label for="end_date" class="form-label">End Date</label>
            <input type="date" class="form-control" id="end_date" value="<?= $experience[0]['end_date'] ?>" name="end_date">
        </div>
        <div class="form-floating mb-3">
            <textarea class="form-control" placeholder="Write what you did..." id="experience_desc" name="experience_desc"><?= $experience[0]['experience_desc'] ?></textarea>
            <label for="experience_desc">Experience Description</label>
        </div>
        <input type="hidden" name="id" value="<?= $experience[0]['id']?>">    
        <button type="submit" name="update_exp" class="btn btn-warning">Update</button>
    </form>
    <?php endif; ?>
</div>



<?php include('../includes/footer.php'); ?>

