<?php 
    ob_start();
    include('../includes/header.php'); 
    include('../../classes/CRUD.php');
    
    $crud = new CRUD;
    $errors = [];
    
    if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin'){
        $testimonials = $crud->read('testimonials'); 
    }else if(isset($_SESSION['role']) && $_SESSION['role'] == 'person'){
        $testimonials = $crud->read('testimonials', ['column' => 'user_id', 'value' => $_SESSION['id']]);
    }
    $users = $crud->read('users');

    if(isset($_GET['action']) && ($_GET['action']) === 'delete'){
        if($crud->delete('testimonials', ['column' => 'id', 'value' => $_GET['id']])){
            header('Location: index.php');
        }
    }
    
    ob_end_flush();    
?>


<div class="container my-5 project-add-card">
    <div class="title">
        <h3>Testimonials</h3>
        <div class="line"></div>
    </div>
    <?php if($testimonials && count($testimonials)): ?>
        <div class="table-responsive project-table mt-3">
            <table class="table text-center align-middle">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Description</th>
                        <th>Publish Date</th>
                        <th>User</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($testimonials as $testimonial): ?>
                    <tr>
                        <td class="data-id"><?= $testimonial['id']?></td>
                        <td class="data-desc">
                            <div class="desc-scroll">
                                <?= $testimonial['testimonial_desc']?>
                            </div>
                        </td>
                        <td class="data-tools">
                            <span class="badge bg-danger"><?= $testimonial['published_date']?></span>
                        </td>
                        <?php foreach($users as $user):?>
                            <?php if($user['id'] === $testimonial['user_id']): ?>
                                <td class="data-title" value="<?= $user['id']?>"><?= $user['name']?></td>
                            <?php endif; ?>
                        <?php endforeach;?>
                        <td>
                            <a href="?action=delete&id=<?= $testimonial['id']?>"><i class="fa-solid fa-trash"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
    </div>
</div>


<?php include('../includes/footer.php'); ?>