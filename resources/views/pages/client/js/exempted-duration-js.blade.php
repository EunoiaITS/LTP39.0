<script>
    $(document).ready(function () {
        $('.time').on('click',function (e) {
            $('.from-time').text($('.from').val());
            $('.to-time').text($('.to').val());
        });
        $('.duration').on('click',function (e) {
            $('.f-duration').text($('.e-duration').val());
        });
    });
</script>