<?php 
    ob_start();
    include('../includes/header.php'); 
    include('../../classes/CRUD.php');
    $errors = [];
    $crud = new CRUD;
    $hobbies = $crud->read('hobbies', ['column' => 'id', 'value' => $_GET['id']], 1);

    if(isset($_POST['update_hobbie'])){
        $id = $_POST['id'];
        $hobbie_title = $_POST['hobbie_title'];
        
        if(empty($hobbie_title)){
            $errors[] = 'Hobbie Title is empty!';
        }

        if(count($errors) === 0){
            if($crud->update('hobbies', ['hobbie_title' => $hobbie_title], ['column' => 'id', 'value' => $id]) === true){
                header('Location: index.php?action=update&status=success');
            }else{
                $errors = 'Something went wrong!'; 
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
    <?php if(isset($hobbies) && is_array($hobbies[0])): ?>
        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="hobbie_title" class="form-label">Hobbie</label>
                <input type="text" class="form-control" id="hobbie_title" name="hobbie_title" value="<?= $hobbies[0]['hobbie_title'] ?>">
            </div>
            <input type="hidden" class="form-control" name="id" value="<?= $hobbies[0]['id'] ?>">
            <button type="submit" class="btn btn-warning" name="update_hobbie">Update</button>
        </form>
    <?php else: ?>
        <p>Hobbie does not exist!</p>
    <?php endif; ?>
</div>


<?php include('../includes/footer.php'); ?>