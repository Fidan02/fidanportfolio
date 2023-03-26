<?php 
    ob_start();
    include('../includes/header.php'); 
    include('../../classes/CRUD.php');
    $errors = [];
    $crud = new CRUD;

    function imageValidation($image){
        $types = explode('.', $image);
        $type = end($types);
        $imageTypes = ['png', 'jpg', 'jpeg', 'webp'];
        
        return in_array($type, $imageTypes);
    }


    if(isset($_POST['create_event'])){
        $event_title = $_POST['event_title'];
        $event_desc = $_POST['event_desc'];
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
        $event_image = $_FILES['event_image'];
        $data = [
            'event_title' => $event_title,
            'event_desc' => $event_desc,
            'start_date' => $start_date,
            'end_date' => $end_date,
        ];
    
        if(empty($event_title) || empty($event_desc) ||
        empty($start_date) || empty($end_date)){
            $errors[] = 'Some fields are empty! Fill them with data to proceed...';
        }
        
        if(empty($event_image['name']) || !imageValidation($event_image['name'])){
            $errors[] = 'Image is empty or type is not supported!';
        }else{
            $data['event_image'] = time().$event_image['name'];
        }

        if(count($errors) === 0){
            if($crud->create('events', $data) === true){
                if(isset($event_image['name']) && imageValidation($event_image['name'])){
                    move_uploaded_file($event_image['tmp_name'], 'images/'.time().$event_image['name']);
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
            <label for="event_title" class="form-label">Event Title</label>
            <input type="text" class="form-control" id="event_title" name="event_title">
        </div>
        <div class="mb-3">
            <label for="start_date" class="form-label">Start Date </label>
            <input type="date" class="form-control" id="start_date" name="start_date">
        </div>
        <div class="mb-3">
            <label for="end_date" class="form-label">End Date </label>
            <input type="date" class="form-control" id="end_date" name="end_date">
        </div>
        <div class="mb-3">
            <label for="event_image" class="form-label">Image</label>
            <input class="form-control" type="file" id="event_image" name="event_image">
        </div>
        <div class="form-floating mb-3">
            <textarea class="form-control" placeholder="Describe the event here" id="event_desc" name="event_desc"></textarea>
            <label for="event_desc">Event Description</label>
        </div>
        <button type="submit" name="create_event" class="btn btn-success">Submit</button>
    </form>
</div>



<?php include('../includes/footer.php'); ?>

