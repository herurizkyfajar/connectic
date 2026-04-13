<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Anggota - {{ $anggota->nama }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f2f5;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .profile-card {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            overflow: hidden;
            width: 100%;
            max-width: 400px;
            text-align: center;
            padding-bottom: 30px;
            margin: 20px;
        }
        .profile-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            height: 120px;
            position: relative;
        }
        .avatar-container {
            width: 140px;
            height: 140px;
            margin: -70px auto 15px;
            border-radius: 50%;
            background: #fff;
            padding: 5px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            position: relative;
        }
        .avatar-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
            background-color: #eee;
        }
        .profile-name {
            font-size: 1.5rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 5px;
            padding: 0 15px;
        }
        .profile-role {
            font-size: 1rem;
            color: #666;
            margin-bottom: 10px;
        }
        .profile-status {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 25px;
        }
        .status-aktif { background-color: #d1e7dd; color: #0f5132; }
        .status-nonaktif { background-color: #f8d7da; color: #842029; }
        .qrcode-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 15px;
        }
        #qrcode {
            padding: 10px;
            background: #fff;
            border: 1px solid #eee;
            border-radius: 10px;
        }
        .scan-me {
            margin-top: 10px;
            font-size: 0.8rem;
            color: #888;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .footer-logo {
            margin-top: 20px;
            font-size: 0.8rem;
            color: #aaa;
        }
    </style>
</head>
<body>

    <div class="profile-card">
        <div class="profile-header"></div>
        
        <div class="avatar-container">
            @if($anggota->foto)
                <img src="{{ asset('storage/anggotas/' . $anggota->foto) }}" alt="{{ $anggota->nama }}" class="avatar-img">
            @else
                <div class="avatar-img d-flex align-items-center justify-content-center text-secondary fs-1">
                    <i class="fas fa-user"></i>
                </div>
            @endif
        </div>

        <h1 class="profile-name">{{ $anggota->nama }}</h1>
        <div class="profile-role">{{ $anggota->jabatan ?? 'Anggota' }}</div>
        
        @php
            $statusClass = $anggota->status == 'Aktif' ? 'status-aktif' : 'status-nonaktif';
        @endphp
        <span class="profile-status {{ $statusClass }}">
            {{ $anggota->status }}
        </span>

        <div class="qrcode-container">
            <div id="qrcode"></div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script>
        // Generate QR Code
        var qrcode = new QRCode(document.getElementById("qrcode"), {
            text: "{{ route('anggota.profil', $anggota->id) }}",
            width: 128,
            height: 128,
            colorDark : "#000000",
            colorLight : "#ffffff",
            correctLevel : QRCode.CorrectLevel.H
        });
    </script>
</body>
</html>