<?php 
    ob_start();
    include('../includes/header.php'); 
    include('../../classes/CRUD.php');
    
    $crud = new CRUD;
    $errors = [];
    $events = $crud->read('events');

    if(isset($_GET['action']) && ($_GET['action']) === 'delete'){
        $events = $crud->read('events', ['column' => 'id', 'value' => $_GET['id']])[0];
        unlink('images/'.$events['event_image']);
        if($crud->delete('events', ['column' => 'id', 'value' => $_GET['id']])){
            header('Location: index.php');
        }
    }
    ob_end_flush();    
?>



<div class="container my-5 project-add-card">
    <div class="title">
        <h3>Events</h3>
        <div class="line"></div>
    </div>
    <div class="container mt-5">
        <a class="btn btn-danger" href="create.php">Add Event</a>
    </div>
    <?php if($events && count($events)): ?>
    <div class="table-responsive project-table mt-3">
            <?php if(isset($_GET['action']) && isset($_GET['status'])): ?>
                <?php if(($_GET['action'] == 'create') && ($_GET['status'] == 'success')): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        Events was created!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                <?php if(($_GET['action'] == 'delete') && ($_GET['status'] == 'success')): ?>
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        Events was deleted!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                <?php if(($_GET['action'] == 'update') && ($_GET['status'] == 'success')): ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        Events was updated!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                <?php if(($_GET['action'] == 'update') && ($_GET['status'] == 'unsuccessfull')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <p>Events was not updated! Reason may be some important fields were left empty!</p> 
                        <p>Try again!</p>
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
                    <th>Date</th>
                    <th>Description</th>
                    <th>Edit/Delete</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($events as $events): ?>
                <tr>
                    <td class="data-id"><?= $events['id']?></td>
                    <td class="data-image">
                        <img src="images/<?= $events['event_image']?>" alt="Image">
                    </td>
                    <td class="data-title"><?= $events['event_title']?></td>
                    <td class="data-links">
                        <p class="badge bg-danger"><?= $events['start_date']?></p>
                        <p class="badge bg-info"><?= $events['end_date']?></p>
                    </td>
                    <td class="data-desc">
                        <div class="desc-scroll">
                            <?= $events['event_desc']?>
                        </div>
                    </td>
                    <td>
                        <a href="edit.php?id=<?= $events['id']?>"><i class="fa-solid fa-pen-to-square"></i></a>
                        <a href="?action=delete&id=<?= $events['id']?>"><i class="fa-solid fa-trash"></i></a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>
</div>


<?php include('../includes/footer.php'); ?>