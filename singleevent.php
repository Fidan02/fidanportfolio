<?php 
    ob_start();
    include('includes/header.php');
    // include('classes/CRUD.php');
    // $crud = new CRUD;
    $errors = [];
    function splitTools($tools){
        $type = explode(',', $tools);

        return $type;
    }

    if(isset($_GET['id'])){
        $event = $crud->read('events',['column' => 'id', 'value' => $_GET['id']]);
    }else{
        header('Location: projects.php');
    }
    
    ob_end_flush();
?>

<?php if(isset($event) && is_array($event[0])): ?>
    <div>
        <img src="dashboard/events/images/<?= $event[0]['event_image'] ?>" alt="" class="object-fit-cover btm-border" style="height: 400px; width: 100%;"/>
        <div class='container rounded-bottom bgPrimary d-flex justify-content-between'>
            <h2 class='fw-bold secondaryColor mt-2 ps-3'><?= $event[0]['event_title'] ?></h2>
            <p class='fw-bold secondaryColor mt-2 ps-3 pt-2 '>Date:
                <span class="badge bg-danger"><?= $event[0]['start_date'] ?></span> /
                <span class="badge bg-success"><?= $event[0]['end_date'] ?></span>
            </p>
        </div>
        <div class='container mt-5 p-2'>
            <h3 class='primaryColor'>Description 
            </h3>
            <div class='line my-3'></div>
            <div class="container pr-info">
                <div>
                    <p class='secondaryColor desc-width fw-bold'><?= $event[0]['event_desc'] ?></p>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>







<?php include('includes/footer.php'); ?>