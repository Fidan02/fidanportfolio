<?php 
    include('includes/header.php');
    include('../classes/CRUD.php');
    
    $crud = new CRUD;
    $errors = [];

    $user = $crud->read('users', ['column' => 'id', 'value' => $_SESSION['id']], 1);
    
    if(is_array($user)){
        $user = $user[0];
    }
    //For user data
    if(isset($_POST['update_profile'])){
        
    }

    //For Pass
    if(isset($_POST[''])){
        
    }
?>


<div class="container my-5">
    <div class="title">
        <h1>Profile</h1>
        <div class="line"></div>
    </div>
</div>

<div class="container">
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
            <input type="image" height="300" width="250" src="../assets/images/about04.png" class="my-3 rounded" >
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
                <input type="text" class="form-control" id="password1" name="password">
            </div>
            <div class="my-3">
                <label for="password2" class="form-label">Repeat Password</label>
                <input type="text" class="form-control" id="password2" name="password">
            </div>
            <button type="submit" name="update_pass" class="btn btn-warning">Change Password</button>
        </div>
    </form>
</div>



<?php include('includes/footer.php')?>

