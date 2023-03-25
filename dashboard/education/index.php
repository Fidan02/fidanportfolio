<?php 
    ob_start();
    include('../includes/header.php'); 
    include('../../classes/CRUD.php');
    
    $crud = new CRUD;
    $errors = [];
    $education = $crud->read('education');

    if(isset($_GET['action']) && ($_GET['action']) === 'delete'){
        $education = $crud->read('education', ['column' => 'id', 'value' => $_GET['id']])[0];
        unlink('uni_images/'.$education['education_image']);
        if($crud->delete('education', ['column' => 'id', 'value' => $_GET['id']])){
            header('Location: index.php');
        }
    }
    ob_end_flush();    
?>

<div class="container my-5 project-add-card">
    <div class="title">
        <h3>Education</h3>
        <div class="line"></div>
    </div>
    <div class="container mt-5">
        <a class="btn btn-danger" href="create.php">Add Education</a>
    </div>
    <?php if($education && count($education)): ?>
        <div class="table-responsive project-table mt-3">
            <?php if(isset($_GET['action']) && isset($_GET['status'])): ?>
                <?php if(($_GET['action'] == 'create') && ($_GET['status'] == 'success')): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        Education was created!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                <?php if(($_GET['action'] == 'delete') && ($_GET['status'] == 'success')): ?>
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        Education was deleted!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                <?php if(($_GET['action'] == 'update') && ($_GET['status'] == 'success')): ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        Education was updated!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                <?php if(($_GET['action'] == 'update') && ($_GET['status'] == 'unsuccessfull')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <p>Education was not updated! Reason may be some important fields were left empty!</p> 
                        <p>Try again!</p>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
            <table class="table text-center align-middle">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>University</th>
                        <th>Major</th>
                        <th>Start Date</th>
                        <th>Graduation Date</th>
                        <th>Description</th>
                        <th>Image</th>
                        <th>Link</th>
                        <th>Edit/Delete</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($education as $education): ?>
                    <tr>
                        <td class="data-id"><?= $education['id']?></td>
                        <td class="data-title"><?= $education['uni_name']?></td>
                        <td class="data-title"><?= $education['education_major']?></td>
                        <td class="data-tools">
                            <span class="badge bg-primary"><?= $education['start_date']?></span>
                        </td>
                        <td class="data-tools">
                            <span class="badge bg-success"><?= $education['graduation_date']?></span>
                        </td>
                        <td class="data-desc">
                            <div class="desc-scroll">
                                <?= $education['education_description']?>
                            </div>
                        </td>
                        <td class="data-image">
                            <img src="uni_images/<?= $education['education_image']?>" alt="Image">
                        </td>
                        <td class="data-links">
                            <a href="<?= $education['uni_link']?>" target="_blank"><i class="fa-solid fa-school"></i></a>
                        </td>
                        <td>
                            <a href="edit.php?id=<?= $education['id']?>"><i class="fa-solid fa-pen-to-square"></i></a>
                            <a href="?action=delete&id=<?= $education['id']?>"><i class="fa-solid fa-trash"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>


<?php include('../includes/footer.php'); ?>