<div class="home-main">
                <div class="title-container">
                    <div class="globeGateways ">
                        <p class="text-animate">your one-stop solution for all your gateway needs.</p>
                        <h1 style="display: inline;" class="hvr ">Globe</h1>
                        <h1 style="display: inline;" class="hvr ">Gateways</h1>
                    </div>
                    <p class="text-animate">It is a one-stop travel platform offering easy access to explore and book exciting tour packages worldwide.</p>
                </div>
            </div>
            <div class="package-main">
                <div class="fheading ">
                    <h1 class="text-animate">exaplore</h1>
                    <h1 class="">Packages</h1>
                </div>

                <?php
                include '../database/config.php';

                $result = $conn->query("SELECT * FROM packages");

                if ($result->num_rows > 0): ?>
                    <div id="fimages">
                        <div id="fleft">
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <div class="fleftelm">
                                    <h1><?php echo $row['title']; ?>,</h1>
                                    <h3><?php echo $row['description']; ?></h3>
                                    <h3>At : <?php echo $row['location']; ?></h3>
                                    <h4>₹ <?php echo $row['price']; ?> & <?php echo $row['duration']; ?> </h4>
                                    <a class="magnet" href="../client/index.php?booking=booking&id=<?php echo $row['package_id']; ?>"><button>View More</button></a>
                                </div>
                            <?php endwhile; ?>
                        </div>
                        <div id="fright">
                            <div class="images magnet">
                                <?php
                                $result->data_seek(0);
                                while ($row = $result->fetch_assoc()): ?>
                                    <img src="../../www.globe-gateways-php.com/uploads/<?php echo $row['main_image']; ?>">
                                <?php endwhile; ?>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <p>No packages found.</p>   
                <?php endif; ?>
            </div>