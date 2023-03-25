<?php 
    ob_start();
    include('includes/header.php'); 
    $errors = [];

    if(isset($_POST['register_btn'])){
        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $email = $_POST['email'];
        $password1 = $_POST['password1'];
        $password2 = $_POST['password2'];
        
        $data = [
            'name' => $name, 
            'surname' => $surname, 
            'email' => $email,
            'password' => password_hash($password1, PASSWORD_BCRYPT) 
        ];



        if(empty($name) || empty($surname) || empty($email)){
            $errors[] = 'Some fields are empty! Fill them with info to proceed...';
        }

        if($password1 !== $password2){
            $errors[] = 'Passwords fields are not the same!';
        }


        if(count($errors) === 0){
            if($crud->create('users', $data) === true){
                header('Location: login.php?action=register&status=1');
            }else{
                $errors = 'Something went wrong!'; 
            }
        }
    }

    ob_end_flush();
?>


<div class="container text-center my-5 login-title">
    <h2 class="title">Register</h2>
    <div class="about-line"></div>
</div>

<div class="container">
    <div class="container my-5 row login-card">
        <div class="login-image col-xl-6 col-lg-6 col-md-6 col-sm-12">
            <img src="./assets/images/about04.png" alt="">
        </div>
        <div class="container login-form col-xl-6 col-lg-6 col-md-6 col-sm-12">
            <?php if($errors): ?>
                <div class="alert alert-danger" role="alert">
                    <ul class="list-unstyled">
                        <?php foreach($errors as $error): ?>
                        <li><i class="fa-solid fa-arrow-right"></i> <?= $error; ?></li>
                        <?php endforeach;?>
                    </ul>
                </div>
            <?php endif;?>
            <form action="<?= $_SERVER['PHP_SELF']?>" method="POST">
                <div class="mb-3 d-flex justify-content-between align-items-center">
                    <div class="name">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name">
                    </div>
                    <div class="sursname">
                        <label for="surname" class="form-label">Surname</label>
                        <input type="text" class="form-control" id="surname" name="surname">
                    </div>
                </div>
                <div class="mb-3">
                    
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" name="email" id="email" placeholder="name@example.com">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" name="password1" id="password">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Confirm Passowrd</label>
                    <input type="password" class="form-control" name="password2" id="password">
                </div>
                <div class="mb-3">
                    <button type="submit" name="register_btn" class="form-control" id="submit">Register</button>
                </div>
            </form>
            <div class="go-register container">
                <p>Already have an account? <span><a href="login.php">Log-In</a></span></p>
            </div>
        </div>
    </div>
</div>















<?php include('includes/footer.php'); ?>