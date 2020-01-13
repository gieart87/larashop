<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta name="description" content="Sleek Dashboard - Free Bootstrap 4 Admin Dashboard Template and UI Kit. It is very powerful bootstrap admin dashboard, which allows you to build products like admin panels, content management systems and CRMs etc.">
		<title>Sleek - Admin Dashboard Template</title>

		<!-- GOOGLE FONTS -->
		<link href="https://fonts.googleapis.com/css?family=Montserrat:400,500|Poppins:400,500,600,700|Roboto:400,500" rel="stylesheet" />
		<link href="https://cdn.materialdesignicons.com/3.0.39/css/materialdesignicons.min.css" rel="stylesheet" />
		<!-- PLUGINS CSS STYLE -->
		<link href="{{ URL::asset('admin/assets/plugins/nprogress/nprogress.css') }}" rel="stylesheet" />
		<!-- No Extra plugin used -->  
		<link href="{{ URL::asset('admin/assets/plugins/jvectormap/jquery-jvectormap-2.0.3.css') }}" rel="stylesheet" />
		<link href="{{ URL::asset('admin/assets/plugins/daterangepicker/daterangepicker.css') }}" rel="stylesheet" />
		<link href="{{ URL::asset('admin/assets/plugins/toastr/toastr.min.css') }}" rel="stylesheet" />
		<!-- SLEEK CSS -->
		<link id="sleek-css" rel="stylesheet" href="{{ URL::asset('admin/assets/css/sleek.css') }}" />
		<!-- FAVICON -->
		<link href="{{ URL::asset('admin/assets/img/favicon.png') }}" rel="shortcut icon" />
		<!--
			HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries
		-->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
		<script src="{{ URL::asset('admin/assets/plugins/nprogress/nprogress.js') }}"></script>
	</head>
	<body class="header-fixed sidebar-fixed sidebar-dark header-light" id="body">
	
	<script>
		NProgress.configure({ showSpinner: false });
		NProgress.start();
	</script>
	<div class="mobile-sticky-body-overlay"></div>  
	<div id="toaster"></div>
	<div class="wrapper">
		<!-- Github Link -->
		<a href="https://github.com/tafcoder/sleek-dashboard" class="github-link">
		<svg width="70" height="70" viewBox="0 0 250 250" aria-hidden="true">
			<defs>
			<linearGradient id="grad1" x1="0%" y1="75%" x2="100%" y2="0%">
				<stop offset="0%" style="stop-color:#896def;stop-opacity:1" />
				<stop offset="100%" style="stop-color:#482271;stop-opacity:1" />
			</linearGradient>
			</defs>
			<path d="M 0,0 L115,115 L115,115 L142,142 L250,250 L250,0 Z" fill="url(#grad1)"></path>
		</svg>
		<i class="mdi mdi-github-circle"></i>
		</a>
		
		@include('admin.partials.sidebar')

		<div class="page-wrapper">
			@include('admin.partials.header')
			<div class="content-wrapper">
				@yield('content')
			</div>
			@include('admin.partials.footer')
		</div>
	</div>

	<script src="{{ URL::asset('admin/assets/plugins/jquery/jquery.min.js') }}"></script>
	<script src="{{ URL::asset('admin/assets/plugins/slimscrollbar/jquery.slimscroll.min.js') }}"></script>
	<script src="{{ URL::asset('admin/assets/plugins/jekyll-search.min.js') }}"></script>
	<script src="{{ URL::asset('admin/assets/plugins/charts/Chart.min.js') }}"></script>
	<script src="{{ URL::asset('admin/assets/plugins/jvectormap/jquery-jvectormap-2.0.3.min.js') }}"></script>
	<script src="{{ URL::asset('admin/assets/plugins/jvectormap/jquery-jvectormap-world-mill.js') }}"></script>
	<script src="{{ URL::asset('admin/assets/plugins/daterangepicker/moment.min.js') }}"></script>
	<script src="{{ URL::asset('admin/assets/plugins/daterangepicker/daterangepicker.js') }}"></script>
	<script src="{{ URL::asset('admin/assets/plugins/toastr/toastr.min.js') }}"></script>
	<script src="{{ URL::asset('admin/assets/js/sleek.bundle.js') }}"></script>
	<script>
		$(".delete").on("submit", function () {
			return confirm("Do you want to remove this?");
		});

		function showHideConfigurableAttributes() {
			var productType = $(".product-type").val();
				
			if (productType == 'configurable') {
				$(".configurable-attributes").show();
			} else {
				$(".configurable-attributes").hide();
			}
		}

		$(function(){
			showHideConfigurableAttributes();
			$(".product-type").change(function() {
				showHideConfigurableAttributes();
			});
		});
	</script>
	</body>
</html>
