@extends('common.page.Master')
@section('noi_dung')

<div class="page-content">
    <!--breadcrumb-->

    <!--end breadcrumb-->

    <div class="card">
        <div class="card-body">
            <div class="d-lg-flex align-items-center mb-4 gap-3">
                <div class="position-relative">
                    <input type="text" class="form-control ps-5 radius-30" placeholder="Search User" style="width: 600px;">
                    <span class="position-absolute top-50 product-show translate-middle-y" ><i class="bx bx-search"></i></span>
                </div>
                {{-- button add ( cái hiển thị của nó là Add New Product--}}
                <div class="ms-auto " data-bs-toggle="modal" data-bs-target="#adddProduct">
                <a class="btn btn-primary radius-30 mt-2 mt-lg-0"><i class="bx bxs-plus-square"></i>Thêm Tài Khoản Mới</a>
                </div>
            </div>
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
                    <tbody>
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
                                    <a href="javascript:;" class=""><i class='bx bxs-edit'></i></a>
                                    <a href="javascript:;" class="ms-3"><i class='bx bxs-trash'></i></a>
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

                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Họ Và Tên</label>
                                <input  type="text" class="form-control" placeholder="Nhập vào họ và tên *">
                            </div>
                            {{-- input avatar --}}
                            <div class = mb-3 >
                                <label for ="avatar" class="form-label">avatar</label>
                                <input type="file" class="form-control" wire:model="avatar" wire:change="uploadFile">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" placeholder="Nhập vào email *">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Số Điện Thoại</label>
                                <input type="tel" class="form-control" placeholder="Nhập vào số điện thoại *">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Ngày Sinh</label>
                                <input  type="date" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Mật Khẩu</label>
                                <input type="password" class="form-control" placeholder="Nhập vào mật khẩu *">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Xác Nhận Mật Khẩu</label>
                                <input  type="password" class="form-control" placeholder="Nhập lại mật khẩu *">
                            </div>

                        </div>

                    </div>
                    <div class="modal-footer">
                        <button  type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button  type="button" class="btn btn-primary">Thêm mới</button>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>


</div>

@endsection
{{--
@section('js')
    <script>
        $(document).ready(function() {
            new Vue({
                el: '#app',
                data: {
                    data: [],
                    add_menu    : { "ten_mon" : "" , "slug_mon" : "" , "id_danh_muc" : 0 , "gia_ban" : "" , "tinh_trang" : 1},
                    del_menu    : {},
                    edit_menu   : {},
                    file        : '',
                    edit_file   : '',
                },

                created() {
                    this.loadData();
                },

                methods: {

                    loadData() {
                        axios
                            .get('/admin/menu/data')
                            .then((res) => {
                                this.data = res.data.data;
                            });
                    },

                    //---------doi-trang-thai------------
                    changeStatus(abcxyz) {
                        console.log(abcxyz);
                        axios
                            .post('/admin/menu/doi-trang-thai', abcxyz)
                            .then((res) => {
                                if (res.data.status) {
                                    toastr.success(res.data.message, "Success");
                                    this.loadData();
                                } else if (res.data.status == 0) {
                                    toastr.error(res.data.message, "error");
                                }
                            });
                    },

                    //-----------nhap----------------
                    addmenu() {

                        $("#add").prop('disabled', true);

                        var formData = new FormData();

                        formData.append('ten_mon',this.add_menu.ten_mon);
                        formData.append('slug_mon',this.add_menu.slug_mon);
                        formData.append('gia_ban',this.add_menu.gia_ban);
                        formData.append('hinh_anh',this.file);
                        formData.append('id_danh_muc',this.add_menu.id_danh_muc);
                        formData.append('tinh_trang',this.add_menu.tinh_trang);


                        axios

                            .post('/admin/menu/nhap', formData, {
                                headers:{
                                    'Content-Type' : 'nultipart/form-data'
                                }
                            })

                            .then((res) => {
                                if (res.data.status == 1) {
                                    toastr.success(res.data.message, "Success");
                                    this.loadData();
                                    this.add_menu = {
                                        "ten_mon": "",
                                        "slug_mon": "",
                                        "id_danh_muc": 0,
                                        "gia_ban": "",
                                        "tinh_trang": 1,
                                    };
                                    $('#add').removeAttr('disabled');
                                } else if (res.data.status == 0) {
                                    toastr.error(res.data.message, "error");
                                } else if (res.data.status == 2) {
                                    toastr.warning(res.data.message, "warning");
                                }
                            })
                            .catch((res) => {
                                $.each(res.response.data.errors , function(k,v){
                                    toastr.error(v[0]);
                                })
                                $('#add').removeAttr('disabled');
                            });
                    },

                    //hình ảnh
                    uploadfile(){
                        this.file = this.$refs.file.files[0];
                        console.log(this.file);
                    },
                    //----------- vnd ------------
                    number_format(number) {
                        return new Intl.NumberFormat('vi-VI', {
                            style: 'currency',
                            currency: 'VND'
                        }).format(number);
                    },

                    //-------------check-slug-------------
                    createSlug() {
                        var slug = this.toSlug(this.add_menu.ten_mon);
                        this.add_menu.slug_mon = slug;
                    },
                    toSlug(str) {
                        str = str.toLowerCase();
                        str = str
                            .normalize('NFD')
                            .replace(/[\u0300-\u036f]/g, '');
                        str = str.replace(/[đĐ]/g, 'd');
                        str = str.replace(/([^0-9a-z-\s])/g, '');
                        str = str.replace(/(\s+)/g, '-');
                        str = str.replace(/-+/g, '-');
                        str = str.replace(/^-+|-+$/g, '');
                        return str;
                    },

                    //--------xóa------
                    accpectDel(){
                        axios
                            .post('/admin/menu/xoa', this.del_menu)
                            .then((res) => {
                                if (res.data.status == 1) {
                                    toastr.success(res.data.message, "Success");
                                    this.loadData();
                                } else if (res.data.status == 0) {
                                    toastr.error(res.data.message, "error");
                                } else if (res.data.status == 2) {
                                    toastr.warning(res.data.message, "warning");
                                }
                            });
                    },








                    //----------edit----------
                    accpectEdit() {
                        // Tạo một formData mới
                        var formData = new FormData();

                        // Đẩy dữ liệu của edit_menu vào formData
                        formData.append('id', this.edit_menu.id);
                        formData.append('ten_mon', this.edit_menu.ten_mon);
                        formData.append('slug_mon', this.edit_menu.slug_mon);
                        formData.append('gia_ban', this.edit_menu.gia_ban);
                        formData.append('hinh_anh', this.edit_file); // Đẩy hình ảnh mới vào formData
                        formData.append('id_danh_muc', this.edit_menu.id_danh_muc);
                        formData.append('tinh_trang', this.edit_menu.tinh_trang);

                        // Gửi yêu cầu cập nhật thông tin món với hình ảnh mới
                        axios.post('/admin/menu/cap-nhap', formData, {
                            headers: {
                                'Content-Type': 'multipart/form-data'
                            }
                        }).then((res) => {
                            if (res.data.status) {
                                toastr.success(res.data.message, "Success");
                                this.loadData();
                                $('#editModal').modal('hide');
                            } else if (res.data.status == 0) {
                                toastr.error(res.data.message, "error");
                            }
                        }).catch((res) => {
                            $.each(res.response.data.errors, function(k, v) {
                                toastr.error(v[0]);
                            });
                        });
                    },
                    uploadEditFile(){
                        this.edit_file = this.$refs.editFile.files[0];
                        // console.log(this.$refs.editFile.files[0]);
                    },














                    // accpectEdit(){
                    //     axios
                    //         .post('/admin/menu/cap-nhap', this.edit_menu)
                    //         .then((res) => {
                    //             if (res.data.status) {
                    //                 toastr.success(res.data.message, "Success");
                    //                 this.loadData();
                    //                 $('#editModal').modal('hide');
                    //             } else if (res.data.status == 0) {
                    //                 toastr.error(res.data.message, "error");
                    //             }
                    //         })
                    //         .catch((res) => {
                    //             $.each(res.response.data.errors , function(k,v){
                    //                 toastr.error(v[0]);
                    //             })
                    //             $('#add').removeAttr('disabled');
                    //         });
                    // },
                    createSlugedit(){
                        var slug = this.toSlug(this.edit_menu.ten_mon);
                        this.edit_menu.slug_mon = slug;
                    },

                    //-------checkSlug-----------
                    checkSlug(){
                        var payload = {
                            'slug_mon': this.add_menu.slug_mon
                        };
                        axios
                            .post('/admin/menu/check-slug', payload)
                            .then((res) => {
                                if (res.data.status == 1) {
                                    toastr.success(res.data.message, "Success");
                                    $("#add").removeAttr("disabled");
                                } else if (res.data.status == 0) {
                                    toastr.error(res.data.message, "Error");
                                    $("#add").prop("disabled", true);
                                } else if (res.data.status == 2) {
                                    toastr.warning(res.data.message, "warning");
                                }
                            });
                    },


                },

            });
        });
    </script>
@endsection --}}
