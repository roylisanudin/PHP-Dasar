$(document).ready(function(){

    //hilangkan tombol cari
    //jquery carikan tombol-cari (id) lakukan fungsi hide
    $('#tombol-cari').hide();
    
    //event ketika keyword ditulis
    $('#keyword').on('keyup',function(){
        
        //munculkan icon loading
        $('.loader').show();
        
        
        //ajax menggunakan load
        //$('#container').load('ajax/mahasiswa.php?keyword=' + $('#keyword').val());
    
        //$.get() menggunakan jsquery
        //data sebagai parameter menggantikan xhr response text
        $.get('ajax/mahasiswa.php?keyword=' + $('#keyword').val(), function(data){
            //ubah containernya
            //inner html (.html) diganti dengan data 
            $('#container').html(data);
            
            //stelah ketemu datanya, loader sembunyikan
            $('.loader').hide();
        });
    
    
    });
});