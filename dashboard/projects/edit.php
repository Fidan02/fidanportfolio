<?php 
    ob_start();
    include('../includes/header.php'); 
    include('../../classes/CRUD.php');
    $crud = new CRUD;
    $errors = [];
    $projects = $crud->read('projects', ['column' => 'id', 'value' => $_GET['id']], 1);

    //Image Validation
    function imageValidation($image){
        $type = end(explode('.', $image));
        $imageTypes = ['png', 'jpg', 'jpeg', 'webp'];
        
        return in_array($type, $imageTypes);
    }

    if(isset($_POST['update_project'])){
        $id = $_POST['id'];
        $project_title = $_POST['project_title'];
        $project_desc = $_POST['project_desc'];
        $project_tools = $_POST['project_tools'];
        $github_link = $_POST['github_link'];
        $project_image = $_FILES['project_image'];
        $data = [
            'project_title' => $project_title,
            'project_desc' => $project_desc,
            'project_tools' => $project_tools,
            'github_link' => $github_link,
        ];

        // Validation
        if(empty($project_title)){
            $errors[] = 'Project Title is empty!';
        }
        if(empty($project_desc)){
            $errors[] = 'Project Description is empty!';
        }
        if(empty($project_tools)){
            $errors[] = 'Project Tools is empty!';
        }
        if(empty($github_link)){
            $errors[] = 'Github link is empty!';
        }
        if(filter_var($github_link, FILTER_VALIDATE_URL) == false){
            $errors[] = 'Link is invalid!';
        }
        
        if(isset($project_image['name']) && imageValidation($project_image['name'])){
            $data['project_image'] = time().$project_image['name'];
        }

        // Update Section
        if(count($errors) == 0){
            if($crud->update('projects', $data, ['column' => 'id', 'value' => $id]) === true){
                if(isset($project_image['name']) && imageValidation($project_image['name'])){
                    if(move_uploaded_file($project_image['tmp_name'], 'images/'.time().$project_image['name'])){
                        unlink('images/'.$project_image[0]['project_image']);
                    }
                }
                header('Location: index.php?action=update&status=success');
            }else{
                $errors[] = "Something went wrong!";
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
<?php if(isset($projects) && is_array($projects[0])): ?>
    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="project_title" class="form-label">Project Title</label>
            <input type="text" class="form-control" id="project_title" value="<?= $projects[0]['project_title'] ?>" name="project_title">
        </div>
        <div class="mb-3">
            <label for="project_tools" class="form-label">Tools used on project</label>
            <input type="text" class="form-control" id="project_tools" value="<?= $projects[0]['project_tools'] ?>" name="project_tools">
        </div>
        <div class="mb-3">
            <label for="project_image" class="form-label">Image</label>
            <input class="form-control" type="file" id="project_image" name="project_image">
            <input type="image" src="images/<?= $projects[0]['project_image'] ?>" height="120" class="my-3 rounded" name="project_image">
        </div>
        <div class="mb-3">
            <label for="github_link" class="form-label">Github Link</label>
            <input type="text" class="form-control" id="github_link" name="github_link" value="<?= $projects[0]['github_link'] ?>">
        </div>
        <div class="form-floating mb-3">
            <textarea class="form-control" placeholder="Describe the project here" id="project_desc" name="project_desc"><?= $projects[0]['project_desc'] ?></textarea>
            <label for="project_desc">Project Description</label>
        </div>
        <input type="hidden" name="id" value="<?= $projects[0]['id']?>">
        <button type="submit" name="update_project" class="btn btn-warning">Update</button>
    </form>
<?php endif; ?>
</div>



<?php include('../includes/footer.php'); ?>

