<?php 
    ob_start();
    include('../includes/header.php'); 
    include('../../classes/CRUD.php');
    
    $crud = new CRUD;
    $errors = [];
    $exp = $crud->read('experience');

    if(isset($_GET['action']) && ($_GET['action']) === 'delete'){
        if($crud->delete('experience', ['column' => 'id', 'value' => $_GET['id']])){
            header('Location: index.php');
        }
    }
    ob_end_flush();    
?>

<div class="container my-5 project-add-card">
    <div class="title">
        <h3>Experience</h3>
        <div class="line"></div>
    </div>
    <div class="container mt-5">
        <a class="btn btn-danger" href="create.php">Add Experience</a>
    </div>
    <?php if($exp && count($exp)): ?>
        <div class="table-responsive project-table mt-3">
            <?php if(isset($_GET['action']) && isset($_GET['status'])): ?>
                <?php if(($_GET['action'] == 'create') && ($_GET['status'] == 'success')): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        Experience was created!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                <?php if(($_GET['action'] == 'delete') && ($_GET['status'] == 'success')): ?>
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        Experience was deleted!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                <?php if(($_GET['action'] == 'update') && ($_GET['status'] == 'success')): ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        Experience was updated!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                <?php if(($_GET['action'] == 'update') && ($_GET['status'] == 'unsuccessfull')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <p>Experience was not updated! Reason may be some important fields were left empty!</p> 
                        <p>Try again!</p>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
            <table class="table text-center align-middle">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Title</th>
                        <th>Company</th>
                        <th>Start-Date</th>
                        <th>End-Date</th>
                        <th>Description</th>
                        <th>Edit/Delete</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($exp as $exp): ?>
                    <tr>
                        <td class="data-id"><?= $exp['id']?></td>
                        <td class="data-title"><?= $exp['experience_title']?></td>
                        <td class="data-title"><?= $exp['company']?></td>
                        <td class="data-tools">
                            <span class="badge bg-danger"><?= $exp['start_date']?></span>
                        </td>
                        <td class="data-tools">
                            <span class="badge bg-success"><?= $exp['end_date']?></span>
                        </td>
                        <td class="data-desc">
                            <div class="desc-scroll">
                            <?= $exp['experience_desc']?>
                            </div>
                        </td>
                        <td>
                            <a href="edit.php?id=<?= $exp['id']?>"><i class="fa-solid fa-pen-to-square"></i></a>
                            <a href="?action=delete&id=<?= $exp['id']?>"><i class="fa-solid fa-trash"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>



<?php include('../includes/footer.php'); ?>