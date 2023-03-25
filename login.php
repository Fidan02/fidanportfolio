<?php 
    ob_start();
    include('includes/header.php'); 
    $errors = [];

    if(isset($_POST['login_btn'])){
        $email = $_POST['email'];
        $password = $_POST['password'];
        
        $data = [
            'email' => $email,
            'password' => password_hash($password, PASSWORD_BCRYPT) 
        ];



        if(empty($email) || empty($password)){
            $errors[] = 'Some fields are empty! Fill them with info to proceed...';
        }


        if(count($errors) === 0){
            $user = $crud->read('users', ['column' => 'email', 'value' => $email], 1);

            if(count($user)){
                $user = $user[0];
            }

            if(password_verify($password, $user['password'])){
                //set sessions
                $_SESSION['id'] = $user['id'];
                $_SESSION['fullname'] = $user['name'] . " " . $user['surname'];
                $_SESSION['email'] = $email;
                $_SESSION['is_loggedin'] = true;
                $_SESSION['role'] = $user['role'];
                //redirect
                header('Location: dashboard/');
            }else{
                //error
                $errors[] = 'Username or password was incorrect!';
            }
        }
    }

    ob_end_flush();
?>


<div class="container text-center my-5 login-title">
    <h2 class="title">Log-In</h2>
    <div class="about-line"></div>
</div>

<div class="container">
    <div class="container my-5 row login-card">
        <div class="login-image col-xl-6 col-lg-6 col-md-6 col-sm-12">
            <img src="./assets/images/about04.png" alt="">
        </div>
        <div class="container login-form col-xl-6 col-lg-6 col-md-6 col-sm-12">
            <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password">
                </div>
                <div class="mb-3">
                    <button type="submit" name="login_btn" class="form-control" id="submit">Login</button>
                </div>
            </form>
            <div class="go-register container">
                <p>Do not have an account? <span><a href="register.php">Register</a></span></p>
            </div>
        </div>
    </div>
</div>















<?php include('includes/footer.php'); ?>