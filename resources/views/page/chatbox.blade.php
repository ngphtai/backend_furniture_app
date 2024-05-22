@extends('common.page.Master')
@section('noi_dung')
<div class="page-content">
<div class="chat-wrapper" style="height: 600px;">
    @php
        $user = auth()->guard('ANNTStore')->user();
        $adminID = $user->uid;
    @endphp

					<div class="chat-sidebar">
						<div class="chat-sidebar-content">
							<div class="tab-content" id="pills-tabContent">
								<div class="tab-pane fade show active" id="pills-Chats">
								<div class="chat-sidebar-header">
							<div class="input-group input-group-sm"> <span class="input-group-text bg-transparent"><i class='bx bx-search'></i></span>
								<input type="text" class="form-control" placeholder="Tìm kiếm khách hàng">
							</div>
                        </div>
								<div class="p-3 mt-2"> <a class=" text-uppercase text-secondary dropdown-toggle dropdown-toggle-nocaret" >  Danh sách tin nhắn </a>
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
                            <h4 class="mb-1 font-weight-bold"> </h4>
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
                                                    <h5 class="mb-1 mt-2">Họ và tên</h5>
                                                    {{-- <p class="mb-0">Chiongnaunaunaunau@gmail.com</p> --}}
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
					<div class="chat-content" id="chat-content" style="height: 500px;">
                        {{-- content chat --}}
                    </div>
					<div class="chat-footer d-flex align-items-center">
						<div class="flex-grow-1 pe-2">
							<div class="input-group">
								<input type="text" id ="message" class="form-control" placeholder="Nhập tin nhắn" >
							</div>
						</div>
						<div class="chat-footer-menu"> <a onclick="sendByAdmin()"><i class='fadeIn animated bx bx-paper-plane'></i></a>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
	<script>
		new PerfectScrollbar('.chat-list');
		new PerfectScrollbar('.chat-content');
	</script>

	<!--app JS-->
	<script src="/assets/js/app.js"></script>

<script>

  function showName(name, icon) {
    var nameElement = icon.nextElementSibling;
    nameElement.innerText = name;
    nameElement.style.display = 'inline';
  }

  function hideName(icon) {
    var nameElement = icon.nextElementSibling;
    nameElement.style.display = 'none';
  }
</script>

<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/moment/min/moment.min.js"></script>
<script>
        var room_id = null;

        var pusher = new Pusher('{{env('PUSHER_APP_KEY')}}', {
            cluster: 'ap1',
            forceTLS: true,
        });

        $(document).ready(function() {
            // hiển thị list room chat từ đầu
            getChatList();
        });

         //lắng nghe sự kiện chatroom.updated cập nhật lại danh sách chat
         let channel = pusher.subscribe('update-chat-room');
        channel.bind('chatroom.updated', function(data) {
            // console.log('Thành cônggggggggggggg');
            getChatList();
        });
            // load messenger in 1 room with room id
        function loadMessenger(room_id) {
            let Messages = pusher.subscribe('chat-room.1' + room_id);
            Messages.bind('message.sent', function(data) {
                console.log('Có tin nhắn mới !!! '  );
                showMessages(room_id);
            });
        }

        // get all room chat
        function getChatList() {
            $.ajax({
                url: "{{route('chatroom.index')}}",
                type: 'GET',
                success: function(data){
                    $('.chat-list').empty(); // Clear the existing chat list
                    data.forEach(item => {
                        var messageHTML = `
                            <a onclick="GetHeader('${item.uid}')" class="list-group-item">
                                <div class="d-flex">
                                    <div class="chat-user-online">
                                        <img src="/${item.last_messenger.user.avatar}" width="42" height="42" class="rounded-circle" alt="" />
                                    </div>
                                    <div class="flex-grow-1 ms-2">
                                        <h6 class="mb-0 chat-title">${item.last_messenger.user.name}</h6>
                                        ${item.is_read == 0 ? `<p class="mb-0 chat-msg text-black font-weight-bold">${item.last_messenger.message}</p>`:`<p class="mb-0 chat-msg">${item.last_messenger.message}</p>`}
                                    </div>
                                    <div style="position: relative; display: inline-block;">
                                        <i class="fadeIn animated bx ${item.pin ? 'bx-pin':'bx-plus'} font-30 checkbox-icon" onclick="toggleCheckbox('${item.uid}')" onmouseover="showName('${item.pin !=null ? item.pin.name : " " }', this)" onmouseout="hideName(this)"></i>
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
         //get header chat and messenger
        function GetHeader(uid){
            // alert(uid);
            room_id = uid;
            $.ajax({
                url: "{{route('readed')}}",
                type: 'GET',
                data: {
                uid: uid
                },
                success: function(data){
                    console.log('Đã đọc tin nhắn');
                }
            })
            // console.log('room_id: ' + room_id);
            $.ajax({
                url: "{{route('chatroom.store')}}",
                type: 'GET',
                data: {
                uid: uid
                },
            success: function(data){
              //chat header
              $('.chat-header').empty();
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
                                                        <img src="/${data.last_messenger.user.avatar}" width="110" height="110" class="rounded-circle shadow" alt="">
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
                $('.chat-header').append(html);
                //chat content
                showMessages(room_id);
                $('#chat-content').scrollTop($('#chat-content')[0].scrollHeight);
            },
            error: function(err){
              console.log(err);
            }
          });
        }
        function showMessages(room_id){
            // console.log('Lấy all tin nhắn trông ' + room_id + ' thành công');
            var messageHTML = ``;
            $.ajax({
                url: "{{route('showMessengerOnChatRoom')}}",
                type: 'GET',
                data: {
                    room_id: room_id,
                    page: 1
                },
                success: function(data){
                    $('.chat-content').empty();
                    data.reverse().forEach(item => {
                        console.log(item.user.avatar);
                        if(item.uidsender != null){
                            messageHTML +=`
                                <div class="chat-content-leftside">
                                    <div class="d-flex">
                                        <img src="/${item.user.avatar}" width="48" height="48" class="rounded-circle" alt="" />
                                        <div class="flex-grow-1 ms-2">
                                            <p class="mb-0 chat-time">${ moment(item.created_at).format('DD/MM- HH:mm') }</p>
                                            <p class="chat-left-msg">${item.message}</p>
                                        </div>
                                    </div>
                                </div>
                            `;
                        }else {
                            messageHTML +=`
                                <div class="chat-content-rightside">
                                    <div class="d-flex">
                                        <div class="flex-grow-1 me-2">
                                            <p class="mb-0 chat-time text-end">${ moment(item.created_at).format('DD/MM- HH:mm') }</p>
                                            <p class="chat-right-msg">${item.message}</p>
                                        </div>
                                    </div>
                                </div>
                            `;
                        }
                    });

                    $('.chat-content').append(messageHTML);
                    scrollToBottom();
                    getChatList();
                    loadMessenger(room_id);
                },
                error: function(err){
                    console.log(err);
                }
            });
        }


        function scrollToBottom() {
            $('#chat-content').scrollTop($('#chat-content')[0].scrollHeight);
        }

        function sendByAdmin() {
            var message = $('#message').val();

            if(message == ''){
                alert('Vui lòng nhập tin nhắn');
                return;
            }
            $.ajax({
                url: "{{route('sendMessengerByAdmin')}}",
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    room_id: room_id,
                    message: message,
                    _token: "{{ csrf_token() }}"
                },
                success: function(data){
                    $('#message').val('');
                    showMessages(room_id);
                    scrollToBottom();
                },
                error: function(err){
                    console.log(err.message);
                }
            });
        }

        //set pin
        function toggleCheckbox(roomid) {
            var uidAdmin = @json($adminID);
            var roomid = roomid;
            console.log(roomid+'-'+uidAdmin);
            $.ajax({
                url: "{{route('chatroom.setPin')}}",
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    uid: roomid,
                    pin: uidAdmin,
                    _token: "{{ csrf_token() }}"
                },
                success: function(data){
                    getChatList();
                },
                error: function(err){
                    console.log(err.message);
                }
            });
        }
</script>



@endSection




