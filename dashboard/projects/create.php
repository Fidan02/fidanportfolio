<?php 
    ob_start();
    include('../includes/header.php'); 
    include('../../classes/CRUD.php');
    $errors = [];
    $crud = new CRUD;

    function imageValidation($image){
        $type = end(explode('.', $image));
        $imageTypes = ['png', 'jpg', 'jpeg', 'webp'];
        
        return in_array($type, $imageTypes);
    }


    if(isset($_POST['create_project'])){
        $project_title = $_POST['project_title'];
        $project_desc = $_POST['project_desc'];
        $project_tools = $_POST['project_tools'];
        $github_link = $_POST['github_link'];
        $website_link = $_POST['website_link'];
        $project_image = $_FILES['project_image'];
        $data = [
            'project_title' => $project_title,
            'project_desc' => $project_desc,
            'project_tools' => $project_tools,
            'github_link' => $github_link,
            'website_link' => $website_link,
        ];
    
        if(empty($project_title) || empty($project_desc) ||
        empty($project_tools) || empty($github_link)){
            $errors[] = 'Some fields are empty! Fill them with data to proceed...';
        }
        
        if(empty($project_image['name']) || !imageValidation($project_image['name'])){
            $errors[] = 'Image is empty or type is not supported!';
        }else{
            $data['project_image'] = time().$project_image['name'];
        }

        if(count($errors) === 0){
            if($crud->create('projects', $data) === true){
                if(isset($project_image['name']) && imageValidation($project_image['name'])){
                    move_uploaded_file($project_image['tmp_name'], 'images/'.time().$project_image['name']);
                }
                header('Location: index.php?action=create&status=success');
            }else{
                $errors = 'Something went wrong!'; 
            }
        }
    }
    ob_end_flush();
?>

<div class="container my-5">
    <?php if($errors): ?>
        <div class="alert alert-primary" role="alert">
            <ul class="list-unstyled">
                <?php foreach($errors as $error): ?>
                <li><i class="fa-solid fa-arrow-right"></i> <?= $error; ?></li>
                <?php endforeach;?>
            </ul>
        </div>
    <?php endif;?>
    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="project_title" class="form-label">Project Title</label>
            <input type="text" class="form-control" id="project_title" name="project_title">
        </div>
        <div class="mb-3">
            <label for="project_tools" class="form-label">Tools used on project</label>
            <input type="text" class="form-control" id="project_tools" name="project_tools">
        </div>
        <div class="mb-3">
            <label for="project_image" class="form-label">Image</label>
            <input class="form-control" type="file" id="project_image" name="project_image">
        </div>
        <div class="mb-3">
            <label for="github_link" class="form-label">Github Link</label>
            <input type="text" class="form-control" id="github_link" name="github_link">
        </div>
        <div class="mb-3">
            <label for="website_link" class="form-label">Website Link</label>
            <input type="text" class="form-control" id="website_link" name="website_link">
        </div>
        <div class="form-floating mb-3">
            <textarea class="form-control" placeholder="Describe the project here" id="project_desc" name="project_desc"></textarea>
            <label for="project_desc">Project Description</label>
        </div>
        <button type="submit" name="create_project" class="btn btn-success">Submit</button>
    </form>
</div>



<?php include('../includes/footer.php'); ?>

