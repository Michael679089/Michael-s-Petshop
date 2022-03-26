<!-- PHP -->
<?php
include_once 'dbh.inc.php'; // This includes the connection of the database


// Session store data
session_start();

if (!isset($_SESSION["cartItems"])) {
    $_SESSION["cartItems"] = array();
}

if (!isset($_SESSION["necessityCart"])) {
    $_SESSION["necessityCart"] = array();
}
?>

<!-- HTML -->
<!doctype html>
<html lang="en">


<head>
  <title> Michael's Pet Shop </title>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!-- TAILWIND -->
  <link href="public/tailwind.css" rel="stylesheet">
  <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
  <!-- JQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.slim.min.js" integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>
  <!-- SWEET ALERT 2 -->
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<!-- SCRIPT -->
<script>
  $(document).ready(function() {
    const BurMenu = $('#CollapseBTN');
    const openSVG = $('#open');
    const closeSVG = $('#close');
    const target = $('#menu');
    var isOpen = false;

    BurMenu.click(function() {
      if (isOpen == false) {
        isOpen = true;
        target.removeClass("hidden");
        target.addClass("block");
        openSVG.addClass("hidden");
        closeSVG.removeClass("hidden");
      } else if (isOpen == true) {
        isOpen = false;
        target.removeClass("block");
        target.addClass("hidden");
        openSVG.removeClass("hidden");
        closeSVG.addClass("hidden");
      }
    })

    // DISPLAY CART ITEMS WHEN CLICKED
    const cartBTN = $("#cart-BTN");
    cartBTN.click(function() {
      $("#displayCartItems").toggle();
    });
  });
</script>

<!-- BODY -->

<body>
  <!-- NAVBAR -->
  <section>
        <nav class="w-full bg-gradient-to-l from-red-300 px-5 md:px-20 overflow-hidden">
            
            <!-- CART BTN -->
            <div class="w-full">
            
            <!-- COLLAPSE-BTN -->
            <div class="flex float-left">
                <button class="md:hidden rounded-b -ml-3 transform translate-y-4" id="CollapseBTN">
                <svg class="" viewBox="0 0 100 80" width="40" height="40" id='open'>
                    <rect width="100" height="20"></rect>
                    <rect y="30" width="100" height="20"></rect>
                    <rect y="60" width="100" height="20"></rect>
                </svg>
                
                <svg class="hidden" viewBox="0 0 90 80" width="40" height="40" id='close'>
                    <rect width="100" height="20" x="10" y="-10" rx="8" transform="rotate(45)"></rect>
                    <rect width="100" height="20" x="-50" y="50" rx="8" transform="rotate(-45)"></rect>
                </svg>
                </button>
            </div>

            <!-- MySQL Statement -->
            <?php
                $sql = "SELECT * FROM products_cattreat";
                $result = mysqli_query($conn, $sql); 
                $resultCheck = mysqli_num_rows($result);

                if ($resultCheck > 0){
                echo "connection success";
                } else {
                echo "error";
                }
            ?>

            
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>"> <!-- This makes the CART BTN checkout work -->
                <!-- The CART BTN -->
                <div class="flex float-right items-center">
                <div class="w-5 h-5 md:w-10 md:h-10 mt-5 p-1 rounded border border-gray-500 hover:bg-gray-200 transform hover:rotate-3" id='cart-BTN'>
                    <img src="images/shopping/shopping-cart-empty-side-view.png" alt="🛒">
                </div>

                <!-- COUNT ITEMS PHP -->
                <div class="h-1 md:h-2 text-xs text-center absolute transform translate-x-3 -translate-y-2 md:translate-x-6 md:-translate-y-4">
                    <?php
                    if ( (count($_SESSION["cartItems"]) + count($_SESSION["necessityCart"])) <= 0) {
                    echo "<div class='rounded-full py-0.5 px-1.5 md:px-2 bg-gray-500'>0</div>";
                    } else if ((count($_SESSION["cartItems"]) + count($_SESSION["necessityCart"])) > 0 ) {
                    echo "<div class='rounded-full bg-red-600 px-1'>";
                    echo count($_SESSION["cartItems"]) + count($_SESSION["necessityCart"]);
                    echo "</div>";
                    }
                    ?>
                </div>

                <!-- Displaying of Items -->
                <?php
                if (count($_SESSION["cartItems"]) >= 1 || count($_SESSION["necessityCart"]) >= 1) {
                    echo
                    "<div class='w-48 h-64 hidden bg-gray-200 rounded fixed z-10 transform -translate-x-40 md:-translate-x-20 translate-y-36' id='displayCartItems'>
                    <div class='w-auto bg-blue-400 rounded-t px-2 py-1'>
                        <p> Services <span class='bg-white text-xs px-2 py-1  rounded-full'> count: " . count($_SESSION["cartItems"]) + count($_SESSION["necessityCart"]) . "</p>
                    </div>    
                    <!-- Scroll -->
                    <div class='overflow-y-scroll overflow-x-hidden h-full'>";

                    // Display Services
                    foreach ($_SESSION["cartItems"] as $item) {
                    echo "
                        <!-- Service Item -->
                            <div class='m-1 bg-white block border border-black'>
                            <!-- Gray Banner -->
                            <div class='w-auto grid grid-cols-2 bg-gray-400 px-2 items-center'>
                                <div>
                                <p class='font-bold uppercase'>" . $item[1] . "</p>
                                </div>
                            <div>
                                <p class='text-xs italic'>" . $item[3] . "</p>
                            </div>
                            </div>

                            <!-- Pet Name -->
                            <div class='w-auto m-1 block'>
                            <p class='text-sm italic'>" . $item[2] . "</p>
                            </div>

                            <!-- Services -->
                            <div class='w-auto m-1 block text-sm'>
                            <p> Services: </p>
                            <div class='grid grid-cols-1 justify-between'>
                                <div class='w-auto m-1 block text-xs'>
                                " . $item[4] . "
                                </div>
                                <div class='w-auto m-1 block text-xs'>
                                " . $item[5] . "
                                </div>
                                <div class='w-auto m-1 block text-xs'>
                                " . $item[6] . "
                                </div>
                            </div>
                            </div>

                            <!-- Date -->
                            <div class='w-auto m-1 block text-sm'>
                            <p> Date: </p>
                            <p class='text-xs'>" . $item[7] . "</p>
                            </div>

                            <!-- Service Total Prize -->
                            <div class='w-auto block bg-gray-200 m-1 px-2 py-1'>
                            <div class='grid grid-cols-2'>
                                <div class='flex-1'>
                                <p class='text-sm'> Amount: </p>
                                </div>
                                <div class='flex-1'>
                                <p class='text-sm'> " . $item[8] . " </p>
                                </div>
                            </div>
                            </div>
                        </div>
                        ";
                    }
                    foreach ($_SESSION["necessityCart"] as $item) {
                        echo "
                            <!-- Service Item -->
                            <div class='m-1 bg-white block border border-black'>
                                <!-- Gray Banner -->
                                <div class='w-auto grid grid-cols-2 bg-gray-400 px-2 items-center'>
                                    <div>
                                        <p class='font-bold uppercase'>" . $item[2] . "</p>
                                    </div>
                                    <div>
                                    <p class='text-xs italic float-right'>₱ " . $item[3] . "</p>
                                    </div>
                                </div>
                                <div class='grid grid-cols-2'>
                                    <div class='text-xs'>
                                        <p class='text-xs'> Product_ID: ".$item[0]." </p>
                                        <b class='font-bold'>Brand Name:</b> ".$item[1]."
                                        <b class='font-bold'>Price:</b>  ₱".$item[3]."
                                    </div>
                                    <div>
                                        <img src='".$item[4]."' class=''>
                                        
                                    </div>
                                    <div></div>

                                </div>
                            </div>
                        ";
                    };

                    echo
                    "</div>
                        <!-- Check out section -->
                        <div class='w-full m-1 bg-gray-200'>
                        <div class='w-auto m-1 grid grid-cols-2 items-center'>
                            <div class='flex-1'>"
                    ?>
                            <input type='submit' name='btn-submit' class='bg-red-400 p-1 rounded' value='delete-all'> 
                            <input type='submit' name='btn-submit' class='bg-green-400 p-1 rounded' value='checkout'> 
                    <?php
                    echo "
                            </div>
                            <div class='flex-1>
                            <div class='text-center items-center'>";
                            echo "Total:";
                            $grossVal = 0;
                            foreach ($_SESSION['cartItems'] as $item) {
                                $grossVal = $grossVal + $item[8];
                            }
                            foreach ($_SESSION['necessityCart'] as $item) {
                                $grossVal = $grossVal + $item[3];
                            }
                            echo "₱" . $grossVal;
                            echo "
                            </div>
                            </div>
                        </div>
                        </div>
                    </div>";
                }
                ?>
                </div>

                <!-- PHP Scripts for CART BTN -->
                <?php
                // This fires a basic pop up
                function basicPopUp($title, $text, $icon, $iconColor)
                {
                // Basic Pop up Template
                echo " 
                    <template id='basic-template'>
                    <swal-title>$title</swal-title>
                    <swal-html>$text</swal-html>
                    <swal-icon type='$icon' color='$iconColor'>...</swal-icon>
                    </template> 
                    ";

                // Fire Template JS-script
                echo "<script>";
                echo "
                $(document).ready(function(){
                    Swal.fire({
                    template: '#basic-template'
                    })
                });
                ";
                echo "</script>";
                }
                ?>

            </div>

            <!-- SHOP LOGO -->
            <div class="w-full h-auto flex flex-shrink-0 justify-center items-center md:overflow-hidden">
                <div class="px-1 md:px-10 mx-3 mb-2 -mt-6 md:my-1 transform ">
                <img class="object-contain h-10 sm:h-20" src="images/Orange_Michael-Petshop_Logo.png" alt="Store-Logo">
                </div>
            </div>

            <!-- MENU -->
            <div class="hidden md:relative md:flex justify-start md:justify-evenly text-xs md:text-lg uppercase" id="menu">
                <div class="px-5 transition ease-in-out text-gray-900 hover:text-white hover:bg-gray-800 font-bold"><a href="index.php"> Home </a></div>
                <div class="px-5 transition ease-in-out text-gray-900 hover:text-white hover:bg-gray-800 font-bold"><a href="shop.php"> Dog & Cat's Necessity Shop</a></div>
                <div class="px-5 transition ease-in-out text-gray-900 hover:text-white hover:bg-gray-800 font-bold"><a href="about_me.php"> ABOUT US </a></div>
            </div>
        </nav>
        </form>
    
        <?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && (count($_SESSION['cartItems']) > 0 || count($_SESSION['necessityCart']) > 0 )) {
                // This for the CART BTN
                if (!Empty($_REQUEST['btn-submit'])){
                    switch ($_REQUEST['btn-submit']) {
                        // Clear array if btn value is delete-all
                        case 'delete-all':
                            $_SESSION['cartItems'] = [];
                            $_SESSION["necessityCart"] = [];
                            basicPopUp("Items are voided", "Click on a new grooming form if you're interested in grooming your pet!", "success", "lightgreen");
                            break;
                        // Clear array if btn value is checkout
                        case 'checkout':
                            $_SESSION["necessityCart"] = [];
                            $_SESSION['cartItems'] = [];
                            basicPopUp("Thank you for shopping", "You have paid the services in the cart", "success", "lightgreen");
                            break;
                    }
                }
            }
        ?>
  </section>
  <!-- END OF NAVBAR -->

  <!-- BANNER -->
  <div class="w-full flex justify-center">
    <div class="md:my-1">
      <img src="images/banner/PetShopServicesBanner-(longer).png" alt="">

      <div class="bg-green-400 hover:bg-green-200 transition ease-in text-center md:text-xl rounded-full px-2 md:px-5 py-1 md:py-5 md:float-right transform -translate-x-4 -translate-y-8" id="appointmentBTN">
        <a href="grooming-client-form.php" id="appointmentBTN" type="button">Appointment for Pet Gromming</a>
      </div>
    </div>
  </div>

  <!-- ABOUT -->
  <div class="w-full bg-orange-500 mt-10 pt-7">
    <div class="text-center text-gray-700 mx-20">
      <p class="text-3xl font-bold my-10">Michael's Pet Shop </p>
      <p class="pb-14">Michael's Pet shop is your one-stop-shop for your soon to be pet companion and pet care needs. Ranging from a wide variety of pet foods and treats all the way to pet accessories and pet grooming. </p>
    </div>
  </div>

  <!-- SERVICES -->
  <div class="w-full mb-10">
    <div class="mx-10" id="services">
      <h1 class="text-3xl font-bold my-8 uppercase">DOG's & CAT's SERVICES</h1>
      <div class="grid grid-cols-4 justify-between">

        <!-- BOX -->
        <div class="bg-orange-500 hover:bg-yellow-900 hover:text-white text-center text-xl font-Roboto rounded-lg relative max-h-44 overflow-hidden ">
          <a href="grooming-client-form.php">
            <p class="py-10">GROOMING 🧼</p>
          </a>
        </div>
      </div>
    </div>
  </div>

  <!-- FOOTER -->
  <div class="w-full bg-yellow-900 mt-32 pt-7">
    <div class="text-center text-gray-700 mx-20">
      <p class="text-xl text-white font-bold my-10"> MADE BY MICHAEL JACOB M. DELOS SANTOS </p>
      <p class="pb-10 text-gray-500"> This is used for demo purposes only.</p>
    </div>
  </div>


</body>

</html>