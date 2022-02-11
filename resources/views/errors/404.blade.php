<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Coding Test Application</title>
	<link href="https://fonts.googleapis.com/css?family=Heebo:400,700|Oxygen:700" rel="stylesheet">
	<link rel="stylesheet" href="{{ URL::asset('front') }}/dist/css/style.css">
	<script src="https://unpkg.com/scrollreveal@4.0.5/dist/scrollreveal.min.js"></script>
</head>
<body class="is-boxed has-animations">
	<div class="body-wrap boxed-container">
		<header class="site-header text-light">
			<div class="container">
				<div class="site-header-inner">
					<div class="brand header-brand">
						<h1 class="m-0">
							<a href="#">
								<img class="header-logo-image" src="{{ URL::asset('front') }}/dist/images/logo.svg" alt="Logo">
							</a>
						</h1>
					</div>
				</div>
			</div>
		</header>
		<main>
			<section class="hero text-center text-light">
				<div class="hero-bg"></div>
				<div class="hero-particles-container">
					<canvas id="hero-particles"></canvas>
				</div>
				<div class="container-sm">
					<div class="hero-inner">
						<div class="hero-copy">
							<h1 class="hero-title mt-0">Coding Test Application</h1>
							<p class="hero-paragraph">This is an Laravel Based Appliction please login as admin (create an employee after login then login as employee ) for real life experience</p>
							<div class="hero-cta">
								<a class="button button-primary button-wide-mobile" href="{{ url('admin') }}">Login</a>
							</div>
						</div>
						<div class="mockup-container">
							<div class="mockup-bg">
								<img src="{{ URL::asset('front') }}/dist/images/iphone-hero-bg.svg" alt="iPhone illustration">
							</div>
							<img class="device-mockup" src="{{ URL::asset('front') }}/dist/images/iphone-hero.png" alt="iPhone Hero">
						</div>
					</div>
				</div>
			</section>
		</main>
		<footer class="site-footer">
			<div class="footer-particles-container">
				<canvas id="footer-particles"></canvas>
			</div>
			<div class="site-footer-bottom">
				<div class="container">
					<div class="site-footer-inner">
						<div class="brand footer-brand">
							<a href="#">
								<img src="{{ URL::asset('front') }}/dist/images/logo.svg" alt="Venus logo">
							</a>
						</div>
						<div class="footer-copyright">&copy; 2018 Venus, all rights reserved</div>
					</div>
				</div>
			</div>
		</footer>
	</div>
	<script src="{{ URL::asset('front') }}/dist/js/main.min.js"></script>
</body>
</html>
