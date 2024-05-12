@extends('common.page.Master')
@section('noi_dung')
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Danh sách phòng chat</div>
                <div class="card-body">
                    <ul class="list-group" id="roomList">
                        {{-- Danh sách phòng chat sẽ được tải từ JavaScript --}}
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Tin nhắn trong phòng <span id="roomPin"></span></div>
                <div class="card-body">
                    <ul class="list-group" id="messageList">
                        {{-- Danh sách tin nhắn sẽ được tải từ JavaScript --}}
                    </ul>
                </div>
                <div class="card-footer">
                    <div class="input-group">
                        <input type="text" class="form-control" id="newMessage" placeholder="Nhập tin nhắn...">
                        <div class="input-group-append">
                            <button class="btn btn-primary" id="sendMessage">Gửi</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Kết nối với Laravel Echo Server
    window.Echo = new Echo({
        broadcaster: 'socket.io',
        host: window.location.hostname + ':6001'
    });

    // Lấy danh sách phòng chat
    axios.get('/chatroom')
        .then(response => {
            const rooms = response.data;
            const roomList = document.getElementById('roomList');

            rooms.forEach(room => {
                const li = document.createElement('li');
                li.classList.add('list-group-item');
                li.textContent = `${room.pin} - Người tạo: ${room.uid}`;
                li.addEventListener('click', () => {
                    selectRoom(room);
                });
                roomList.appendChild(li);
            });
        })
        .catch(error => {
            console.error(error);
        });

    // Chọn phòng chat
    let selectedRoom = null;
    function selectRoom(room) {
        selectedRoom = room;
        document.getElementById('roomPin').textContent = room.pin;
        fetchMessages();
    }

    // Lấy danh sách tin nhắn
    function fetchMessages() {
        if (!selectedRoom) return;

        const messageList = document.getElementById('messageList');
        messageList.innerHTML = '';

        axios.get(`/api/rooms/${selectedRoom.id}/messages`)
            .then(response => {
                const messages = response.data;

                messages.forEach(message => {
                    const li = document.createElement('li');
                    li.classList.add('list-group-item');

                    if (message.type === 'text') {
                        li.textContent = message.message;
                    } else {
                        li.textContent = `Tin nhắn loại ${message.type}`;
                    }

                    messageList.appendChild(li);
                });
            })
            .catch(error => {
                console.error(error);
            });
    }

    // Gửi tin nhắn mới
    const newMessageInput = document.getElementById('newMessage');
    const sendMessageButton = document.getElementById('sendMessage');

    sendMessageButton.addEventListener('click', () => {
        if (!selectedRoom) return;

        const newMessage = newMessageInput.value.trim();
        if (newMessage) {
            axios.post(`/api/rooms/${selectedRoom.id}/messages`, { message: newMessage })
                .then(response => {
                    newMessageInput.value = '';
                    fetchMessages();
                })
                .catch(error => {
                    console.error(error);
                });
        }
    });

    // Lắng nghe sự kiện tin nhắn mới từ public channel
    Echo.channel('public-chat')
        .listen('NewMessageEvent', (e) => {
            fetchMessages();
        });
</script>


