<?php

use App\Model\ProductModel;

$productId = $_POST['productId'];
$productModel = new ProductModel();
$productDetails = $productModel->getProductById($productId);
$productPictures = [];
$productPictures = ['status' => 'success'];

if (!empty($productDetails['picture_1'])) {
    $productPictures['pictures'][] = $productDetails['picture_1'];
}
if (!empty($productDetails['picture_2'])) {
    $productPictures['pictures'][] = $productDetails['picture_2'];
}
if (!empty($productDetails['picture_3'])) {
    $productPictures['pictures'][] = $productDetails['picture_3'];
}
if (!empty($productDetails['picture_4'])) {
    $productPictures['pictures'][] = $productDetails['picture_4'];
}

echo json_encode($productPictures);