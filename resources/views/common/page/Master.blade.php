<!doctype html>
<html lang="en">

<head>
	@include('common.page.css')
</head>

<body>
	<!--wrapper-->

		<!--sidebar wrapper -->
		<div class="sidebar-wrapper" data-simplebar="true">
			<div class="sidebar-header">
				<div>
					<img src="/assets/images/logo.png" class="logo-icon" alt="logo icon">
				</div>
				<div>
					<h4 class="logo-text" style = "color:#103737">ANNT Store</h4>
				</div>

			</div>
			<!--navigation-->
			<ul class="metismenu" id="menu">
					<a href="/homepage" >
						<div class="parent-icon"><i class='bx bx-home-circle'></i>
						</div>
						<div class="menu-title">Dash Board</div>
					</a>

                    <a href="/users/index" >
						<div class="parent-icon"><i class="bx bx-user"></i>
						</div>
						<div class="menu-title">Users</div>
					</a>

                    <a href="/products/index" >
						<div class="parent-icon"><i class="bx bx-cart"></i>
						</div>
						<div class="menu-title">Products</div>
					</a>

                    <a href="/promotions/index" >
						<div class="parent-icon"><i class="bx bxs-discount"></i>
						</div>
						<div class="menu-title">Promotions</div>
					</a>
                    <a href="/comments/index" >
                        <div class="parent-icon"><i class="bx bx-comment-check"></i>
                        </div>
                        <div class="menu-title">Comment</div>
                    </a>
                    <a href="/categories/index" >
						<div class="parent-icon"><i class="bx bx-category"></i>
						</div>
						<div class="menu-title">Categories</div>
					</a>
                    <a href="/categories/index" >
						<div class="parent-icon"><i class="bx bx-spreadsheet"></i>
						</div>
						<div class="menu-title">Orders</div>
					</a>
                    <a href="/categories/index" >
						<div class="parent-icon"><i class="bx bx-message-rounded"></i>
						</div>
						<div class="menu-title">Messenger</div>
					</a>


			<!--end navigation-->
		</div>
		<!--end sidebar wrapper -->
		<!--start header -->
		<header>
			<div class="topbar d-flex align-items-center">
				<nav class="navbar navbar-expand">
					<div class="mobile-toggle-menu"><i class='bx bx-menu'></i>
					</div>
					<div class="top-menu ms-auto">
						<ul class="navbar-nav align-items-center">
							<li class="nav-item mobile-search-icon">
								<a class="nav-link" href="#">	<i class='bx bx-search'></i>
								</a>
							</li>
						</ul>
					</div>
					<div class="user-box dropdown">
						<a class="d-flex align-items-center nav-link dropdown-toggle dropdown-toggle-nocaret" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
							<img src="/assets/images/avatars/avatar-2.png" class="user-img" alt="user avatar">
							{{-- thông tin admin --}}
                            <div class="user-info ps-3">
								<p class="user-name mb-0">Admin</p>
							</div>
						</a>
						<ul class="dropdown-menu dropdown-menu-end">
							<li><a class="dropdown-item" href="{{route('admin.profile')}}"><i class="bx bx-user"></i><span>Profile</span></a>
							</li>
							<li>
								<div class="dropdown-divider mb-0"></div>
							</li>
							<li><a class="dropdown-item" href="javascript:;"><i class='bx bx-log-out-circle'></i><span>Logout</span></a>
							</li>
						</ul>
					</div>
				</nav>
			</div>
		</header>
		<!--end header -->
		<!--start page wrapper -->
		<div class="page-wrapper">
            @yield('noi_dung')
		</div>
		<!--end page wrapper -->
		<!--start overlay-->
		<div class="overlay toggle-icon"></div>
		<!--end overlay-->
		<!--Start Back To Top Button--> <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
		<!--End Back To Top Button-->

	<!--end wrapper-->
	<!--start switcher-->
	<div class="switcher-wrapper">

	</div>

	<!--end switcher-->
	<!-- Bootstrap JS -->
	<script src="/assets/js/bootstrap.bundle.min.js"></script>
	<!--plugins-->
	<script src="/assets/js/jquery.min.js"></script>
	<script src="/assets/plugins/simplebar/js/simplebar.min.js"></script>
	<script src="/assets/plugins/metismenu/js/metisMenu.min.js"></script>
	<script src="/assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
	<script src="/assets/plugins/vectormap/jquery-jvectormap-2.0.2.min.js"></script>
    <script src="/assets/plugins/vectormap/jquery-jvectormap-world-mill-en.js"></script>
	<script src="/assets/plugins/chartjs/js/Chart.min.js"></script>
	<script src="/assets/plugins/chartjs/js/Chart.extension.js"></script>
	<script src="/assets/plugins/sparkline-charts/jquery.sparkline.min.js"></script>
	<!--Morris JavaScript -->
	<script src="/assets/plugins/raphael/raphael-min.js"></script>
	<script src="/assets/plugins/morris/js/morris.js"></script>
	<script src="/assets/js/index2.js"></script>
	<!--app JS-->
	<script src="/assets/js/app.js"></script>
</body>

</html>
