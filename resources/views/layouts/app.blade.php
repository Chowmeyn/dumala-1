<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>Dumala</title>
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<!-- ================== BEGIN core-css ================== -->
	<link href="{{ asset('assets/css/vendor.min.css') }}" rel="stylesheet" />
	<link href="{{ asset('assets/css/facebook/app.min.css') }}" rel="stylesheet" />


    	
	<!-- ================== BEGIN core-js ================== -->
	<script src="{{ asset('assets/js/vendor.min.js') }}"></script>
	<script src="{{ asset('assets/js/app.min.js') }}"></script>
	<!-- ================== END core-js ================== -->

    <!-- ================== BEGIN page-css ================== -->
	<link href="{{ asset('assets/plugins/gritter/css/jquery.gritter.css') }}" rel="stylesheet" />
	<!-- ================== END page-css ================== -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
	<!-- ================== BEGIN page-js ================== -->
	<script src="{{ asset('assets/js/demo/login-v2.demo.js') }}"></script>
	<style>
		
.no-data-container {
    display: flex;
    justify-content: center;
    /* Center horizontally */
    align-items: center;
    /* Center vertically */
    height: 100px;
    /* Adjust height to suit your needs */
    text-align: center;
    /* Ensure text is centered inside the container */
}

.modal-content {
    background-color: #f1f4e4;
    color: #3d4b3e;
    border-radius: 10px;
    font-family: 'Arial', sans-serif;
}

.modal-title {
    font-weight: bold;
}

.modal-body p {
    margin-bottom: 8px;
}

.btn-success {
    background-color: #2d5a27;
    border-color: #2d5a27;
}

.btn-danger {
    background-color: #c0392b;
    border-color: #c0392b;
}

.btn-success:hover {
    background-color: #274d22;
}

.btn-danger:hover {
    background-color: #a93226;
}
	</style>
	<!-- ================== END page-js ================== -->

    	<!-- ================== BEGIN page-js ================== -->
	<script src="{{ asset('assets/plugins/gritter/js/jquery.gritter.js') }}"></script>
	<script src="{{ asset('assets/plugins/sweetalert/dist/sweetalert.min.js') }}"></script>
	<script src="{{ asset('assets/js/demo/ui-modal-notification.demo.js') }}"></script>
	<script src="{{ asset('assets/plugins/@highlightjs/cdn-assets/highlight.min.js') }}"></script>
	<script src="{{ asset('assets/js/demo/render.highlight.js') }}"></script>
	<!-- ================== END page-js ================== -->

</head>
<body class='pace-top theme-lime'>
	<!-- BEGIN #loader -->
	<div id="loader" class="app-loader">
		<span class="spinner"></span>
	</div>
	<!-- END #loader -->

	
	<!-- BEGIN #app -->
	<div id="app" class="app">
		<!-- BEGIN login -->
        @yield('content')

	</div>
	<!-- END #app -->

</body>
</html>