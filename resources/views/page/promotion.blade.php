@extends('common.page.Master')
@section('noi_dung')

    <div class="page-content">
        <!--breadcrumb-->
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-3 p-0">
                    <li class="breadcrumb-item active" aria-current="page" style="font-size:18px">Khuyến Mãi</li>
                </ol>
            </nav>
        </div>
        <!--end breadcrumb-->

        <div class="card">
            <div class="card-body">
                <div class="d-lg-flex align-items-center mb-4 gap-3">
                    <div class="position-relative">
                        <input type="text" name="search" id="search" class="form-control ps-5 radius-30" placeholder="Tìm kiếm theo têna Khuyến Mãi" style="width: 600px;">
                        <span class="position-absolute top-50 product-show translate-middle-y" ><i class="bx bx-search"></i></span>
                    </div>
                    {{-- button add ( cái hiển thị của nó là Add New promotion--}}
                    <div class="ms-auto " data-bs-toggle="modal" data-bs-target="#addPromotion">
                    <a class="btn btn-primary radius-30 mt-2 mt-lg-0"><i class="bx bxs-plus-square"></i>Thêm Khuyến Mãi</a>
                    </div>
                </div>
                {{-- bắt sự kiện tạo mới sản phẩm thành công  --}}
                @if(session('success'))
                    <div class="alert alert-success" role="alert">
                        {{session() -> get('success')}}
                    </div>
                @endif
                @if($errors->any())
                    <div class=" alert alert-danger" role="alert">
                        @foreach ($errors->all() as $error)
                        <li class='list-group-item text-danger'>{{$error}}</li>
                        @endforeach
                    </div>
                @endif

                    <table class="table mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Stt</th>
                                <th>Tên Khuyến Mãi</th>
                                <th>Mô Tả</th>
                                <th>Giảm Giá </th>
                                <th>Ngày Bắt Đầu</th>
                                <th>Ngày Kết Thúc</th>
                                <th>Hiển Thị</th>
                                <th>Hoạt Động</th>
                            </tr>
                        </thead>

                        <?php $stt =1 ?>
                        <tbody id="search_list">
                            {{-- trả về kết quả tìm kiếm --}}
                        </tbody>
                        <tbody id ="alldata">
                            @foreach ($info as $item )
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="ms-2">
                                            <h6 class="mb-0 font-14">{{$item->id}}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>{{$item -> promotion_name}}</td>
                                <td>{{$item -> description ??  "trống"}}</td>
                                <td>{{$item -> discount}}%</td>
                                <td>{{$item -> start_date}}</td>
                                <td>{{$item -> end_date}}</td>
                                <td>
                                    @if($item ->is_show == 1)
                                        <icon class="badge bg-success">Hiển Thị</icon>
                                    @else
                                        <icon class="badge bg-danger">Ẩn</icon>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex order-actions">
                                        <div class="ms-auto " data-bs-toggle="modal" data-bs-target="#editPromotionModal"  >
                                            <a class="edit-promotion-btn" id = {{$item -> id}}  class=""><i class='bx bxs-edit'></i></a>
                                        </div>
                                        <a href="{{url('promotions/delete',$item->id)}}" class="ms-3" onclick="return confirm('Bạn có chắc chắn muốn xoá?')"><i class='bx bxs-trash'></i></a>

                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{$info->links()}}
                </div>


                <!-- Add New promotion -->
                <div class="modal fade" id="addPromotion" tabindex="0" aria-labelledby="addPromotion" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addPromotion">Thêm Khuyến Mãi</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">

                                <div class="card-body">
                                    <form id="promotionForm" action="{{route('promotion.store')}}" method="POST">
                                        @csrf
                                        {{-- chống tấn công CSRF --}}
                                        <div class="form-group">
                                            <div class="mb-3">
                                                <label for="promotion_name" class="form-label">Tên Khuyến Mãi</label>
                                                <input name="promotion_name" type="text" class="form-control" placeholder="Nhập vào tên Khuyến Mãi *" wire:model="name">
                                            </div>
                                            <div class="mb-3">
                                                <label for="description" class="form-label">Mô Tả</label>
                                                <textarea name="description" type="text" class="form-control" placeholder="Nhập vào mô tả *" wire:model="description"></textarea>

                                            </div>
                                            <div class="mb-3">
                                                <label for="discount" class="form-label">Giảm giá</label>
                                                <input name="discount" type="tel" class="form-control" placeholder="Chọn giá giảm % *">

                                            </div>
                                            <div class="mb-3">
                                                <label for="start_date" class="form-label">Ngày bắt đầu</label>
                                                <input name="start_date" type="date" class="form-control">

                                            </div>
                                            <div class="mb-3">
                                                <label for="end_date" class="form-label">Ngày kết thúc </label>
                                                <input name="end_date" type="date" class="form-control">

                                            </div>
                                            <div class="mb-3">
                                                <label for="is_show" class="form-label">Trạng thái</label>
                                                <select name="is_show" class="form-select">
                                                    <option value="1">Hiển Thị</option>
                                                    <option value="0">Ẩn</option>
                                                </select>

                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                <button type="submit" form="promotionForm" class="btn btn-primary" onclick="return confirm('Bạn có chắc chắn muốn thêm mới?')">Thêm mới</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- update Product -->

                <div class="modal fade" id="editPromotionModal" tabindex="0" aria-labelledby="editPromotionModal" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editPromotionModelLabel">Chỉnh sửa Khuyến Mãi</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            {{-- body --}}
                            <div class="modal-body">
                                <div class="card-body">
                                    <form id="editPromotionForm" action="#" enctype="multipart/form-data" >
                                        @csrf
                                        {{-- chống tấn công CSRF --}}
                                        <input type="hidden" name="id" id = "id" >
                                        <div class="form-group">
                                            <div class="mb-3">
                                                <label for="promotion_name" class="form-label">Tên Khuyến Mãi</label>
                                                <input name="promotion_name"  id ="promotion_name" type="text" class="form-control" placeholder="Nhập vào tên Khuyến Mãi *" wire:model="name">
                                            </div>
                                            <div class="mb-3">
                                                <label for="description" class="form-label">Mô Tả</label>
                                                <textarea name="description" id ="description"  type="text" class="form-control" placeholder="Nhập vào mô tả *" wire:model="description"></textarea>

                                            </div>
                                            <div class="mb-3">
                                                <label for="discount" class="form-label">Giảm giá</label>
                                                <input name="discount"  id ="discount" type="tel" class="form-control" placeholder="Chọn giá giảm % *">

                                            </div>
                                            <div class="mb-3">
                                                <label for="start_date" class="form-label">Ngày bắt đầu</label>
                                                <input name="start_date" id="start_date"  type="date" class="form-control">

                                            </div>
                                            <div class="mb-3">
                                                <label for="end_date" class="form-label">Ngày kết thúc </label>
                                                <input name="end_date" id="end_date"  type="date" class="form-control">

                                            </div>
                                            <div class="mb-3">
                                                <label for="is_show" class="form-label">Trạng thái</label>
                                                <select name="is_show" id="is_show"  class="form-select">
                                                    <option value="1">Hiển Thị</option>
                                                    <option value="0">Ẩn</option>
                                                </select>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                <button type="submit" id = "editPromotionBtn" form="editPromotionForm" class="btn btn-primary"  onclick="return confirm('Bạn có chắc chắn muốn cập nhật?')" >Cập nhật</button>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>




    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <script>
        //search
        $(document).ready(function(){
            $('#search').on('keyup',function(){
                var query= $(this).val();
                // alert(query);
                if(query){
                    $('#alldata').hide();
                    $('#search_list').show();
                }else {
                    $('#alldata').show();
                    $('#search_list').hide();
                }
                $.ajax({
                    url:"{{route('promotion.search')}}",
                    type:"GET",
                    data:{'search':query},
                    success:function(data){
                        $('#search_list').html(data);
                    }
                });
            });
        });
    </script>

    {{-- edit  --}}
    <script>
        $(document).ready(function() {

        // Edit button click event handler to each promotion
        $('.edit-promotion-btn').click(function(event) {
            event.preventDefault();
            const promotionId = $(this).attr('id') ;
            $.ajax({
                url: '{{ route('promotion.edit') }}',
            method: 'get',
            data: {
                id: promotionId,
            },
            success: function(promotionData) {
                $("#promotion_name").val(promotionData.promotion_name);
                $("#description").val(promotionData.description);
                $("#discount").val(promotionData.discount);
                $("#start_date").val(promotionData.start_date);
                $("#end_date").val(promotionData.end_date);
                $("#is_show").val(promotionData.is_show);
                $("#id").val(promotionData.id);

            },
            error: function(error) {
                console.error('Error fetching promotion data:', error);
            }
            });

        });
        //handle update promotion
        $(document).ready(function() {
            $('#editPromotionBtn').click(function(event) {
                event.preventDefault(); // tránh sự kiện mặc định của form
                const promotionId = $('#id').val(); // lấy id của sản phẩm
                 promotionData = $('#editPromotionForm').serialize();
                $.ajax({
                url: `/promotions/update/${promotionId}`,
                method: 'POST',
                data: promotionData,
                success: function(response) {
                    if (response.status == 200) {
                        $('#editPromotionModal').modal('hide');
                        location.reload();
                    }
                },
                error: function(error) {
                    console.error('Error updating promotion:', error);
                }
                });
            });
        });

        });


    </script>


@endsection

                  {{-- _oo0oo_
                      o8888888o
                      88" . "88
                      (| -_- |)
                      0\  =  /0
                    ___/`---'\___
                  .' \\|     |// '.
                 / \\|||  :  |||// \
                / _||||| -:- |||||- \
               |   | \\\  -  /// |   |
               | \_|  ''\---/''  |_/ |
               \  .-\__  '-'  ___/-. /
             ___'. .'  /--.--\  `. .'___
          ."" '<  `.___\_<|>_/___.' >' "".
         | | :  `- \`.;`\ _ /`;.`/ - ` : | |
         \  \ `_.   \_ __\ /__ _/   .-` /  /
     =====`-.____`.___ \_____/___.-`___.-'=====
                       `=---='


     ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}
