<?php 
    ob_start();
    include('includes/header.php');
    include('../classes/CRUD.php');
    
    $crud = new CRUD;
    $errors = [];
    $user = $crud->read('users', ['column' => 'id', 'value' => $_SESSION['id']], 1);
    
    if(is_array($user)){
        $user = $user[0];
    }
    function imageValidation($image){
        $types = explode('.', $image);
        $type = end($types);
        $imageTypes = ['png', 'jpg', 'jpeg', 'webp'];
        
        return in_array($type, $imageTypes);
    }
    //For user data
    if(isset($_POST['update_profile'])){
        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $email = $_POST['email'];
        $avatar = $_FILES['avatar_image'];
        $data = [
            'name' => $name,
            'surname' => $surname,
            'email' => $email,
        ];

        if(empty($name)){
            $errors[] = 'Name field is empty';
        }
        if(empty($surname)){
            $errors[] = 'Surname field is empty';
        }
        if(empty($email)){
            $errors[] = 'Email field is empty';
        }

        if(isset($avatar['name']) && imageValidation($avatar['name'])){
            $data['avatar_image'] = time().$avatar['name'];
        }


        if(count($errors) == 0){
            if($crud->update('users', $data, ['column' => 'id', 'value' => $_SESSION['id']]) === true){
                if(isset($avatar['name']) && imageValidation($avatar['name'])){
                    if(move_uploaded_file($avatar['tmp_name'], 'avatars/'.time().$avatar['name'])){
                        unlink('avatars/'.$avatar[0]['project_image']);
                    }
                }
                header('Location: profile.php?action=update&status=success');
            }else{
                $errors[] = "Something went wrong!";
            }
        }else if(count($errors) > 0){
            $_SESSION['profile_errors'] = $errors;
            header("Location: profile.php?action=update&status=unsuccessfull");
        }

    }

    //For Pass
    if(isset($_POST['update_pass'])){
        $password1 = $_POST['password1'];
        $password2 = $_POST['password2'];

        if(empty($password1)){
            $errors[] = 'Password field is empty';
        }
        if(empty($password2)){
            $errors[] = 'Repeat Password field is empty';
        }
        if($password1 !== $password2){
            $errors[] = 'Passwords are not the same!';
        }

        if(count($errors) == 0){
            $data = [
                'password' => password_hash($password1, PASSWORD_BCRYPT),
            ];

            if($crud->update('users', $data, ['column' => 'id', 'value' => $_SESSION['id']]) === true){
                header('Location: profile.php');
            }else{
                $errors[] = 'Something went wrong';
            }
        }else if(count($errors) > 0){
            $_SESSION['profile_errors'] = $errors;
            header("Location: profile.php?action=update&status=unsuccessfull");
        }
    }
    ob_end_flush();
?>


<div class="container my-5">
    <div class="title">
        <h1>Profile</h1>
        <div class="line"></div>
    </div>
</div>



<div class="container">
    <?php if(isset($_GET['action']) && isset($_GET['status'])): ?>
        <?php if(($_GET['action'] == 'update') && ($_GET['status'] == 'unsuccessfull')): ?>
            <?php if(isset($_SESSION['profile_errors'])): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?php foreach($_SESSION['profile_errors'] as $error): ?>
                        <p><?php echo $error; ?></p>
                    <?php endforeach; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php unset($_SESSION['profile_errors']); ?>
            <?php endif; ?>
        <?php endif; ?>
    <?php endif; ?>
    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
        <div class="my-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="<?= $user['name'] ?>">
        </div>
        <div class="my-3">
            <label for="surname" class="form-label">Surname</label>
            <input type="text" class="form-control" id="surname" name="surname" value="<?= $user['surname'] ?>">
        </div>
        <div class="my-3">
            <label for="email" class="form-label">Email</label>
            <input type="text" class="form-control" id="email" name="email" value="<?= $user['email'] ?>">
        </div>
        <div class="my-3">
            <label for="avatar_image" class="form-label">Avatar</label>
            <input type="file" class="form-control" id="avatar_image" name="avatar_image">
            <input type="image" height="300" width="250" src="avatars/<?= $user['avatar_image'] ?>" class="my-3 rounded" >
        </div>
        <div class="mb-3">
            <button type="submit" name="update_profile" class="btn btn-success">Save</button>
        </div>
    </form>
</div>


    <!-- Password change -->
<div class="container my-3">
    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
        <div class="my-3 border rounded p-2">
            <div class="title">
                <h4>Change Password</h4>
            </div>
            <div class="my-3">
                <label for="password1" class="form-label">Password</label>
                <input type="password" class="form-control" id="password1" name="password1">
            </div>
            <div class="my-3">
                <label for="password2" class="form-label">Repeat Password</label>
                <input type="password" class="form-control" id="password2" name="password2">
            </div>
            <button type="submit" name="update_pass" class="btn btn-warning">Change Password</button>
        </div>
    </form>
</div>



<?php include('includes/footer.php')?>

