import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import interactionPlugin from '@fullcalendar/interaction';

document.addEventListener('DOMContentLoaded', function () {
    let calendarEl = document.getElementById('calendar');

    let calendar = new Calendar(calendarEl, {
        plugins: [dayGridPlugin, interactionPlugin],
        initialView: 'dayGridMonth',
        events: '/api/kegiatan', // endpoint yang kamu buat di Laravel
        selectable: true,
        select: function (info) {
            alert('Tanggal dipilih: ' + info.startStr);
            // Kamu bisa munculkan modal input kegiatan di sini
        },
        eventClick: function(info) {
            alert('Judul Kegiatan: ' + info.event.title);
            // Bisa munculkan modal detail/edit kegiatan
        }
    });

    calendar.render();
});
