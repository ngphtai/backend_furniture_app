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
                <input type="text" class="form-control ps-5 radius-30"  id="search" placeholder="Tìm kiếm tài khoản" style="width: 600px;">
                <span class="position-absolute top-50 product-show translate-middle-y"><i class="bx bx-search"></i></span>
            </div>
            {{-- button add ( cái hiển thị của nó là Add New Product--}}
            <div class="ms-auto" data-bs-toggle="modal" data-bs-target="#addUser">
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
                            <th>Trạng thái</th>
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
                                        <h6 class="mb-0 font-14">{{$item ->id}}</h6>
                                    </div>
                                </div>
                            </td>
                            <td >{{ \Illuminate\Support\Str::limit($item->uid, 10, '...') }}</td>
                            <td>{{$item -> name ??  "trống"}}</td>

                            <td>
                                @if($item->avatar)
                                    <img class ="avatar" src="{{ asset( $item->avatar) }}" alt="No Avatar">
                                @else
                                    <span class ="avatar">No avatar</span>
                                @endif
                            </td>

                            <td>{{$item -> email}}</td>
                            <td>  @if($item -> address == null )
                                    {{'trống'}}
                                @else{
                                    {{ Str::limit($item->address, 10, '') }}<br>
                                    @if (strlen($item->address) > 10)
                                    {{ Str::substr($item->address, 10) }}
                                    @endif
                                }
                                @endif
                            </td>
                            <td>{{$item -> phone_number ??  "trống"}}</td>
                            <td>{{$item -> user_type}}</td>
                            <td>
                                @if($item ->is_lock == 0)
                                    <span class="badge bg-success">Hoạt Động</span>
                                @else
                                    <span class="badge bg-danger">Khoá</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex order-actions">
                                    @if($item->is_lock == 0)
                                        <a href="{{url('users/block',$item->id)}}" class="ms-3 size_button_action" onclick="return confirm('Bạn có chắc chắn muốn khoá tài khoản này?')"><i class="bx bx-block"></i></a>
                                    @else
                                        <a href="{{url('users/block',$item->id)}}" class="ms-3 size_button_action" onclick="return confirm('Bạn có chắc chắn muốn mở khoá tài khoản này?')"><i class="bx bx-check"></i></a>
                                    @endif
                                </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
                {{$info->links()}}
            </div>
            <!-- Add New User -->
            <div class="modal fade" id="addUser" tabindex="0" aria-labelledby="addUser" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" >Thêm Tài Khoản</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                                <form name="addForm"  action ='{{route('user.store')}}' method="POST"  enctype="multipart/form-data">
                                    @csrf
                                    <?php $uid = rand(10000,99990)?>
                                    <input type="hidden" id="uid" name="uid" value="{{$uid}}">
                                    <div class="mb-3">
                                        <label class="form-label" for= "name">Họ Và Tên</label>
                                        <input  type="text" name="name"  id ="name"   class="form-control" placeholder="Nhập vào họ và tên *" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="email">Email</label>
                                        <input type="email"   name="email"  id ="email" class="form-control" placeholder="Nhập vào email *" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="password">Mật Khẩu</label>
                                        <input type="password" name ="password" id="password" class="form-control" placeholder="Nhập vào mật khẩu *" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="user_type">Loại tài khoản</label>
                                        <select class="form-select" name="user_type" id="user_type">
                                            <option value="Admin">Admin</option>
                                            <option value="Staff">Staff</option>
                                            <option value="User">User</option>
                                        </select>
                                    </div>
                                    <div class="modal-footer">
                                        <button  type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                        <button  type="submit" id="btn-add-user" class="btn btn-primary">Thêm mới</button>
                                    </div>
                                </form>
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

    // $('#addUser').on('click','#btn-primary',function(e){
    //     e.preventDefault();
    //     var name = $('#name').val();
    //     var email = $('#email').val();
    //     var password = $('#password').val();
    //     var user_type = $("#user_type").val();

    //     $.ajax({
    //     url:'{{route('user.store')}}',
    //     type:"POST",
    //     data:{
    //         name: name,
    //         email: email,
    //         password: password,
    //         user_type: user_type
    //     },
    //     success:function(data){
    //         toastr.success(data.message);
    //         $('#addUser').modal('hide');
    //     },
    //     error:function(data){
    //         toastr.error(data.message);
    //         }
    //     });
    // });
</script>
@endsection
