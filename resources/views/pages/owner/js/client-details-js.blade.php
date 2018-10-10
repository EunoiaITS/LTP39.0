<script>
    $(function(){
        $('#enable-edit').on('click', function(e){
            e.preventDefault();
            $('#phone-no').removeAttr('readonly');
            $('#file-up').removeAttr('disabled');
            $('#btn-save').removeAttr('disabled');
        });
        $('.dev-in').click( function()
        {
            $('#devices').html($("input[name=dev_in]:checked").map(
                    function () {return '<li><input type="hidden" name="devices[]" value="'+this.value+'">'+this.value;}).get().join("</li>"));
        });
    });
</script>