<script>
    $(document).ready(function(){
        $('#exampleFormControlSelect1').on('change', function(e){
            e.preventDefault();
            var link = '{{ url('/reports') }}';
            @if($type == null && $eDate != null && $sDate != null)
            link = link+'?sDate={{ date('d/m/Y', strtotime($sDate)) }}&eDate={{ date('d/m/Y', strtotime($eDate)) }}&vc='+$(this).val();
            @elseif($type != null && $eDate == null && $sDate == null)
            link = link+'?type={{ $type }}&vc='+$(this).val();
            @elseif($type != null && $eDate != null && $sDate != null)
            link = link+'?sDate={{ date('d/m/Y', strtotime($sDate)) }}&eDate={{ date('d/m/Y', strtotime($eDate)) }}&type={{ $type }}&vc='+$(this).val();
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
            link = link+'?vc={{ $vc }}&type='+$(this).val();
            @elseif($vc != null && $eDate != null && $sDate != null)
            link = link+'?sDate={{ date('d/m/Y', strtotime($sDate)) }}&eDate={{ date('d/m/Y', strtotime($eDate)) }}&vc={{ $vc }}&type='+$(this).val();
            @else
            link = link+'?type='+$(this).val();
            @endif
            window.location.href = link;
        });
        var s_date = e_date = '{{ date('Y-m-d') }}';
        @if($sDate != null)
        s_date = '{{ $sDate }}';
        @endif
        @if($eDate != null)
        e_date = '{{ $eDate }}';
        @endif
        $('#sDate').datetimepicker({
            format: "DD/MM/YYYY",
            useCurrent: false,
            maxDate: moment(),
            defaultDate: new Date(s_date),
        });
        $('#eDate').datetimepicker({
            format: "DD/MM/YYYY",
            useCurrent: false,
            maxDate: moment(),
            defaultDate: new Date(e_date),
        }).on('dp.change',function(e){
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