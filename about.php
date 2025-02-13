
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SimplyWear</title>
    <link rel="stylesheet" href="css/main.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css?v=<?php echo time(); ?>">
</head>
<body>
    <section id="header">
    <?php require "navbar.php"; ?>
    </section>

    <section id="page-header" class="about-header">
        <h2>#Know Us</h2>
        <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit.</p>
    </section>

    <section id="about-head" class="section_p1">
        <img src="img/about/a6.jpg" alt="">
        <div>
            <h2>Who We Are?</h2>
            <p>Bridge Courier is a logistics and delivery company dedicated to providing fast, reliable, and secure courier services. Specializing in seamless transportation solutions, Bridge Courier offers a range of options, from same-day delivery to international shipping, ensuring that packages reach their destinations safely and on time. Committed to exceptional customer service, the company provides easy tracking, flexible pickup and drop-off options, and transparent pricing. Bridge Courier’s mission is to bridge the gap between businesses and customers by connecting people, places, and products efficiently across distances.</p>
            <br/>
            <marquee bgcolor="#ccc" loop="-1" scrollamount="5" width="100%">"At Bridge Courier, we go the extra mile to deliver not just packages but peace of mind, connecting you to what matters most with speed, security, and reliability."</marquee>
        </div>
    </section>

    

    <section id="feature" class="section_p1">
        <div class="fe-box">
            <img src="img/features/f1.png" alt="">
            <h6>Free Shipping</h6>
        </div>
        <div class="fe-box">
            <img src="img/features/f2.png" alt="">
            <h6>Online Order</h6>
        </div> 
        <div class="fe-box">
            <img src="img/features/f3.png" alt="">
            <h6>Save Money</h6>
        </div> 
        <div class="fe-box">
            <img src="img/features/f4.png" alt="">
            <h6>Promotion</h6>
        </div> 
        <div class="fe-box">
            <img src="img/features/f5.png" alt="">
            <h6>Happy Sell</h6>
        </div> 
        <div class="fe-box">
            <img src="img/features/f6.png" alt="">
            <h6>Support</h6>
        </div>
    </section>
    
    <?php require "footer.php"; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="script.js"></script>
</body>
</html>