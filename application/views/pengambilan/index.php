<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>METROFEST 22</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="<?= base_url(); ?>assets/images/icons/favicon.ico"/>
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/vendor/bootstrap/css/bootstrap.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/fonts/iconic/css/material-design-iconic-font.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/vendor/animate/animate.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/vendor/css-hamburgers/hamburgers.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/vendor/animsition/css/animsition.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/vendor/select2/select2.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/vendor/daterangepicker/daterangepicker.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/vendor/sweetalert2/dist/sweetalert2.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/css/util.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/css/main.css">
	<!--===============================================================================================-->
</head>
<style type="text/css">
	.btn-info {
    color: #fff;
    width: 53px;
    height: 62px;
    background-color: #17a2b8;
    border-color: #17a2b8;
}
</style>
<body>


	<div class="container-contact100">
		<!-- <img src="<?= base_url(); ?>assets/images/mgnnet.jpg" width="50%">
 -->
		 <div class="wrap-contact100">
			<form class="contact100-form validate-form" id="antigenForm" method="POST">
				<span class="contact100-form-title">
					Pengambilan Goodie Bag
				</span>

				<!-- <div class="wrap-input100" id="qr-reader"></div> -->
				<div class="row">
					<div class="wrap-input100 validate-input" style="width: 90%;">
						<input class="input100" type="text" name="participant_id" id="participant_id" placeholder="NIK">
						<span class="focus-input100"></span>
					</div>
					<div>
						<button type="button" class="btn btn-info" id="btnFind"><i class="fa fa-search"></i></button>
					</div>
				</div>

				<div class="wrap-input100 validate-input">
					<input class="input100" type="text" name="participant_name" id="participant_name" placeholder="Nama">
					<span class="focus-input100"></span>
				</div>

				<!--<div class="wrap-input100 validate-input">
					<input class="input100" type="text" name="dob" id="dob" placeholder="Departement">
					<span class="focus-input100"></span>
				</div>

				 <div class="wrap-input100 validate-input">
					<input class="input100" type="text" name="ukuran_jersey" id="ukuran_jersey" placeholder="Ukuran Jersey">
					<span class="focus-input100"></span>
				</div> -->

				<div class="wrap-input100 validate-input">
					<input class="input100" type="text" name="category" id="category" placeholder="Kategori">
					<span class="focus-input100"></span>
				</div> 


				<div class="container-contact100-form-btn">
					<input type="hidden" name="registration_id" id="registration_id">
					<button type="submit" class="contact100-form-btn" id="btnSubmit">
						AMBIL
					</button>
				</div>
			</form>

			
		</div>
	</div>

	<audio id="soundSuccess">
		<source src="<?= base_url(); ?>assets/sounds/success.mp3" type="audio/mpeg">
		Your browser does not support the audio tag.
	</audio>
 


	<div id="dropDownSelect1"></div>
	<script type="text/javascript">var base_url = "<?= base_url(); ?>" </script>
	<!--===============================================================================================-->
	<script src="<?= base_url(); ?>assets/vendor/jquery/jquery-3.2.1.min.js"></script>
	<!--===============================================================================================-->
	<script src="<?= base_url(); ?>assets/vendor/animsition/js/animsition.min.js"></script>
	<!--===============================================================================================-->
	<script src="<?= base_url(); ?>assets/vendor/bootstrap/js/popper.js"></script>
	<script src="<?= base_url(); ?>assets/vendor/bootstrap/js/bootstrap.min.js"></script>
	<!--===============================================================================================-->
	<script src="<?= base_url(); ?>assets/vendor/select2/select2.min.js"></script>
	<!--===============================================================================================-->
	<script src="<?= base_url(); ?>assets/vendor/daterangepicker/moment.min.js"></script>
	<script src="<?= base_url(); ?>assets/vendor/daterangepicker/daterangepicker.js"></script>
	<script src="<?= base_url(); ?>assets/vendor/sweetalert2/dist/sweetalert2.min.js"></script>
	<!--===============================================================================================-->
	<script src="<?= base_url(); ?>assets/vendor/countdowntime/countdowntime.js"></script>
	<!--===============================================================================================-->
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAKFWBqlKAGCeS1rMVoaNlwyayu0e0YRes"></script>
	<script src="<?= base_url(); ?>assets/js/map-custom.js"></script>
	<!--===============================================================================================-->
	<script src="<?= base_url(); ?>assets/html5-qrcode/minified/html5-qrcode.min.js"></script>
	<script src="<?= base_url(); ?>assets/js/main.js"></script>
	<script src="<?= base_url(); ?>assets/js/pages/pengambilan.js"></script>

	<!-- Global site tag (gtag.js) - Google Analytics -->

</body>
</html>
