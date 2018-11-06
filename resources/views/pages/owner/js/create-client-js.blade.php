<script>
    $(document).ready(function () {
        var name = '';
        var name1 = '';
        var type = '';
        var currentTime = new Date();
        var year = currentTime.getFullYear();
        var clients = '<?php echo $ids;?>';
        $('#client-type').on('change',function (e) {
            e.preventDefault();
            if($(this).val() === 'park'){
                type = '01';
            }else{
                type = '02';
            }
            $.each(JSON.parse(clients),function (i, e){
                if(e.client_id === (name + type + year)){
                    //alert(name1);
                    $('#client-id').val(name1 + type + year);
                }else{
                    $('#client-id').val(name + type + year);
                }
            });
        });
        $('#user-name').on('change',function (e) {
           e.preventDefault();
           var str = $(this).val();
           var val = str.split(' ');
           name = val[0].slice(0,1) + val[1].slice(0,1);
           name1 = val[0].slice(0,2) + val[1].slice(0,1);
            $.each(JSON.parse(clients),function (i, e){
                if(e.client_id === (name + type + year)){
                    //alert(name1);
                    $('#client-id').val(name1 + type + year);
                }else{
                    $('#client-id').val(name + type + year);
                }
            });
        });
    });
</script>