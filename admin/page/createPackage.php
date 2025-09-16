<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Creating Package</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../../assets/css/admin.style.css">
    <link rel="stylesheet" href="../../assets/css/dashboard.style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
   
<body>
    <style>
        * {
            box-sizing: border-box;
        }
   
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
    </style>
    <!-- Package Form -->
    <div class="d-flex justify-content-center align-items-center flex-column container">
        <?php

        include "../../database/config.php";
        if (isset($_REQUEST['submit'])) {
           
            $title = $_REQUEST['title'];
            
            $location = $_REQUEST['location'];
            $price = $_REQUEST['price'];
            $duration = $_REQUEST['duration'];
            $package_type = $_REQUEST['package_type'];
            $description = $_REQUEST['description'];
            $video_url = $_REQUEST['video_url'];



            // Handle file uploads
            $main_image = $_FILES['main_image']['name'];
            $sub_images = $_REQUEST['sub_images'];

            // Move uploaded files to the desired directory
            move_uploaded_file($_FILES['main_image']['tmp_name'], "../../../www.globe-gateways-php.com/uploads/" . $main_image);
            // Insert package details into the database
            
            $sql = "INSERT INTO packages (title, description, location, price, duration, package_type, main_image, sub_images, video_url) VALUES (
            '$title',
            '$description',
            '$location',
            '$price',
            '$duration',
            '$package_type',
            '$main_image',
            '$sub_images',
            '$video_url'
        )";

            $result = mysqli_query($conn, $sql);
            
            if ($result) {
                echo "<script>alert('Package created successfully!');</script>";
                header("Location: ../page/dashboard.php?package=package");
            } else {
                echo "Error: " . mysqli_error($conn);
            }

            exit();
        }


        ?>
        <form class="container pb-5" method="POST" enctype="multipart/form-data">
            <div class="title-container" style="margin: 100px;">
                <span>C</span><span>r</span><span>e</span><span>a</span><span>t</span><span>e</span><span>i</span><span>n</span><span>g</span>
                <span>&nbsp;&nbsp;</span>
                <span>P</span><span>a</span><span>c</span><span>k</span><span>a</span><span>g</span><span>e</span>
            </div>

            <div class="row mb-3">
                <div class="col-md-12">
                    <label class="form-label">Title</label>
                    <input type="text" class="form-control" name="title"
                        placeholder="Enter package title (e.g. Goa Beach Tour)" required>
                </div>
                
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Location</label>
                    <input type="text" class="form-control" name="location" placeholder="Enter location (e.g. Goa, India)"
                        required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Price</label>
                    <input type="number" step="0.01" class="form-control" name="price"
                        placeholder="Enter price (e.g. 14999)" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Duration</label>
                    <input type="text" class="form-control" name="duration"
                        placeholder="Enter duration (e.g. 5 Days / 4 Nights)">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Package Type</label>
                <select class="form-select" name="package_type">
                    <option value="Standard">Standard</option>
                    <option value="Premium">Premium</option>
                    <option value="Luxury">Luxury</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea class="form-control" name="description" rows="4"
                    placeholder="Write package details (e.g. itinerary, highlights, inclusions)"></textarea>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Main Image</label>
                    <input type="file" class="form-control" name="main_image" accept="image/*"
                        placeholder="Upload main package image">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Sub Images</label>
                    <input type="text" class="form-control" name="sub_images"
                        placeholder="Enter image URLs separated by commas">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Video URL</label>
                <input type="url" class="form-control" name="video_url" placeholder="Enter YouTube/Vimeo video link">
            </div>

            <!-- Buttons -->
            <div class="d-flex justify-content-between ">
                <a href="javascript:history.back()" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Back
                </a>
                <button type="submit" name="submit" class="btn btn-success">
                    <i class="bi bi-check"></i> Submit
                </button>
            </div>
        </form>
    </div>
</body>

</html>