<script>
    $(document).ready(function () {
        var html = '';
        $('#generate').on('click',function (e) {
            e.preventDefault();
            html = 'Id : '+$('#vip-id').val()+'<br/>' +
                'Name : '+$('#name').val()+'<br/>'+
                'Phone : '+$('#phone').val()+'<br/>';
            $('#qr-code').qrcode(html);
            var canvas = document.querySelector("#qr-code canvas");
            var img = canvas.toDataURL("image/png");
            var anc = '<a href="'+img+'" class="download-btn" target="_blank" download="qrcode.png"><i class="fas fa-arrow-alt-circle-down"></i></a>';
            //var dl = document.createElement('a');
            //dl.setAttribute('href', img);
            //dl.setAttribute('download', 'qrcode.png');
            //dl.class('download-btn');
            $('#qr-code').append(anc);
        });
    });
</script>