<script>
    $(document).ready(function(){
        $.ajax({
            url: "{{ url('/report/ui-report-ajax') }}",
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
            {{--e.preventDefault();--}}
            {{--var link = '{{ url('/report/user-incomes') }}';--}}
            {{--@if($duration == null && $eDate != null && $sDate != null)--}}
            {{--link = link+'?sDate={{ date('d/m/Y', strtotime($sDate)) }}&eDate={{ date('d/m/Y', strtotime($eDate)) }}&emp='+$(this).val();--}}
            {{--@elseif($duration != null && $eDate == null && $sDate == null)--}}
            {{--link = link+'?duration={{ $duration }}&emp='+$(this).val();--}}
            {{--@else--}}
            {{--link = link+'?emp='+$(this).val();--}}
            {{--@endif--}}
            {{--window.location.href = link;--}}
        {{--});--}}
        $('#exampleFormControlSelect2').on('change', function(e){
            e.preventDefault();
            $('#sDate').val('');
            $('#eDate').val('');
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
            $('#exampleFormControlSelect2').val('');
        });
    });
</script>