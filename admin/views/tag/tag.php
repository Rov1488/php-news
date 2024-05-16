<?php

require __DIR__. "/../layout/header.php";

//PAGINATION options
$page = 1;
if (isset($_GET['page'])) {
    $page = $_GET['page'];
}
//Keyingi bet ikonka
$next_page = $page + 1;
//Oldingi bet ikonka
$previous_page = $page - 1;

//Bazadan ma'lumoti o'chirish
$id = null;
$del = null;
$sort = null;
$order = null;

if(isset($_GET['id']) && isset($_GET["del"]) && !empty($_GET["del"]) == 'del-item'){
    $id = $_GET['id'];
    $del = $_GET["del"];
    $result = deleteData("tag", $id, $del);
    if ($result){
        redirect('tag.php');
    }
}

//Sorting by title
if (isset($_GET['sort']) && !empty($_GET['sort'])){
    $sort = $_GET['sort'];
    $s_elements = explode(',', $sort);
    $s_title = $s_elements[0];
    $s_type = $s_elements[1];
    $order = $s_title ." ". $s_type;

}
// echo "bu kategoriya sahifasi";
?>

    <div class="container justify-content-lg-center">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">TAG</li>
            </ol>
        </nav>

        <div class="d-grid gap-1 d-md-block">
            <a href="add_tag.php" class="btn btn-success">ADD TAG</a>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-12">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th scope="col">#ID
                                <?php if (!empty($s_type) &&  $s_type == 'asc'): ?>
                                    <a href="tag.php?sort=id,desc">
                                        <i class="bi bi-sort-down-alt"></i>
                                    </a>
                                <?php elseif (!empty($s_type) &&  $s_type == 'desc'): ?>
                                    <a href="tag.php?sort=id,asc">
                                        <i class="bi bi-sort-up-alt"></i>
                                    </a>
                                <?php else:?>
                                    <a href="tag.php?sort=id,asc">
                                        <i class="bi bi-sort-down-alt"></i>
                                    </a>
                                <?php endif; ?>
                            </th>
                            <th scope="col">Tag name
                                <?php if (!empty($s_type) &&  $s_type == 'asc'): ?>
                                    <a href="tag.php?sort=name,desc">
                                        <i class="bi bi-sort-down-alt"></i>
                                    </a>
                                <?php elseif (!empty($s_type) &&  $s_type == 'desc'): ?>
                                    <a href="tag.php?sort=name,asc">
                                        <i class="bi bi-sort-up-alt"></i>
                                    </a>
                                <?php else:?>
                                    <a href="tag.php?sort=name,asc">
                                        <i class="bi bi-sort-down-alt"></i>
                                    </a>
                                <?php endif; ?>
                            </th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach (getListSort('tag', $page, $order) as $item): ?>
                            <tr>

                                <td><?=$item['id'];?></td>
                                <td><?=$item['name'];?></td>
                                <td>
                                    <a href="edit_tag.php?id=<?=$item['id'];?>"><i class="bi bi-pencil-square"></i></a>
                                    <a class="delete" name="del_item" href="tag.php?id=<?=$item['id'];?>&del=del-item"><i class="bi bi-trash3"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <!--Pagination-->
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center">
                        <?php if ($previous_page > 0): ?>
                            <li class="page-item">
                                <a class="page-link" href="tag.php?page=<?=$previous_page; ?>" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                        <?php endif;?>
                        <?php for ($i = 1; $i <= getPageCount('tag'); $i++): $val_sort = $i; ?>
                            <?php if(!is_null($order)){
                                $val_sort = $i."&"."sort=".$sort;
                            } ?>
                            <li class="page-item <?php echo (isset($_GET["page"]) && $_GET["page"] == $i) ? 'active' : ''?>">
                                <a class="page-link" href="tag.php?page=<?=$val_sort;?>"><?=$i?></a>
                            </li>
                        <?php endfor; ?>
                        <?php if ($next_page <= getPageCount("tag")):?>
                            <li class="page-item">
                                <a class="page-link" href="tag.php?page=<?=$next_page; ?>" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        <?php endif;?>
                    </ul>
                </nav>
            </div>


        </div>
    </div>
<?php include __DIR__. "/../layout/footer.php"; ?>