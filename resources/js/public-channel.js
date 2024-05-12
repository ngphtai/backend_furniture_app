import Echo from 'laravel-echo';

window.Echo = new Echo({
  broadcaster: 'pusher',
  key: '4c55c513a0c2bd70d338',
  cluster: 'ap1',
  forceTLS: true
});

var channel = Echo.channel('my-channel');
channel.listen('.my-event', function(data) {
  alert(JSON.stringify(data));
});
