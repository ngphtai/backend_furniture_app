@extends('common.page.Master')
@section('noi_dung')

    <div class="page-content">
        <!--breadcrumb-->
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-3 p-0">
                    <li class="breadcrumb-item active" aria-current="page" style="font-size:18px">Danh Mục</li>
                </ol>
            </nav>
        </div>
        <!--end breadcrumb-->

        <div class="card">
            <div class="card-body">
                <div class="d-lg-flex align-items-center mb-4 gap-3">
                    <div class="position-relative">
                        <input type="text" name="search" id="search" class="form-control ps-5 radius-30" placeholder="Tìm kiếm Danh Mục" style="width: 600px;" onfocus="this.value=''">
                        <span class="position-absolute top-50 product-show translate-middle-y" ><i class="bx bx-search"></i></span>
                    </div>
                    {{-- button add ( cái hiển thị của nó là Add New category--}}
                    <div class="ms-auto " data-bs-toggle="modal" data-bs-target="#addCategory">
                    <a class="btn btn-primary radius-30 mt-2 mt-lg-0"><i class="bx bxs-plus-square"></i>Thêm Danh Mục</a>
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

                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Stt</th>
                                <th>Tên Danh Mục</th>
                                <th>Hình ảnh minh hoạ</th>
                                <th>Hoạt động</th>
                            </tr>
                        </thead>

                        <tbody id="search_list">
                            {{-- trả về kết quả tìm kiếm --}}
                        </tbody>
                        <?php $stt =1 ?>
                        <tbody id = "alldata">
                           @foreach ($info as $item )
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="ms-2">
                                            <h6 class="mb-0 font-14"><?= $stt++?></h6>
                                        </div>
                                    </div>
                                </td>
                                <td>{{$item -> name}}</td>
                                <td>
                                    @if($item->image)
                                        <img class ="image_review_category" src="{{ asset('storage/' . $item->image) }}" alt="No image">
                                    @else
                                        <span class ="image_review_category">No image</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex order-actions">
                                        <div class="ms-center " data-bs-toggle="modal" data-bs-target="#editCategoryModal"  >
                                        <a class="edit-category-btn size_button_action" id = {{$item -> id}} >
                                        <i   class=" bx bxs-edit " ></i></a>
                                        </div>
                                         <a href= "{{url('categories/delete',$item->id)}}"class="ms-3 size_button_action" onclick=" return confirm('Bạn có chắc chắn muốn xoá?')"><i class="bx bxs-trash"></i></a>
                                    </div>
                                </td>
                            </tr>
                           @endforeach

                        </tbody>
                    </table>
                </div>
                <!-- Add New Product -->
                <div class="modal fade" id="addCategory" tabindex="-1" aria-labelledby="addCategory" aria-hidden="true">
                    <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addCategoryLabel">Thêm danh mục</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form  action = "{{route('category.store')}}" id ="add_category_form" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Tên danh mục</label>
                                        <input name="name" type="text" class="form-control" placeholder="Nhập vào tên danh mục *" wire:model="name">
                                    </div>
                                    <div class="mb-3">
                                        <div class="my-2">
                                            <label for="image">Chọn ảnh minh hoạ</label>
                                            <input  name="image" type="file"  class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                            <button type="submit" id ="addCategoryBtn" form="categoryForm" class="btn btn-primary">Thêm danh mục</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- update Product -->

        <div class="modal fade" id="editCategoryModal" tabindex="0" aria-labelledby="editCategoryModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editCategoryModalLabel">Chỉnh sửa Danh Mục</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    {{-- body --}}
                    <div class="modal-body">
                        <div class="card-body">
                            <form id="editCategoryForm" action="#" enctype="multipart/form-data" >
                                @csrf
                                <div class="form-group">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Tên danh mục</label>
                                        <input name="name" id ="name" type="text" class="form-control" placeholder="Nhập vào tên danh mục *" wire:model="name">
                                    </div>
                                    <div class="mb-3">
                                        <div class="my-2">
                                            <label for="image">Chọn ảnh minh hoạ</label>
                                            <input  name="image" id="image" type="file"  class="form-control">
                                        </div>
                                    </div>
                                    <div class="mt-2" id ="image_review">

                                    </div>
                                    <input type="hidden" name="id" id="id">
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" id = "editCategoryBtn" form="editCategoryForm" class="btn btn-primary" onclick="return confirm('Bạn có chắc chắn muốn cập nhật?')" >Cập nhật</button>
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
    <script src="/assets/js/bootstrap.bundle.min.js"></script>


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
                    url:"{{route('category.search')}}",
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
        // Edit button click event handler
        $('.edit-category-btn').click(function(event) {
            event.preventDefault();
            const categpryId = $(this).attr('id') ;
            $.ajax({
                url: '{{ route('category.edit') }}',
            method: 'get',
            data: {
                id: categpryId,
            },
            success: function(data) {
                $("#name").val(data.name);
                $("#image_review").html(
                `<img src="/storage/${data.image}" alt ="lỗi hình ảnh" width="250" height="200" class="img-fluid img-thumbnail ">`);
                $("#id").val(data.id);

            },
            error: function(error) {
                console.error('Error fetching category data:', error);
            }
            });

        });

        $(document).ready(function() {
            $('#editCategoryBtn').click(function(event) {
                event.preventDefault(); // tránh sự kiện mặc định của form
                const id = $('#id').val();
                // lấy id của sản phẩm
                 promotionData = $('#editCategoryForm').serialize();
                $.ajax({
                url: `/categories/update/${id}`,
                method: 'POST',
                data: promotionData,
                success: function(response) {
                    if (response.status == 200) {
                        $('#editCategoryModal').modal('hide');
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

   {{--                _oo0oo_
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
