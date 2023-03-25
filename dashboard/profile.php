<?php include('includes/header.php')?>


<div class="container">
    <div class="title">
        <h1>Profile</h1>
        <div class="line"></div>
    </div>
</div>

<div class="container">
    <form action="#" enctype="multipart/form-data">
        <div class="my-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name">
        </div>
        <div class="my-3">
            <label for="surname" class="form-label">Surname</label>
            <input type="text" class="form-control" id="surname" name="surname">
        </div>
        <div class="my-3">
            <label for="email" class="form-label">Email</label>
            <input type="text" class="form-control" id="email" name="email">
        </div>
        <div class="my-3">
            <label for="avatar_image" class="form-label">Avatar</label>
            <input type="file" class="form-control" id="avatar_image" name="avatar_image">
            <input type="image" height="300" width="250" src="../assets/images/about04.png" class="my-3 rounded" >
        </div>
        <div class="mb-3">
            <button type="submit" class="btn btn-success">Save</button>
        </div>
    </form>
</div>


    <!-- Password change -->
<div class="container my-3">
    <form action="#">
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
            <button type="submit" class="btn btn-warning">Change Password</button>
        </div>
    </form>
</div>



<?php include('includes/footer.php')?>

