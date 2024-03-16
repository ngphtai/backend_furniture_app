@extends('common.page.Master')
@section('noi_dung')

    <div class="page-content">
        <!--breadcrumb-->

        <!--end breadcrumb-->

        <div class="card">
            <div class="card-body">
                <div class="d-lg-flex align-items-center mb-4 gap-3">
                    <div class="position-relative">
                        <input type="text" name="search" id="search" class="form-control ps-5 radius-30" placeholder="Tìm kiếm Khuyến Mãi" style="width: 600px;" onfocus="this.value=''">
                        <span class="position-absolute top-50 product-show translate-middle-y" ><i class="bx bx-search"></i></span>
                    </div>
                    {{-- button add ( cái hiển thị của nó là Add New Product--}}
                    <div class="ms-auto " data-bs-toggle="modal" data-bs-target="#adddProduct">
                    <a class="btn btn-primary radius-30 mt-2 mt-lg-0"><i class="bx bxs-plus-square"></i>Thêm Khuyến Mãi</a>
                    </div>
                </div>
                {{-- bắt sự kiện tạo mới sản phẩm thành công  --}}
                @if(session('success'))
                    <div class="alert alert-success" role="alert">
                        {{session() -> get('success')}}
                </div>
                 @elseif (session('delete success'))
                    <div class="alert alert-success" role="alert">
                        {{session() -> get('delete success')}}
                    </div>
                @elseif (session('update success'))
                    <div class="alert alert-success" role="alert">
                        {{session() -> get('update success')}}
                    </div>
                <div >
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

                        </tbody>
                        <tbody id ="alldata">
                            @foreach ($info as $item )
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="ms-2">
                                            <h6 class="mb-0 font-14"><?= $stt++?></h6>
                                        </div>
                                    </div>
                                </td>
                                <td>{{$item -> promotion_name}}</td>
                                <td>{{$item -> description ??  "trống"}}</td>
                                <td>{{$item -> discount}}</td>
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
                                        <div class="ms-auto " data-bs-toggle="modal" data-bs-target="#editPromotionModal">
                                            <a class="edit-promotion-btn"  data-id="{{$item->id}}" class=""><i class='bx bxs-edit'></i></a>
                                        </div>
                                        <a href="{{url('promotions/delete',$item->id)}}" class="ms-3" onclick="return confirm('Bạn có chắc chắn muốn xoá?')"><i class='bx bxs-trash'></i></a>

                                    </div>
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                </div>


                <!-- Add New Product -->
                <div class="modal fade" id="adddProduct" tabindex="0" aria-labelledby="adddProduct" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="adddProduct">Thêm Khuyến Mãi</h5>
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
                                    <form id="editPromotionForm" action="{{url("promotions/update/",9)}}" method="PUT">
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
                                <button type="submit" form="editPromotionForm" class="btn btn-primary" onclick="return confirm('Bạn có chắc chắn muốn cập nhật ?')">Thêm mới</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>



    {{-- search with name --}}
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <script>
        $(document).ready(function(){
            $('#search').on('keyup',function(){
                var query= $(this).val();

                if(query){
                    $('#alldata').hide();
                    $('#search_list').show();
                }else {
                    $('#alldata').show();
                    $('#search_list').hide();
                }
                $.ajax({
                    url:"/promotions/search",
                    type:"GET",
                    data:{'search':query},
                    success:function(data){
                        $('#search_list').html(data);
                    }
                });
                //end of ajax call
            });
        });
    </script>

{{-- edit  --}}
    <script>
        $(document).ready(function(){
            $('.edit-promotion-btn').click(function(){
                var promotionId = $(this).data('id');
                $.ajax({
                    url: '/promotions/show/' + promotionId, // Corrected URL by adding a slash before the promotionId
                    type: 'GET',
                    success: function(response){
                        // Đổ dữ liệu vào form chỉnh sửa
                        // $id = response.id;
                        // $('#editPromotionForm').attr('action', '/promotions/' + promotionId);
                        $('#editPromotionForm').find('input[name="promotion_name"]').val(response.promotion_name);
                        $('#editPromotionForm').find('textarea[name="description"]').val(response.description);
                        $('#editPromotionForm').find('input[name="discount"]').val(response.discount);
                        $('#editPromotionForm').find('input[name="start_date"]').val(response.start_date);
                        $('#editPromotionForm').find('input[name="end_date"]').val(response.end_date);
                        $('#editPromotionForm').find('select[name="is_show"]').val(response.is_show);
                        $('#editPromotionModal').modal('show');
                    }
                });
            });
        });
    </script>


@endsection
