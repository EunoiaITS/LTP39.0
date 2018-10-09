<script>
    $(function(){
        $('#enable-edit').on('click', function(e){
            e.preventDefault();
            $('#phone-no').removeAttr('readonly');
            $('#file-up').removeAttr('disabled');
            $('#btn-save').removeAttr('disabled');
        });
    });
</script>