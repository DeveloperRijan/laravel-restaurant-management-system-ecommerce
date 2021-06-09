<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Foodpick-4</title>

    <link rel="stylesheet" href="{{$publicAssetsPathStart}}frontend/css/bootstrap.min.css" />
    <link rel="stylesheet" href="{{$publicAssetsPathStart}}frontend/css/all.min.css" />

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="{{$publicAssetsPathStart}}frontend/css/style.css" />
    <link rel="stylesheet" href="{{$publicAssetsPathStart}}frontend/css/responsive.css" />

    <style type="text/css">
        /*increase item numbers*/
        .foodBoxWrapper{
            width:48%;
        }
    </style>
</head>

<body>
    <!-- Header Section starts -->
    <header id="header" >
        <div class="menuSection container">
            <div class="logo_area">
                <div class="logo">
                    <img src="{{$publicAssetsPathStart}}frontend/images/logo.png" alt="Logo" />
                </div>
            </div>
            <div class="menu_area">
                <ul>
                    <li>
                        <a href="">
                            <img src="{{$publicAssetsPathStart}}frontend/images/shopping-cart.png" width="25px">
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="hero_area container">
            <h1>Search Your Favour Food</h1>
            <p>Find Restaurants, Specials, and coupons for free</p>
            <div class="search_field">
                <form>
                    <input type="text" placeholder="What is Your location?" />
                    <button>Search<i class="fas fa-search"></i></button>
                </form>
            </div>

            <div class="delivery_graph">
                <img src="{{$publicAssetsPathStart}}frontend/images/steps.png">
            </div>
        </div>
    </header>
    <!-- Header Section ends -->
    <!-- change address starts -->
    <section style="border-bottom: 1px solid #ddd;margin-bottom: 0px">
        <div class="container">
            <div class="d-flex justify-content-between p-3">
                <h6 style="color: #888; font-size: 14px;">124 Results so far</h6>
                <h6 style="color: #888; font-size: 14px;">Sort by popularity</h6>
            </div>
        </div>
    </section>
    <!-- change address ends -->

    <div id="sidebar-section" class="container active-sidebar">
        <div class="row">
            <div class="col-lg-1 col-md-1 col-sm-12"></div>
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div id="tertiary" class="sidebar-container" role="complementary" style="padding: 40px 0">
                   <div class="sidebar-inner">
                      <div class="widget-area clearfix">
                         <div id="azh_widget-11" class="widget widget_azh_widget">
                            <div class="widget-title d-flex justify-content-between">
                               <div style="color: #fff;font-size: 18px">
                                   <i class="fa fa-times"></i>
                               </div>
                               <div>
                                   <h3 style="font-size: 18px">Search Filters</h3>
                               </div>
                               <div style="color: #fff;font-size: 18px">
                                   <i class="fa fa-check"></i>
                               </div>
                            </div>

                            <div class="d-flex justify-content-between" style="border: 1px solid #ededed">
                                <input class="filter_item" type="text" name="filter_item" placeholder="Search your favorite food...">
                                <button><i class="fa fa-search"></i></button>
                            </div>
                             <div class="taxonomy-radio product_cat-wrapper" data-taxonomy="product_cat">
                                <ul>
                                   <li id="listing-one"><label for="in-product_cat-25"><div class="checkIcon"><i class="fa fa-check"></i></div> Beverages</label> <input type="radio" id="in-product_cat-25" name="product_cat" value="beverages"></li>
                                   <li id="listing-two"><label for="in-product_cat-31"><div class="checkIcon"><i class="fa fa-check"></i></div> Burgers</label><input type="radio" id="in-product_cat-31" name="product_cat" value="burgers"></li>
                                </ul>
                             </div>
                         </div>

                         <div class="widget widget_azh_widget">
                             <h6 class="sm-title">Popular Categories</h6>
                             <div class="tags">
                                 <span class="tag">Asian <i class="fa fa-times"></i></span>
                                 <span class="tag">Gril <i class="fa fa-times"></i></span>
                                 <span class="tag">Salads <i class="fa fa-times"></i></span>
                             </div>
                         </div>

                         <div class="widget widget_azh_widget">
                             <div class="d-flex justify-content-between">
                                 <h6 class="sm-title">Price Range</h6>
                                 <h6 class="sm-title">RESET</h6>
                             </div>
                             <div class="rangerSliderBox">
                                <div class="d-flex justify-content-between custom-price-range ">
                                    <div>
                                        <div class="rangeValueBlock">
                                            $<span id="range-startAmount"></span>
                                        </div>
                                    </div>
                                    <div id="slider-range"></div>
                                    <div>
                                        <div class="rangeValueBlock">
                                            $<span id="range-endAmount"></span>
                                        </div>
                                    </div>
                                </div>
                             </div>
                         </div>
                      </div>
                      <!-- .widget-area -->
                   </div>
                   <!-- .sidebar-inner -->
                </div>
            </div>

            <div class="col-lg-7 col-md-8 col-sm-12">
                <!--  foods section starts -->
                <section id="popular_foods">
                    <div class="inner_popular container">

                        <div class="foodBoxWrapper">
                            <div class="food_box">
                                <div class="food_img">
                                    <img src="{{$publicAssetsPathStart}}frontend/images/food1.png" alt="Food" />
                                </div>

                                <h3>The South's Best Fried Chicken</h3>
                                <p>Fried Chicken with Cheese</p>

                                <div class="pricing">
                                    <h4>$15,99</h4>
                                    <a href="">Order Now</a>
                                </div>
                            </div>

                            <div class="restaurant">
                                <div class="restaurant_name text-center">
                                    <button class="w-100 text-uppercase"><i class="fas fa-shopping-cart"></i> Add to cart</button>
                                </div>
                                <div class="love_react">
                                    <i class="far fa-heart"></i>
                                    <p>48</p>
                                </div>
                            </div>
                        </div>

                        <div class="foodBoxWrapper">
                            <div class="food_box">
                                <div class="food_img">
                                    <img src="{{$publicAssetsPathStart}}frontend/images/food1.png" alt="Food" />
                                </div>

                                <h3>The South's Best Fried Chicken</h3>
                                <p>Fried Chicken with Cheese</p>

                                <div class="pricing">
                                    <h4>$15,99</h4>
                                    <a href="">Order Now</a>
                                </div>
                            </div>

                            <div class="restaurant">
                                <div class="restaurant_name text-center">
                                    <button class="w-100 text-uppercase"><i class="fas fa-shopping-cart"></i> Add to cart</button>
                                </div>
                                <div class="love_react">
                                    <i class="far fa-heart"></i>
                                    <p>48</p>
                                </div>
                            </div>
                        </div>


                        <div class="foodBoxWrapper">
                            <div class="food_box">
                                <div class="food_img">
                                    <img src="{{$publicAssetsPathStart}}frontend/images/food1.png" alt="Food" />
                                </div>

                                <h3>The South's Best Fried Chicken</h3>
                                <p>Fried Chicken with Cheese</p>

                                <div class="pricing">
                                    <h4>$15,99</h4>
                                    <a href="">Order Now</a>
                                </div>
                            </div>

                            <div class="restaurant">
                                <div class="restaurant_name text-center">
                                    <button class="w-100 text-uppercase"><i class="fas fa-shopping-cart"></i> Add to cart</button>
                                </div>
                                <div class="love_react">
                                    <i class="far fa-heart"></i>
                                    <p>48</p>
                                </div>
                            </div>
                        </div>


                    </div>
                </section>
                <!-- foods section ends -->
            </div>
        </div>
    </div>

    





    <section id="footer_section">
        
        <div class="bottomFooterBoxWrapper container">

            <div class="footer_box2">
                <h4>Payment Option</h4>
                <div class="payment">
                    <img src="{{$publicAssetsPathStart}}frontend/images/pay.png" alt="">
                </div>
            </div>

            <div class="footer_box2">
                <h4>Address</h4>
               <p>Concept design of online food order and delivery, planned as restaurant directory</p>
               <h4>Phone: <span>060 000012 33</span></h4>
            </div>



            <div class="footer_box2">
                <h4>Addition information</h4>
               <p>join the thousands of other restaurants who benefit from having their menus on TakeOff</p>
              
            </div>



        </div>
    </section>

    <!-- scripts -->
    <script type="text/javascript" src="{{$publicAssetsPathStart}}frontend/js/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script type="text/javascript" src="{{$publicAssetsPathStart}}frontend/js/popper.min.js"></script>
    <script type="text/javascript" src="{{$publicAssetsPathStart}}frontend/js/bootstrap.min.js"></script>



    <script>
      $( function() {
        $( "#slider-range" ).slider({
          range: true,
          min: 0,
          max: 500,
          values: [ 75, 300 ],
          slide: function( event, ui ) {
            $(".custom-price-range #range-startAmount").html(ui.values[0])
            $(".custom-price-range #range-endAmount").html(ui.values[1])
            //$( "#amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
          }
        });

        $( "#range-startAmount" ).html( $( "#slider-range" ).slider( "values", 0 ))
        $( "#range-endAmount" ).html( $( "#slider-range" ).slider( "values", 1 ))
      } );
    </script>

    <script type="text/javascript">
        $("#sidebar-section div.taxonomy-radio ul li input[type='radio']").on("click", function(){
           
            $("#sidebar-section div.taxonomy-radio ul li div.checkIcon").removeClass('checkedStatus')

            let parentID = $(this).parent("li").attr('id')
           $("li#"+parentID+" label div").addClass('checkedStatus')
        })
    </script>
</body>

</html>