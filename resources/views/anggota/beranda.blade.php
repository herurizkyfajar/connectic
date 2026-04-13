<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda - ConnecTIK Anggota</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .navbar { background:#fff; border-bottom:1px solid #e5e7eb; }
        .navbar .navbar-brand { color:#1877F2; font-weight:700; }
        .navbar .nav-link { color:#1c1e21; }
        .navbar .container-fluid { display:grid; grid-template-columns:1fr auto 1fr; align-items:center; }
        .navbar .navbar-brand { justify-self:start; }
        .navbar .nav-center { justify-self:center; }
        .navbar .nav-right { justify-self:end; }
        .nav-center .nav-icon { width:60px; height:44px; display:flex; align-items:center; justify-content:center; border-radius:8px; color:#5f676b; text-decoration:none; }
        .nav-center .nav-icon:hover { background:#f0f2f5; color:#1c1e21; }
        .nav-center .nav-icon.active { box-shadow: inset 0 -3px 0 #1877F2; color:#1877F2; }
        .nav-right .nav-circle { width:36px; height:36px; border-radius:50%; display:flex; align-items:center; justify-content:center; background:#f0f2f5; color:#1c1e21; text-decoration:none; }
        .nav-right .nav-circle:hover { background:#e9ecef; }
        .card { border: none; border-radius: 15px; box-shadow: none; --bs-card-bg: transparent; --bs-card-spacer-y: 0; background-color: transparent; }
        .card-body { padding: 0 !important; }
        .card-header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 15px 15px 0 0 !important; border: none; }
        .section-title { font-weight: 700; }
        .list-group-item { border: none; }
        .list-group, .list-group-item { --bs-list-group-bg: transparent; background-color: transparent; }
        .anggota-list .list-group-item { border-radius: 12px; margin-bottom: 8px; }
        .anggota-card .card-header { background: transparent !important; color: #212529; border: none; margin-bottom: 5px; }
        .sidebar-card { background: #ffffff; border-radius: 12px; }
        .sidebar-item { display:flex; align-items:center; gap:12px; padding:10px 12px; border-radius:10px; color: inherit; text-decoration: none; }
        .sidebar-item:hover { background:#f1f3f5; text-decoration:none; }
        .sidebar-avatar { width:36px; height:36px; border-radius:50%; overflow:hidden; background:#eee; display:flex; align-items:center; justify-content:center; }
        .sidebar-text { color:#212529; }
        .sidebar-item.me { background:#e9ecef; }
        .sidebar-card { background: #fff; border-radius: 12px; }
        .sidebar-item { display:flex; align-items:center; gap:12px; padding:10px 12px; border-radius:10px; }
        .sidebar-item:hover { background:#f1f3f5; text-decoration:none; }
        .sidebar-avatar { width:36px; height:36px; border-radius:50%; overflow:hidden; background:#eee; display:flex; align-items:center; justify-content:center; }
        .sidebar-text { color:#212529; }
        .social-icons { display:flex; align-items:center; gap:8px; margin-left:8px; margin-bottom:8px; }
        .social-icon { width:36px; height:36px; border-radius:8px; display:flex; align-items:center; justify-content:center; background:#f1f3f5; text-decoration:none; }
        .social-icon:hover { background:#e9ecef; }
        .social-title { margin-top:5px; margin-bottom:5px; margin-left:8px; }
        .story-item { cursor:pointer; }
        .story-modal-img { max-width:100%; max-height:85vh; object-fit:contain; }
        .story-modal-caption { color:#fff; padding:12px; }
        .modal-content .modal-body { position: relative; }
        .modal-nav { position:absolute; top:50%; transform:translateY(-50%); width:40px; height:40px; border-radius:50%; display:flex; align-items:center; justify-content:center; background:rgba(255,255,255,0.9); color:#000; box-shadow:0 2px 6px rgba(0,0,0,0.2); }
        .modal-nav.prev { left:12px; }
        .modal-nav.next { right:12px; }
        @media (min-width: 992px) {
            html, body { height: 100%; overflow: hidden; }
            .page-content { height: calc(100vh - 64px); display: flex; flex-direction: column; overflow: hidden; padding-top: 16px; }
            .grid-row { flex: 1 1 auto; display: flex; overflow: hidden; }
            .grid-col { height: 100%; overflow-y: auto; padding-bottom: 50px; box-sizing: border-box; scrollbar-gutter: stable; -ms-overflow-style: none; scrollbar-width: none; }
            .grid-col::-webkit-scrollbar { width: 0; height: 0; }
            .grid-col::after { content: ""; display: block; height: 50px; }
            .grid-col > .card:last-child { margin-bottom: 50px; }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar sticky-top">
        <div class="container-fluid d-flex align-items-center justify-content-between">
            <a class="navbar-brand" href="{{ route('anggota.beranda') }}">ConnecTIK Anggota</a>
            <div class="nav-center d-flex align-items-center gap-1">
                <a class="nav-icon nav-home" href="{{ route('anggota.beranda') }}"><i class="fas fa-home"></i></a>
                <a class="nav-icon nav-users" href="{{ route('anggota.anggota-list') }}" title="Daftar Anggota"><i class="fas fa-users"></i></a>
                <a class="nav-icon nav-academy" href="{{ route('anggota.academy') }}" title="Academy"><i class="fas fa-graduation-cap"></i></a>
                <a class="nav-icon nav-calendar" href="{{ route('anggota.kegiatan.calendar') }}" title="Kalender Kegiatan"><i class="fas fa-calendar-days"></i></a>
            </div>
            
            <div class="nav-right d-flex align-items-center gap-2">
                <form method="POST" action="{{ route('anggota.logout') }}" class="m-0">
                    @csrf
                    <button type="submit" class="btn p-0 nav-circle"><i class="fas fa-sign-out-alt"></i></button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container page-content">
        <div class="mb-4">
            @if($absensiTerbaru->count())
            <div id="storiesWrapper" style="position:relative;">
                <button type="button" class="btn btn-light stories-nav prev" style="position:absolute;left:8px;top:50%;transform:translateY(-50%);z-index:2;border-radius:50%;width:36px;height:36px;display:flex;align-items:center;justify-content:center;box-shadow:0 2px 6px rgba(0,0,0,0.2);">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <div id="storiesViewport" style="overflow:hidden;">
                    <div id="storiesTrack" class="d-flex" style="gap:12px;transition:transform .3s ease;">
                @foreach($absensiTerbaru as $absen)
                        @php
                            $bukti = $absen->bukti_kehadiran ?? null;
                            $ext = $bukti ? strtolower(pathinfo($bukti, PATHINFO_EXTENSION)) : null;
                            $isImg = in_array($ext, ['jpg','jpeg','png','gif','webp']);
                            $imgUrl = $isImg ? asset('storage/absensi-kegiatan/' . $bukti) : null;
                        @endphp
                        @if($imgUrl)
                        <div class="story-item" style="width:110px;" data-nama="{{ optional($absen->anggota)->nama ?? 'Anggota' }}" data-tanggal="{{ optional($absen->created_at ?? $absen->waktu_absen)->format('d M Y') }}" data-kegiatan="{{ optional($absen->riwayatKegiatan)->judul ?? '' }}">
                            <div style="position:relative;width:110px;height:180px;border-radius:12px;overflow:hidden;background:#eee;display:flex;align-items:center;justify-content:center;">
                                <img src="{{ $imgUrl }}" alt="Bukti" style="width:100%;height:100%;object-fit:cover;">
                                <div style="position:absolute;left:0;right:0;bottom:0;background:linear-gradient(180deg, rgba(0,0,0,0) 0%, rgba(0,0,0,0.7) 80%);color:#fff;padding:6px 8px;">
                                    <div style="font-size:12px;line-height:1.2;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ optional($absen->anggota)->nama ?? 'Anggota' }}</div>
                                    <div style="font-size:11px;opacity:0.9;">{{ optional($absen->created_at ?? $absen->waktu_absen)->format('d M Y') }}</div>
                                    <div style="font-size:11px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ optional($absen->riwayatKegiatan)->judul ?? '' }}</div>
                                </div>
                            </div>
                        </div>
                        @endif
                @endforeach
                    </div>
                </div>
                <button type="button" class="btn btn-light stories-nav next" style="position:absolute;right:8px;top:50%;transform:translateY(-50%);z-index:2;border-radius:50%;width:36px;height:36px;display:flex;align-items:center;justify-content:center;box-shadow:0 2px 6px rgba(0,0,0,0.2);">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
            @else
            <div class="text-muted">Belum ada cerita.</div>
            @endif
        </div>
        <div class="row g-4 grid-row">
            <div class="col-lg-3 grid-col">
                <div class="card sidebar-card">
                    <div class="card-body p-3">
                        <div class="mb-2">
                            <a href="{{ route('anggota.profile') }}" class="sidebar-item me">
                                <div class="sidebar-avatar">
                                    @php
                                        $meFoto = $anggota->foto ?? null;
                                        $meFotoUrl = $meFoto ? asset('storage/anggotas/' . $meFoto) : null;
                                    @endphp
                                    @if($meFotoUrl)
                                        <img src="{{ $meFotoUrl }}" alt="{{ $anggota->nama }}" style="width:100%;height:100%;object-fit:cover;">
                                    @else
                                        <i class="fas fa-user text-secondary"></i>
                                    @endif
                                </div>
                                <div class="sidebar-text">{{ $anggota->nama }}</div>
                            </a>
                        </div>
                        <div class="d-grid gap-1">
                            <a href="{{ route('absensi-kegiatan.index') }}" class="sidebar-item">
                                <i class="fas fa-clipboard-check text-primary"></i>
                                <div class="sidebar-text">Absensi Kegiatan</div>
                            </a>
                            <a href="{{ route('anggota.meeting-notes.index') }}" class="sidebar-item">
                                <i class="fas fa-file-alt text-success"></i>
                                <div class="sidebar-text">Riwayat Meeting</div>
                            </a>
                            <a href="{{ route('anggota.tentang.penjelasan') }}" class="sidebar-item">
                                <i class="fas fa-book-open text-info"></i>
                                <div class="sidebar-text">Penjelasan RTIK</div>
                            </a>
                            <a href="{{ route('anggota.tentang.struktur') }}" class="sidebar-item">
                                <i class="fas fa-sitemap text-warning"></i>
                                <div class="sidebar-text">Struktur RTIK</div>
                            </a>
                            <a href="https://drive.google.com/drive/folders/1tEeSl8Bc3BJ2k0YRgIcfT3IFTb9uSCD_?usp=sharing" target="_blank" rel="noopener" class="sidebar-item">
                                <i class="fas fa-folder-open text-secondary"></i>
                                <div class="sidebar-text">SK</div>
                            </a>
                        </div>
                        <div>
                            <div class="text-muted small social-title">Sosial Media RTIK</div>
                            <div class="social-icons">
                                <a href="https://www.instagram.com/rtikcmh/" target="_blank" rel="noopener" class="social-icon" title="Instagram">
                                    <i class="fab fa-instagram text-warning"></i>
                                </a>
                                <a href="https://www.youtube.com/@rtikkotacimahi9689" target="_blank" rel="noopener" class="social-icon" title="YouTube">
                                    <i class="fab fa-youtube text-danger"></i>
                                </a>
                                <a href="https://www.linkedin.com/in/relawan-tik-cimahi-63986b261?originalSubdomain=id" target="_blank" rel="noopener" class="social-icon" title="LinkedIn">
                                    <i class="fab fa-linkedin text-primary"></i>
                                </a>
                            </div>
                        </div>
                        @if(isset($upcomingBirthdays) && $upcomingBirthdays->count())
                        <div class="mt-3">
                            <div class="text-muted small social-title">Ulang Tahun Terdekat</div>
                            <div class="d-grid gap-1">
                                @foreach($upcomingBirthdays as $a)
                                @php
                                    $foto = $a->foto ?? null;
                                    $fotoUrl = $foto ? asset('storage/anggotas/' . $foto) : null;
                                @endphp
                                <div class="sidebar-item">
                                    <div class="sidebar-avatar">
                                        @if($fotoUrl)
                                            <img src="{{ $fotoUrl }}" alt="{{ $a->nama }}" style="width:100%;height:100%;object-fit:cover;">
                                        @else
                                            <i class="fas fa-user text-secondary"></i>
                                        @endif
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="sidebar-text">{{ $a->nama }}</div>
                                        <div class="text-muted small">{{ optional($a->next_birthday_date)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</div>
                                    </div>
                                    
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-lg-6 grid-col order-lg-2" id="feedColumn">
                <div class="card h-100">
                    <div class="card-body">
                        @if(isset($updateTerbaru) && $updateTerbaru->count())
                        <ul class="list-group list-group-flush anggota-list" id="updateList">
                            @foreach($updateTerbaru as $item)
                            @php
                                $imgUrl = $item->image ?? null;
                                $headline = $item->title ?? 'Update';
                                $lead = ($item->type === 'rapat' && !empty($item->subtitle)) ? $item->subtitle : $headline;
                            @endphp
                            <li class="list-group-item p-0">
                                <div class="bg-white border rounded p-3 mb-3">
                                    <div class="d-flex justify-content-between mb-2">
                                        <div class="fw-semibold">{{ $lead }}</div>
                                        <small class="text-muted">{{ optional($item->date)->diffForHumans() }}</small>
                                    </div>
                                    @if($imgUrl)
                                    <div class="ratio ratio-16x9 mb-2">
                                        <img src="{{ $imgUrl }}" alt="Gambar" class="w-100 h-100" style="object-fit:cover;">
                                    </div>
                                    @else
                                    <div class="ratio ratio-16x9 mb-2 bg-light d-flex align-items-center justify-content-center">
                                        <i class="fas fa-{{ $item->icon }} text-{{ $item->color }} fa-2x"></i>
                                    </div>
                                    @endif
                                    @if($item->type === 'kegiatan' && !empty($item->description))
                                    <div class="mt-2">
                                        <div id="desc-short-{{ $item->id }}">
                                            {{ \Illuminate\Support\Str::limit($item->description, 300) }}
                                            @if(\Illuminate\Support\Str::length($item->description) > 300)
                                            <button type="button" class="btn btn-link p-0 ms-2 btn-more" data-id="{{ $item->id }}">Selengkapnya</button>
                                            @endif
                                        </div>
                                        <div id="desc-full-{{ $item->id }}" style="display:none;">
                                            {{ $item->description }}
                                            <button type="button" class="btn btn-link p-0 ms-2 btn-less" data-id="{{ $item->id }}">Sembunyikan</button>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </li>
                            @endforeach
                        </ul>
                        <div id="paginationMeta" data-next="{{ $updateTerbaru->nextPageUrl() ?? '' }}" style="display:none;"></div>
                        <div id="infiniteSentinel" class="text-center text-muted small py-2" style="{{ $updateTerbaru->hasMorePages() ? '' : 'display:none;' }}">Scroll untuk memuat lebih banyak...</div>
                        @else
                        <div class="text-muted">Belum ada update.</div>
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 grid-col order-lg-3" style="padding-bottom:50px;">
                <div class="card h-100 anggota-card" id="anggota-rtik">
                    <div class="card-header">
                        <h5 class="mb-0">Anggota RTIK</h5>
                    </div>
                    <div class="card-body">
                        @if(isset($anggotaList) && $anggotaList->count())
                        <ul class="list-group list-group-flush anggota-list">
                            @foreach($anggotaList as $a)
                            @php
                                $foto = $a->foto ?? null;
                                $fotoUrl = $foto ? asset('storage/anggotas/' . $foto) : null;
                            @endphp
                            <li class="list-group-item">
                                <div class="d-flex align-items-center">
                                    <div class="me-3" style="width:50px;height:50px;border-radius:50%;overflow:hidden;background:#eee;display:flex;align-items:center;justify-content:center;">
                                        @if($fotoUrl)
                                            <img src="{{ $fotoUrl }}" alt="{{ $a->nama }}" style="width:100%;height:100%;object-fit:cover;">
                                        @else
                                            <i class="fas fa-user text-secondary"></i>
                                        @endif
                                    </div>
                                    <div class="flex-grow-1">
                                        <div>{{ $a->nama }}</div>
                                        <div class="text-muted small">{{ $a->jabatan ?? '' }}</div>
                                    </div>
                                    <div class="ms-auto text-end">
                                        <span class="badge bg-primary">Skor {{ $a->skor_keaktifan }}</span>
                                    </div>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                        @else
                        <div class="text-muted">Belum ada data anggota.</div>
                        @endif
                        
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-fullscreen-sm-down">
            <div class="modal-content bg-dark">
                <div class="modal-body p-0 d-flex align-items-center justify-content-center">
                    <button type="button" class="btn modal-nav prev"><i class="fas fa-chevron-left"></i></button>
                    <img id="imageModalImg" src="" alt="Bukti" class="img-fluid story-modal-img">
                    <button type="button" class="btn modal-nav next"><i class="fas fa-chevron-right"></i></button>
                </div>
                <div id="imageModalCaption" class="story-modal-caption"></div>
            </div>
        </div>
    </div>

    

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    (function(){
        var home = document.querySelector('.nav-center .nav-home');
        var users = document.querySelector('.nav-center .nav-users');
        if(home){ home.classList.add('active'); }
        function syncActive(){
            if(!users) return;
            if(location.hash === '#anggota-rtik'){
                users.classList.add('active');
            } else {
                users.classList.remove('active');
            }
        }
        window.addEventListener('hashchange', syncActive);
        syncActive();
        var viewport = document.getElementById('storiesViewport');
        var track = document.getElementById('storiesTrack');
        if(!viewport || !track) return;
        var items = Array.prototype.slice.call(track.querySelectorAll('.story-item'));
        if(items.length === 0) return;
        var gap = 12;
        var itemW = items[0].getBoundingClientRect().width + gap;
        var index = 0;
        function vis(){
            var vw = viewport.getBoundingClientRect().width;
            var cnt = Math.max(1, Math.floor(vw / itemW));
            return cnt;
        }
        function update(){
            var maxIndex = Math.max(0, items.length - vis());
            if(index > maxIndex) index = maxIndex;
            if(index < 0) index = 0;
            track.style.transform = 'translateX(' + (-index*itemW) + 'px)';
            var prevBtn = document.querySelector('.stories-nav.prev');
            var nextBtn = document.querySelector('.stories-nav.next');
            var canScroll = items.length > vis();
            if(prevBtn){ prevBtn.style.display = (canScroll && index > 0) ? 'flex' : 'none'; }
            if(nextBtn){ nextBtn.style.display = (canScroll && index < maxIndex) ? 'flex' : 'none'; }
        }
        var prevBtn = document.querySelector('.stories-nav.prev');
        var nextBtn = document.querySelector('.stories-nav.next');
        if(prevBtn) prevBtn.addEventListener('click', function(){ index = index - vis(); update(); });
        if(nextBtn) nextBtn.addEventListener('click', function(){ index = index + vis(); update(); });
        window.addEventListener('resize', update);
        update();
    })();
    $(function(){
        $(document).on('click', '.btn-more', function(){
            var id = $(this).data('id');
            $('#desc-short-'+id).slideUp(150);
            $('#desc-full-'+id).slideDown(150);
        });
        $(document).on('click', '.btn-less', function(){
            var id = $(this).data('id');
            $('#desc-full-'+id).slideUp(150);
            $('#desc-short-'+id).slideDown(150);
        });

        var storyItems = $('#storiesTrack .story-item');
        var storyIndex = -1;
        function renderStory(idx){
            if(idx < 0 || idx >= storyItems.length) return;
            var $el = $(storyItems[idx]);
            var img = $el.find('img');
            if(!img.length){
                return;
            }
            $('#imageModalImg').attr('src', img.attr('src'));
            var nama = $el.data('nama') || '';
            var tanggal = $el.data('tanggal') || '';
            var kegiatan = $el.data('kegiatan') || '';
            $('#imageModalCaption').html(
                '<div class="fw-semibold">'+nama+'</div>'+
                '<div class="small">'+tanggal+'</div>'+
                '<div class="small">'+kegiatan+'</div>'
            );
            storyIndex = idx;
            $('.modal-nav.prev').toggle(storyIndex > 0);
            $('.modal-nav.next').toggle(storyIndex < storyItems.length - 1);
        }
        $(document).on('click', '.story-item', function(){
            var idx = storyItems.index(this);
            var img = $(this).find('img');
            if(img.length){
                renderStory(idx);
                var modal = new bootstrap.Modal(document.getElementById('imageModal'));
                modal.show();
            }
        });
        $(document).on('click', '.modal-nav.prev', function(){ if(storyIndex > 0){ renderStory(storyIndex - 1); } });
        $(document).on('click', '.modal-nav.next', function(){ if(storyIndex < storyItems.length - 1){ renderStory(storyIndex + 1); } });

        var $feedCol = $('#feedColumn');
        var $list = $('#updateList');
        var $sentinel = $('#infiniteSentinel');
        var loading = false;
        function getNextUrl(){
            return $('#paginationMeta').data('next') || '';
        }
        if($feedCol.length && $list.length && $sentinel.length){
            var io = new IntersectionObserver(function(entries){
                entries.forEach(function(entry){
                    if(entry.isIntersecting && !loading){
                        var nextUrl = getNextUrl();
                        if(nextUrl){
                            loading = true;
                            $sentinel.text('Memuat...');
                            $.get(nextUrl, function(html){
                                var $doc = $($.parseHTML(html));
                                var $newLis = $doc.find('ul.anggota-list > li');
                                if($newLis.length){
                                    $list.append($newLis);
                                }
                                var newNext = $doc.find('#paginationMeta').data('next') || '';
                                $('#paginationMeta').data('next', newNext);
                                if(!newNext){
                                    $sentinel.hide();
                                    io.disconnect();
                                } else {
                                    $sentinel.text('Scroll untuk memuat lebih banyak...');
                                }
                            }).always(function(){
                                loading = false;
                            });
                        } else {
                            $sentinel.hide();
                            io.disconnect();
                        }
                    }
                });
            }, { root: $feedCol.get(0), rootMargin: '0px 0px 200px 0px', threshold: 0.1 });
            io.observe($sentinel.get(0));
        }
    });
    </script>
</body>
</html>
