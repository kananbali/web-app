<?php

// configuration
include 'config.php';

$row = $_POST['row'];
$rowperpage = 5;
// selecting posts
$query = 'SELECT * FROM category_master WHERE effective_end_dt is NULL ORDER BY category_name LIMIT '.$row.','.$rowperpage;
$result = mysqli_query($conn, $query);

$html = '';

while ($category = $result->fetch_assoc()) {

    $html .= '<div class="col-lg-3 col-md-5 col-sm-6 col-11" data-aos="fade-up post" data-aos-delay="200">';
    $html .= '<a class="text-center" href="category.php?category_id='.$category['category_id'].'" style="color:black;">';
    $html .= '<div class="box shadow p-0">';
    $html .= '<img src="admin/'.$category['category_image'].'" class="mb-3 p-2 img-fluid card-img-top">';
    $html .= '<h4 class=" my-3 ">'.$category['category_name'].'</h4>';
    $html .= '<p class="mx-4 " style="word-wrap: break-word;">'.$category['category_description'].'</p>';
    $html .= '</div>';
    $html .= '</a>';
    $html .= '</div>';
} 
echo $html;
?>