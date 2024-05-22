import './bootstrap';

Echo.channel('update-chat-room')
    .listen('chatroom.updated', (e) => {
        alert('Có tin nhắn mới');
        console.log('Bước 2: Bắt đầu xử lý sự kiện');
        console.log('Bước 3: Dữ liệu nhận được từ sự kiện', e);

        // Bước 4: Xử lý dữ liệu (ví dụ: hiển thị tin nhắn mới)
        const roomId = e.room_id;
        const message = e.message;

        console.log(`Bước 5: Tin nhắn mới trong phòng ${roomId}: ${message}`);

        // Thêm mã xử lý hiển thị tin nhắn mới vào giao diện ở đây
    });
