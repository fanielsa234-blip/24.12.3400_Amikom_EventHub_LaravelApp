<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Ticket Resmi - AmikomEventHub</title>
</head>
<body style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f1f5f9; margin: 0; padding: 20px; color: #1e293b; -webkit-font-smoothing: antialiased;">
    
    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 20px; overflow: hidden; box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05); border: 1px solid #e2e8f0;">
        
        <!-- Header -->
        <tr>
            <td style="background-color: #4f46e5; padding: 30px; text-align: center; color: #ffffff;">
                <div style="font-size: 24px; font-weight: 900; letter-spacing: -0.5px; margin-bottom: 4px;">AmikomEventHub</div>
                <div style="font-size: 13px; font-weight: 600; opacity: 0.9; text-transform: uppercase; letter-spacing: 1px;">Platform Tiket Event Kampus</div>
            </td>
        </tr>

        <!-- Body Content -->
        <tr>
            <td style="padding: 32px 28px;">
                <div style="text-align: center; margin-bottom: 28px;">
                    <div style="display: inline-block; background-color: #e0e7ff; color: #4338ca; padding: 6px 16px; border-radius: 50px; font-size: 12px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 12px;">
                        Pembayaran Berhasil
                    </div>
                    <h1 style="font-size: 22px; font-weight: 800; color: #0f172a; margin: 0 0 8px 0; letter-spacing: -0.5px;">E-Ticket Resmi Anda</h1>
                    <p style="font-size: 14px; color: #64748b; margin: 0;">Terima kasih atas pemesanan Anda! Berikut adalah rincian tiket acara resmi Anda.</p>
                </div>

                <!-- Event Details Card -->
                <div style="background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 16px; padding: 24px; margin-bottom: 24px;">
                    <h2 style="font-size: 18px; font-weight: 800; color: #1e1b4b; margin: 0 0 16px 0; border-bottom: 1px solid #cbd5e1; padding-bottom: 10px;">
                        {{ $transaction->event->title ?? 'Detail Event' }}
                    </h2>
                    
                    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="font-size: 14px; line-height: 1.6;">
                        <tr>
                            <td style="padding: 4px 0; color: #64748b; font-weight: 600; width: 130px;">📅 Tanggal & Waktu:</td>
                            <td style="padding: 4px 0; color: #0f172a; font-weight: 700;">
                                {{ isset($transaction->event->date) ? \Carbon\Carbon::parse($transaction->event->date)->format('d M Y, H:i') : '-' }} WIB
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 4px 0; color: #64748b; font-weight: 600;">📍 Lokasi Event:</td>
                            <td style="padding: 4px 0; color: #0f172a; font-weight: 700;">
                                {{ $transaction->event->location ?? '-' }}
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 4px 0; color: #64748b; font-weight: 600;">👤 Nama Pemesan:</td>
                            <td style="padding: 4px 0; color: #0f172a; font-weight: 700;">
                                {{ $transaction->customer_name }}
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 4px 0; color: #64748b; font-weight: 600;">📧 Email Pembeli:</td>
                            <td style="padding: 4px 0; color: #0f172a; font-weight: 700;">
                                {{ $transaction->customer_email }}
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 4px 0; color: #64748b; font-weight: 600;">🎟️ Jumlah Tiket:</td>
                            <td style="padding: 4px 0; color: #0f172a; font-weight: 700;">
                                1 Tiket Masuk
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 4px 0; color: #64748b; font-weight: 600;">💰 Total Pembayaran:</td>
                            <td style="padding: 4px 0; color: #4338ca; font-weight: 800; font-size: 15px;">
                                Rp {{ number_format($transaction->total_price, 0, ',', '.') }}
                            </td>
                        </tr>
                    </table>
                </div>

                <!-- Ticket Code / Order ID Box -->
                <div style="background-color: #eff6ff; border: 2px dashed #3b82f6; border-radius: 16px; padding: 24px; text-align: center; margin-bottom: 24px;">
                    <div style="font-size: 11px; font-weight: 800; color: #1d4ed8; text-transform: uppercase; letter-spacing: 1.5px; margin-bottom: 8px;">
                        KODE KLAIM TIKET / ORDER ID
                    </div>
                    <div style="font-family: 'Courier New', Courier, monospace; font-size: 26px; font-weight: 900; color: #1e3a8a; letter-spacing: 2px; margin-bottom: 8px;">
                        {{ $transaction->order_id }}
                    </div>
                    <p style="font-size: 12px; color: #3b82f6; margin: 0; font-weight: 600;">
                        Tunjukkan Kode Order ID ini kepada panitia saat check-in di lokasi acara.
                    </p>
                </div>

                <!-- Notice Note -->
                <div style="background-color: #fffbeb; border: 1px solid #fef3c7; border-radius: 12px; padding: 16px; font-size: 13px; color: #92400e; line-height: 1.5;">
                    📌 <strong>Catatan Penting:</strong> Harap simpan email ini sebagai bukti pembayaran dan bukti kehadiran resmi Anda. Jangan membagikan kode E-Ticket ini kepada orang lain untuk menghindari klaim ganda.
                </div>
            </td>
        </tr>

        <!-- Footer -->
        <tr>
            <td style="background-color: #f8fafc; padding: 20px; text-align: center; border-top: 1px solid #e2e8f0; font-size: 12px; color: #94a3b8;">
                <p style="margin: 0 0 4px 0;">&copy; {{ date('Y') }} <strong>AmikomEventHub</strong>. All rights reserved.</p>
                <p style="margin: 0;">Email ini dikirimkan secara otomatis dari sistem AmikomEventHub.</p>
            </td>
        </tr>
    </table>

</body>
</html>