<?php 
    ob_start();
    include('includes/header.php'); 
    $testimonials = $crud->read('testimonials');      
    $users = $crud->read('users');
    
    if(isset($_POST['post_testify'])){
        $desc = $_POST['testimonial_desc'];

        if(strlen($desc) <= 120){
            if($crud->create('testimonials', ['testimonial_desc' => $desc, 'user_id' => $_SESSION['id']]) === true){
                header('Location: about.php?action=create&status=success');
            }
        }else{
            header('Location: about.php');
        }
    }
    ob_end_flush();
?>


<div class="about-title container text-center my-5">
    <h1>ABOUT</h1>
    <div class="about-line"></div>
</div>


<div class="about-content container my-5">
    <div class="image-container">
        <img src="assets/images/about-one.jpg" alt="About Image">
    </div>
    <div class="about-info container">
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Odit, mollitia quia. At sed neque quas, saepe ipsum debitis nostrum laudantium incidunt aspernatur harum exercitationem nihil provident. Iure, earum voluptatem dignissimos similique natus quasi. Tempore voluptate accusamus dolores porro delectus voluptates nostrum rem sunt, molestiae suscipit perspiciatis, voluptas doloribus modi. Cumque voluptas officiis commodi labore! A illum reiciendis enim, quibusdam iste eos ratione obcaecati aspernatur. Quisquam dolor veniam suscipit. </p>
    </div>
</div>

<div class="about-title container text-center my-5">
    <h1>TESTIMONIALS</h1>
    <div class="about-line"></div>
</div>

<?php if($testimonials && $testimonials): ?> 
    <div class="container">
        <div class="d-flex align-items-center py-5 mh-100">    
            <a class="carousel-control-prev text-decoration-none " href="#mycarousel" role="button" data-bs-slide="prev">
                <div class="d-flex flex-column justify-content-center me-2 ms-auto left">PREV<span class="fas fa-arrow-left"></span> </div> <span class="sr-only">Previous</span>
        </a>
        <div class="container">
            <div id="mycarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <?php foreach($testimonials as $index => $testimonial): ?>
                        <div class="carousel-item <?= ($index === 0) ? 'active' : '' ?>">
                            <div class="row">
                                <div class="col-lg-6 ">
                                    <img src="./assets/images/about04.png" class="d-block w-100" alt="...">
                                </div>
                                <div class="col-lg-6 ">
                                    <div class=" d-flex flex-column justify-content-center my-5 px-3">
                                        <p class="review text-center">"<?= $testimonial['testimonial_desc'] ?>"</p>
                                        <div class="name d-flex align-items-center justify-content-center">
                                        <?php foreach($users as $user):?>
                                            <?php if($user['id'] === $testimonial['user_id']): ?>
                                                <span class="fas fa-minus pe-1"></span>
                                                <p class="m-0"><?= $user['name'] ?> <?= $user['surname'] ?></p>
                                            <?php endif; ?>
                                        <?php endforeach;?>
                                        </div>
                                        <p class="job text-center"><?= $testimonial['published_date'] ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <a class="carousel-control-next text-decoration-none " href="#mycarousel" role="button" data-bs-slide="next">
            <div class="d-flex flex-column justify-content-center right ms-2 me-auto"> NEXT <span class="fas fa-arrow-right"></span> </div> <span class="sr-only">Next</span>
        </a>
    </div>
</div>
<?php endif;?> 

<?php if(isset($_SESSION['is_loggedin']) && $_SESSION['is_loggedin'] === true): ?>
    <div class="container my-5">
        <div class="text-center secondaryColor">
            <h3>Testify</h3>
        </div>
        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST" class="container testify">
            <div class="mb-3 testify-comment text-center">
                <label for="testimonial_desc" class="form-label">Comment:</label>
                <input type="text" class="form-control" maxlength="100" id="testimonial_desc" name="testimonial_desc">
            </div>
            <button type="submit" name="post_testify" class="btn btn-primary">Submit</button>
        </form>
    </div>
<?php else: ?>
    <div class="container my-5 text-center">
        <div class="text-center secondaryColor">
            <h3>Login to testify!</h3>
        </div>
        <a class="primaryColor fw-bold text-decoration-none" href="login.php">Log-in</a>
    </div>
<?php endif; ?>













<?php include('includes/footer.php'); ?>