@extends('common.page.Master')
@section('noi_dung')

    <div class="page-content">
        <!--breadcrumb-->
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-3 p-0">
                    <li class="breadcrumb-item active" aria-current="page" style="font-size:18px">Danh Sách Sản Phẩm</li>
                </ol>
            </nav>
        </div>

        <!--end breadcrumb-->

        <div class="card">
            <div class="card-body">
                <div class="d-lg-flex align-items-center mb-4 gap-3">
                    <div class="position-relative">
                        <input type="text" name="search" id="search" class="form-control ps-5 radius-30" placeholder="Tìm kiếm sản phẩm" style="width: 600px;" onfocus="this.value=''">
                        <span class="position-absolute top-50 product-show translate-middle-y" ><i class="bx bx-search"></i></span>
                    </div>
                    <div class ="ms-auto">
                        <button type="button" class="btn btn-primary radius-30 mt-2 mt-lg-0" data-bs-toggle="modal" data-bs-target="#ColorManagement">
                            <i class="bx bxs-plus-square"></i>Quản lý màu sắc
                        </button>
                    </div>
                    <a href="{{ url('products/addproduct') }}" class="ms-auto btn btn-primary radius-30 mt-2 mt-lg-0"><i class="bx bxs-plus-square"></i>Thêm sản phẩm</a>

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
                        <div class="row">
                            <div class="col-xl-12">
                                <table class="table table-striped align-middle table-nowrap">
                                    <?php $stt =1 ?>
                                    <tbody id="search_list">
                                        {{-- trả về kết quả tìm kiếm --}}
                                    </tbody>

                                    <tbody  id ="alldata">
                                        <?php
                                        $info = App\Models\Products::with('promotion')->get();
                                        $info = App\Models\Products::with('category')->get();

                                        // lấy ra tất cả sản phẩm và danh mục của sản phẩm ( trong model Products có 1 hàm category dùng để lấy ra danh mục của sản phẩm)
                                        ?>
                                        @foreach ($info as $item )
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="ms-2">
                                                        <h6 class="mb-0 font-14"><?= $stt++?></h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="avatar-lg me-4">
                                                    @php
                                                        $images = json_decode($item->product_image);
                                                        // kiểm tra xem nó có phải là mảng không nếu có thì lấy giá trị đầu tiên nếu không thì lấy giá trị đó
                                                    @endphp

                                                    @if(is_array($images))
                                                        <img src="{{ asset('/storage//'. $images[0]) }}" alt="Hình ảnh" style="width: 100px; height: 100px;">
                                                    @endif

                                                </div>
                                            </td>

                                            <td>
                                                <div class="mb-3" >
                                                    <h5 class="font-size-15 ">
                                                        <a href="{{url('products/detail', $item->id)}}" class="text-dark">
                                                            {{ \Illuminate\Support\Str::limit($item->product_name, 50, '...') }}
                                                        </a>
                                                    </h5>
                                                    <h6 class="font-size-15">{{optional($item->category)->name }}</h6>
                                                    <p class="text-muted mb-0 mt-2 pt-2">

                                                       @foreach(range(1,5) as $i)
                                                       <span class="fa-stack" style="width:1em">
                                                           <i class="far fa-star fa-stack-1x text-warning"></i>

                                                           @if($item -> rating_count >0)
                                                               @if($item -> rating_count >0.5)
                                                                   <i class="fas fa-star fa-stack-1x text-warning"></i>
                                                               @else
                                                                   <i class="fas fa-star-half fa-stack-1x text-warning"></i>
                                                               @endif
                                                           @endif
                                                           @php $item -> rating_count--; @endphp
                                                       </span>
                                                       @endforeach
                                                    </p>
                                                </div>
                                            </td>

                                            <td>
                                                <ul class="list-unstyled ps-0 mb-0 ">
                                                    <li><p class="text-muted mb-1 text-truncate"><i class="mdi mdi-circle-medium align-middle text-primary me-1"></i>Tồn kho:<b style ="font size:13 px"> {{$item -> quantity}}</b> </p></li>
                                                    <li><p class="text-muted mb-1 text-truncate"><i class="mdi mdi-circle-medium align-middle text-primary me-1"></i>Đã bán:<b style ="font size:13 px"> {{$item -> sold}}</b> </p></li>
                                                    <li><p class="text-muted mb-0 text-truncate"><i class="mdi mdi-circle-medium align-middle text-primary me-1"></i>Giá tiền: <b style ="font size:15 px">{{$item -> price}}</b></p></li>
                                                    <li><p class="text-muted mb-1 text-truncate"><i class="mdi mdi-circle-medium align-middle text-primary me-1"></i>Khuyến mãi: <b style ="font size:13 px">{{optional($item->promotion)->discount?? 0}}%  </b> </p></li>
                                                </ul>
                                            </td>

                                            <td class="mb-2">
                                                <h5 style=" font-size: 15px" class = "text-muted">
                                                    {{ \Illuminate\Support\Str::limit($item->description, 100, '...') }}
                                                </h5>
                                            </td>
                                            <td class="col-md-1">
                                                <a href="{{ url('products/detail', $item->id) }}" class="btn btn-primary btn-sm waves-effect waves-light" style="font-size: 20px;">
                                                    <i class="bx bx-detail me-2 align-middle" style="font-size:25px"></i>

                                                </a>

                                            </td>
                                            <td class="col-md-1">
                                                <div class="d-flex order-actions" style="font-size: 20px;">
                                                    @if($item->is_show == 1)
                                                        <span class="badge bg-success" >Hiển Thị</span>
                                                    @else
                                                        <span class="badge bg-danger">Ẩn</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="col-md-1">
                                                <div class="d-flex order-actions">
                                                    <a href="{{url('products/delete',$item->id)}}"   onclick="return confirm('Bạn có chắc chắn muốn xoá?')"><i class='bx bxs-trash' ></i></a>
                                                </div>
                                            </td>

                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                </div>
        </div>
    </div>

    <!-- Color Management -->
    <div class="modal fade" id="ColorManagement" tabindex="-1" aria-labelledby="ColorManagement" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ColorManagementLabel">Quản lý màu sắc</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('color.add')}}" method="POST" id ="form_color" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <div class="table-responsive">
                            <table class = "table mb-0">
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
                                    <div class ="all-color">
                                            @foreach ($colors as $color)
                                                <tr>
                                                    <td >
                                                        <a class="ms-auto radius-30 text-black " style=" width:100px; height:30px;margin-top:20px">{{$color->id}} </a>
                                                    </td>
                                                    <td >
                                                        <div class="ms-auto radius-30 " style="background-color: #{{$color->color_name }}; width:150px; height: 30px; margin:0 20px 20px 0"></div>
                                                    </td>
                                                    <td>
                                                        <div class="ms-auto radius-30 btn edit-btn" id = '{{$color ->id}}'  style=" width:100px; height: 40px;">
                                                              <i class='bx bxs-edit text-black' ></i>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                    </div>
                                    <div class ="list-color" style="display:none">
                            </table>
                            <hr class="mt-4">
                                <label id = "labelEdit" class="form-label "  >Thêm từ khoá</label>
                                <div class="mb-3 d-flex">
                                    <input type= "hidden" name ="id" id="id"></input>
                                    <input name="color_name" id ="color_name" type="text" style ="margin:0 5px 5px 0" class="form-control"  placeholder="Nhập mã màu muốn thêm *" required>
                                    <button id ="reset"  style ="margin:5px" class="btn btn-warning " >Reset</button>
                                    <button id ="buttonColor" type="submit" style ="margin:5px" class="btn btn-primary " >Thêm</button>
                                </div>
                        </div>
                    </div>
                </form>
        </div>
        </div>
    </div>



<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
{{-- <!--start overlay-->
<div class="overlay toggle-icon"></div>
<!--end overlay-->
<!--Start Back To Top Button-->
<a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
<!--End Back To Top Button--> --}}

<script>
    //search
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
                url:"{{route('product.search_admin')}}",
                type:"GET",
                data:{'search':query},
                success:function(data){
                    $('#search_list').html(data);

                }
            });
        });
    });
</script>

<script>
   $(document).ready(function() {
        $('#color_name').val(null);
        $('#id').val(null);
        // Ensure ColorManagement element exists before attaching event handler
        if ($('#ColorManagement').length > 0) {
            $('#ColorManagement').on('click', '.edit-btn', function(e) {
            e.preventDefault();

            var id = $(this).attr('id');
            console.log("Edit button clicked with ID:", id);

            // Update button text
            $('#buttonColor').text("Cập nhật");
            $('#labelEdit').text("Cập nhật từ khoá");
            $.ajax({
                type: "GET",
                url: "{{ route('color.edit') }}", // Check route helper definition
                data: {
                "id": id,
                "_token": "{{ csrf_token() }}" // Check CSRF token generation
                },
                success: function(data) {
                console.log("AJAX success:", data);
                $('#color_name').val(data.color_name);
                $('#id').val(data.id);
                //toart thông báo khi cập nhật thành công
                toastr.success('Cập nhật thành công');
                },
                error: function(error) {
                console.error("AJAX error:", error);
                alert(error.message);
                }
            });
            });
        } else {
            console.warn("Element with ID 'ColorManagement' not found"); // Debugging log
        }
        $('#reset').click(function(){
            $('#color_name').val(null);
            $('#id').val(null);
            $('#buttonColor').text("Thêm");
            $('#labelEdit').text("Thêm từ khoá");
        });
    });
</script>

{{-- <script>
    $(document).ready(function(){
        $('.form_color').on('submit', function(e){
            $type = $(this).attr('method');
            alert($type);
            e.preventDefault();
            $check =  $('input#color_name').val();
            alert($check);
                var form = $(this);
                var data = form.serialize();
                $.ajax({
                    type: "$type ",
                    url: "{{route('color.create')}}" ,
                    data:
                    {
                        "colors_name": $('input#color_name').val()
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function(data){
                        alert(data);
                        $('.all-color').hide();
                        $('.list-color').html(data);
                        $('.list-color').show();
                    },
                    error: function(error){
                        alert("error" + error);
                    }
                });
        });
    })
</script> --}}
{{--
<script>
    if (window.location.protocol !== "https:") {
      window.location.href = "https:" + window.location.href.substring(window.location.protocol.length);
    }
  </script> --}}
@endsection
