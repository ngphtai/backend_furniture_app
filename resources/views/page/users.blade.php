@extends('common.page.Master')
@section('noi_dung')

<div class="page-content">
    <!--breadcrumb-->
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-3 p-0">
                <li class="breadcrumb-item active" aria-current="page" style="font-size:18px">Danh sách người dùng</li>
            </ol>
        </nav>
    </div>
    <!--end breadcrumb-->

    <div class="card">
        <div class="card-body">
            <div class="d-lg-flex align-items-center mb-4 gap-3">
                <div class="position-relative">
                    <input type="text" class="form-control ps-5 radius-30" name ="search" id = "search" placeholder="Tìm kiếm tài khoản" style="width: 600px;">
                    <span class="position-absolute top-50 product-show translate-middle-y" ><i class="bx bx-search"></i></span>
                </div>
                {{-- button add ( cái hiển thị của nó là Add New Product--}}
                <div class="ms-auto " data-bs-toggle="modal" data-bs-target="#adddProduct">
                <a class="btn btn-primary radius-30 mt-2 mt-lg-0"><i class="bx bxs-plus-square"></i>Thêm Tài Khoản Mới</a>
                </div>
            </div>
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
                            <th>UID</th>
                            <th>Tên Người Dùng</th>
                            <th>Avatar</th>
                            <th>Email </th>
                            <th>Địa chỉ</th>
                            {{-- lấy địa chỉ chính thôi mấy kia k cần đâu --}}
                            <th>Số Điện Thoại</th>
                            <th>Loại tài Khoản</th>
                            <th>Hoạt Động</th>
                        </tr>
                    </thead>
                    <?php $stt =1 ?>
                    <tbody id="search_list">
                        {{-- trả về kết quả tìm kiếm --}}
                    </tbody>
                    <tbody id= 'alldata'>
                        @foreach ($info as $item )
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="ms-2">
                                        <h6 class="mb-0 font-14"><?= $stt++?></h6>
                                    </div>
                                </div>
                            </td>
                            <td>{{$item -> uid}}</td>
                            <td>{{$item -> name ??  "trống"}}</td>

                            <td>
                                @if($item->avatar)
                                    <img class ="avatar" src="{{ asset('storage/' . $item->avatar) }}" alt="No Avatar">
                                @else
                                    <span class ="avatar">No avatar</span>
                                @endif
                            </td>

                            <td>{{$item -> email}}</td>
                            <td>{{$item ->address ??  "trống"}}</td>
                            <td>{{$item -> phone_number ??  "trống"}}</td>
                            <td>{{$item -> user_type}}</td>
                            <td>
                                <div class="d-flex order-actions">
                                    <a href= "{{url('users/delete',$item->id)}}"class="ms-3 size_button_action" onclick=" return confirm('Bạn có chắc chắn muốn xoá?')"><i class="bx bxs-trash"></i></a>
                                </div>
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
            <!-- Add New Product -->
            <div class="modal fade" id="adddProduct" tabindex="-1" aria-labelledby="adddProduct" aria-hidden="true">
                <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="adddProduct"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="#" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Họ Và Tên</label>
                                <input  type="text" class="form-control" placeholder="Nhập vào họ và tên *">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" placeholder="Nhập vào email *">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Mật Khẩu</label>
                                <input type="password" class="form-control" placeholder="Nhập vào mật khẩu *">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Loại tài khoản</label>
                                <select class="form-select" aria-label="Default select example">
                                    <option selected>Chọn loại tài khoản</option>
                                    <option value="1">Admin</option>
                                    <option value="2">User</option>
                                </select>
                    </div>
                    <div class="modal-footer">
                        <button  type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button  type="submit" id="btn-add-user" class="btn btn-primary">Thêm mới</button>
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
                    url:"{{route('user.search')}}",
                    type:"GET",
                    data:{'search':query},
                    success:function(data){
                        $('#search_list').html(data);
                    }
                });
            });
        });

    $('#btn-add-user').click(function(){
        var name = $('#name').val();
        var email = $('#email').val();
        var password = $('#password').val();
        var user_type = $('#user_type').val();
        $.ajax({
            url:"{{route('user.store')}}",
            type:"POST",
            data:{
                name:name,
                email:email,
                password:password,
                user_type:user_type,
                _token:"{{csrf_token()}}"
            },
            success:function(data){
                alert(data);
            }
        });
    });
</script>
@endsection
