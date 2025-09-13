<?php
include '../../database/config.php';

if (isset($_GET['id'])) {
    $package_id = $_GET['id'];
    $sql = "SELECT * FROM packages WHERE package_id = '$package_id'";
    $result = mysqli_query($conn, $sql);
    $package = mysqli_fetch_assoc($result);
}


if (isset($_POST['update'])) {

    $title = $_POST['title'];
    $location = $_POST['location'];
    $price = $_POST['price'];
    $duration = $_POST['duration'];
    $package_type = $_POST['package_type'];
    $description = $_POST['description'];
    $video_url = $_POST['video_url'];

    // Handle file uploads
    $main_image = $_FILES['main_image']['name'] ?: $package['main_image'];
    $sub_images = $_POST['sub_images'];

    if (!empty($_FILES['main_image']['tmp_name'])) {
        move_uploaded_file($_FILES['main_image']['tmp_name'], "../../../www.globe-gateways-php.com/uploads/" . $main_image);
    }


    // Update package details in the database
    $sql = "UPDATE packages SET
        title = '$title',
        location = '$location',
        price = '$price',
        duration = '$duration',
        package_type = '$package_type',
        description = '$description',
        video_url = '$video_url',
        main_image = '$main_image',
        sub_images = '$sub_images'
        WHERE package_id = '$package_id'
    ";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        echo "<script>alert('Package updated successfully!');</script>";
        header("Location: ../page/dashboard.php?package=package");
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Package</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../../assets/css/admin.style.css">
    <link rel="stylesheet" href="../../assets/css/dashboard.style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background-color: #f8f9fa; font-family: Arial, sans-serif;">

<div class="d-flex justify-content-center align-items-center flex-column container">
    <form class="container" method="POST" enctype="multipart/form-data" style="margin: 100px;">
        <div class="title-container mb-4">
            <span>E</span><span>d</span><span>i</span><span>t</span>
            <span>&nbsp;&nbsp;</span>
            <span>P</span><span>a</span><span>c</span><span>k</span><span>a</span><span>g</span><span>e</span>
        </div>

        <input type="hidden" name="package_id" value="<?php echo $package['package_id']; ?>">

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Title</label>
                <input type="text" class="form-control" name="title" value="<?php echo $package['title']; ?>" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Location</label>
                <input type="text" class="form-control" name="location" value="<?php echo $package['location']; ?>" required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4">
                <label class="form-label">Price</label>
                <input type="number" class="form-control" name="price" value="<?php echo $package['price']; ?>" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Duration</label>
                <input type="text" class="form-control" name="duration" value="<?php echo $package['duration']; ?>" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Package Type</label>
                <select class="form-select" name="package_type">
                    <option value="Standard" <?php if ($package['package_type']=="Standard") echo "selected"; ?>>Standard</option>
                    <option value="Premium" <?php if ($package['package_type']=="Premium") echo "selected"; ?>>Premium</option>
                    <option value="Luxury" <?php if ($package['package_type']=="Luxury") echo "selected"; ?>>Luxury</option>
                </select>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea class="form-control" name="description" rows="4"><?php echo $package['description']; ?></textarea>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Main Image</label>
                <input type="file" class="form-control" name="main_image">
                <small class="text-muted">Current: <?php echo $package['main_image']; ?></small>
            </div>
            <div class="col-md-6">
                <label class="form-label">Sub Images</label>
                <input type="text" class="form-control" name="sub_images" value="<?php echo $package['sub_images']; ?>">
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Video URL</label>
            <input type="url" class="form-control" name="video_url" value="<?php echo $package['video_url']; ?>">
        </div>

        <div class="d-flex justify-content-between">
            <a href="javascript:history.back()" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Back
            </a>
            <button type="submit" name="update" class="btn btn-success">
                <i class="bi bi-check"></i> Update
            </button>
        </div>
    </form>
</div>
</body>
</html>
