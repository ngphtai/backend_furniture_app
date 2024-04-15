@extends('common.page.Master')
@section('noi_dung')
<?php $user = auth()->guard("ANNTStore")->user() ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<div class="container">
    <div class="main-body">
        <div class="row ">
            <div class="col-lg" style="width:100%">
                <div class="card align-items-center" style ="width:80%">
                    <div class="card-body">
                        <form id="form" action='{{ route('user.update')}}' method="POST" enctype="multipart/form-data" >
                            @csrf
                            <input type="hidden" name="uid" id ="uid" value="{{$user->uid}}">
                            <div class="row mb-3">
                                <div class="d-flex flex-column align-items-center text-center">
                                    <img src ='{{asset("$user->avatar" )}}' alt="Avatar" class="rounded-circle p-1 bg-primary" width="180" style="margin-bottom:10px">
                                    {{-- update avatar --}}
                                    <input type="file" name="file" id = "file"  class="form-control p-1 flex-column align-items-center text-center" style="width:60%"/>
                                    <div class="mt-3">
                                        <h6 style="font-size: 30px">{{$user-> name}}</h6>
                                        <p class="text-secondary mb-1">{{$user->user_type}}</p>
                                    </div>
                                </div>
                                <div style="height: 30px"></div>
                                <hr style="width:80%, align:min-content" >
                                <div style="height: 30px"></div>
                                <div class="col-sm-3">
                                    <h6 class="mb-0" for = "name">Full Name</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="text" class="form-control" value="{{$user ->name}}" name ="name" id="name" />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0" for = "email">Email</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="text" class="form-control" value="{{$user ->email}}" name ="email" id = "email" />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <h6 class="mb-0" for =" phone_number">Phone</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="text" class="form-control" value="{{$user ->phone_number}}" name ="phone_number" id = "phone_number"  />
                                </div>
                            </div>
                            <div class="row">
                                <div class="d-flex flex-column align-items-center text-center">
                                    <input type="submit" class="btn btn-primary px-4" value="Save Changes" />
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    // $(document).ready(function(){
    //     $("#image").change(function(){
    //         alert('change');
    //         var file = $(this)[0].files[0];
    //         $.ajax({
    //             url: "",
    //             type: "POST",
    //             data: {
    //                 file: file,
    //                 uid: $('#uid').val()
    //             }
    //             success: function(data){
    //                 reload();
    //                 toastr.success("Update success");
    //                 $('#avatar').attr('src', data.avatar);
    //             }
    //         });
    //     });
    // });
</script>

@endsection

{{-- <script>  không sử dụng vì không thể dùng toastr trong blade
    $(document).ready(function(){
        $("#form").submit(function(e){
            e.preventDefault();
            alert('submit');
            var formData = new FormData(this);
            $.ajax({
                url: '{{ route('user.update')}}',
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(data){
                    // load lại trang
                    location.reload();
                    //SỬ DỤNG TOASTR
                    toastr.success("Update success");
                }
                console.error(function(data){
                    toastr.error("Update fail");
                });
            });
        });

    });


</script> --}}
