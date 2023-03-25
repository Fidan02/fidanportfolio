<?php 
    ob_start();
    include('../includes/header.php'); 
    include('../../classes/CRUD.php');
    
    $crud = new CRUD;
    $errors = [];
    $projects = $crud->read('projects');
    function splitTools($tools){
        $type = explode(',', $tools);

        return $type;
    }

    if(isset($_GET['action']) && ($_GET['action']) === 'delete'){
        $projects = $crud->read('projects', ['column' => 'id', 'value' => $_GET['id']])[0];
        unlink('images/'.$projects['project_image']);
        if($crud->delete('projects', ['column' => 'id', 'value' => $_GET['id']])){
            header('Location: index.php');
        }
    }
    ob_end_flush();    
?>

<div class="container my-5 project-add-card">
    <div class="title">
        <h3>Projects</h3>
        <div class="line"></div>
    </div>
    <div class="container mt-5">
        <a class="btn btn-danger" href="create.php">Add Project</a>
    </div>
    <?php if($projects && count($projects)): ?>
        <div class="table-responsive project-table mt-3">
            <?php if(isset($_GET['action']) && isset($_GET['status'])): ?>
                    <?php if(($_GET['action'] == 'create') && ($_GET['status'] == 'success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            Project was created!
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>
                    <?php if(($_GET['action'] == 'delete') && ($_GET['status'] == 'success')): ?>
                        <div class="alert alert-info alert-dismissible fade show" role="alert">
                            Project was deleted!
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>
                    <?php if(($_GET['action'] == 'update') && ($_GET['status'] == 'success')): ?>
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            Project was updated!
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>
                    <?php if(($_GET['action'] == 'update') && ($_GET['status'] == 'unsuccessfull')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <p>Project was not updated! Reason may be some important fields were left empty!</p> 
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
                        <th>Links</th>
                        <th>Tools</th>
                        <th>Description</th>
                        <th>Edit/Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($projects as $project): ?>
                        <tr>
                            <td class="data-id"><?= $project['id']?></td>
                            <td class="data-image">
                                <img src="images/<?= $project['project_image']?>" alt="Image">
                            </td>
                            <td class="data-title"><?= $project['project_title']?></td>
                            <td class="data-links">
                                <a href="<?= $project['github_link']?>" target="_blank"><i class="fa-brands fa-github"></i></a>
                                <a href="https://<?= $project['website_link']?>" target="_blank"><i class="fa-solid fa-earth-asia"></i></a>
                            </td>
                            <td class="data-tools">
                            <?php foreach(splitTools($project['project_tools']) as $tool): ?>
                                <span class="badge bg-warning"><?= $tool ?></span>
                            <?php endforeach; ?>
                            </td>
                            <td class="data-desc">
                                <div class="desc-scroll">
                                    <?= $project['project_desc']?>
                                </div>
                            </td>
                            <td>
                                <a href="edit.php?id=<?= $project['id']?>"><i class="fa-solid fa-pen-to-square"></i></a>
                                <a href="?action=delete&id=<?= $project['id']?>"><i class="fa-solid fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<!-- <div class="project-id">
            <h3>1</h3>
        </div>
        <div class="project-image">
            <img src="../../assets/images/about04.png" alt="">
        </div>
        <div class="project-title">
            <h3>Project Title</h3>
        </div>
        <div class="project-links">
            <a href="www.github.com"><i class="fa-brands fa-github"></i></a>
            <a href="www.google.com"><i class="fa-solid fa-earth-asia"></i></a>
        </div>
        <div class="project-tools">
            <p class="badge bg-danger">HTML, CSS</p>
        </div>
        <div class="project-desc">
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Debitis consequatur, repellendus exercitationem velit fugit quod earum perferendis amet reiciendis quia!
        </div>
        <div class="project-edit-delete">
            <a href="edit.php?id=6"><i class="fa-solid fa-pen-to-square"></i></a>
            <a href="?action=delete&amp;id=6"><i class="fa-solid fa-trash"></i></a>
        </div> -->


<?php include('../includes/footer.php'); ?>