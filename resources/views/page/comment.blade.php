@extends('common.page.Master')
@section('noi_dung')

<div class="page-content">

    <!--breadcrumb-->
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-3 p-0">
                <li class="breadcrumb-item active" aria-current="page" style="font-size:18px">Bình luận</li>
            </ol>
        </nav>
    </div>
    <!--end breadcrumb-->

    <?php
        //    $info = App\Models\Comments::with('user', 'product');
    ?>

    <div class="card">
        <div class="card-body">
            <div class="d-lg-flex align-items-center mb-4 gap-3">
                <div class="position-relative">
                    <input type="text" name="search" id="search" class="form-control ps-5 radius-30" placeholder="Tìm kiếm bình luận" style="width: 600px;" onfocus="this.value=''">
                    <span class="position-absolute top-50 product-show translate-middle-y" ><i class="bx bx-search"></i></span>
                </div>
                {{-- button add ( cái hiển thị của nó là Add New category--}}
                <div class="ms-auto " data-bs-toggle="modal" data-bs-target="#add_word">
                <a class="btn btn-primary radius-30 mt-2 mt-lg-0"><i class="bx bxs-plus-square"></i>Kiểm tra từ Cấm</a>
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
                            <th>Tên Người dùng</th>
                            <th>Mã hoá đơn</th>
                            <th>Tên Sản Phẩm</th>
                            <th>Rating</th>
                            <th>Nội dung</th>
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
                            <td>{{
                                // optional($item->user)->name
                                $item ->user->name
                            }}</td>
                            <td>{{$item -> order_id}}</td>
                            <td>
                                {{ \Illuminate\Support\Str::limit($item->product->product_name, 15, '...', 5) }}
                            </td>
                            <td>
                                @foreach(range(1,5) as $i)
                                <span class="fa-stack" style="width:1em">
                                    <i class="far fa-star fa-stack-1x text-warning"></i>

                                    @if($item -> rating >0)
                                        @if($item -> rating >0.5)
                                            <i class="fas fa-star fa-stack-1x text-warning"></i>
                                        @else
                                            <i class="fas fa-star-half fa-stack-1x text-warning"></i>
                                        @endif
                                    @endif
                                    @php $item -> rating--; @endphp
                                </span>
                                @endforeach

                            </td>
                            <td class="mb-2">
                                <h5 style=" font-size: 15px" >
                                    {{ \Illuminate\Support\Str::limit($item->content, 100, '...') }}
                                </h5>
                            </td>
                        </tr>
                       @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add banned keyword  -->
    <div class="modal fade" id="add_word" name= "add_word" tabindex="-1" aria-labelledby="add_word" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="add_word_Label">Thêm từ khoá bị cấm</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form  action = "{{route('comment.add_keyword')}}" id ="add_keyword_form" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <div class="row row-cols-auto g-3 all_key"  >
                            @foreach ($keys as $key)
                            <div class="col">
                                <div type="button" class="btn btn-info keys-detail" id="keys-detail">{{$key}} <span class="badge bg-red "><i class="bx bxs-trash"></i></span>
                                </div>
                            </div>
                             @endforeach
                        </div>

                        <div class = "row row-cols-auto g-3 list_key">
                            @php
                                $output = ''; // Define the $output variable
                            @endphp

                            {{-- Your existing code --}}
                            <div class="table-responsive">
                                <table class="table mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Stt</th>
                                            <th>Tên Người dùng</th>
                                            <th>Mã hoá đơn</th>
                                            <th>Tên Sản Phẩm</th>
                                            <th>Rating</th>
                                            <th>Nội dung</th>
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
                                                <td>{{
                                                    // optional($item->user)->name
                                                    $item -> user_id
                                                }}</td>
                                                <td>{{$item -> order_id}}</td>
                                                <td>{{
                                                    // optional($item->product())->product_name
                                                    $item -> product_id
                                                }}</td>
                                                <td>{{$item -> rating}}</td>
                                                <td class="mb-2">
                                                    <h5 style=" font-size: 15px" >
                                                        {{ \Illuminate\Support\Str::limit($item->content, 100, '...') }}
                                                    </h5>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Add banned keyword  -->
                            <div class="modal fade" id="add_word" name= "add_word" tabindex="-1" aria-labelledby="add_word" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="add_word_Label">Thêm từ khoá bị cấm</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form  action = "{{route('comment.add_keyword')}}" id ="add_keyword_form" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div class="form-group">
                                                    <div class="row row-cols-auto g-3 all_key"  >
                                                        @foreach ($keys as $key)
                                                            <div class="col">
                                                                <div type="button" class="btn btn-info key-detail" id="key-detail">{{$key}} <span class="badge bg-red "><i class="bx bxs-trash"></i></span>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>

                                                    <div class = "row row-cols-auto g-3 list_key">
                                                        {{-- Your existing code --}}
                                                    </div>

                                                    <hr class="mt-4">
                                                    <label for="keyword" class="form-label ">Thêm từ khoá</label>
                                                    <div class="mb-3 d-flex">
                                                        <input name="keyword" type="text" class="form-control"  placeholder="Nhập từ khoá muốn cấm *" >
                                                        <button type="submit" class="btn btn-primary">Thêm</button>
                                                    </div>

                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                            <button type="submit" id ="addCategoryBtn" form="categoryForm" class="btn btn-primary">Xác nhận</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="mt-4">
                        <label for="keyword" class="form-label ">Thêm từ khoá</label>
                        <div class="mb-3 d-flex">
                            <input name="keyword" type="text" class="form-control"  placeholder="Nhập từ khoá muốn cấm *" >
                            <button type="submit" class="btn btn-primary">Thêm</button>
                        </div>

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <button type="submit" id ="addCategoryBtn" form="categoryForm" class="btn btn-primary">Xác nhận</button>
            </div>
        </div>
    </div>


</div>




<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="/assets/js/bootstrap.bundle.min.js"></script>
<script src="/assets/js/jquery.min.js"></script>

<script>
    $(document).ready(function(){

        $('.list_key').hide();
        $('#search').on('keyup',function(){
            var value = $(this).val();
            $.ajax({
                type: 'get',
                url: "{{route('comment.search')}}",
                data: {
                    'search': value
                },
                success: function(data){
                    $('#search_list').html(data);
                    $('#alldata').hide();
                    $('#search_list').show();
                }
            });
        });

        $('#add_keyword_form').on('submit', function(e){
            e.preventDefault();
            alert('submit');
            var form = $(this);
            var url = form.attr('action');
            var type = form.attr('method');
            var data = form.serialize();
            $.ajax({
                type: type,
                url: url,
                data: data,
                success: function(data){
                    $('.all_key').hide();
                    $('.list_key').html(data);
                    $('.list_key').show();
                },
                error: function(error){
                    console.log(error);
                }
            });
        });
    });
</script>
<script>
   $(document).ready(function(){

    $('.keys-detail').on('click', function() {
        var key = $(this).text();
        $.ajax({
            type: 'get',
            url: '{{route("comment.delete_keyword")}}',
            data: {
                'delete_key': key
            },
            success: function(data) {
                // alert(key);
                $('.all_key').hide();
                $('.list_key').html(data);
                $('.list_key').show();

            }
        });
    });
    $('#add_word').on('click', '.key-detail', function() {
        var key = $(this).text();
        $.ajax({
            type: 'get',
            url: '{{route("comment.delete_keyword")}}',
            data: {
                'delete_key': key
            },
            success: function(data) {
                // alert(key);
                $('.all_key').hide();
                $('.list_key').html(data);
                $('.list_key').show();
            }
        });
    });
});

</script>

@endsection
