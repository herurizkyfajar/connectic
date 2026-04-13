@extends('admin.layouts.app')

@section('title', 'Kalender Kegiatan')
@section('page-title', 'KALENDER KEGIATAN')

@section('styles')
<style>
    #calendar {
        background: white;
        padding: 20px;
        border-radius: 15px;
        height: 100%;
        min-height: 600px;
    }
    .fc-header-toolbar {
        margin-bottom: 20px !important;
    }
    .fc-event {
        cursor: pointer;
    }
</style>
@endsection

@section('content')
<div class="row h-100">
    <div class="col-12 h-100">
        <div id='calendar'></div>
    </div>
</div>
@endsection

@section('scripts')
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            events: '{{ route("riwayat-kegiatan.events") }}',
            eventClick: function(info) {
                if (info.event.url) {
                    window.location.href = info.event.url;
                    info.jsEvent.preventDefault();
                }
            },
            height: 'auto',
            locale: 'id',
            buttonText: {
                today: 'Hari Ini',
                month: 'Bulan',
                week: 'Minggu',
                day: 'Hari'
            }
        });
        calendar.render();
    });
</script>
@endsection
