<?php 
    include('includes/header.php');
    // include('classes/CRUD.php');
    // $crud = new CRUD;
    $errors = [];
    $events = $crud->read('events');     
?>


<div class="event-title container my-5">
    <h1>EVENTS</h1>
    <div class="event-line"></div>
</div>

<?php if($events && count($events)): ?>
    <div class="container me-5 my-5">
        <div class="m-2 gap-5 row">
            <?php foreach($events as $event): ?>
                <div class="card event-card col-xl-5 col-lg-5 col-md-5 col-sm-12 p-0">
                    <img src="dashboard/events/images/<?= $event['event_image']?>" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title"><?= $event['event_title']?></h5>
                        <p class="card-text desc-scroll"><?= $event['event_desc']?></p>
                        <a href="singleevent.php?id=<?= $event['id']?>" class="btn btn-event">More Info</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif;?>




<?php include('includes/footer.php'); ?>