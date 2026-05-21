@extends('layouts.app')

@section('title', 'Riwayat Booking')

@section('content')
<div class="container section">
    <div class="section-header">
        <h2 class="section-title">Riwayat Booking Anda</h2>
        <p class="section-subtitle">Kelola dan lihat status booking studio musik Anda.</p>
    </div>

    <div class="card">
        <div class="card-header flex flex-between">
            <h3>Daftar Booking</h3>
            <button class="btn btn-outline btn-sm" onclick="loadHistory()"><i class="fas fa-sync"></i> Refresh</button>
        </div>
        <div class="card-body p-0">
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID Booking</th>
                            <th>Studio & Ruangan</th>
                            <th>Tanggal & Waktu</th>
                            <th>Total Bayar</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="history-table">
                        <tr><td colspan="6" style="text-align: center;">Memuat data...</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', loadHistory);

    async function loadHistory() {
        const res = await fetch('/bookings');
        const result = await res.json();
        const tbody = document.getElementById('history-table');

        if (result.success) {
            if (result.data.length === 0) {
                tbody.innerHTML = '<tr><td colspan="6" style="text-align: center;">Anda belum memiliki riwayat booking.</td></tr>';
            } else {
                tbody.innerHTML = result.data.map(b => `
                    <tr>
                        <td><strong>${b.id_booking}</strong></td>
                        <td>${b.nama_studio}<br><small>${b.nama_ruangan}</small></td>
                        <td>${b.tanggal_booking}<br><small>${b.jam_mulai} - ${b.jam_selesai}</small></td>
                        <td>Rp ${b.total_bayar.toLocaleString()}</td>
                        <td><span class="status-badge status-${b.status_booking}">${b.status_booking}</span></td>
                        <td>
                            ${b.status_pembayaran === 'pending' ? `<button class="btn btn-primary btn-sm" onclick="showPayment('${b.id_booking}', ${b.total_bayar})">Bayar</button>` : ''}
                            <button class="btn btn-outline btn-sm" onclick="showDetail('${b.id_booking}')">Detail</button>
                        </td>
                    </tr>
                `).join('');
            }
        }
    }

    function showPayment(id, total) {
        showModal('Pembayaran', `
            <div style="text-align: center;">
                <p>Silakan transfer sebesar <strong>Rp ${total.toLocaleString()}</strong></p>
                <img src="{{ asset('img/qris_dummy.svg') }}" style="max-width: 200px; margin: 1rem 0;">
                <form id="payment-form">
                    <input type="file" id="proof" class="form-control" required>
                    <button type="submit" class="btn btn-primary btn-block" style="margin-top: 1rem;">Upload Bukti</button>
                </form>
            </div>
        `);

        document.getElementById('payment-form').onsubmit = async (e) => {
            e.preventDefault();
            const formData = new FormData();
            formData.append('id_booking', id);
            formData.append('bukti_pembayaran', document.getElementById('proof').files[0]);

            const res = await fetch('/upload-proof', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: formData
            });
            if ((await res.json()).success) {
                alert('Bukti pembayaran berhasil diupload!');
                document.getElementById('modal').classList.remove('active');
                loadHistory();
            }
        };
    }
</script>
@endpush
