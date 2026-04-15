<script>
function konfirmasiPesanan() {
    const orderData = {
        id_pelanggan: "{{ $order->id_pelanggan }}",
        total_harga: {{ $order->total_harga }},
        details: @json($details),
        waktu: new Date().toLocaleString('id-ID')
    };

    // Simpan sementara di localStorage
    localStorage.setItem('order_to_process', JSON.stringify(orderData));

    // Kirim ke database Laravel (riwayat)
    fetch("{{ route('simpan.riwayat') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(orderData)
    })
    .then(res => res.json())
    .then(data => {
        if(data.success) {
            alert('✅ Pesanan berhasil dikonfirmasi dan disimpan ke Riwayat!\nMengalihkan ke halaman kasir...');
            window.location.href = "{{ route('kasir') }}?auto=1";
        } else {
            alert('⚠ Gagal menyimpan ke Riwayat.');
        }
    })
    .catch(err => {
        console.error(err);
        alert('⚠ Terjadi error saat menyimpan ke Riwayat.');
    });
}
</script>