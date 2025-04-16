// Validasi form sederhana
function validateForm() {
    let inputs = document.querySelectorAll('input[required], select[required]');
    for (let input of inputs) {
        if (!input.value) {
            alert('Harap isi semua kolom yang wajib!');
            return false;
        }
    }
    alert('Produk berhasil ditambahkan!');
    return true;
}