<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <link rel="stylesheet" href="/assets/css/login.css" />
    <link rel="stylesheet" href="/assets/css/icons.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toast-css/1.1.0/grid.min.css" integrity="sha512-YOGZZn5CgXgAQSCsxTRmV67MmYIxppGYDz3hJWDZW4A/sSOweWFcynv324Y2lJvY5H5PL2xQJu4/e3YoRsnPeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <section>
    <div class ="box">
        <div class ='container'>
            <div class = "top-header" >
                  <div class = "header1">
                        <h1 style="color:#fff">ANNT Store</h1>
                  </div>
                <span>Đăng nhập</span>
            </div>
            <form action="/admin/login" method="POST">
                @csrf
                <div class ="input-field" for ="email">
                    <input type ="email" name ="email" id ="email" class = "input" placeholder="Email" required>
                </div>
                <div class ="input-field" for ="password">
                    <input type ="password" name ="password" id ="password"class = "input" placeholder="Mật khẩu" required>
                </div>
                <div class = "input-field">
                    <input type ="submit" class ="submit" value="Đăng nhập">
                </div>
                <div class ="bottom">
                    <div class ="left">
                        <input type ="checkbox" id ="remember">
                        <label for ="remember">Ghi nhớ tài khoản</label>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
</body>
</html>


