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
                    {{-- button add ( cái hiển thị của nó là Add New promotion--}}
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
                                                       {{ $item->rating_count}}
                                                        <i class="bx bxs-star text-warning"></i>
                                                    </p>
                                                </div>
                                            </td>

                                            <td>
                                                <ul class="list-unstyled ps-0 mb-0 ">
                                                    <li><p class="text-muted mb-1 text-truncate"><i class="mdi mdi-circle-medium align-middle text-primary me-1"></i>Tồn kho:<b style ="font size:13 px"> {{$item -> quantity}}</b> </p></li>
                                                    <li><p class="text-muted mb-1 text-truncate"><i class="mdi mdi-circle-medium align-middle text-primary me-1"></i>Đã bán:<b style ="font size:13 px"> {{$item -> sold}}</b> </p></li>
                                                    <li><p class="text-muted mb-0 text-truncate"><i class="mdi mdi-circle-medium align-middle text-primary me-1"></i>Giá tiền: <b style ="font size:15 px">{{$item -> price}}</b></p></li>
                                                    <li><p class="text-muted mb-1 text-truncate"><i class="mdi mdi-circle-medium align-middle text-primary me-1"></i>Khuyến mãi: <b style ="font size:13 px">{{optional($item->promotion)->discount}}%  </b> </p></li>
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
                                                    <a href="{{url('products/delete',$item->id)}}"  onclick="return confirm('Bạn có chắc chắn muốn xoá?')"><i class='bx bxs-trash' ></i></a>
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




<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


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


@endsection
