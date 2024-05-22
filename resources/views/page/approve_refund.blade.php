@extends('common.page.Master')
@section('noi_dung')

        <!--breadcrumb-->
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-3 p-0">
                    <li class="breadcrumb-item active" aria-current="page" style="font-size:18px">Phê Duyệt Yêu Cầu Hoàn Tiền</li>
                </ol>
            </nav>
        </div>
        <!--end breadcrumb-->
        <?php
            //  dd($info);
            // $stt=1;

            // $info = $info->sortByDesc('created_at')-> where ('is_done', 0);

        ?>
        <div class="card">
            <div class="card-body">
                <div>
                    <div class="d-lg-flex align-items-center mb-4 gap-3">
                        <div class="position-relative">
                            <input id ="search" name ="search" type="text" class="form-control ps-5 radius-30" placeholder="Số Hoá Đơn" > <span class="position-absolute top-50 product-show translate-middle-y"><i class="bx bx-search"></i></span>
                        </div>
                        <div class="gap-3">
                            <div class="dropdown">
                                <button id="filterTypePayment" class="btn btn-outline-primary" type="button" data-bs-toggle="dropdown" aria-expanded="false">Tình Trạng</button>
                                    <ul class="dropdown-menu">
                                        <li><a class=" rounded-0 badge text-danger bg-light-danger p-2 text-uppercase px-3 dropdown-item" href="#" onclick="changePhuongThuc('Chưa Duyệt')">Chưa Duyệt</a></li>
                                        <li><a class=" rounded-0 badge text-success bg-light-success p-2 text-uppercase px-3 rounded-0 dropdown-item" href="#" onclick="changePhuongThuc('Duyệt')">Duyệt</a></li>
                                    </ul>
                            </div>
                        </div>

                        <div class="gap-3">
                            <input id= "start_date"  type="text" class="form-control datepicker" style="width:150px" placeholder="Từ ngày"/>
                        </div>
                        <div class="gap-3">
                            <input id="end_date" type="text" class="form-control datepicker" style="width:150px" placeholder="Đến ngày"/>
                        </div>
                        <div class="gap-3">
                            <button id="butotn-search" type="button" class="btn btn-info px-3  radius-30">Tìm kiếm</button>
                        </div>

                </div>
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class ="text-center">Mã số Yêu Cầu</th>
                                <th >Chi tiết</th>
                                <th>Lý Do</th>
                                <th>Trạng thái</th>
                                <th>Ngày tạo</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody class ="search-data">
                        </tbody>

                        <tbody class ="all-data" id ="all-data">
                            @if(    $info->count()== 0)
                                <tr>
                                    <td colspan="10" class=" bg-warning text-center">Không có dữ liệu</td>
                                </tr>
                            @endif

                              @foreach ($info as $item)
                                <tr>
                                  <td class ="text-center" >{{$item -> id}}</td>
                                  <td><button type="button" class="detail-btn btn btn-primary btn-sm radius-30 px-4" id={{$item->id}} onclick ="addDetailBtnEvent({{$item->order_id}})"   data-bs-toggle="modal" data-bs-target="#viewDetails">Xem chi tiết</button></td>
                                  <td>{{$item -> reason}}</td>
                                  <td class="col-md-1">
                                    <div class="d-flex order-actions" style="font-size: 20px;">
                                        @if($item->status == 1)
                                            <span class="badge bg-success radius-30 " >Đã Duyệt</span>
                                        @else
                                            <span class="badge bg-danger radius-30">Chưa Duyệt</span>
                                        @endif
                                    </div>
                                  </td>
                                  <td>{{ $item->created_at->format('d/m/Y') }}</td>
                                  <td>
                                    <div class="d-flex order-actions">
                                        @if($item -> status == 0)
                                            <button  id = "approveRefundBtn" onclick='approveRefund({{$item->id}})'  class="btn btn-success px-5 radius-30" >Duyệt</button>
                                        @else
                                            <button    class="btn btn-secondary   px-5 radius-30" style="width:140px" > Đã Duyệt</button>
                                        @endif
                                    </div>
                                  </td>
                                </tr>
                              @endforeach
                        </tbody>

                    </table>
                    {{$info->links()}}
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
                                                                <th>Đơn giá</th>
                                                                <th>Khuyến mãi</th>
                                                                <th>Số lượng</th>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
        <script src="/assets/js/jquery.min.js"></script>
        <script src="/assets/plugins/datetimepicker/js/legacy.js"></script>
        <script src="/assets/plugins/datetimepicker/js/picker.js"></script>
        <script src="/assets/plugins/datetimepicker/js/picker.time.js"></script>
        <script src="/assets/plugins/datetimepicker/js/picker.date.js"></script>
        <script>
            function changePhuongThuc(filterName) {
                var filterButton = document.getElementById('filterTypePayment');
                filterButton.innerHTML = filterName;

                filterButton.classList.remove('btn-outline-success', 'btn-outline-warning');
                if (filterName === 'Duyệt') {
                    filterButton.classList.add('btn-outline-success');
                }
                if (filterName === 'Chưa Duyệt') {
                    filterButton.classList.add('btn-outline-warning');
                }
            }
        </script>
        <script>
            function approveRefund(id){
                if(confirm('Bạn có chắc chắn muốn duyệt yêu cầu hoàn tiền này không?')){
                    $.ajax({
                        url: "{{route('order.approveRefund')}}",
                        type: "GET",
                        data: {id: id},
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(data){
                            console.log(data);
                            location.reload();
                        },
                        error: function(xhr, status, error) {
                            console.log(xhr.responseText);
                            toastr.error('Có lỗi xảy ra, vui lòng thử lại sau')
                        }
                    });
                }
                else
                    return false;
            }
            function addDetailBtnEvent(id) {
                    event.preventDefault();
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
                                        console.log(id);
                                        $.ajax({
                                            url: '{{route('product.detail1')}}',
                                            type: "GET",
                                            data: {id: products[i].product_id,
                                                    order_id: id
                                            },
                                            async: false, // giúp chờ ajax chạy xong mới chạy tiếp đoạn code tiếp theo (đồng bộ)
                                            success: function(data){
                                                name = data.product_name;
                                                price = data.price;
                                                promotion = data.promotion_id;
                                                list_products += `<tr>
                                                                    <td>${stt++}</td>
                                                                    <td>${name}</td>
                                                                    <td>${price}</td>
                                                                    <td>${promotion}</td>
                                                                    <td>${products[i].quantity}</td>
                                                                    <td>${(products[i].quantity * price) - (products[i].quantity * price)*( promotion/100)}</td>
                                                                </tr>`;
                                            },
                                            error: function(data) {
                                                console.log("check: " + data);
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
            }
        </script>

<script>
    $(document).ready(function(){
        $("#butotn-search").click(function(){
            var order_id = $('#search').val()?? '';

            var status='';
            if($('#filterTypePayment').text() == 'Duyệt')
                status = 1;
            else if( $('#filterTypePayment').text() == 'Chưa Duyệt')
                status = 0;

            var start_date = null;
            var end_date = null;
            if($('#start_date').val() )
                start_date = moment($('#start_date').val(), 'DD MMMM, YYYY').format('YYYY-MM-DD');
            if($('#end_date').val())
                end_date = moment($('#end_date').val(), 'DD MMMM, YYYY').format('YYYY-MM-DD');

            console.log('email: '+ order_id + ' status: '+ status + ' start_date: '+ start_date + ', end_date:'+ end_date);
            $.ajax({
                url: "{{route('request.searchRequest')}}",
                type: "GET",
                data: {
                    order_id: order_id ?? '',
                    status: status?? '',
                    start_date: start_date ?? null,
                    end_date: end_date?? null,
                    },
                success: function(data){
                    var html =``;
                    var stt = 1;
                    console.log(data);

                    if( data.length == 0 || data== null)
                        html = `<tr><td colspan="10" class=" bg-warning text-center">Không có dữ liệu</td></tr>`;
                    data.forEach(item => {
                        console.log(item);
                        html += `<tr>`;
                        html += `<td>`;
                        html +=     `<h6 class=" font-14 text-center">${item.id}</h6>`;
                        html += `</div>`;
                        html += `</td>`;
                        html += `<td><button type="button" class="detail-btn btn btn-primary btn-sm radius-30 px-4" id=${ item.id }  onclick ="addDetailBtnEvent(${item.id})"data-bs-toggle="modal" data-bs-target="#viewDetails">Xem chi tiết</button></td>`;
                        html += `<td>${item.reason}</td></td>`;
                        html += `<td >`
                        html+=      `<div class="d-flex order-actions" style="font-size: 20px;">`
                        if(item.status == 1)
                            html +=     `<span class="badge bg-success radius-30 " >Đã Duyệt</span>`
                        else
                            html +=     `<span class="badge bg-danger radius-30">Chưa Duyệt</span> `
                        html +=     `</div>`
                        html += `</td>`
                        html += `<td>${ moment(item.created_at).format('DD/MM/YYYY') }</td>`;
                        html += `<td>`;
                        html +=     `<div class="d-flex order-actions">`;
                        html +=         `<button  id = "approveRefundBtn" onclick='approveRefund({{$item->id}})'  class="btn btn-success px-5 radius-30" >Duyệt</button> `
                        html +=     `</div>`
                        html += `</td>`;
                        html += `</tr>`;


                    });
                     //reset search data

                     $('#search').val('');
                    $('#filterTypePayment').text('Tình trạng');
                    $('#start_date').val('');
                    $('#end_date').val('');
                    $('#all-data').hide();

                    $('.search-data').html(html);
                    $('.search-data').show();



                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                }
            });
        });
    })
</script>

@endsection
