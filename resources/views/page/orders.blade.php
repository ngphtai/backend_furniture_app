@extends('common.page.Master')
@section('noi_dung')

        <!--breadcrumb-->
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-3 p-0">
                    <li class="breadcrumb-item active" aria-current="page" style="font-size:18px">Quản lý Order</li>
                </ol>
            </nav>
        </div>
        <!--end breadcrumb-->
        <?php
            //  dd($info);
            $stt=1;

            // $info = $info->sortByDesc('created_at')-> where ('is_done', 0);

        ?>
        <div class="card">
            <div class="card-body">
                <div>
                    <div class="d-lg-flex align-items-center mb-4 gap-3">
                        <div class="position-relative">
                            <input id ="search" type="text" class="form-control ps-5 radius-30" placeholder="Example@email.com"> <span class="position-absolute top-50 product-show translate-middle-y"><i class="bx bx-search"></i></span>
                        </div>
                        <div class="gap-3">
                            <div class="dropdown">
                                <button id="filterTypePayment" class="btn btn-outline-primary" type="button" data-bs-toggle="dropdown" aria-expanded="false">Phương thức</button>
                                    <ul class="dropdown-menu">
                                        <li><a class=" rounded-0 badge text-warning bg-light-warning p-2 text-uppercase px-3 dropdown-item" href="#" onclick="changePhuongThuc('stripe')">stripe</a></li>
                                        <li><a class=" rounded-0 badge text-primary bg-light-primary p-2 text-uppercase rounded-0 px-3 dropdown-item" href="#" onclick="changePhuongThuc('vnpay')">vnpay</a></li>
                                        <li><a class=" rounded-0 badge text-info bg-light-info p-2 text-uppercase px-3 rounded-0 dropdown-item" href="#" onclick="changePhuongThuc('direct')">direct</a></li>
                                        <li><a class=" rounded-0 badge text-secondary bg-light-secondary p-2 text-uppercase px-3 rounded-0 dropdown-item" href="#" onclick="changePhuongThuc('Phương thức')">ALL</a></li>
                                    </ul>
                            </div>
                        </div>
                        <div class="gap-3">
                            <div class="dropdown">
                                <button id="filterStatus" class="btn btn-outline-primary" type="button" data-bs-toggle="dropdown" aria-expanded="false">Thanh toán</button>
                                    <ul class="dropdown-menu">
                                        <li><a class="badge text-success bg-light-success p-2 text-uppercase px-3 rounded-0 dropdown-item" href="#" onclick="changeThanhToan('Thành công')">Thành công</a></li>
                                        <li><a class="badge text-danger bg-light-danger p-2 text-uppercase px-3 rounded-0 dropdown-item" href="#" onclick="changeThanhToan('Thất bại')">Thất bại</a></li>
                                        <li><a class="badge text-secondary bg-light-secondary p-2 text-uppercase rounded-0 px-3 dropdown-item" href="#" onclick="changeThanhToan('Thanh toán')">ALL</a></li>
                                    </ul>
                            </div>
                        </div>
                        <div class="gap-3">
                            <div class="dropdown">
                                <button id="filterIsDone" class="btn btn-outline-primary" type="button" data-bs-toggle="dropdown" aria-expanded="false">Trạng thái</button>
                                    <ul class="dropdown-menu">
                                        <li><a class="badge text-success bg-light-success p-2 text-uppercase px-3 rounded-0 dropdown-item" href="#" onclick="changeTrangthai('Hoàn thành')">Hoàn thành</a></li>
                                        <li><a class="badge rounded-0 text-info bg-light-info p-2  text-uppercase px-3 dropdown-item" href="#" onclick="changeTrangthai('Đang giao')">Đang giao</a></li>
                                        <li><a class="badge rounded-0 text-warning bg-light-warning  p-2 text-uppercase px-3 dropdown-item" href="#" onclick="changeTrangthai('Chưa xác nhận')">Chưa xác nhận</a></li>
                                        <li><a class="badge rounded-0 text-danger bg-light-danger  p-2 text-uppercase px-3 dropdown-item" href="#" onclick="changeTrangthai('Đã xác nhận')">Đã xác nhận</a></li>
                                        <li><a class="badge rounded-0 text-white bg-secondary   p-2 text-uppercase px-3 dropdown-item" href="#" onclick="changeTrangthai('Hoàn tiền')">Hoàn tiền</a></li>
                                        <li><a class="badge rounded-0 text-white bg-dark  p-2 text-uppercase px-3 dropdown-item" href="#" onclick="changeTrangthai('Từ chối')">Từ chối</a></li>
                                        <li><a class="badge rounded-0 text-secondary bg-light-secondary  p-2 text-uppercase px-3 dropdown-item" href="#" onclick="changeTrangthai('Trạng thái')">ALL</a></li>
                                    </ul>
                            </div>
                        </div>
                        <div class="gap-3">
                            <input id= "start_date"  type="text" class="form-control datepicker" placeholder="Từ ngày"/>
                        </div>
                        <div class="gap-3">
                            <input id="end_date" type="text" class="form-control datepicker" placeholder="Đến ngày"/>
                        </div>
                        <div class="gap-3">
                            <button id="butotn-search" type="button" class="btn btn-info px-3  radius-30">Tìm kiếm</button>
                        </div>
                </div>
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Stt</th>
                                <th>Khách hàng</th>
                                <th>Tổng tiền</th>
                                <th>Date</th>
                                <th>Phương thức</th>
                                <th>Thanh toán</th>
                                <th>Trạng thái</th>
                                <th>View Details</th>
                                <th>Hành Động</th>
                            </tr>
                        </thead>
                        <tbody class ="all-data">
                            @if(    $info->count()== 0)
                                <tr>
                                    <td colspan="10" class=" bg-warning text-center">Không có dữ liệu</td>
                                </tr>
                            @endif
                            @foreach ($info as $item )
                            <tr >
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="ms-2">
                                            <h6 class="mb-0 font-14">{{$stt++}}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>{{$item->name}}</td>
                                <td>{{$item->total_price}}</td>
                                <td>{{date('d/m/Y', strtotime($item->created_at))}}</td>
                                @if($item-> type_payment== "stripe" )
                                    <td><div class="badge rounded-pill text-warning bg-light-warning p-2 text-uppercase px-3"><i class='bx bxs-circle me-1'></i>{{$item-> type_payment}}</div></td>
                                @elseif ($item-> type_payment== "vnpay" )
                                    <td><div class="badge rounded-pill text-primary bg-light-primary p-2 text-uppercase px-3"><i class='bx bxs-circle me-1'></i>{{$item-> type_payment}}</div></td>
                                @else
                                    <td><div class="badge rounded-pill text-info bg-light-info p-2 text-uppercase px-3"><i class='bx bxs-circle me-1'></i>{{$item-> type_payment}}</div></td>
                                @endif

                                @if($item->status== 0 )
                                    <td><div class="badge rounded-pill text-danger bg-light-danger p-2 text-uppercase px-3"><i class='bx bxs-watch me-1'></i>Chưa thành công</div></td>
                                @elseif ($item->status== 1 )
                                    <td><div class="badge rounded-pill text-success bg-light-success p-2 text-uppercase px-3"><i class='bx bx-check me-1'></i>Thành công</div></td>
                                @endif

                                @if($item-> is_done == 0 )
                                    <td><div class="badge rounded-pill text-danger bg-light-danger p-2 text-uppercase px-3"><i class='bx bxs-circle me-1'></i>Chưa xác nhận</div></td>
                                @elseif ($item-> is_done == 1 )
                                    <td><div class="badge rounded-pill text-warning bg-light-warning p-2 text-uppercase px-3"><i class='bx bxs-circle me-1'></i>Đã xác nhận</div></td>
                                @elseif($item-> is_done == 2 )
                                    <td><div class="badge rounded-pill text-info bg-light-info p-2 text-uppercase px-3"><i class='bx bxs-circle me-1'></i>Đang giao</div></td>
                                @elseif($item-> is_done == 3 )
                                    <td><div class="badge rounded-pill text-success bg-light-success p-2 text-uppercase px-3"><i class='bx bxs-circle me-1'></i>Hoàn thành</div></td>
                                @elseif($item-> is_done == 4 )
                                    <td><div class="badge rounded-pill   bg-secondary  p-2 text-uppercase px-3"><i class='bx bxs-circle me-1'></i>Hoàn tiền</div></td>
                                 @elseif($item-> is_done == -1 )
                                    <td><div class="badge rounded-pill text-white bg-dark  p-2 text-uppercase px-3"><i class='bx bxs-circle me-1'></i>Từ chối</div></td>
                                @endif
                                <td><div type="button" class="detail-btn btn btn-primary btn-sm radius-30 px-4" id={{$item->id}} data-bs-toggle="modal" data-bs-target="#viewDetails">Xem chi tiết</div></td>
                                <td>
                                    <div class="d-flex order-actions">
                                        <a href="{{ 'toPDF/'. $item ->id}}" class=""><i class='bx bxs-file-export'></i></a>
                                        {{-- <a href="{{ route('order.update-is-done', ['id' => $item->id]) }}" onclick="return confirm('Bạn có chắc chắn muốn cập nhật tình trạng sản phẩm?')" class="ms-3"><i class='bx bx-check'></i></a> --}}
                                    </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tbody class ="search-data">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Modal for view details --}}
        <div class="modal fade " id="viewDetails" tabindex="-1" aria-labelledby="viewDetailsLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="viewDetailsLabel">Order Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="card border-warning border-bottom border-3 border-0 ">
                            <div class="card-body">
                                <h5 class="card-title text-warning">Thông tin hoá đơn</h5>
                                <div class="table-responsive">
                                    <table class="table table-borderless mb-0">
                                        <tbody>
                                            <tr>
                                                <td>Order ID: </td>
                                                <td id = 'id'>#123456</td>
                                                <td >Tên người dùng: </td>
                                                <td id = "name"><h6>Loading ... </h6></td>
                                            </tr>

                                            <tr>
                                                <td >Email người dùng: </td>
                                                <td id = "email"><h6>Loading ... </h6></td>

                                                <td >Số điện thoại: </td>
                                                <td id = "phone"><h6>Loading ... </h6></td>
                                            </tr>
                                            <tr>
                                                <td >Địa chỉ: </td>
                                                <td colspan="3" id = "address">Loading ...   </td>
                                            </tr>

                                            <td colspan="4"><hr></td>

                                            <tr >
                                                <td colspan="4">
                                                    <table class="table table-borderless mb-0">
                                                        <thead>
                                                            <tr>
                                                                <th>STT</th>
                                                                <th>Tên sản phẩm</th>
                                                                <th>Số lượng</th>
                                                                <th>Đơn giá</th>
                                                                <th>Thành tiền</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="list-products">
                                                            <tr>
                                                                <td></td>
                                                                <td></td>
                                                                <td>LOADING . . . </td>
                                                                <td></td>
                                                                <td></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>

                                            <td colspan="4"><hr></td>
                                            <tr>
                                                    <td>Tổng đơn giá: </td>
                                                    <td  colspan="3" id="total_price"> Loading ...  </td>
                                                </tr>
                                            <tr>
                                                <td>Chú thích: </td>
                                                <td  colspan="3" id="note"> Loading ... </td>
                                            </tr>

                                            <tr>
                                                <td>Phương thức thanh toán: </td>
                                                <td id="type_payment"><span class="badge rounded-pill text-secondary bg-light-secondary p-2 text-uppercase px-3"><i class='bx bxs-circle me-1'></i>Loading</span></td>
                                                <td>Trạng thái thanh toán: </td>
                                                <td id="status"><span class="badge rounded-pill text-secondary bg-light-secondary p-2 text-uppercase px-3"><i class='bx bx-check me-1'></i>Loading</span></td>
                                            </tr>

                                            <tr>
                                                <td>Trạng thái đơn: </td>
                                                <td id="is_done"><span class="badge rounded-pill text-secondary bg-light-secondary p-2 text-uppercase px-3"><i class='bx bx-check me-1'></i>Loading</span></td>

                                                <td>Ngày đặt hàng: </td>
                                                <td id = "created_at">Loading ... </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" id = "toPDF" class="btn btn-warning px-5 radius-30" data-bs-dismiss="modal"><i class="bx bxs-file-export"></i> Xuất file PDF</button>
                            {{-- <button type="submit" id = "turnAround"   class="btn btn-danger px-5 radius-30"  >Quay ngược</button>
                            <button type="submit" id = "toWards"   class="btn btn-success px-5 radius-30"  >Chuyển tiếp</button> --}}
                            <div class="dropdown">
                                <button id="status-navigation" class="btn btn-outline-primary" type="button" data-bs-toggle="dropdown" aria-expanded="false">Cập nhật Trạng thái</button>
                                    <ul class="dropdown-menu">
                                        <li><a class="badge text-success bg-light-success p-2 text-uppercase px-3 rounded-0 dropdown-item" href="#" onclick="changeTrangthai2('Hoàn thành')">Hoàn thành</a></li>
                                        <li><a class="badge rounded-0 text-info bg-light-info p-2  text-uppercase px-3 dropdown-item" href="#" onclick="changeTrangthai2('Đang giao')">Đang giao</a></li>
                                        <li><a class="badge rounded-0 text-warning bg-light-warning  p-2 text-uppercase px-3 dropdown-item" href="#" onclick="changeTrangthai2('Chưa xác nhận')">Chưa xác nhận</a></li>
                                        <li><a class="badge rounded-0 text-danger bg-light-danger  p-2 text-uppercase px-3 dropdown-item" href="#" onclick="changeTrangthai2('Đã xác nhận')">Đã xác nhận</a></li>
                                        <li><a class="badge rounded-0 text-white bg-secondary   p-2 text-uppercase px-3 dropdown-item" href="#" onclick="changeTrangthai2('Hoàn tiền')">Hoàn tiền</a></li>
                                        <li><a class="badge rounded-0 text-white bg-dark  p-2 text-uppercase px-3 dropdown-item" href="#" onclick="changeTrangthai2('Từ chối')">Từ chối</a></li>
                                    </ul>
                            </div>
                            <button type="submit" id = "updateIsDone"   class="btn btn-success px-5 radius-30"  >Cập nhật</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>


<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.min.js"></script>

<script src="/assets/js/jquery.min.js"></script>
<script src="/assets/plugins/datetimepicker/js/legacy.js"></script>
<script src="/assets/plugins/datetimepicker/js/picker.js"></script>
<script src="/assets/plugins/datetimepicker/js/picker.time.js"></script>
<script src="/assets/plugins/datetimepicker/js/picker.date.js"></script>

<script>
    $(document).ready(function(){
       // kiểm tra đường dẫn hiện tại của trang là gì nếu là /orders/index/v5  thì ẩn button có id là filterIsDone ẩm đi
        var url = window.location.pathname;
        //kiểm tra kí tự cuối của chuỗi url
        var lastChar = parseInt( url.substr(url.length - 1));
        if(lastChar>=0 && lastChar<=5)
            $('#filterIsDone').hide();



    });
</script>

<script>
    function changePhuongThuc(filterName) {
        var filterButton = document.getElementById('filterTypePayment');
        filterButton.innerHTML = filterName;

        filterButton.classList.remove('btn-outline-warning', 'btn-outline-primary', 'btn-outline-info');
        if (filterName === 'direct') {
            filterButton.classList.add('btn-outline-info');
        }
        if (filterName === 'stripe') {
            filterButton.classList.add('btn-outline-warning');
        }
        if (filterName === 'vnpay') {
            filterButton.classList.add('btn-outline-primary');
        }
        else {
            filterButton.classList.add('btn-outline-primary');
        }
    }

    function changeThanhToan(filterName2) {
        var filterButton = document.getElementById('filterStatus');
        filterButton.innerHTML = filterName2;

        filterButton.classList.remove('btn-outline-success', 'btn-outline-primary', 'btn-outline-danger');
        if (filterName2 === 'Thành công') {
            filterButton.classList.add('btn-outline-success');
        }
        if (filterName2 === 'Thất bại') {
            filterButton.classList.add('btn-outline-danger');
        }
        if (filterName2 === 'Thanh toán') {
            filterButton.classList.add('btn-outline-primary');
        }
    }

    function changeTrangthai(filterName3) {
        var filterButton = document.getElementById('filterIsDone');
        filterButton.innerHTML = filterName3;

        filterButton.classList.remove('btn-outline-success', 'btn-outline-primary', 'btn-outline-danger', 'btn-outline-warning', 'btn-outline-info','btn-outline-secondary', 'btn-outline-dark');
        if (filterName3 === 'Từ chối') {
            filterButton.classList.add('btn-outline-dark');
        }
        if (filterName3 === 'Hoàn tiền') {
            filterButton.classList.add('btn-outline-secondary');
        }
        if (filterName3 === 'Hoàn thành') {
            filterButton.classList.add('btn-outline-success');
        }
        if (filterName3 === 'Đang giao') {
            filterButton.classList.add('btn-outline-info');
        }
        if (filterName3 === 'Đã xác nhận') {
            filterButton.classList.add('btn-outline-warning');
        }
        if (filterName3 === 'Chưa xác nhận') {
            filterButton.classList.add('btn-outline-danger');
        }
        if (filterName3 === 'Trạng thái') {
            filterButton.classList.add('btn-outline-primary');
        }
    }
     function changeTrangthai2(filterName3) {
        var filterButton = document.getElementById('status-navigation');
        filterButton.innerHTML = filterName3;

        filterButton.classList.remove('btn-outline-success', 'btn-outline-primary', 'btn-outline-danger', 'btn-outline-warning', 'btn-outline-info','btn-outline-secondary', 'btn-outline-dark');
        if (filterName3 === 'Từ chối') {
            filterButton.classList.add('btn-outline-dark');
        }
        if (filterName3 === 'Hoàn tiền') {
            filterButton.classList.add('btn-outline-secondary');
        }
        if (filterName3 === 'Hoàn thành') {
            filterButton.classList.add('btn-outline-success');
        }
        if (filterName3 === 'Đang giao') {
            filterButton.classList.add('btn-outline-info');
        }
        if (filterName3 === 'Đã xác nhận') {
            filterButton.classList.add('btn-outline-warning');
        }
        if (filterName3 === 'Chưa xác nhận') {
            filterButton.classList.add('btn-outline-danger');
        }
        if (filterName3 === 'Trạng thái') {
            filterButton.classList.add('btn-outline-primary');
        }
    }
</script>

<script>
    $('.datepicker').pickadate({
        selectMonths: true,
        selectYears: true
    });
    $('.timepicker').pickatime();
</script>

<script>
    $(document).ready(function(){
        $('.detail-btn').click(function(event){
            event.preventDefault();
            var id = $(this).attr('id');
            // alert(id);
            // alert('check data');
            // get data from database
            $.ajax({
                url: "{{route('order.detail')}}",
                type: "GET",
                data: {id: id},
                success: function(data){
                    console.log(data);
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
                        if (data.status == 0) {
                            return `<td><div class="badge rounded-pill text-danger bg-light-danger p-2 text-uppercase px-3"><i class='bx bxs-watch me-1'></i>Chưa thành công</div></td>`;
                        }if(data.status)  {
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
                        else if(data.is_done == 3)
                            return `<td><div class="badge rounded-pill text-success bg-light-success p-2 text-uppercase px-3"><i class='bx bxs-circle me-1'></i>Hoàn thành</div></td>`;
                        else if(data.is_done == 4)
                            return `<td><div class="badge rounded-pill text-white   bg-secondary -info p-2 text-uppercase px-3"><i class='bx bxs-circle me-1'></i>Hoàn tiền</div></td>`;
                        else if(data.is_done == -1 )
                            return `<td><div class="badge rounded-pill text-dark  bg-light-dark  p-2 text-uppercase px-3"><i class='bx bxs-circle me-1'></i>Từ chối</div></td>`;

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
                                                            <td>${stt++}</td>
                                                            <td>${name}</td>
                                                            <td>${price}</td>
                                                            <td>${products[i].quantity}</td>
                                                            <td>${products[i].quantity * price}</td>
                                                        </tr>`;
                                    }
                                });
                            }
                            return list_products;
                    });
                },//end success
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                }
            });
        });
    });
</script>
<script>
    $(document).ready(function(){
        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' } });
        $('#toWards').click(function(){
            var id = $('#id').text();
            if (!confirm('Bạn có chắc chắn muốn cập nhật tình trạng sản phẩm?')) {
                return;
            }
            $.ajax({
                type: 'post',
                url: '{{route('order.update-next-is-done')}}',
                data: {
                    'id': id,
                    '_token': '{{ csrf_token() }}'
                },
                success: function(data){
                    location.reload();
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                }
            });
        });
        $('#turnAround').click(function(){
            var id = parseInt($('#id').text());
            if (!confirm('Bạn có chắc chắn muốn thực hiện quay ngược trạng thái sản phẩm?')) {
                if(!confirm('Việc thực hiện hành động này rất nguy hiểm, bạn có chắc chắn muốn thực hiện?'))
                    return;
            }
            $.ajax({
                type: 'post',
                url: '{{route('order.update-retreat-is-done')}}',
                data: {
                    'id': id,
                    '_token': '{{ csrf_token() }}'
                },
                success: function(data){
                    location.reload();
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                }
            });
        });
        $('#updateIsDone').click(function(){
            var id =  parseInt($('#id').text());
            var is_done = null;
            if($('#status-navigation').text()== "Hoàn thành")
                is_done = 3;
            else if($('#status-navigation').text()== "Đang giao")
                is_done = 2;
            else if($('#status-navigation').text()== "Đã xác nhận")
                is_done = 1;
            else if($('#status-navigation').text()== "Chưa xác nhận")
                is_done = 0;
            else if($('#status-navigation').text()== "Hoàn tiền")
                is_done = 4;
            else if($('#status-navigation').text()== "Từ chối")
                is_done = -1;

            console.log(is_done + ' ' + id);

            $.ajax({
                type: 'post',
                url: '{{route('order.updateOrder')}}',
                data: {
                    'id': id,
                    'is_done': is_done,
                    '_token': '{{ csrf_token() }}'
                },
                success: function(data){
                    console.log(data);
                    location.reload();
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                }
            });
        });
    });

</script>
<script>
    $(document).ready(function(){
        $('#toPDF').click(function(){
            var id = $('#id').text();
            window.location.href = '/orders/toPDF/' + id;
        });
    });
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script>
    $(document).ready(function(){
        $("#butotn-search").click(function(){
            var email = $('#search').val();
            var typepayment = $('#filterTypePayment').text();
            if(typepayment == 'Phương thức')
                typepayment = '';
            // alert($('#filterStatus').text() );
            var status='';
            if($('#filterStatus').text() == 'Thành công')
                status = 1;
            else if( $('#filterStatus').text() == 'Thất bại')
                status = 0;

            var is_done = null;
            if($('#filterIsDone').text()== "Hoàn thành")
                is_done = 3;
            else if($('#filterIsDone').text()== "Đang giao")
                is_done = 2;
            else if($('#filterIsDone').text()== "Đã xác nhận")
                is_done = 1;
            else if($('#filterIsDone').text()== "Chưa xác nhận")
                is_done = 0;
            else if($('#filterIsDone').text()== "Hoàn tiền")
                is_done = 4;
            else if($('#filterIsDone').text()== "Từ chối")
                is_done = -1;


            var start_date = null;
            var end_date = null;
            if($('#start_date').val() )
                start_date = moment($('#start_date').val(), 'DD MMMM, YYYY').format('YYYY-MM-DD');
            if($('#end_date').val())
                end_date = moment($('#end_date').val(), 'DD MMMM, YYYY').format('YYYY-MM-DD');

            //alert('email: '+ email + ' type_payment: '+ typepayment + ' status: '+ status + ', is_done: '+ is_done + ' start_date: '+ start_date + ', end_date:'+ end_date);
            $.ajax({
                url: "{{route('order.search')}}",
                type: "GET",
                data: {
                    email: email ?? '',
                    type_payment: typepayment?? '',
                    status: status?? '',
                    is_done: is_done?? null,
                    start_date: start_date ?? null,
                    end_date: end_date?? null,
                    },
                success: function(data){
                    var html =``;
                    var stt = 1;
                    console.log(data);
                    //for each data
                    if( data.length == 0 || data== null)
                        html = `<tr><td colspan="10" class=" bg-warning text-center">Không có dữ liệu</td></tr>`;
                    data.forEach(item => {
                        console.log(item);
                        html += `<tr>`;
                        html += `<td>`;
                        html += `<div class="d-flex align-items-center">`;
                        html += `<div class="ms-2">`;
                        html += `<h6 class="mb-0 font-14">${stt}</h6>`;
                        html += `</div>`;
                        html += `</div>`;
                        html += `</td>`;
                        html += `<td>${item.name}</td></td>`;
                        html += `<td>${item.total_price}</td>`;
                        html += `<td>${ moment(item.created_at).format('DD/MM/YYYY') }</td>`;
                        if(item.type_payment == "stripe")
                            html += `<td><div class="badge rounded-pill text-warning bg-light-warning p-2 text-uppercase px-3"><i class="bx bxs-circle me-1"></i>${item.type_payment}</div></td>`;
                        else if(item.type_payment == "vnpay")
                            html += `<td><div class="badge rounded-pill text-primary bg-light-primary p-2 text-uppercase px-3"><i class="bx bxs-circle me-1"></i> ${item.type_payment }</div></td>`;
                        else
                            html += `<td><div class="badge rounded-pill text-info bg-light-info p-2 text-uppercase px-3"><i class="bx bxs-circle me-1"></i>${item.type_payment }</div></td>`;

                        if(item.status == 0)
                            html += `<td><div class="badge rounded-pill text-danger bg-light-danger p-2 text-uppercase px-3"><i class="bx bxs-watch me-1"></i>Chưa thành công</div></td>`;
                        else
                            html += `<td><div class="badge rounded-pill text-success bg-light-success p-2 text-uppercase px-3"><i class="bx bx-check me-1"></i>Thành công</div></td>`;

                        if(item.is_done == 0)
                            html += `<td><div class="badge rounded-pill text-danger bg-light-danger p-2 text-uppercase px-3"><i class="bx bxs-circle me-1"></i>Chưa xác nhận</div></td>`;
                        else if(item.is_done == 1)
                            html += `<td><div class="badge rounded-pill text-warning bg-light-warning p-2 text-uppercase px-3"><i class="bx bxs-circle me-1"></i>Đã xác nhận</div></td>`;
                        else if(item.is_done == 2)
                            html += `<td><div class="badge rounded-pill text-info bg-light-info p-2 text-uppercase px-3"><i class="bx bxs-circle me-1"></i>Đang giao</div></td>`;
                        else if(item.is_done == 3)
                            html += `<td><div class="badge rounded-pill text-success bg-light-success p-2 text-uppercase px-3"><i class="bx bxs-circle me-1"></i>Hoàn thành</div></td>`;
                        else if(item.is_done == 4)
                            html += `<td><div class="badge rounded-pill text-white bg-secondary p-2 text-uppercase px-3"><i class="bx bxs-circle me-1"></i>Hoàn tiền</div></td>`;
                        else if(item.is_done == -1)
                            html += `<td><div class="badge rounded-pill text-white bg-dark p-2 text-uppercase px-3"><i class="bx bxs-circle me-1"></i>Từ chối</div></td>`;
                        html += `<td><div type="button" class="detail-btn btn btn-primary btn-sm radius-30 px-4" id=${ item.id } data-bs-toggle="modal" data-bs-target="#viewDetails">Xem chi tiết</div></td>`;
                        html += `<td>`;
                        html += `<div class="d-flex order-actions">`;
                        html += `<a href=""toPDF/" . "${item.id}" " class=""><i class="bx bxs-file-export"></i></a>`;
                        html += `</div>`;
                        html += `</div>`;
                        html += `</td>`;
                        html += `</tr>`;

                    });
                     //reset search data
                     $('#search').val('');
                    $('#filterTypePayment').text('Phương thức');
                    $('#filterStatus').text('Thanh toán');
                    $('#filterIsDone').text('Trạng thái');
                    $('#start_date').val('');
                    $('#end_date').val('');

                    $('.all-data').hide();
                    $('.search-data').html(html);
                    $('.search-data').show();

                },
            });
        });
    })
</script>

@endsection


