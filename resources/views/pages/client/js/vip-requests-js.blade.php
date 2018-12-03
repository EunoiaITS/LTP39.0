<script>
    $(document).ready(function () {
        var html = '';
        var rel = '';
        var query = '';
        $('.approve').on('click',function (e) {
           e.preventDefault();
           rel = $(this).attr('rel');
            $('#generate'+rel).on('click',function (e) {
                e.preventDefault();
                $('#qr-code'+rel).html('');
                html = $('#vip-id'+rel).val();
                $('#qr-code'+rel).qrcode(html);
                var sel = "#qr-code"+rel;
                var canvas = document.querySelector(sel+" canvas");
                var img = canvas.toDataURL("image/png");
                var anc = '<a href="'+img+'" class="download-btn" target="_blank" download="qrcode.png"><i class="fas fa-arrow-alt-circle-down"></i></a>';
                $('#qr-image'+rel).val(img);
                $('#qr-code'+rel).append(anc);
            });
        });
    });
</script>