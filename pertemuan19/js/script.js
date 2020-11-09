//ambil elemen2 yg dibutuhkan
var keyword = document.getElementById('keyword');
var tombolCari = document.getElementById('tombol-cari');
var container = document.getElementById('container');

//tambahkan event ketika keyword ditulis
keyword.addEventListener('keyup', function(){
    
    //membuat object ajax
    var xhr = new XMLHttpRequest();

    //cek kesiapan ajax
    xhr.onreadystatechange = function(){
        //angka 4 berarti ready dan 200 kode berhasil
        if (xhr.readyState == 4 && xhr.status == 200) {
            //pnggil class container yg tadi di div index.php
            //inner html = ganti isi dari id = conteinernya dengan respone sumbernya seperti xhr.open
            container.innerHTML = xhr.responseText;
        }
    }

    //eksekusi ajax
    //diurlnya sambil juga mengirimkan data keywordnya yaitu ?keyword
    // + dgn keyword.value yaitu apapun keywordnya dikirim oleh ajax
    xhr.open('GET', 'ajax/mahasiswa.php?keyword=' + keyword.value, true);
    xhr.send();

})