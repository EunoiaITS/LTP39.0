<script>
    $(document).ready(function () {
        var html = '';
        var rel = '';
        var query = '';
        $('.approve').on('click',function (e) {
           e.preventDefault();
           rel = $(this).attr('rel');
           alert(rel);
        });
        $('#generate'+rel).on('click',function (e) {
            e.preventDefault();
            html = 'Id : '+$('#vip-id'+rel).val()+'<br/>' +
                'Name : '+$('#name'+rel).val()+'<br/>'+
                'Phone : '+$('#phone'+rel).val()+'<br/>';
            $('#qr-code'+rel).qrcode(html);
            var canvas = document.querySelector("#qr-code canvas");
            var img = canvas.toDataURL("image/png");
            var anc = '<a href="'+img+'" class="download-btn" target="_blank" download="qrcode.png"><i class="fas fa-arrow-alt-circle-down"></i></a>';
            $('#qr-image').val(img);
            $('#qr-code'+rel).append(anc);
        });
    });
</script>