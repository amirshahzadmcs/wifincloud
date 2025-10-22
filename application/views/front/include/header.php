<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Register to connect | WiFinCloud</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?php echo $url->assets ?>front/css/bootstrap.min.css">

    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?php echo $url->assets ?>front/css/scss/custom.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $url->assets ?>front/css/style.css">
</head>

<body>
<?php 			//echo "<pre>"; print_r($_SESSION); die();
                //images for gallery 
                    //checking if image exists
                    
					$location_id = (isset($_SESSION['location_id']))? $_SESSION['location_id'] : "";
                    if(isset($_GET['location_id'])){
                        $location_id = $_GET['location_id'];
                    }
					$img1 = $img2 = $img3 = $clogo_path = "";
					$domain_name = (isset($_SESSION['domain_name']))? $_SESSION['domain_name'] : "none";
					if(!isset( $preview )) $preview = "";
					
					if( $preview == "domain" ){
                        
						$globelDomain = $this->session->userdata('globelDomain');
						$clogo_path = get_domain_logo('', $globelDomain->domain_db_name);
						$img1 = get_domain_img('', $globelDomain->domain_db_name, '1'); 
						$img2 = get_domain_img('', $globelDomain->domain_db_name, '2');
						$img3 = get_domain_img('', $globelDomain->domain_db_name, '3');
						
					}elseif($preview == "location"){
                        
						$globelDomain = $this->session->userdata('globelDomain');
						$clogo_path = get_location_logo( $location_id, $globelDomain->domain_db_name);
						$img1 = get_domain_location_img($location_id,  $globelDomain->domain_db_name, '1');
						$img2 = get_domain_location_img($location_id, $globelDomain->domain_db_name,'2' ); 
						$img3 = get_domain_location_img($location_id, $globelDomain->domain_db_name, '3' ); 
						
					}else{
                        
						if(get_location_image_status( $location_id ) == 'enable'  ){
							$clogo_path = get_location_logo( $location_id, $domain_name);
							$img1 = get_domain_location_img($location_id,  $domain_name, '1');
							$img2 = get_domain_location_img($location_id, $domain_name,'2' ); 
							$img3 = get_domain_location_img($location_id, $domain_name, '3' ); 
							
						}else{
							
							$clogo_path = get_domain_logo('', $domain_name);
							$img1 = get_domain_img('', $domain_name, '1'); 
							$img2 = get_domain_img('', $domain_name, '2');
							$img3 = get_domain_img('', $domain_name, '3');
						}
						
					}
					
                    //$img1 = get_domain_img('', get_session('dname'), '1'); 
                    //$img2 = get_domain_img('', get_session('dname'), '2');
                    //$img3 = get_domain_img('', get_session('dname'), '3');

?>
    <div class="position-fixed top-0 start-0 bg_box w-100 h-100">
        <div id="slide_bg" class="carousel slide carousel-fade w-100 h-100" data-bs-ride="carousel">
            <div class="carousel-inner  w-100 h-100">
                <div class="carousel-item active w-100 h-100">
                    <img src="<?php echo $img1 ?>" class="d-block w-100"
                        >
                </div>
                <div class="carousel-item w-100 h-100">
                    <img src="<?php echo $img2 ?>" class="d-block w-100"
                        >
                </div>
                <div class="carousel-item w-100 h-100">
                    <img src="<?php echo $img3 ?>" class="d-block w-100"
                        >
                </div>

            </div>
        </div>
    </div>
    <div class="position-fixed top-50 start-50 translate-middle system_wrap">
        <div class="form-container">
            <?php 
                //default logo 
                    //checking if image exists 
                    $logo_path = $url->assets . 'front/images/slider/wifincloud_logo.svg';
                    

                    if($clogo_path != ''){
                        $logo_path = $clogo_path;
                    }
                ?>
            <div class="logo_box">
                <img src="<?php echo $logo_path; ?>" class="" alt="...">
            </div>