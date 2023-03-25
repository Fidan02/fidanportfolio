<?php 
    ob_start();
    include('../includes/header.php'); 
    include('../../classes/CRUD.php');
    $crud = new CRUD;
    $errors = [];
    $hobbies = $crud->read('hobbies');

    if(isset($_GET['action']) && ($_GET['action']) === 'delete'){
        if($crud->delete('hobbies', ['column' => 'id', 'value' => $_GET['id']])){
            header('Location: index.php?action=delete&status=success');
        }
    }
    ob_end_flush();
?>
<div class="container my-5 project-add-card">
    <div class="title">
        <h3>Hobbies</h3>
        <div class="line"></div>
    </div>
    <div class="container my-3">
        <a class="btn btn-outline-danger" href="create.php">Add Hobbie</a>
    </div>
    <?php if($hobbies && count($hobbies)): ?>
        <div class="table-responsive project-table mt-3">
            <!-- Notys when hobbie gets updated, added, deleted -->
        <?php if(isset($_GET['action']) && isset($_GET['status'])): ?>
            <?php if(($_GET['action'] == 'create') && ($_GET['status'] == 'success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    Hobbie was created!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <?php if(($_GET['action'] == 'delete') && ($_GET['status'] == 'success')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Hobbie was deleted!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <?php if(($_GET['action'] == 'update') && ($_GET['status'] == 'success')): ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    Hobbie was updated!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
        <?php endif; ?>
        <table class="table text-center align-middle">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Title</th>
                    <th>Edit/Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($hobbies as $hobbie): ?>
                    <tr>
                        <td class="data-id"><?= $hobbie['id'] ?></td>
                        <td class="data-title"><?= $hobbie['hobbie_title']?></td>
                        <td>
                            <a href="edit.php?id=<?= $hobbie['id'] ?>"><i class="fa-solid fa-pen-to-square"></i></a>
                            <a href="?action=delete&id=<?= $hobbie['id'] ?>"><i class="fa-solid fa-trash"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif ?>
</div>
<?php include('../includes/footer.php'); ?>