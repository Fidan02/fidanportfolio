<?php 
    include('includes/header.php'); 
    include('../classes/CRUD.php');
    
    $crud = new CRUD;
    $errors = [];
    $projects = count($crud->read('projects')); 
    $events = count($crud->read('events')); 
    $skills = count($crud->read('skills')); 
    $education = count($crud->read('education')); 
    $certificates = count($crud->read('certificates')); 
    $experience = count($crud->read('experience')); 
    $hobbies = count($crud->read('hobbies')); 



    if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin'){
        $testimonials = count($crud->read('testimonials')); 
    }else if(isset($_SESSION['role']) && $_SESSION['role'] == 'person'){
        $testimonials = count($crud->read('testimonials', ['column' => 'user_id', 'value' => $_SESSION['id']]));
    }
?>

<?php if(isset($_SESSION['is_loggedin']) && $_SESSION['is_loggedin'] === true): ?>
    <div class="container user-table my-3">
        <div class="user-info">
            <div class="user">
                <h4><?= $_SESSION['fullname'] ?></h4>
            </div>
            <div class="user-email">
                <h5><?= $_SESSION['email'] ?></h5>
            </div>
        </div>
        <div class="logout">
            <a class="btn" href="?action=logout">Log-Out</a>
        </div>
    </div>
    
    
    <div class="container">
        <div class="container dashboard-cards">
            <?php if(isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title">Projects</h2>
                        <h5 class="card-text"><?= $projects ?></h5>
                        <a href="projects/" class="btn btn-danger">Manage</a>
                    </div>
                </div>
                <?php endif; ?>
        <?php if(isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title">Events</h2>
                    <h5 class="card-text"><?= $events ?></h5>
                    <a href="events/" class="btn">Manage</a>
                </div>
            </div>
            <?php endif; ?>
            <?php if(isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title">Skills</h2>
                        <h5 class="card-text"><?= $skills ?></h5>
                        <a href="skills/" class="btn">Manage</a>
                    </div>
                </div>
                <?php endif; ?>
                <?php if(isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                    <div class="card">
                        <div class="card-body">
                            <h2 class="card-title">Education</h2>
                            <h5 class="card-text"><?= $education ?></h5>
                            <a href="education/" class="btn">Manage</a>
                        </div>
                    </div>
        <?php endif; ?>
        <?php if(isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title">Certificates</h2>
                    <h5 class="card-text"><?= $certificates ?></h5>
                    <a href="certificates/" class="btn">Manage</a>
                </div>
            </div>
            <?php endif; ?>
            <?php if((isset($_SESSION['role']) && $_SESSION['role'] !== 'admin') || (isset($_SESSION['role']) && $_SESSION['role'] !== 'person')): ?>
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title">Testimonials</h2>
                        <h5 class="card-text"><?= $testimonials ?></h5>
                        <a href="testimonials/" class="btn">Manage</a>
                    </div>
                </div>
                <?php endif; ?>
                <?php if(isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                    <div class="card">
                        <div class="card-body">
                            <h2 class="card-title">Experience</h2>
                            <h5 class="card-text"><?= $experience ?></h5>
                            <a href="experience/" class="btn">Manage</a>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php if(isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                        <div class="card">
                            <div class="card-body">
                                <h2 class="card-title">Hobbies</h2>
                                <h5 class="card-text"><?= $hobbies ?></h5>
                                <a href="hobbies/" class="btn">Manage</a>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
<?php endif; ?>


<?php include('includes/footer.php') ?>