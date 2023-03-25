<?php 
    ob_start();
    include('../includes/header.php'); 
    include('../../classes/CRUD.php');
    $errors = [];
    $crud = new CRUD;
    if(isset($_POST['create_hobby'])){
        $hobbie_title = $_POST['hobbie_title'];
    
        if(empty($hobbie_title)){
            $errors[] = 'Title is empty';
        }else if($crud->create('hobbies', ['hobbie_title' => $hobbie_title]) === true){
            header('Location: index.php?action=create&status=success');
        }else{
            $errors = 'Something went wrong!'; 
        }
    }
    ob_end_flush();
?>
<div class="container my-5">
    <?php if($errors): ?>
        <ul>
        <?php foreach($errors as $error): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <li class="list-unstyled"><?= $error ?></li>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endforeach; ?>
        </ul>
    <?php endif; ?>
    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
        <div class="mb-3">
            <label for="hobbie_title" class="form-label">Hobbie</label>
            <input type="text" class="form-control" id="hobbie_title" name="hobbie_title">
        </div>
        <button type="submit" class="btn btn-success" name="create_hobby">Submit</button>
    </form>
</div>
<?php include('../includes/footer.php'); ?>