<script>
    $(document).ready(function(){
        var link = '{{ url('/report/vehicle-category') }}';
        $('#exampleFormControlSelect1').on('change', function(e){
            e.preventDefault();
            window.location.href = link+'?vc='+$(this).val();
        });
        $('#exampleFormControlSelect2').on('change', function(e){
            e.preventDefault();
            @if($vc_selected != null)
            link = link+'?vc='+'{{ $vc_selected }}&type='+$(this).val();
            @else
            link = link+'?type='+$(this).val();
            @endif
            window.location.href = link;
        });
    });
</script>