<?php 
    ob_start();
    include('../includes/header.php'); 
    include('../../classes/CRUD.php');
    $errors = [];
    $crud = new CRUD;
    $events = $crud->read('events', ['column' => 'id', 'value' => $_GET['id']], 1);

    function imageValidation($image){
        $type = end(explode('.', $image));
        $imageTypes = ['png', 'jpg', 'jpeg', 'webp'];
        
        return in_array($type, $imageTypes);
    }

    if(isset($_POST['update_event'])){
        $id = $_POST['id'];
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
    
        if(empty($event_title)){
            $errors[] = 'Event Title is empty!';
        }
        if(empty(strlen(trim($event_desc)))){
            $errors[] = 'Event Description is empty!';
        }
        if(empty($start_date)){
            $errors[] = 'Start-date is empty!';
        }
        if(empty($end_date)){
            $errors[] = 'End-date is empty!';
        }
        
        
        if(isset($event_image['name']) && imageValidation($event_image['name'])){
            $data['event_image'] = time().$event_image['name'];
        }

        if(count($errors) === 0){
            if($crud->update('events', $data, ['column' => 'id', 'value' => $id]) === true){
                if(isset($event_image['name']) && imageValidation($event_image['name'])){
                    if(move_uploaded_file($event_image['tmp_name'], 'images/'.time().$event_image['name'])){
                        unlink('images/'.$event_image[0]['event_image']);
                    }
                }
                header('Location: index.php?action=update&status=success');
            }else{
                $errors = "Something went wrong!";
            }
        }else if(count($errors) > 0){
            $_SESSION['project_errors'] = $errors;
            header("Location: edit.php?id=$id&action=update&status=unsuccessfull");
        }
    }
    ob_end_flush();
?>

<div class="container my-5">
    <?php if(isset($_GET['action']) && isset($_GET['status'])): ?>
        <?php if(($_GET['action'] == 'update') && ($_GET['status'] == 'unsuccessfull')): ?>
            <?php if(isset($_SESSION['project_errors'])): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?php foreach($_SESSION['project_errors'] as $error): ?>
                        <p><?php echo $error; ?></p>
                    <?php endforeach; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php unset($_SESSION['project_errors']); ?>
            <?php endif; ?>
        <?php endif; ?>
    <?php endif; ?>
    <?php if(isset($events) && is_array($events[0])): ?>
    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="event_title" class="form-label">Event Title</label>
            <input type="text" class="form-control" id="event_title" value="<?= $events[0]['event_title'] ?>" name="event_title">
        </div>
        <div class="mb-3">
            <label for="start_date" class="form-label">Start Date </label>
            <input type="date" class="form-control" id="start_date" value="<?= $events[0]['start_date'] ?>" name="start_date">
        </div>
        <div class="mb-3">
            <label for="end_date" class="form-label">End Date </label>
            <input type="date" class="form-control" id="end_date" value="<?= $events[0]['end_date'] ?>" name="end_date">
        </div>
        <div class="mb-3">
            <label for="event_image" class="form-label">Image</label>
            <input class="form-control" type="file" id="event_image" name="event_image">
            <input type="image" src="images/<?= $events[0]['event_image'] ?>" height="120" class="my-3 rounded" name="event_image">
        </div>
        <div class="form-floating mb-3">
            <textarea class="form-control" placeholder="Describe the event here" id="event_desc" name="event_desc">
            <?= $events[0]['event_desc'] ?>
            </textarea>
            <label for="event_desc">Event Description</label>
        </div>
        <input type="hidden" name="id" value="<?= $events[0]['id']?>">
        <button type="submit" name="update_event" class="btn btn-warning">Update</button>
    </form>
    <?php endif; ?>
</div>



<?php include('../includes/footer.php'); ?>

