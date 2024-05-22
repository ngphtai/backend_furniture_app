@extends('common.page.Master')
@section('noi_dung')

    <div class="page-content">
        <!--breadcrumb-->
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-3 p-0">
                    <li class="breadcrumb-item active" aria-current="page" style="font-size:18px">Thêm sản phẩm mới</li>
                </ol>
            </nav>
        </div>
        <!--end breadcrumb-->

        <div class="card">
            <div class="card-body p-4">
                <h5 class="card-title">Thêm sản phẩm mới</h5>
                <hr/>
            </div>
                @if(@session('success'))
                    <div class="alert alert-success">
                        {{ session()->get('success') }}
                    </div>
                @elseif($errors->any())
                        <div   div class=" alert alert-danger" role="alert">
                        @foreach ($errors->all() as $error)
                        <li class='list-group-item text-danger'>{{$error}}</li>
                        @endforeach
                    </div>
                @endif
                @php
                    use App\Models\Categories;
                    use App\Models\Promotions;
                @endphp

                <form action="{{ route('product.store') }}"  method="post" enctype="multipart/form-data">@csrf
                    <div class="form-body mt-4">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="border border-3 p-4 rounded">
                                <div class="mb-3">
                                <label for="product_name" class="form-label">Tên sản phẩm</label>
                                <input type="text" name ="product_name" class="form-control" id="product_name" placeholder="Nhập tên sản phẩm (gồm Mã sản phẩm (#AB123) và tên sản phẩm)">
                                </div>
                                <div class="mb-3">
                                <label for="description" class="form-label">Mô tả sản phẩm</label>
                                <textarea class="form-control" name ="description" id="description" rows="3" placeholder="Chi tiết sản phẩm" maxlength="700"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="file" class="form-label">Ảnh sản phẩm</label>
                                    <input type="file" name="file[]" id="file" class="form-control " multiple >
                                    <button type="button" name="clean_image" class="btn btn-danger mt-3  float-left">Xóa ảnh</button>
                                </div>
                                <div id="image-preview"></div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="border border-3 p-4 rounded">
                            <div class="row g-3">
                            <div class="col-md-12">
                                <label for="price" class="form-label">Giá sản phẩm<main></main></label>
                                <input type="number" name ="price" class="form-control" id="price" placeholder="00.00">
                                </div>
                                <div class="col-md-12">
                                <label for="quantity" class="form-label">Số lượng sản phẩm</label>
                                <input type="number" name ="quantity" class="form-control" id="quantity">
                                </div>
                                <div class="col-12">
                                <label for="category_id" class="form-label">Danh mục</label>
                                <?php $categories = Categories::all(); ?>
                                <select  class="form-select" name="category_id" id="category_id" aria-placeholder="Chọn danh mục">
                                    <option></option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                </div>
                                <?php $promotions = Promotions::all(); ?>
                                <div class="col-12">
                                <label for="promotion_id" class="form-label">Chương trình khuyến mãi </label>
                                <select class="form-select" id="promotion_id" name = "promotion_id">
                                    <option></option>
                                        @foreach ($promotions as $item )
                                            <option value ={{$item -> id}}> {{$item -> promotion_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12">
                                <label for="is_show" class="form-label">Trạng thái sản phẩm</label>
                                    <select class="form-select" id="is_show" name = "is_show">
                                        <option value="1">Hiển thị</option>
                                        <option value="0">Ẩn</option>
                                    </select>
                                </div>


                            <div class="col-12">
                                <div class="d-grid">
                                   <button type="submit" name="add-product-btn" id ="add-product-btn" class="btn btn-primary">Thêm sản phẩm</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                 </div><!--end row-->
              </div>
            </div>
        </div>
    </div>


<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



    <script>
        const fileInput = document.getElementById('file');
        const imagePreview = document.getElementById('image-preview');
        const cleanButton = document.querySelector('button[name="clean_image"]');
        const selectedFiles = [];

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
      </script>


@endsection
