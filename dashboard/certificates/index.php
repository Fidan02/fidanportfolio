<?php 
    ob_start();
    include('../includes/header.php'); 
    include('../../classes/CRUD.php');
    
    $crud = new CRUD;
    $errors = [];
    $certificates = $crud->read('certificates');

    if(isset($_GET['action']) && ($_GET['action']) === 'delete'){
        $certificates = $crud->read('certificates', ['column' => 'id', 'value' => $_GET['id']])[0];
        unlink('images/'.$certificates['certificates_image']);
        if($crud->delete('certificates', ['column' => 'id', 'value' => $_GET['id']])){
            header('Location: index.php');
        }
    }
    ob_end_flush();    
?>

<div class="container my-5 project-add-card">
    <div class="title">
        <h3>Certificates</h3>
        <div class="line"></div>
    </div>
    <div class="container mt-5">
        <a class="btn btn-danger" href="create.php">Add Certificate</a>
    </div>
    <?php if($certificates && count($certificates)): ?>
        <div class="table-responsive project-table mt-3">
            <?php if(isset($_GET['action']) && isset($_GET['status'])): ?>
                    <?php if(($_GET['action'] == 'create') && ($_GET['status'] == 'success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            Certificate was created!
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>
                    <?php if(($_GET['action'] == 'delete') && ($_GET['status'] == 'success')): ?>
                        <div class="alert alert-info alert-dismissible fade show" role="alert">
                            Certificate was deleted!
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>
                    <?php if(($_GET['action'] == 'update') && ($_GET['status'] == 'success')): ?>
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            Certificate was updated!
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>
                    <?php if(($_GET['action'] == 'update') && ($_GET['status'] == 'unsuccessfull')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <p>Certificate was not updated! Reason may be some important fields were left empty!</p> 
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
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Description</th>
                        <th>Image</th>
                        <th>Edit/Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($certificates as $certificate): ?>
                        <tr>
                            <td class="data-id"><?= $certificate['id']?></td>
                            <td class="data-title"><?= $certificate['certificate_title']?></td>
                            <td class="data-title"><?= $certificate['certificate_company']?></td>
                            <td class="data-tools">
                                <span class="badge bg-primary"><?= $certificate['start_date']?></span>
                            </td>
                            <td class="data-tools">
                                <span class="badge bg-success"><?= $certificate['end_date']?></span>
                            </td>
                            <td class="data-desc">
                                <div class="desc-scroll">
                                    <?= $certificate['certificate_desc']?>
                                </div>
                            </td>
                            <td class="data-image">
                                <img src="images/<?= $certificate['certificate_image']?>" alt="Image">
                            </td>
                            <td>
                                <a href="edit.php?id=<?= $certificate['id']?>"><i class="fa-solid fa-pen-to-square"></i></a>
                                <a href="?action=delete&id=<?= $certificate['id']?>"><i class="fa-solid fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>


<?php include('../includes/footer.php'); ?>