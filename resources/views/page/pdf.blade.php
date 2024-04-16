<!DOCTYPE html>
<html lang="vn">
<head>
    <title>Download PDF</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <!-- External CSS libraries -->
    <link type="text/css" rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset('assets/fonts/font-awesome/css/font-awesome.min.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="{{asset('assets/images/logo.png')}}" type="image/x-icon">
    <!-- Google fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <!-- Custom Stylesheet  -->
    <link type="text/css" rel="stylesheet" href="{{asset('assets/css/style.css')}}">
    {{-- set font family for pdf --}}
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body>
<!-- Invoice 1 start -->
<div class="invoice-1 invoice-content">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="invoice-inner clearfix">
                    <div class="invoice-info clearfix" id="invoice_wrapper">
                        <div class="invoice-headar">
                            <div class="row g-0">
                                <div class="col-sm-6">
                                    <div class="invoice-logo">
                                        <!-- logo started -->
                                        <div class="logo">
                                            <h1 >ANNT Store</h1>
                                        </div>
                                        <!-- logo ended -->
                                    </div>
                                </div>
                                <div class="col-sm-6 invoice-id">
                                    <div class="info">
                                        <h1 class="color-white inv-header-1">Hoá Đơn bán hàng</h1>
                                        <p class="color-white mb-1" >Số Hoá Đơn <span id = 'id'>{{$orders ->id}}</span></p>
                                        <p class="color-white mb-0">Ngày tạo <span> {{$orders ->created_at}}</span></p>
                                        <p class="color-white mb-0">Ngày thanh toán <span> {{$orders ->updated_at?? "chưa thanh toán"}}</span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="invoice-top">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="invoice-number mb-30">
                                        <h4 class="inv-title-1">CONG TY</h4>
                                        <h2 class="name mb-10">ANNT Store</h2>
                                        <p class="invo-addr-1">
                                            anntStore@gmail.com<br/>
                                            0949522102<br/>
                                           Hoà Khê, Thanh Khê, Đà Nẵng <br/>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="invoice-number mb-30">
                                        <div class="invoice-number-inner">
                                            <h4 class="inv-title-1">NGUOI MUA</h4>
                                            <h2 class="name mb-10">{{$orders ->name}}</h2>
                                            <p class="invo-addr-1">
                                                {{$orders ->phone}}  <br/>
                                                {{$orders ->email}} <br/>
                                                {{$orders ->address}}<br/>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="invoice-center">
                            <div class="table-responsive">
                                <table class="table mb-0 table-striped invoice-table">
                                    <thead class="bg-active">
                                    <tr class="tr">
                                        <th>STT.</th>
                                        <th class="pl0 text-start">Tên sản phẩm</th>
                                        <th class="text-center">Giá </th>
                                        <th class="text-center">Số Lượng</th>
                                        <th class="text-end">Tổng Tiền</th>
                                    </tr>
                                    </thead>
                                    <?php $stt = 1; ?>
                                    <tbody id ="list-products">

                                    </tbody>
                                    <tbody>
                                    <tr class="tr2">
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td class="text-center">Giá tạm tính</td>
                                        <td class="text-end">{{$orders->total_price}}</td>
                                    </tr>
                                    <tr class="tr2">
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td class="text-center">Phí vận chuyển</td>
                                        <td class="text-end">{{30000}}</td>
                                    </tr>
                                    <tr class="tr2">
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td class="text-center f-w-600 active-color">Tổng tiền</td>
                                        <td class="f-w-600 text-end active-color">{{$orders->total_price + 30000}}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="invoice-bottom">
                            <div class="row">
                                <div class="col-lg-6 col-md-8 col-sm-7">
                                    <div class="mb-30 dear-client">
                                        <h3 class="inv-title-1">Chú thích của người dùng</h3>
                                        <p>{{$orders -> note}}</p>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-4 col-sm-7">
                                    <div class="mb-30 payment-method">
                                        <h3 class="inv-title-1">Chú ý</h3>
                                        <p> Hoàn tiền chỉ áp dụng khi sản phẩm chưa được giao đến khách hàng</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="invoice-contact clearfix">
                            <div class="row g-0">
                                <div class="col-lg-9 col-md-11 col-sm-12">
                                    <div class="contact-info">
                                        <a href="tel:+55-4XX-634-7071"><i class="fa fa-phone"></i> +0949522102</a>
                                        <a href="tel:info@themevessel.com"><i class="fa fa-envelope"></i> anntStore@gmail.com</a>
                                        <a href="tel:info@themevessel.com" class="mr-0 d-none-580"><i class="fa fa-map-marker"></i> Thanh Khê, Đà Nẵng</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="invoice-btn-section clearfix d-print-none">
                        <a href="javascript:window.print()" class="btn btn-lg btn-print">
                            <i class="fa fa-print"></i> Print Invoice
                        </a>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


</body>
</html>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.min.js"></script>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/jspdf.min.js"></>
<script src="assets/js/html2canvas.js"></>
<script src="assets/js/app.js"></script>

<script>
    $(document).ready(function(){
    var id = $('#id').text();
       $.ajax({
        url: "{{route('order.detail')}}",
                type: "GET",
                data: {id: id},
                success: function(data){
                    $('#id').html(data.id);
                    $('#name').html(`<h6>${data.name}</h6>`);
                    $('#email').html(`<h6>${data.email}</h6>`);
                    $('#phone').html(`<h6>${data.phone}</h6>`);
                    $('#address').html(`<h6>${data.address}</h6>`);
                    $('#note').html(data.note);
                    $('#total_price').html(`<h6>${data.total_price} VND</h6>`);
                    $('#created_at').html(data.created_at);
                    $('#type_payment').html(function() {
                        if (data.type_payment === "stripe") {
                            return `<td><div class="badge rounded-pill text-warning bg-light-warning p-2 text-uppercase px-3"><i class='bx bxs-circle me-1'></i>${data.type_payment}</div></td>`;
                        } else if (data.type_payment === "vnpay") {
                            return `<td><div class="badge rounded-pill text-primary bg-light-primary p-2 text-uppercase px-3"><i class='bx bxs-circle me-1'></i>${data.type_payment}</div></td>`;
                        } else {
                            return `<td><div class="badge rounded-pill text-info bg-light-info p-2 text-uppercase px-3"><i class='bx bxs-circle me-1'></i>${data.type_payment}</div></td>`;
                        }
                    });
                    $('#status').html(function() {
                        if (data.status === 0) {
                            return `<td><div class="badge rounded-pill text-danger bg-light-danger p-2 text-uppercase px-3"><i class='bx bxs-watch me-1'></i>Chưa thành công</div></td>`;
                        } else {
                            return `<td><div class="badge rounded-pill text-success bg-light-success p-2 text-uppercase px-3"><i class='bx bx-check me-1'></i>Thành công</div></td>`;
                        }
                    });
                    $('#is_done').html(function(){
                        if(data.is_done ==0)
                            return `<td><div class="badge rounded-pill text-danger bg-light-danger p-2 text-uppercase px-3"><i class='bx bxs-circle me-1'></i>Chưa xác nhận</div></td>`;
                        else if(data.is_done == 1)
                            return `<td><div class="badge rounded-pill text-warning bg-light-warning p-2 text-uppercase px-3"><i class='bx bxs-circle me-1'></i>Đã xác nhận</div></td>`;
                        else if(data.is_done == 2)
                            return `<td><div class="badge rounded-pill text-info bg-light-info p-2 text-uppercase px-3"><i class='bx bxs-circle me-1'></i>Đang giao</div></td>`;
                        else
                            return `<td><div class="badge rounded-pill text-success bg-light-success p-2 text-uppercase px-3"><i class='bx bxs-circle me-1'></i>Hoàn thành</div></td>`;
                    });

                    $('#list-products').html(function(){
                             // get array products folow the format  $products = ['product_id' => 82, 'quantity' => 2],['product_id' => 83, 'quantity' => 2];
                            var list_products = null;
                            var stt =1;


                            //chuyển data.products từ dạng json sang dạng array
                            var products = JSON.parse(data.products);

                            for (var i = 0; i < products.length; i++) {
                                var name = null;
                                var price = null;
                                $.ajax({
                                    url: '{{route('product.detail1')}}',
                                    type: "GET",
                                    data: {id: products[i].product_id},
                                    async: false, // giúp chờ ajax chạy xong mới chạy tiếp đoạn code tiếp theo (đồng bộ)
                                    success: function(data){
                                        name = data.product_name;
                                        price = data.price;
                                        list_products += `<tr>
                                                            <td class="pl0 text-center">${stt++}</td>
                                                            <td class="text-center">${name}</td>
                                                            <td class="text-center">${price}</td>
                                                            <td class="text-center">${products[i].quantity}</td>
                                                            <td class="text-end">${products[i].quantity * price}</td>
                                                        </tr>`;
                                    }
                                });
                            }

                            return list_products;
                    });
                }
       })

    });

</script>

