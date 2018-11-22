<script>
    $(document).ready(function () {
        $('#client-select').on('change',function (e) {
           e.preventDefault();
           var link = '{{ url('/clients-list') }}';
           if($(this).val() == 'pc'){
                window.location.href = link+'?type=park';
           }else if($(this).val() == 'ac'){
               window.location.href = link+'?type=ad';
           }else{
                window.location.href = link;
           }
        });
    });
</script>