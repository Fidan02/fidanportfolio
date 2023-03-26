<?php 
    ob_start();
    include('includes/header.php');
    $errors = [];
    $users = $crud->read('users');
    function splitTools($tools){
        $type = explode(',', $tools);

        return $type;
    }

    if(isset($_GET['id'])){
        $projects = $crud->read('projects',['column' => 'id', 'value' => $_GET['id']]);
        $comments = $crud->read('comments',['column' => 'project_id', 'value' => $_GET['id']]);
        if(empty($projects)){
            header('Location: projects.php');
        }
    }else {
        header('Location: projects.php');
    }


    if(isset($_POST['post_comment']) && isset($_GET['id'])){
        $comment_desc = $_POST['comment_desc'];
        $user_id = $_SESSION['id'];
        $project_id = $_GET['id'];
        $data = [
            'comment_desc' => $comment_desc, 
            'user_id' => $user_id, 
            'project_id' => $project_id,
        ];

        if(empty($comment_desc)){
            $errors[] = 'Comment section is empty...';
        }

        if(count($errors) === 0){
            if($crud->create('comments', $data) == true){
                header("Location: singleproject.php?id=".$_GET['id']."&action=create");
            }else{
                $errors = 'Something went wrong!'; 
            }
        }
    }
    ob_end_flush();
?>

<?php if(isset($projects) && is_array($projects[0])): ?>
    <div>
        <img src="dashboard/projects/images/<?= $projects[0]['project_image'] ?>" alt="" class="object-fit-cover btm-border" style="height: 400px; width: 100%;"/>
        <div class='container rounded-bottom bgPrimary d-flex justify-content-between'>
            <h2 class='fw-bold secondaryColor mt-2 ps-3'><?= $projects[0]['project_title'] ?></h2>
            <p class='fw-bold secondaryColor mt-2 ps-3 pt-2 '>Tools: 
            <?php foreach(splitTools($projects[0]['project_tools']) as $tool): ?>
                <span class="badge bg-danger"><?= $tool ?></span>
            <?php endforeach; ?>
            </span></p>
        </div>
        <div class='container mt-5 p-2'>
            <h3 class='primaryColor'>Description 
                <a class='btn btn-danger secondaryColor text-decoration-none' href="<?= $projects[0]['github_link'] ?>" target='_blank'>Github</a>
            </h3>
            <div class='line my-3'></div>
            <div class="container pr-info">
                <div>
                    <p class='secondaryColor desc-width fw-bold'><?= $projects[0]['project_desc'] ?></p>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php if(isset($comments)): ?>
    <div class="container my-5">
        <div class="title">
            <h3>Comments</h3>
            <div class="lineTwo"></div>
        </div>

        <?php if($errors): ?>
        <div class="alert alert-primary" role="alert">
            <ul class="list-unstyled">
                <?php foreach($errors as $error): ?>
                <li><i class="fa-solid fa-arrow-right"></i> <?= $error; ?></li>
                <?php endforeach;?>
            </ul>
        </div>
        <?php endif;?>
        <?php if(isset($_SESSION['is_loggedin']) && $_SESSION['is_loggedin'] === true): ?>
            <div class="comment_form my-3">
                <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data" class="d-flex justify-content-around">
                    <div class="mb-3 w-50">
                        <input type="text" class="form-control" id="comment_desc" name="comment_desc" placeholder="Post a comment">
                    </div>
                    <button type="submit" name="post_comment" class="form-control btn w-25 h-25">Post</button>
                </form>
            </div>
        <?php else: ?>
            
            <div class="container my-5 text-center">
                <div class="text-center secondaryColor">
                    <h3>Login to be able to comment!</h3>
                </div>
                <a class="primaryColor fw-bold text-decoration-none" href="login.php">Log-in</a>
            </div>
        <?php endif; ?>
        </div>

        <?php if(isset($comments)): ?>
            <section>
                <div class="container my-5 py-5 text-dark">
                    <div class="row d-flex justify-content-center">
                    <div class="col-md-12 col-lg-10 col-xl-8">
                        <?php foreach($comments as $comment): ?>
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="d-flex flex-start">
                                        <img class="rounded-circle shadow-1-strong me-3"
                                            src="assets/images/about04.png" alt="avatar" width="40"
                                            height="40" />
                                        <div class="w-100">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h6 class="secondaryColor fw-bold mb-0">
                                                <?php foreach($users as $user):?>
                                                    <?php if($user['id'] === $comment['user_id']): ?>
                                                        <?= $user['name'] ?> <?= $user['surname'] ?>
                                                    <?php endif; ?>
                                                <?php endforeach;?>
                                                <span class="text-light ms-1"><?= $comment['comment_desc']?></span>
                                            </h6>
                                            <p class="mb-0 badge bg-light text-dark"><?= $comment['posted_date'] ?></p>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <p class="small mb-0" style="color: #aaa;">
                                                <?php if(isset($_SESSION['id']) && $_SESSION['id'] == $comment['user_id']): ?>
                                                    <a href="?action=delete">Delete</a>
                                                <?php endif; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?> 
                        </div>
                    </div>
                    </div>
                </div>
            </section>
        <?php endif; ?> 
    



<?php endif; ?>





<?php include('includes/footer.php'); ?>