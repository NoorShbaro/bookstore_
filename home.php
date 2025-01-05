<?php
include 'components/connect.php';

if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    $user_id = '';
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Store</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/user_style.css">
</head>

<body>
    <?php include 'components/user_header.php'; ?>

    <!--slider section start-->
    <div class="slider-container">
        <div class="slider">
            <div class="slideBox active">
                <div class="textBox">
                    <h1>We take pride in offering <br> stories that captivate and inspire</h1>
                    <a href="menu.php" class="btn">shop now</a>
                </div>
                <div class="imgBox">
                    <img src="image/slider4.webp">
                </div>
            </div>
            <div class="slideBox">
                <div class="textBox">
                    <h1>Every page is a journey, <br> every book a new adventure</h1>
                    <a href="menu.php" class="btn">shop now</a>
                </div>
                <div class="imgBox">
                    <img src="image/slider5.webp">
                </div>
            </div>
        </div>
        <ul class="controls">
            <li onclick="nextSlide();" class="next"><i class="bx bx-right-arrow-alt"></i></li>
            <li onclick="prevSlide();" class="prev"><i class="bx bx-left-arrow-alt"></i></li>
        </ul>
    </div>
    <!--slider slider end-->
    <div class="service">
        <div class="box-container">
            <!--slider item box-->
            <div class="box">
                <div class="icon">
                    <div class="icon-box">
                        <img src="image/motorbike.png" class="img1">
                        <img src="image/box.png" class="img2">
                    </div>
                </div>
                <div class="detail">
                    <h4>delivery</h4>
                    <span>fast delivery</span>
                </div>
            </div>
            <!--slider item box-->
            <!--slider item box-->
            <div class="box">
                <div class="icon">
                    <div class="icon-box">
                        <img src="image/cash-payment.png" class="img1">
                        <img src="image/credit-card.png" class="img2">
                    </div>
                </div>
                <div class="detail">
                    <h4>payment</h4>
                    <span>100% secure</span>
                </div>
            </div>
            <!--slider item box-->
            <!--slider item box-->
            <div class="box">
                <div class="icon">
                    <div class="icon-box">
                        <img src="image/support.png" class="img1">
                        <img src="image/24-7.png" class="img2">
                    </div>
                </div>
                <div class="detail">
                    <h4>support</h4>
                    <span>24/7</span>
                </div>
            </div>
            <!--slider item box-->
            <!--slider item box-->
            <div class="box">
                <div class="icon">
                    <div class="icon-box">
                        <img src="image/return.png" class="img1">
                        <img src="image/return-money.png" class="img2">
                    </div>
                </div>
                <div class="detail">
                    <h4>return</h4>
                    <span>with money back</span>
                </div>
            </div>
            <!--slider item box-->
        </div>
    </div>
    <!--service section end-->
    <!--category section start-->
    <div class="categories">
        <div class="heading">
            <h1>categories features</h1>
            <img src="image/seperator-img.png">
        </div>
        <div class="box-container">
            <div class="box">
                <img src="image/tech.jpg">
                <a href="menu.php" class="btn">technology</a>
            </div>
            <div class="box">
                <img src="image/math.jpg">
                <a href="menu.php" class="btn">math</a>
            </div>
            <div class="box">
                <img src="image/foods.jpg">
                <a href="menu.php" class="btn">food</a>
            </div>
            <div class="box">
                <img src="image/astronaut.jpg">
                <a href="menu.php" class="btn">astronaut</a>
            </div>
            <div class="box">
                <img src="image/travels.jpg">
                <a href="menu.php" class="btn">travel</a>
            </div>
        </div>
    </div>
    <!--category section end-->
    <img src="image/menu-banner.jpg" class="menu-banner">

    <div class="type">
        <div class="heading">
            <span>type</span>
            <h1>buy 5 books with 40% sale</h1>
            <img src="image/seperator-img.png">
        </div>
        <div class="box-container">
            <div class="box">
                <img src="image/type.jpg">
                <div class="detail">
                    <h2>Immerse Yourself in Stories</h2>
                    <h1>The World of Books</h1>
                </div>
            </div>
            <div class="box">
                <img src="image/type0.jpg">
                <div class="detail">
                    <h2>Adventure Awaits</h2>
                    <h1>Discover Your Next Chapter</h1>
                </div>
            </div>
            <div class="box">
                <img src="image/type1.jpg">
                <div class="detail">
                    <h2>Fuel Your Imagination</h2>
                    <h1>Uncover Hidden Worlds</h1>
                </div>
            </div>
        </div>
    </div>
    <!--type section end-->
    <div class="book-container">
        <div class="overlay"></div>
        <div class="detail">
            <h1>Books are cheaper than therapy<br> and just as soothing</h1>
            <p>Immerse yourself in the comfort of words that heal and inspire.
                <br> Every book is a friend offering solace in tough times,
                <br> wisdom when you need it most, and endless adventures
                <br> that transport you to places unknown.
                <br> Discover stories that stay with you forever.
            </p>
            <a href="menu.php" class="btn">shop now</a>
        </div>
    </div>
    <!--container section end-->
    <div class="type2">
        <div class="t-banner">
            <div class="overlay"></div>
            <div class="detail">
                <h1>Find your next great adventure</h1>
                <p>Treat yourself to a captivating story<br>
                    or send the gift of imagination to someone special.<br>
                    Books open doors to endless worlds and unforgettable journeys!</p>
                <a href="menu.php" class="btn">shop now</a>
            </div>
        </div>
        <div class="box-container">
            <div class="box">
                <div class="box-overlay"></div>
                <img src="image/type2.jpg">
                <div class="box-details fadeIn-bottom">
                    <h1>Fantasy</h1>
                    <p>Step into realms of magic and wonder, <br> where imagination knows no bounds.</p>
                    <a href="menu.php" class="btn">explore more</a>
                </div>
            </div>
            <div class="box">
                <div class="box-overlay"></div>
                <img src="image/adv.jpg">
                <div class="box-details fadeIn-bottom">
                    <h1>Adventure</h1>
                    <p>Embark on journeys beyond the horizon, <br> where every page is an untold story waiting for you.</p>
                    <a href="menu.php" class="btn">explore more</a>
                </div>
            </div>
            <div class="box">
                <div class="box-overlay"></div>
                <img src="image/type3.jpg">
                <div class="box-details fadeIn-bottom">
                    <h1>Thrillers</h1>
                    <p>Uncover mysteries and plot twists <br> that will keep you on the edge of your seat.</p>
                    <a href="menu.php" class="btn">explore more</a>
                </div>
            </div>
        </div>
    </div>
    <!--type2 section end-->
    <div class="genre">
        <div class="box-container">
            <img src="image/left-banner2.jpg">
            <div class="detail">
                <h1>hot deal ! sale up to <span>50% off</span></h1>
                <p>expired</p>
                <a href="menu.php" class="btn">shop now</a>
            </div>
        </div>
    </div>
    <!--genre section end-->
    <div class="usage">
        <div class="heading">
            <h1>how it works</h1>
            <img src="image/seperator-img.png">
        </div>
        <div class="row">
            <div class="box-container">
                <div class="box">
                    <img src="image/book.png">
                    <div class="detail">
                        <h3>Explore New Reads</h3>
                        <p>Delve into worlds unknown and stories untold.
                            <br> From timeless classics to modern bestsellers,
                            <br> discover a book that speaks to you.
                        </p>
                    </div>
                </div>
                <div class="box">
                    <img src="image/book1.png">
                    <div class="detail">
                        <h3>Uncover Hidden Gems</h3>
                        <p>Every page is a journey waiting to be explored.
                            <br> Find books that inspire, educate, and entertain.
                            <br> Your next favorite read is here.
                        </p>    
                    </div>
                </div>
                
                <div class="box">
                    <img src="image/book2.png">
                    <div class="detail">
                        <h3>For the Love of Stories</h3>
                        <p>Lose yourself in captivating tales
                            <br> that ignite imagination and fuel curiosity.
                            <br> Dive into a story today.
                        </p>
                    </div>
                </div>
                <div class="box">
                    <img src="image/book3.png">
                    <div class="detail">
                        <h3>Curated for You</h3>
                        <p>Handpicked selections to match your taste.
                            <br> From gripping thrillers to heartwarming romances,
                            <br> we have something for everyone.
                        </p>
                    </div>
                </div>
            </div>
            <img src="image/sub-banner.jpg" class="divider">
        </div>
    </div>
    <!--usage section end-->
    <div class="pride">
        <div class="detail">
            <h1>We pride ourselves on<br> exceptional stories.</h1>
            <p>Explore a world of knowledge, adventure, and inspiration.
                <br> Every book offers a journey worth taking.
            </p>
            <a href="menu.php" class="btn">shop now</a>
        </div>
    </div>
    <!--pride section end-->
    <?php include 'components/footer.php'; ?>
    <!--link got from sweet alert cdn link-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <!--my javascript code-->
    <script src="js/user_script.js" defer></script>

    <?php include 'components/alert.php'; ?>
</body>

</html>