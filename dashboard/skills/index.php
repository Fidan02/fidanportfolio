<?php 
    ob_start();
    include('../includes/header.php'); 
    include('../../classes/CRUD.php');
    
    $crud = new CRUD;
    $errors = [];
    $skills = $crud->read('skills');

    if(isset($_GET['action']) && ($_GET['action']) === 'delete'){
        $skills = $crud->read('skills', ['column' => 'id', 'value' => $_GET['id']])[0];
        unlink('images/'.$skills['skill_image']);
        if($crud->delete('skills', ['column' => 'id', 'value' => $_GET['id']])){
            header('Location: index.php');
        }
    }
    ob_end_flush();    
?>


<div class="container my-5 project-add-card">
    <div class="title">
        <h3>Skills</h3>
        <div class="line"></div>
    </div>
    <div class="container mt-5">
        <a class="btn btn-danger" href="create.php">Add Skill</a>
    </div>

    <?php if($skills && count($skills)): ?>
        <div class="table-responsive project-table mt-3">
            <?php if(isset($_GET['action']) && isset($_GET['status'])): ?>
                <?php if(($_GET['action'] == 'create') && ($_GET['status'] == 'success')): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        Skill was created!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                <?php if(($_GET['action'] == 'delete')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        Skill was deleted!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                <?php if(($_GET['action'] == 'update') && ($_GET['status'] == 'success')): ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        Skill was updated!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
            <table class="table text-center align-middle">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Percentage</th>
                        <th>Edit/Delete</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($skills as $skill): ?>
                    <tr>
                        <td class="data-id"><?= $skill['id']?></td>
                        <td class="data-image">
                            <img src="images/<?= $skill['skill_image']?>" height="80" width="60" class="rounded border" alt="Image">
                        </td>
                        <td class="data-title"><?= $skill['skill_title']?></td>
                        <td class="data-tools">
                            <span class="badge bg-danger"><?= $skill['percentage']?>%</span>
                        </td>
                        <td>
                            <a href="edit.php?id=<?= $skill['id']?>"><i class="fa-solid fa-pen-to-square"></i></a>
                            <a href="?action=delete&id=<?= $skill['id']?>"><i class="fa-solid fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>


<?php include('../includes/footer.php'); ?>