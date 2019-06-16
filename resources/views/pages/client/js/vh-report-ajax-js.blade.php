<script>
    $(document).ready(function(){
        $.ajax({
            url: "{{ url('/report/vh-ajax-counts') }}",
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                $('#daily-count').text(response.daily);
                $('#weekly-count').text(response.weekly);
                $('#monthly-count').text(response.monthly);
                $('#yearly-count').text(response.yearly);
                $('#daily-perc').text((parseInt(response.daily)-parseInt(response.last_daily))/100+'%');
                $('#weekly-perc').text((parseInt(response.weekly)-parseInt(response.last_weekly))/100+'%');
                $('#monthly-perc').text((parseInt(response.monthly)-parseInt(response.last_monthly))/100+'%');
                $('#yearly-perc').text((parseInt(response.yearly)-parseInt(response.last_yearly))/100+'%');
            }
        });
        {{--$('#exampleFormControlSelect1').on('change', function(e){--}}
            {{--alert(55);--}}
            {{--e.preventDefault();--}}
            {{--var link = '{{ url('/report/vh-ajax-ui') }}';--}}
            {{--@if($type != null && $duration == null && $sDate == null && $eDate == null)--}}
            {{--link = link+'?type={{ $type }}&vc='+$(this).val();--}}
            {{--@elseif($type == null && $duration != null)--}}
            {{--link = link+'?duration={{ $duration }}&vc='+$(this).val();--}}
            {{--@elseif($type != null && $duration != null)--}}
            {{--link = link+'?type={{ $type }}&duration={{ $duration }}&vc='+$(this).val();--}}
            {{--@elseif($type == null && $eDate != null && $sDate != null)--}}
            {{--link = link+'?sDate={{ date('d/m/Y', strtotime($sDate)) }}&eDate={{ date('d/m/Y', strtotime($eDate)) }}&vc='+$(this).val();--}}
            {{--@elseif($type != null && $eDate != null && $sDate != null)--}}
            {{--link = link+'?sDate={{ date('d/m/Y', strtotime($sDate)) }}&eDate={{ date('d/m/Y', strtotime($eDate)) }}&type={{ $type }}&vc='+$(this).val();--}}
            {{--@else--}}
            {{--link = link+'?vc='+$(this).val();--}}
            {{--@endif--}}
            {{--window.location.href = link;--}}
        {{--});--}}
        {{--$('#exampleFormControlSelect2').on('change', function(e){--}}
            {{--e.preventDefault();--}}
            {{--var link = '{{ url('/report/vh-ajax-ui') }}';--}}
            {{--@if($vc_selected != null && $duration == null && $sDate == null && $eDate == null)--}}
            {{--link = link+'?vc={{ $vc_selected }}&type='+$(this).val();--}}
            {{--@elseif($vc_selected == null && $duration != null)--}}
            {{--link = link+'?duration={{ $duration }}&type='+$(this).val();--}}
            {{--@elseif($vc_selected != null && $duration != null)--}}
            {{--link = link+'?duration={{ $duration }}&vc={{ $vc_selected }}&type='+$(this).val();--}}
            {{--@elseif($vc_selected == null && $eDate != null && $sDate != null)--}}
            {{--link = link+'?sDate={{ date('d/m/Y', strtotime($sDate)) }}&eDate={{ date('d/m/Y', strtotime($eDate)) }}&type='+$(this).val();--}}
            {{--@elseif($vc_selected != null && $eDate != null && $sDate != null)--}}
            {{--link = link+'?sDate={{ date('d/m/Y', strtotime($sDate)) }}&eDate={{ date('d/m/Y', strtotime($eDate)) }}&vc={{ $vc_selected }}&type='+$(this).val();--}}
            {{--@else--}}
            {{--link = link+'?type='+$(this).val();--}}
            {{--@endif--}}
            {{--window.location.href = link;--}}
        {{--});--}}
        $('#exampleFormControlSelect3').on('change', function(e){
            e.preventDefault();
            $('#sDate').val('');
            $('#eDate').val('');
        });
        var s_date = e_date = '{{ date('Y-m-d', strtotime(date('Y-m-d').' -1 day')) }}';
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
            $('#exampleFormControlSelect3').val('');
        });
    });
</script>