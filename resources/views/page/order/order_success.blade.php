<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Succrssfull</title>
        <link rel="icon" href="/assets/images/favicon-32x32.png" type="image/png" />
    <!--plugins-->
    <link href="/assets/plugins/vectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet"/>
    <link href="/assets/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
    <link href="/assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" />
    <link href="/assets/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet" />
    <!-- loader-->
    <link href="/assets/css/pace.min.css" rel="stylesheet" />
    <script src="/assets/js/pace.min.js"></script>
    <!-- Bootstrap CSS -->
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/css/bootstrap-extended.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link href="/assets/css/icons.css" rel="stylesheet">
    <!-- Theme Style CSS -->
    <link rel="stylesheet" href="/assets/css/dark-theme.css" />
    <link rel="stylesheet" href="/assets/css/semi-dark.css" />
    <link rel="stylesheet" href="/assets/css/header-colors.css" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/5.3.45/css/materialdesignicons.css" integrity="sha256-NAxhqDvtY0l4xn+YVa6WjAcmd94NNfttjNsDmNatFVc=" crossorigin="anonymous" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>


    <link href="{{ asset('assets/plugins/datetimepicker/css/classic.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/datetimepicker/css/classic.date.css') }}" rel="stylesheet" />

    <link href="{{ asset('assets/plugins/simplebar/css/simplebar.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/metismenu/css/metisMenu.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/pace.min.css') }}" rel="stylesheet" />

    <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" />
    <link href="/assets/css/bootstrap-extended.css" rel="stylesheet" />
    <script src="/assets/js/client.js" defer></script>

    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 30px;
        }
        #check {
        display: none;
    }
        .container {
            display: flex;
            justify-content: flex-start;
            align-items: flex-start;
            flex-direction: column;
        }
        .container > div {
            text-align: left;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }
        .button:hover {
            background-color: #45a049;
        }
        .success-image {
            width: 300px;
            margin: 0px auto;
        }
        .table-no {
            margin-top: 2px;
            font-weight: bold;
            color: black;
        }
        .not-paid {
            margin-top: 2px;
            font-weight: bold;
            color: red;
        }
    </style>
</head>
<body>

    <img class="success-image" src="/assets/images/order/success.gif" >
    <div>
		<div class="lign-items-center">
			<h1 class="mb-0 text-success" style ="font-weight: 600; padding-bottom: 20px">Đặt hàng thành công</h1>
            <h5 class="card-title text-Dark "  style ="font-weight: 600">ANNT Stone</h5>
            {{-- <h6 class="card-title text-success "  style ="font-weight: 600">Đã thanh toán thành công</h6> --}}
		</div>
    </div>
    <div class="container my-3">
        <h7 class="text-Dark mb-0">
            Date: {{$order->updated_at}}
        </h7>
        <h7 class="text-Dark mb-0">
            ID: {{$order->id}}
        </h7>
    </div>
    <div style="border-top: 1px solid lightgray; margin-top: 4px; margin-bottom: 6px;"></div>
    <div class="card-body">
	    <div class="container">
			<strong class="text-Secondary mb-1"  style ="font-size: 18px;">Thông tin người đặt</strong>
		<div class="column column-cols-auto g-3">
		    <div class="col">
                <div style="display: inline-block;" class="text-secondary rounded">Họ và tên:</div>
                <div style="display: inline-block;">{{$order -> name}}</div>
            </div>
		    <div class="col">
                <div style="display: inline-block;" class="text-secondary rounded">Số điện thoại:</div>
                <div style="display: inline-block;">{{$order -> phone}}</div>
            </div>
		    <div class="col">
                <div style="display: inline-block;" class="text-secondary rounded">Gmail:</div>
                <div style="display: inline-block;"><em>{{$email}}</em></div>
            </div>
		    <div class="col">
                <div style="display: inline-block;" class="text-secondary rounded">Địa chỉ giao hàng:</div>
                <div style="display: inline-block;">{{$order -> address}}</div>
            </div>
		</div>
        </div>
	</div>
	</div>
    <div class="col my-3">
		<div class="card radius-10 overflow-hidden">
			<div class="card-body">
				<div class="d-flex align-items-center">
					<div>
						<h5 class="mb-0">Tổng hóa đơn</h5>

					</div>
				<div class="ms-auto">	<h5 class="mb-0">{{$order -> total_price}} $</h5>
					</div>
				</div>
			</div>
			<div class="" id="w-chart6"></div>
		</div>
	</div>
    <div class="col">
		<button type="button" onclick="postMessage();" class="btn btn-lg btn-outline-info px-5" style="width: 300px;"><i class='bx bx-home mr-1'></i>Trở về trang chủ</button>
	</div>

    <script type='text/javascript'>
        function postMessage(){
            Pay.postMessage('success');
        }
    </script>
    <!-- test ở đây nha! nếu check = 0 thì đã thanh toán và bằng 1 là chưa thanh toán -->
    {{-- <h6 id="check">1</h6>

    <script>
        var checkElement = document.getElementById("check");
        var chuaThanhToanElement = document.querySelector(".card-title.text-danger");
        var daThanhToanElement = document.querySelector(".card-title.text-success");

        if (checkElement.innerHTML === "0") {
           chuaThanhToanElement.style.display = "none";
            daThanhToanElement.style.display = "block";
        } else if (checkElement.innerHTML === "1") {
            chuaThanhToanElement.style.display = "block";
            daThanhToanElement.style.display = "none";
        }
    </script> --}}
</html>
