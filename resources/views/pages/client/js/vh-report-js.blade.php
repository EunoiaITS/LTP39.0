<script>
    $(document).ready(function(){
        $('#exampleFormControlSelect1').on('change', function(e){
            e.preventDefault();
            var link = '{{ url('/report/vehicle-category') }}';
            @if($type != null && $duration == null && $sDate == null && $eDate == null)
            link = link+'?type={{ $type }}&vc='+$(this).val();
            @elseif($type == null && $duration != null)
            link = link+'?duration={{ $duration }}&vc='+$(this).val();
            @elseif($type != null && $duration != null)
            link = link+'?type={{ $type }}&duration={{ $duration }}&vc='+$(this).val();
            @elseif($type == null && $eDate != null && $sDate != null)
            link = link+'?sDate={{ date('d/m/Y', strtotime($sDate)) }}&eDate={{ date('d/m/Y', strtotime($eDate)) }}&vc='+$(this).val();
            @elseif($type != null && $eDate != null && $sDate != null)
            link = link+'?sDate={{ date('d/m/Y', strtotime($sDate)) }}&eDate={{ date('d/m/Y', strtotime($eDate)) }}&type={{ $type }}&vc='+$(this).val();
            @else
            link = link+'?vc='+$(this).val();
            @endif
            window.location.href = link;
        });
        $('#exampleFormControlSelect2').on('change', function(e){
            e.preventDefault();
            var link = '{{ url('/report/vehicle-category') }}';
            @if($vc_selected != null && $duration == null && $sDate == null && $eDate == null)
            link = link+'?vc={{ $vc_selected }}&type='+$(this).val();
            @elseif($vc_selected == null && $duration != null)
            link = link+'?duration={{ $duration }}&type='+$(this).val();
            @elseif($vc_selected != null && $duration != null)
            link = link+'?duration={{ $duration }}&vc={{ $vc_selected }}&type='+$(this).val();
            @elseif($vc_selected == null && $eDate != null && $sDate != null)
            link = link+'?sDate={{ date('d/m/Y', strtotime($sDate)) }}&eDate={{ date('d/m/Y', strtotime($eDate)) }}&type='+$(this).val();
            @elseif($vc_selected != null && $eDate != null && $sDate != null)
            link = link+'?sDate={{ date('d/m/Y', strtotime($sDate)) }}&eDate={{ date('d/m/Y', strtotime($eDate)) }}&vc={{ $vc_selected }}&type='+$(this).val();
            @else
            link = link+'?type='+$(this).val();
            @endif
            window.location.href = link;
        });
        $('#exampleFormControlSelect3').on('change', function(e){
            e.preventDefault();
            var link = '{{ url('/report/vehicle-category') }}';
            @if($vc_selected != null && $type == null)
            link = link+'?vc={{ $vc_selected }}&duration='+$(this).val();
            @elseif($type != null && $vc_selected == null)
            link = link+'?type={{ $type }}&duration='+$(this).val();
            @elseif($vc_selected != null && $type != null)
            link = link+'?type={{ $type }}&vc={{ $vc_selected }}&duration='+$(this).val();
            @else
            link = link+'?duration='+$(this).val();
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
            var link = '{{ url('/report/vehicle-category') }}';
            @if($vc_selected != null && $type == null)
            link = link+'?vc={{ $vc_selected }}&eDate='+$(this).val()+'&sDate='+sDate;
            @elseif($type != null && $vc_selected == null)
            link = link+'?type={{ $type }}&eDate='+$(this).val()+'&sDate='+sDate;
            @elseif($vc_selected != null && $type != null)
            link = link+'?type={{ $type }}&vc={{ $vc_selected }}&eDate='+$(this).val()+'&sDate='+sDate;
            @else
            link = link+'?eDate='+$(this).val()+'&sDate='+sDate;
            @endif
            window.location.href = link;
        });
    });
</script>