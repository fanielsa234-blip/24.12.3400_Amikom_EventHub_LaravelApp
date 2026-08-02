<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Pembaruan Status Pendaftaran Organizer</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f8fafc; padding: 20px; color: #1e293b;">
    <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 16px; padding: 32px; border: 1px solid #e2e8f0;">
        <div style="text-align: center; margin-bottom: 24px;">
            <h1 style="color: #4f46e5; margin: 0;">AmikomEventHub</h1>
            <p style="font-size: 14px; color: #64748b;">Portal Mitra Penyelenggara Event</p>
        </div>
        
        <div style="padding: 20px; border-radius: 12px; margin-bottom: 24px; background-color: {{ $status === 'approved' ? '#f0fdf4' : '#fef2f2' }}; border: 1px solid {{ $status === 'approved' ? '#bbf7d0' : '#fecaca' }};">
            <h2 style="margin-top: 0; color: {{ $status === 'approved' ? '#166534' : '#991b1b' }};">
                {{ $status === 'approved' ? 'Pendaftaran Organizer Disetujui! 🎉' : 'Pendaftaran Organizer Memerlukan Penyesuaian' }}
            </h2>
            <p style="margin: 8px 0; font-size: 14px; color: #334155;">
                Halo <strong>{{ $organizer->name }}</strong>,
            </p>
            <p style="margin: 8px 0; font-size: 14px; color: #334155;">
                @if($status === 'approved')
                    Pendaftaran organisasi Anda sebagai mitra resmi AmikomEventHub telah disetujui oleh Superadmin Kampus. Anda sekarang dapat masuk ke Portal Organizer untuk membuat dan mengelola event.
                @else
                    Status pendaftaran organisasi Anda saat ini berstatus <strong>{{ ucfirst($status) }}</strong>. Silakan hubungi tim administrasi untuk informasi lebih lanjut.
                @endif
            </p>
        </div>

        @if($status === 'approved')
            <div style="text-align: center; margin-top: 24px;">
                <a href="{{ route('organizer.login') }}" style="display: inline-block; padding: 12px 24px; background-color: #4f46e5; color: #ffffff; text-decoration: none; font-weight: bold; border-radius: 10px;">
                    Masuk Portal Organizer &rarr;
                </a>
            </div>
        @endif
    </div>
</body>
</html>
