<script>
    $(document).ready(function(){
        $('#exampleFormControlSelect1').on('change', function(e){
            e.preventDefault();
            var link = '{{ url('/reports') }}';
            @if($type == null && $eDate != null && $sDate != null)
            link = link+'?sDate={{ date('d/m/Y', strtotime($sDate)) }}&eDate={{ date('d/m/Y', strtotime($eDate)) }}&vc='+$(this).val();
            @elseif($type != null && $eDate == null && $sDate == null)
            link = link+'?vc='+$(this).val();
            @elseif($type != null && $eDate != null && $sDate != null)
            link = link+'?sDate={{ date('d/m/Y', strtotime($sDate)) }}&eDate={{ date('d/m/Y', strtotime($eDate)) }}&vc='+$(this).val();
            @else
            link = link+'?vc='+$(this).val();
            @endif
            window.location.href = link;
        });
        $('#exampleFormControlSelect2').on('change', function(e){
            e.preventDefault();
            var link = '{{ url('/reports') }}';
            @if($vc == null && $eDate != null && $sDate != null)
            link = link+'?sDate={{ date('d/m/Y', strtotime($sDate)) }}&eDate={{ date('d/m/Y', strtotime($eDate)) }}&type='+$(this).val();
            @elseif($vc != null && $eDate == null && $sDate == null)
            link = link+'?type='+$(this).val();
            @elseif($vc != null && $eDate != null && $sDate != null)
            link = link+'?sDate={{ date('d/m/Y', strtotime($sDate)) }}&eDate={{ date('d/m/Y', strtotime($eDate)) }}&type='+$(this).val();
            @else
            link = link+'?type='+$(this).val();
            @endif
            window.location.href = link;
        });
        $('#eDate').datetimepicker().on('dp.change',function(e){
            e.preventDefault();
            var sDate = $('#sDate').val();
            var link = '{{ url('/reports') }}';
            @if($type != null && $vc == null)
            link = link+'?type={{ $type }}&eDate='+$(this).val()+'&sDate='+sDate;
            @elseif($type == null && $vc != null)
            link = link+'?vc={{ $vc }}&eDate='+$(this).val()+'&sDate='+sDate;
            @elseif($type != null && $vc != null)
            link = link+'?type={{ $type }}&vc={{ $vc }}}&eDate='+$(this).val()+'&sDate='+sDate;
            @else
            link = link+'?eDate='+$(this).val()+'&sDate='+sDate;
            @endif
            window.location.href = link;
        });
    });
</script>