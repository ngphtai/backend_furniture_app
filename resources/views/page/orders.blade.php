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
            $stt=1;
            $info =  App\Models\Orders::with('user')-> get();
        ?>
        <div class="card">
            <div class="card-body">
                <div class="d-lg-flex align-items-center mb-4 gap-3">
                    <div class="position-relative">
                        <input type="text" class="form-control ps-5 radius-30" placeholder="Search Order"> <span class="position-absolute top-50 product-show translate-middle-y"><i class="bx bx-search"></i></span>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Stt</th>
                                <th>Email</th>
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
                            @foreach ($info as $item )
                            <tr >
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="ms-2">
                                            <h6 class="mb-0 font-14">{{$stt++}}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>{{optional($item->user)->email}}</td>
                                <td>{{$item->total_price}}</td>
                                <td>{{date('d/m/Y', strtotime($item->created_at))}}</td>
                                @if($item-> type_payment== "stripe" )
                                    <td><div class="badge rounded-pill text-warning bg-light-warning p-2 text-uppercase px-3"><i class='bx bxs-circle me-1'></i>{{$item-> type_payment}}</div></td>
                                @elseif ($item-> type_payment== "vnpay" )
                                    <td><div class="badge rounded-pill text-primary bg-light-primary p-2 text-uppercase px-3"><i class='bx bxs-circle me-1'></i>{{$item-> type_payment}}</div></td>
                                @else
                                    <td><div class="badge rounded-pill text-info bg-light-info p-2 text-uppercase px-3"><i class='bx bxs-circle me-1'></i>{{$item-> type_payment}}</div></td>
                                @endif

                                @if($item-> status== 0 )
                                    <td><div class="badge rounded-pill text-danger bg-light-danger p-2 text-uppercase px-3"><i class='bx bxs-watch me-1'></i>Chưa thành công</div></td>
                                @elseif ($item-> status== 1 )
                                    <td><div class="badge rounded-pill text-success bg-light-success p-2 text-uppercase px-3"><i class='bx bx-check me-1'></i>Thành công</div></td>
                                @endif

                                @if($item-> is_done == 0 )
                                    <td><div class="badge rounded-pill text-danger bg-light-danger p-2 text-uppercase px-3"><i class='bx bxs-circle me-1'></i>Chưa xác nhận</div></td>
                                @elseif ($item-> is_done == 1 )
                                    <td><div class="badge rounded-pill text-warning bg-light-warning p-2 text-uppercase px-3"><i class='bx bxs-circle me-1'></i>Đã xác nhận</div></td>
                                @elseif($item-> is_done == 2 )
                                    <td><div class="badge rounded-pill text-info bg-light-info p-2 text-uppercase px-3"><i class='bx bxs-circle me-1'></i>Đang giao</div></td>
                                @else
                                    <td><div class="badge rounded-pill text-success bg-light-success p-2 text-uppercase px-3"><i class='bx bxs-circle me-1'></i>Hoàn thành</div></td>
                                @endif
                                <td><div type="button" class="detail-btn btn btn-primary btn-sm radius-30 px-4" id={{$item->id}} data-bs-toggle="modal" data-bs-target="#viewDetails">Xem chi tiết</div></td>
                                <td>
                                    <div class="d-flex order-actions">
                                        <a href="javascript:;" class=""><i class='bx bxs-file-export'></i></a>
                                        <a href="javascript:;" class="ms-3"><i class='bx bx-check'></i></a>
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
                                                <td id="type_payment"><span class="badge rounded-pill text-info bg-light-info p-2 text-uppercase px-3"><i class='bx bxs-circle me-1'></i>Stripe</span></td>
                                                <td>Trạng thái thanh toán: </td>
                                                <td id="status"><span class="badge rounded-pill text-success bg-light-success p-2 text-uppercase px-3"><i class='bx bx-check me-1'></i>Success</span></td>
                                            </tr>

                                            <tr>
                                                <td>Trạng thái đơn: </td>
                                                <td id="is_done"><span class="badge rounded-pill text-success bg-light-success p-2 text-uppercase px-3"><i class='bx bx-check me-1'></i>Delivered</span></td>

                                                <td>Ngày đặt hàng: </td>
                                                <td id = "created_at">Loading ... </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-warning px-5 radius-30" data-bs-dismiss="modal"><i class ="bx bxs-file-export "></i> Xuất file PDF</button>
                            <button type="submit" id = "editOrder"  form="editPromotionForm" class="btn btn-success px-5 radius-30"  onclick="return confirm('Bạn có chắc chắn muốn cập nhật tình trạng sản phẩm?')" >Cập nhật</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>


<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.min.js"></script>

<script>
    $(document).ready(function(){
        $('.detail-btn').click(function(event){
            event.preventDefault();
            var id = $(this).attr('id');
            // alert('check data');
            // get data from database
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



                }//end success
            });

        });
    });
</script>
<script>
    $(document).ready(function(){
        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' } });
        $('#editOrder').click(function(){
            var id = $('#id').text();
            $.ajax({
                type: 'post',
                url: '{{route('order.update-is-done')}}',
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
    });
</script>

@endsection

