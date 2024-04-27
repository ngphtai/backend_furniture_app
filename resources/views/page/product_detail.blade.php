@extends('common.page.Master')
@section('noi_dung')

    <?php
    $product = DB::table('products')->where('id', $info )->first();
    $product = App\Models\Products::with('promotion', 'category','color')->find($info );
    $images = json_decode($product->product_image, true);
    $comments = App\Models\Comments::with('user')->where('product_id', $info)->get();
    use App\Models\Categories;
    use App\Models\Promotions;
    ?>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="page-content">
        <!--breadcrumb-->
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-3 p-0">
                        <li class="breadcrumb-item active" aria-current="page" style="font-size:18px">Chi Tiết Sản Phẩm</li>
                    </ol>
                </nav>
            </div>
        <!--end breadcrumb-->

         <div class="card">
            <div class="row g-0">
            <div class="col-md-4 border-end">
                <div id="mainImageContainer" class =" align-items-center ">
                    <img src="{{ asset('/storage//'. $images[0]) }}" class="img-fluid border fitImage" style="max-width: 100%; height: auto;">
                </div>
                <div class="row mb-3 row-cols-auto g-2 justify-content-center mt-3" >
                    @if(!empty($images))
                        @foreach ($images as $image )
                            <div class="col">
                                <img src="{{ asset('/storage//'. $image) }}" width="70" class="border rounded cursor-pointer" alt="" onclick="changeMainImage('{{ asset('/storage//'. $image) }}')">
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

              <div class="col-md-8">
                <div class="card-body">
                <div class="d-flex align-items-center">
                    <h4 class="card-title col-md-9">
                        <input type="text" class="form-control text-black no_boder no_margin_padding" name="product_name" id ="product_name"style="font-size:25px; font-weight:700; " value="{{$product->product_name}}">
                    </h4>

                </div>
                  <div class="d-flex gap-3  " >
                    <div class="cursor-pointer">
                        @foreach(range(1,5) as $i)
                        <span class="fa-stack" style="width:1em">
                            <i class="far fa-star fa-stack-1x text-warning"></i>
                            @if($product -> rating_count >0)
                                @if($product -> rating_count >0.5)
                                    <i class="fas fa-star fa-stack-1x text-warning"></i>
                                @else
                                    <i class="fas fa-star-half fa-stack-1x text-warning"></i>
                                @endif
                            @endif
                            @php $product -> rating_count--; @endphp
                        </span>
                        @endforeach
                        </div>
                        <div style="margin-top:5px">Số đánh giá </div>
                        <div class="text-success " style="margin-top:5px" ><i class='bx bxs-cart-alt align-middle'></i> Số lượng mua</div>

                        <?php
                            use App\Models\Colors;

                            $color_id = mb_substr($product->product_name, 5, 1);
                            $color = Colors::find($color_id);

                        ?>

                        <div class="text-muted d-flex"><i class='bx bxs-palette align-middle'></i> <div style="background-color: #{{$color->color_name}};width:25px;height:25px;border-radius: 10px;"></div> </div>
                    </div>
                    <div class="mb-3 align-items-center d-flex">
                        <h2 class="price h4 col-md-4">
                            <input type="text" class="form-control text-black no_boder no_margin_padding" name="price" id="price" style="font-size:20px; font-weight:500;" value="{{$product->price}} ">
                        </h2>
                        <span class="text-muted fs-6">VNĐ</span>

                    </div>
                    <p class="card-text fs-6">
                        <textarea class="form-control no_boder no_margin_padding" name="description" id="description" rows="3" style="font-size:16px;">{{$product->description}}</textarea>

                    </p>

                <dl class="row center_table">
                    <dt class="col-sm-3 center_table">Danh mục</dt>
                    <dd class="col-sm-3 text-center center_table no_margin_padding">{{optional($product->category)->name }}</dd>
                    <dd class="col-sm-3 text-center">
                        <?php $categories = Categories::all(); ?>
                        <select class="form-select" style="margin-botton: 10px;margin-top:0px;" id="category_id" aria-placeholder="Chọn danh mục">
                            <option></option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </dd>
                    <dt class="col-sm-3"></dt>

                    <dt class="col-sm-3 center_table">Khuyến mãi</dt>
                    <dd class="col-sm-3 text-center center_table no_margin_padding" >"{{optional($product->promotion)->promotion_name }}"  - {{optional($product->promotion)->discount}} %</dd>
                    <dd class="col-sm-3 text-center">
                        <?php $promotions = Promotions::all(); ?>
                        <select class="form-select" id="promotion_id" >
                            <option></option>
                            @foreach ($promotions as $item )
                                <option value="{{$item->id}}">{{$item->promotion_name}}</option>
                            @endforeach
                        </select>
                    </dd>
                    <dt class="col-sm-3"></dt>

                    <dt class="col-sm-3">Số lượng bán</dt>
                    <dd class="col-sm-3 text-center">{{$product->sold }}</dd>
                    <dt class="col-sm-6"></dt>
                </dl>
                <dl  class="row ">
                    <dt class="col-sm-3 ">Trạng thái</dt>
                    <dd class="col-sm-3 text-center center_table no_margin_padding">
                        <select name="is_show" id="is_show" class="form-select">
                            <option value=1 {{ $product->is_show == 1 ? 'selected' : '' }}>Hiển Thị</option>
                            <option value=0 {{ $product->is_show == 0 ? 'selected' : '' }}>Ẩn</option>
                        </select>
                    </dd>
                    <dd class="col-sm-3 text-center"></dd>

                </dl>
                  <hr>
                  <div class="row row-cols-auto align-items-center" style="200px">
                    <div class="col">
                        <label class="form-label">Số lượng sản phẩm tồn kho</label>
                        <div class="d-flex justify-content-center">
                            <div class="d-flex">
                                <div class="input-group input-spinner text-black gap-3 py-3 justify-content-center  "><a>{{$product->quantity}}</a></div>
                                <div class="input-group input-spinner">
                                    <button class="btn btn-white" type="button" id="button-plus"> + </button>
                                    <input type="text" name="add_quatity" class="form-control"  value="0">
                                    <button class="btn btn-white" type="button" id="button-minus"> − </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex gap-3 mt-3">
                    <a id="btn-update" class="btn btn-primary">Cập nhật sản phẩm</a>
                    <a  class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateImages">Cập nhật hình ảnh</a>
                    <a  class="btn btn-outline-primary"  id ="btn-clean" onclick = "return confirm('Bạn có chắc chắn muốn huỷ thay đổi?')"><span class="text btn-clean">Huỷ thay đổi</span> <i class='bx bxs-trash-alt'></i></a>
                </div>
                </div>
              </div>
            </div>
            <hr/>
            <div class="card-body">
                <ul class="nav nav-tabs nav-primary mb-0" role="tablist">

                    <li class="nav-item" role="presentation">
                        <a class="nav-link" data-bs-toggle="tab" href="#primarycontact" role="tab" aria-selected="false">
                            <div class="d-flex align-items-center">
                                <div class="tab-icon"><i class='bx bx-star font-18 me-1'></i>
                                </div>
                                <div class="tab-title">Đánh giá sản phẩm</div>
                            </div>
                        </a>
                    </li>
                </ul>
                <div class="card radius-10">
                    <div class="card-body">
                        <ul class="list-unstyled">
                            @foreach ($comments as $comment )
                                <li class="d-flex align-items-center border-bottom pb-2">
                                    <img src="{{ asset($comment->user->avatar?? null) }}" class="rounded-circle p-1 border" width="90" height="90" alt="Lỗi hình ảnh">
                                    <div class="flex-grow-1 ms-3">
                                        <h5 class="mt-0 mb-1" style="margin-right:50px">{{ $comment->user->name ?? 'User không tồn tại' }} </h5>
                                            <span class="text-muted fs-6">
                                                @foreach(range(1,5) as $i)
                                                <span class="fa-stack" style="width:1em">
                                                    <i class="far fa-star fa-stack-1x text-warning"></i>
                                                    @if($comment->rating >0)
                                                        @if($comment->rating >0.5)
                                                            <i class="fas fa-star fa-stack-1x text-warning"></i>
                                                        @else
                                                            <i class="fas fa-star-half fa-stack-1x text-warning"></i>
                                                        @endif
                                                    @endif
                                                    @php $comment->rating--; @endphp
                                                </span>
                                                @endforeach
                                            </span>
                                        <br >
                                        {{ $comment->content }}
                                        <br>
                                        <small class = "mb-10">{{ $comment->created_at }}</small></div>
                                </li>
                            @endforeach
                        </ul>
                        </ul>
                    </div>
                </div>
            </div>

          </div>

          <!-- edit image product -->
          <div class="modal fade" id="updateImages" tabindex="-1" aria-labelledby="updateImages"  aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="UpdateImageLabel">Chỉnh sửa hình ảnh</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                        <div class="form-group">
                            <label for="product_image">Danh sách hình ảnh</label>
                            <hr>
                            <div class="row mb-3 row-cols-auto g-2 justify-content-center mt-3" >
                                    <div id="image-review-edit">
                                    </div>

                            </div>
                            <hr>
                            <div class="mb-3">
                                <label for="file" class="form-label">Ảnh sản phẩm</label>
                                <input type="file" name="file[]" id="file" class="form-control " multiple >
                                <button type="button" name="clean_image" class="btn btn-danger mt-3  float-left">Xóa ảnh</button>
                            </div>
                            <div id="image-preview"></div>

                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" name ="addImage" id="addImage"  class="btn btn-primary addImage" data-bs-dismiss="modal" >Thêm ảnh mới</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></label>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>


<script>


    $(document).ready(function() {
        $('#button-plus').click(function() {
            var input = $('input[name="add_quatity"]');
            var value = parseInt(input.val());
            input.val(value + 1);
        });
        $('#button-minus').click(function() {
            var input = $('input[name="add_quatity"]');
            var value = parseInt(input.val());
            if (value < 9999) {
                input.val(value - 1);
            }
        });
    });
    // thay đổi ảnh cho review ảnh hiện có
    function changeMainImage(imageUrl) {
        document.getElementById('mainImageContainer').innerHTML = '<img src="' + imageUrl + '" class="img-fluid border fitImage" style="max-width: 100%; height: auto;">';
    }
</script>



<script>

        $(document).ready(function(){
            // thêm ảnh mới và review ảnh mới
            const fileInput = document.getElementById('file');
            const imagePreview = document.getElementById('image-preview');
            const cleanButton = document.querySelector('button[name="clean_image"]');
             selectedFiles = [];

            function updatePreview() {
            imagePreview.innerHTML = '';

            for (let i = 0; i < selectedFiles.length; i++) {
                const file = selectedFiles[i];
                if (!file.type.startsWith('image/')) continue;

                const reader = new FileReader();
                reader.onload = function() {
                const img = document.createElement('img');
                img.src = reader.result;
                img.style.maxWidth = '200px';
                img.style.borderRadius = '8px'; // Bo góc hình ảnh
                img.style.margin = '10px'; // Khoảng cách giữa các hình ảnh
                imagePreview.appendChild(img);
                }
                reader.readAsDataURL(file);
            }
            }

            fileInput.addEventListener('change', function() {
            const files = this.files;
            for (let i = 0; i < files.length; i++) {
                selectedFiles.push(files[i]);
            }
            updatePreview();
            });

            cleanButton.addEventListener('click', function() {
            selectedFiles.length = 0;
            fileInput.value = '';
            updatePreview();
            });



            // ảnh hiển thị có sẵn trong $images
            var images = {!! json_encode($images) !!};

            function updateImagesPreview(images) {
                $('#image-review-edit').html('');
                for (let i = 0; i < images.length; i++) {
                    const url = images[i];
                    const img = document.createElement('img');
                    img.src = '/storage/' + url;
                    img.style.maxWidth = '150px';
                    img.style.maxHeight = '150px';
                    img.style.borderRadius = '8px';
                    img.style.margin = '10px';

                    const deleteButton = document.createElement('button');
                    deleteButton.textContent = 'Xóa';
                    deleteButton.classList.add('btn', 'btn-danger');
                    deleteButton.addEventListener('click', function() {
                        deleteImage(url);
                    });

                    const container = document.createElement('div');
                    container.style.display = 'inline-block'; // Display images in a horizontal layout
                    container.appendChild(img);
                    container.appendChild(deleteButton);
                    document.getElementById('image-review-edit').appendChild(container);
                }
            }

            $('#updateImages').on('shown.bs.modal', function () {
                    updateImagesPreview(images);
            });

            function deleteImage(imageUrl) {
                    // Xóa ảnh từ mảng images
                    images = images.filter(function(img) {
                        return img !== imageUrl;
                    });
                    alert("Xóa ảnh thành công" + images);
                    // Cập nhật giao diện
                    updateImagesPreview(images);
                }

            $('#addImage').click(function(){
                alert("Chọn ảnh thành công" );
                $("#updateImages").modal("hide");
            });



            var product = {!! json_encode($product) !!};

            document.getElementById('btn-clean').addEventListener('click', function() {
                    document.getElementById('category_id').value = '';
                    document.getElementById('promotion_id').value = '';
            });
            $('#btn-clean').click(function(){
                $('#product_name').val(product.product_name);
                $('#price').val(product.price);
                $('#description').val(product.description);
                $('#is_show').val(product.is_show);
                var input = $('input[name="add_quatity"]');
                input.val(0);
                selectedFiles.length = 0;
                fileInput.value = '';
                updatePreview();
                images = {!! json_encode($images) !!};
                updateImages();
            });
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#btn-update').click(function(){

                var product_name = $('#product_name').val();
                var price = $('#price').val();
                var description = $('#description').val();
                var category_id = $('#category_id').val();
                var promotion_id = $('#promotion_id').val();
                var is_show_val = $('#is_show').val();
                var add_quatity = $('input[name="add_quatity"]').val();
                var file = $('#file').prop('files');
                var formData = new FormData();
                formData.append('product_name', product_name);
                formData.append('category_id', category_id);
                formData.append('promotion_id', promotion_id);
                formData.append('add_quatity', add_quatity);
                formData.append('images',images); // images hiện tại là kiểu mảng nhưng mà gửi qua ajax thì nó sẽ thành dạng string nên bên controller phải dùng explode để chuyển về mảng mới thêm vào được

                for (let i = 0; i < file.length; i++) {
                    formData.append('file[]', file[i]);
                }
                formData.append('description', description);
                formData.append('price', price);

                formData.append('is_show', is_show_val);
                $.ajax({
                    url: '/products/update/' + product.id,
                    type: 'post',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        alert('Cập nhật sản phẩm thành công');
                        window.location.reload();
                    },
                    error: function(response) {
                        alert(response.responseJSON.message);
                    }
                });
            })

        });


</script>




