<!doctype html>
<html lang="en">

<!-- PHP -->
<?php
// Session store data
session_start();

if (!isset($_SESSION["cartItems"])) {
    $_SESSION["cartItems"] = array();
}

if (!isset($_SESSION["necessityCart"])) {
    $_SESSION["necessityCart"] = array();
}
?>

<head>
  <!-- ... -->
  <title> Grooming Client Form </title>
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

<body class="font-Roboto">
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


    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
      <div class="mx-1 sm:mx-20 my-10">
        <!-- ASKING CLIENT INFO -->
        <div class="w-auto">
          <h1 class="font-bold text-2xl uppercase">CLIENT INFO</h1>
          <label class="block">
            <span class="block text-gray-700">What is your name?</span>
            <input type="text" name="name" class="w-full block border w-full" placeholder="type your full name here.">
          </label>
          <label class="block">
            <span class="block text-gray-700">Is your pet a cat or a dog?</span>
            <select class="w-full" name="specie" id="specie">
              <option value="cat">CAT</option>
              <option value="dog">DOG</option>
            </select>
          </label>
          <label class="block">
            <span class="block text-gray-700">What is your pet's name?</span>
            <input type="text" name="pet-name" class="w-full block border" placeholder="type your pet's name here.">
          </label>
          <label class="block mb-5">
            <span class="block text-gray-700">What is your pet's weight?</span>
            <select name="pet-size" class="w-full">
              <option value="small">Below 10 KG</option>
              <option value="medium">Between 11-26 KG</option>
              <option value="large">Between 27-39 KG</option>
              <option value="giant">Above 40 KG</option>
            </select>
          </label>

          <!-- ASKING SERVICES INFO -->
          <h1 class="font-bold text-2xl uppercase">GROOMING SERVICES</h1>

          <label class="block mb-5">
            <span class="block text-gray-700">What grooming service/s do you want (max 3)?</span>
            <?php
            for ($i = 1; $i <= 3; $i++) {
              $i;
              echo "
            <span class='block'>Choice $i</span>
            <select class='w-full block' name='service$i' id='service$i'>
              <optgroup label='No Answer'>
                <option value='none'>None</option>
              </optgroup>
              <optgroup label='Bathing & Blow drying'>
                <option value='full-groom'>Full Grooming</option>
                <option value='shampoo'>Shampoo & Blow Drying</option>
                <option value='medbath'>Medicated Bath (giant not allowed)</option>
                <option value='teeth-brushing'>Teeth Brushing</option>
                <option value='mouth-wash'>Mouth Washing</option>
                <option value='eye-wash'>Eye Washing w/ tear-stain removal</option>
              </optgroup>
              <optgroup label='Cutting & Trimming'>
                <option value='dematting'>Dematting</option>
                <option value='nail-trim'>Nail Trimming & Filing</option>
                <option value='spec-cut'>Special Cut</option>
              </optgroup>
            </select>
            ";
            }
            ?>
          </label>

          <!-- ASKING SERVICES INFO -->
          <h1 class="font-bold text-2xl uppercase">WHEN?</h1>
          <label class="block">
            <span class="block"> When will the appointment be? </span>
            <input type="date" name="date" class="w-full">
          </label>

          <input type="submit" class="my-2 px-5 py-2 cursor-pointer hover:bg-gray-600 hover:text-white" type="submit" name="btn-submit" value='submit'>
      </div>
    </form>

  <!-- CONFIRMATION -->
  <?php
  $amount = 0;
  if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_REQUEST['btn-submit'] == "submit"){
    $pet = array(
      $_REQUEST['name'],
      $_REQUEST['specie'],
      $_REQUEST['pet-name'],
      $_REQUEST['pet-size'],
      $_REQUEST['service1'],
      $_REQUEST['service2'],
      $_REQUEST['service3'],
      $_REQUEST['date'],
      $amount
    );
  }


  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // This for the CART BTN
    switch ($_REQUEST['btn-submit']) {
      // Clear array if btn value is delete-all
      case 'delete-all':
        $_SESSION['cartItems'] = [];
        basicPopUp("Items are voided", "Click on a new grooming form if you're interested in grooming your pet!", "success", "lightgreen");
        break;
      // Clear array if btn value is checkout
      case 'checkout':
        $_SESSION['cartItems'] = [];
        basicPopUp("Thank you for shopping", "You have paid the services in the cart", "success", "lightgreen");
        break;
    }

    // Check what size is the dog then calculate their expenses.
    if ($pet[3] === "small") {
      // Small dog's Services 
      for ($i = 4; $i <= 6; $i++) {
        if ($pet[$i] == "full-groom") {
          $pet[8] = $pet[8] + 500;
        } else if ($pet[$i] ==  "shampoo") {
          $pet[8] = $pet[8] + 250;
        } else if ($pet[$i] == "medbath") {
          $pet[8] = $pet[8] + 250;
        }
        // Small dog's optionals
        else if ($pet[$i] == "teeth-brushing") {
          $pet[8] = $pet[8] + 75;
        } else if ($pet[$i] == "mouth-wash") {
          $pet[8] = $pet[8] + 75;
        } else if ($pet[$i] == "eye-wash") {
          $pet[8] = $pet[8] + 75;
        } else if ($pet[$i] == "dematting") {
          $pet[8] = $pet[8] + 450;
        } else if ($pet[$i] == "nail-trim") {
          $pet[8] = $pet[8] + 100;
        } else if ($pet[$i] == "spec-cut") {
          $pet[8] = $pet[8] + 200;
        }
      }
      // Medium Dog
    } else if ($pet[3] == "medium" || $pet[3] == "large") {
      // Medium Dog's Services
      for ($i = 4; $i <= 6; $i++) {
        if ($pet[$i] == "full-groom") {
          $pet[8] = $pet[8] + 750;
        } else if ($pet[$i] ==  "shampoo") {
          $pet[8] = $pet[8] + 450;
        } else if ($pet[$i] == "medbath") {
          $pet[8] = $pet[8] + 450;
        }
        // Medium dog's optionals
        else if ($pet[$i] == "teeth-brushing") {
          $pet[8] = $pet[8] + 75;
        } else if ($pet[$i] == "mouth-wash") {
          $pet[8] = $pet[8] + 75;
        } else if ($pet[$i] == "eye-wash") {
          $pet[8] = $pet[8] + 75;
        } else if ($pet[$i] == "dematting") {
          $pet[8] = $pet[8] + 450;
        } else if ($pet[$i] == "nail-trim") {
          $pet[8] = $pet[8] + 100;
        } else if ($pet[$i] == "spec-cut") {
          $pet[8] = $pet[8] + 200;
        }
      }
      // Giant Dog
    } else if ($pet[3] == "giant") {
      // Giant Dog's Choices
      for ($i = 4; $i <= 6; $i++) {
        if ($pet[$i] == "full-groom") {
          $pet[8] += 900;
        } else if ($pet[$i] == "shampoo") {
          $pet[8] += 600;
        }
        // Giant Dog's Optionals
        else if ($pet[$i] == "teeth-brushing") {
          $pet[8] = $pet[8] + 75;
        } else if ($pet[$i] == "mouth-wash") {
          $pet[8] = $pet[8] + 75;
        } else if ($pet[$i] == "eye-wash") {
          $pet[8] = $pet[8] + 75;
        } else if ($pet[$i] == "dematting") {
          $pet[8] = $pet[8] + 450;
        } else if ($pet[$i] == "nail-trim") {
          $pet[8] = $pet[8] + 100;
        } else if ($pet[$i] == "spec-cut") {
          $pet[8] = $pet[8] + 200;
        }
      }
    }

    // If date null, deny and redo form.
    if ($pet[7] == null) {
      echo basicPopUp("Missing date", "Please input a date to complete purchase", "warning", "orange");
    }
    // If there's date, get all data.
    if ($pet[7] != null) {
      basicPopUp("Successfully Added Appointment", "Check the cart for the details of the scheduled grooming", "success", "lightgreen");
      array_push($_SESSION["cartItems"], array($pet[0], $pet[1], $pet[2], $pet[3], $pet[4], $pet[5], $pet[6], $pet[7], $pet[8]) );
    }
  }
  ?>
  </div>
</body>

</html>