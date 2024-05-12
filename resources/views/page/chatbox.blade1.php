@extends('common.page.Master')
@section('noi_dung')
<div class="page-content">
<div class="chat-wrapper" style="height: 600px;">
					<div class="chat-sidebar">
						<div class="chat-sidebar-content">
							<div class="tab-content" id="pills-tabContent">
								<div class="tab-pane fade show active" id="pills-Chats">
								<div class="chat-sidebar-header">
							<div class="input-group input-group-sm"> <span class="input-group-text bg-transparent"><i class='bx bx-search'></i></span>
								<input type="text" class="form-control" placeholder="Tìm kiếm khách hàng">
							</div>
                        </div>
								<div class="p-3 mt-2"> <a class="text-uppercase text-secondary dropdown-toggle dropdown-toggle-nocaret" >  Danh sách tin nhắn </a>
										</div>
									<div class="chat-list list-group list-group-flush" style="height: 500px;">
                                        <div class="loading d-flex justify-content-center mt-5">
                                            <div class="spinner-border text-primary" role="status">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                        </div>
									</div>
								</div>
							</div>
						</div>
					</div>
                    <div class="chat-header d-flex align-items-center">
                       {{--  title --}}
                        <div class="chat-toggle-btn"><i class='bx bx-menu-alt-left'></i></div>
                        <div>
                            <h4 class="mb-1 font-weight-bold">Chị Đông</h4>
                        </div>
                        {{-- detail  --}}
                        <div class="chat-top-header-menu ms-auto">
                            <li class="nav-item dropdown dropdown-large">
                                <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class='fadeIn animated bx bx-user'></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <div class="row row-cols-1 g-3 p-3">
                                        <div class="col text-center">
                                            <div class="card-body text-center">
                                                <div class="border radius-15">
                                                    <img src="/assets/images/avatars/avatar-1.png" width="110" height="110" class="rounded-circle shadow" alt="">
                                                    <h5 class="mb-1 mt-2">Phạm Thị Duy Đông</h5>
                                                    <p class="mb-0">Chiongnaunaunaunau@gmail.com</p>
                                                    <!-- <p class="mb-3">gmail khách hàng: ngphtai.it+1@gmail.com</p> -->
                                                    <hr class="my-3" />
                                                    <ul class="list-group list-group-flush">
                                                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                                            <h6 class="mb-0">Email</h6>
                                                            <span class="text-secondary">example@gmail.com</span>
                                                        </li>
                                                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                                            <h6 class="mb-0">Số điện thoại:</h6>
                                                            <span class="text-secondary">000xxxxxxx</span>
                                                        </li>
                                                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                                            <h6 class="mb-0">Địa chỉ:</h6>
                                                            <span class="text-secondary">example example example example example example example example example example example example </span>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </div>
                    </div>
					<div class="chat-content" style="height: 500px;">
						<div class="chat-content-leftside">
							<div class="d-flex">
								<img src="/assets/images/avatars/avatar-3.png" width="48" height="48" class="rounded-circle" alt="" />
								<div class="flex-grow-1 ms-2">
									<p class="mb-0 chat-time">2:35 PM</p>
									<p class="chat-left-msg">xin chao</p>
								</div>
							</div>
						</div>
						<div class="chat-content-rightside">
							<div class="d-flex ms-auto">
								<div class="flex-grow-1 me-2">
									<p class="mb-0 chat-time text-end">2:37 PM</p>
									<p class="chat-right-msg">chào</p>
								</div>
							</div>
						</div>
						<div class="chat-content-leftside">
							<div class="d-flex">
								<img src="/assets/images/avatars/avatar-3.png" width="48" height="48" class="rounded-circle" alt="" />
								<div class="flex-grow-1 ms-2">
									<p class="mb-0 chat-time">2:48 PM</p>
									<p class="chat-left-msg">uk chào</p>
								</div>
							</div>
						</div>
						<div class="chat-content-rightside">
							<div class="d-flex">
								<div class="flex-grow-1 me-2">
									<p class="mb-0 chat-time text-end">2:49 PM</p>
									<p class="chat-right-msg">ừ chào</p>
								</div>
							</div>
						</div>
						<div class="chat-content-leftside">
							<div class="d-flex">
								<img src="/assets/images/avatars/avatar-3.png" width="48" height="48" class="rounded-circle" alt="" />
								<div class="flex-grow-1 ms-2">
									<p class="mb-0 chat-time">3:12 PM</p>
									<p class="chat-left-msg">nha` bán yến j z e</p>
								</div>
							</div>
						</div>
						<div class="chat-content-rightside">
							<div class="d-flex">
								<div class="flex-grow-1 me-2">
									<p class="mb-0 chat-time text-end">3:14 PM</p>
									<p class="chat-right-msg">yến chưng nóng ạ! chị có thể xem menu ở đây ạ</p>
								</div>
							</div>
						</div>
						<div class="chat-content-leftside">
							<div class="d-flex">
								<img src="/assets/images/avatars/avatar-3.png" width="48" height="48" class="rounded-circle" alt="" />
								<div class="flex-grow-1 ms-2">
									<p class="mb-0 chat-time">3:16 PM</p>
									<p class="chat-left-msg">ừ cho chị 5 hủ yến 200lm</p>
									<p class="chat-left-msg">2 hủ yến đường phèn</p>
									<p class="chat-left-msg">3 hủ yến chưng táo đỏ thêm 2 long nhân với đông trùng hạ thảo nha e</p>
								</div>
							</div>
						</div>
                    </div>
					<div class="chat-footer d-flex align-items-center">
						<div class="flex-grow-1 pe-2">
							<div class="input-group">
								<input type="text" class="form-control" placeholder="Type a message">
							</div>
						</div>
						<div class="chat-footer-menu"> <a href="javascript:;"><i class='fadeIn animated bx bx-paper-plane'></i></a>
						</div>
					</div>
					<!--start chat overlay-->
					<div class="overlay chat-toggle-btn-mobile"></div>
					<!--end chat overlay-->
				</div>
			</div>
			<script src="/assets/js/bootstrap.bundle.min.js"></script>
	<!--plugins-->
	<script src="/assets/js/jquery.min.js"></script>
	<script src="/assets/plugins/simplebar/js/simplebar.min.js"></script>
	<script src="/assets/plugins/metismenu/js/metisMenu.min.js"></script>
	<script src="/assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
	<script>
		new PerfectScrollbar('.chat-list');
		new PerfectScrollbar('.chat-content');
	</script>
	<!--app JS-->
	<script src="/assets/js/app.js"></script>

	<script src="/assets/js/bootstrap.bundle.min.js"></script>
	<!--plugins-->
	<script src="/assets/js/jquery.min.js"></script>
	<script src="/assets/plugins/simplebar/js/simplebar.min.js"></script>
	<script src="/assets/plugins/input-tags/js/tagsinput.js"></script>
	<script src="/assets/plugins/metismenu/js/metisMenu.min.js"></script>
	<script src="/assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
	<!--app JS-->
	<script>
  function toggleCheckbox(checkboxIndex) {
    var checkboxIcon = document.querySelectorAll('.checkbox-icon')[checkboxIndex - 1];

    if (checkboxIcon.classList.contains('bx-plus')) {
      checkboxIcon.classList.remove('bx-plus');
      checkboxIcon.classList.add('bx-pin');
    } else {
      checkboxIcon.classList.remove('bx-pin');
      checkboxIcon.classList.add('bx-plus');
    }
  }
</script>
<script>
    function toggleSearch() {
      var searchContainer = document.querySelector('.search-container');

      if (searchContainer.style.display === 'none') {
        searchContainer.style.display = 'block';
      } else {
        searchContainer.style.display = 'none';
      }
    }
	function showName(name, icon) {
    var nameElement = icon.nextElementSibling;
    nameElement.innerText = name;
    nameElement.style.display = 'inline';
  }

  function hideName(icon) {
    var nameElement = icon.nextElementSibling;
    nameElement.style.display = 'none';
  }
  function GetMessenger(uid){
          $.ajax({
            url: "{{route('chatroom.store')}}",
            type: 'GET',
            data: {
              uid: uid
            },
            success: function(data){
              //chat header
              var html =`
              <div class="chat-header d-flex align-items-center">
                             {{--  title --}}
                              <div class="chat-toggle-btn"><i class='bx bx-menu-alt-left'></i></div>
                              <div>
                                  <h4 class="mb-1 font-weight-bold">${data.last_messenger.user.name}</h4>
                              </div>
                              {{-- detail  --}}
                              <div class="chat-top-header-menu ms-auto">
                                <li class="nav-item dropdown dropdown-large">
                                    <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class='fadeIn animated bx bx-user'></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <div class="row row-cols-1 g-3 p-3">
                                            <div class="col text-center">
                                                <div class="card-body text-center">
                                                    <div class="border radius-15">
                                                        <img src="/assets/images/avatars/avatar-1.png" width="110" height="110" class="rounded-circle shadow" alt="">
                                                        <h5 class="mb-1 mt-2">${data.last_messenger.user.name}</h5>
                                                        <hr class="my-3" />
                                                        <ul class="list-group list-group-flush">
                                                            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                                                <h6 class="mb-0">Email</h6>
                                                                <span class="text-secondary">${data.last_messenger.user.email}</span>
                                                            </li>
                                                            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                                                <h6 class="mb-0">Số điện thoại:</h6>
                                                                <span class="text-secondary">${data.last_messenger.user.name}</span>
                                                            </li>
                                                            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                                                <h6 class="mb-0">Địa chỉ:</h6>
                                                                <span class="text-secondary">${data.last_messenger.user.address}</span>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </div>
                          </div>
              `;

            },
            error: function(err){
              console.log(err);
            }
          });
        }
  </script>
<script>
    $(document).ready(function(){
        function getChatList() {
            $.ajax({
                url: "{{route('chatroom.index')}}",
                type: 'GET',
                success: function(data){
                    $('.chat-list').empty(); // Clear the existing chat list
                    data.forEach(item => {
                        var messageHTML = `
                            <a onclick="GetMessenger(${item.uid})" class="list-group-item">
                                <div class="d-flex">
                                    <div class="chat-user-online">
                                        <img src="/${item.last_messenger.user.avatar}" width="42" height="42" class="rounded-circle" alt="" />
                                    </div>
                                    <div class="flex-grow-1 ms-2">
                                        <h6 class="mb-0 chat-title">${item.last_messenger.user.name}</h6>
                                        <p class="mb-0 chat-msg">${item.last_messenger.message}</p>
                                    </div>
                                    <div style="position: relative; display: inline-block;">
                                        <i class="fadeIn animated bx bx-plus font-30 checkbox-icon" onclick="toggleCheckbox(1)" onmouseover="showName('YếnNhi', this)" onmouseout="hideName(this)"></i>
                                        <span class="icon-name pin-icon" style="">van A</span>
                                    </div>
                                </div>
                            </a>
                        `;
                        $('.chat-list').append(messageHTML);
                    });
                },
                error: function(err){
                    console.log(err);
                }
            });
        }

        // Call getChatList function every 5 seconds
        setInterval(getChatList, 5000);
    });
</script>

@endSection
