// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     encrypted: true
// });

// window.Echo.channel('acara')
// .listen('AcaraCreated', (e) => {
//     toastr.success('Pemberitahuan baru: ' + e.acara.judul);
// });

// $(document).ready(function() {
//     var pusher = new Pusher('{{ config('broadcasting.connections.pusher.key') }}', {
//         cluster: '{{ config('broadcasting.connections.pusher.options.cluster') }}',
//         encrypted: true
//     });

//     var notificationsWrapper = $('.dropdown-notifications');
//     var notificationsToggle = notificationsWrapper.find('a[data-toggle]');
//     var notificationsCountElem = notificationsToggle.find('i[data-count]');
//     var notificationsCount = parseInt(notificationsCountElem.data('count'));
//     var notifications = notificationsWrapper.find('ul.dropdown-menu');

//     if (notificationsCount <= 0) {
//         notificationsWrapper.hide();
//     }

//     var channel = pusher.subscribe('acara');

//     channel.bind('AcaraCreated', function(data) {
//         var existingNotifications = notifications.html();
//         var newNotificationHtml = `
//             <li class="notification active">
//                 <div class="media">
//                     <div class="media-left">
//                         <div class="media-object">
//                             <img src="https://api.adorable.io/avatars/71/${data.avatar}.png" class="img-circle" alt="Avatar">
//                         </div>
//                     </div>
//                     <div class="media-body">
//                         <strong class="notification-title">${data.acara.judul}</strong>
//                         <div class="notification-meta">
//                             <small class="timestamp">Just now</small>
//                         </div>
//                     </div>
//                 </div>
//             </li>
//         `;
//         notifications.html(newNotificationHtml + existingNotifications);

//         notificationsCount++;
//         notificationsCountElem.attr('data-count', notificationsCount);
//         notificationsWrapper.find('.notif-count').text(notificationsCount);
//         notificationsWrapper.show();
//     });
// });

// document.addEventListener('DOMContentLoaded', function () {
//     var notifikasiIcon = document.querySelector('.dot');
//     var modal = document.getElementById('notificationModal');
//     var span = document.getElementsByClassName('close')[0];

//     var notificationsCountElem = notifikasiIcon;
//     var notificationsCount = parseInt(notificationsCountElem.getAttribute('data-count'));

//     notifikasiIcon.onclick = function () {
//         modal.style.display = 'block';
//         notifikasiIcon.classList.remove('active');
//     }
//     span.onclick = function () {
//         modal.style.display = 'none';
//     }
//     window.onclick = function (event) {
//         if (event.target == modal) {
//             modal.style.display = 'none';
//         }
//     }
//     var pusher = new Pusher('{{ config('broadcasting.connections.pusher.key') }}', {
//         cluster: '{{ config('broadcasting.connections.pusher.options.cluster') }}',
//         encrypted: true
//     });

//     var channel = pusher.subscribe('acara');
//     channel.bind('App\\Events\\AcaraCreated', function(data) {
//         console.log('New Event Created:', data);

//         var notificationList = document.getElementById('notificationList');
//         var newNotification = document.createElement('li');
//         newNotification.textContent = 'Acara baru telah dimuat: ' + data.acara.judul;
//         notificationList.appendChild(newNotification);

//         notificationsCount += 1;
//         notificationsCountElem.setAttribute('data-count', notificationsCount);
//         notifikasiIcon.classList.add('active');
//     });

//     pusher.connection.bind('state_change', function(states) {
//         console.log('Pusher connection state changed:', states);
//     });
// });
import Echo from 'laravel-echo';
window.Pusher = require('pusher-js');

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    forceTLS: true
});

// var pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
//     cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
//     encrypted: true
// });

// var channel = pusher.subscribe('test-channel');
// channel.bind('App\\Events\\TestEvent', function(data) {
//     console.log('Event Received:', data.message);
//     // Tambahkan logika untuk menampilkan notifikasi atau melakukan tindakan lainnya di sini
//     alert('Pesan baru: ' + data.message);
// });

function sendTestEvent() {
    fetch('/test-push')
        .then(response => response.text())
        .then(data => console.log(data))
        .catch(error => console.error('Error sending test event:', error));
}