<script>
    $(document).ready(function(){
        $('#exampleFormControlSelect1').on('change', function(e){
            e.preventDefault();
            var link = '{{ url('/report/user-incomes') }}';
            @if($duration == null && $eDate != null && $sDate != null)
            link = link+'?sDate={{ date('d/m/Y', strtotime($sDate)) }}&eDate={{ date('d/m/Y', strtotime($eDate)) }}&emp='+$(this).val();
            @elseif($duration != null && $eDate == null && $sDate == null)
            link = link+'?duration={{ $duration }}&emp='+$(this).val();
            @else
            link = link+'?emp='+$(this).val();
            @endif
            window.location.href = link;
        });
        $('#exampleFormControlSelect2').on('change', function(e){
            e.preventDefault();
            var link = '{{ url('/report/user-incomes') }}';
            @if($emp != null)
            link = link+'?emp={{ $emp }}&duration='+$(this).val();
            @else
            link = link+'?duration='+$(this).val();
            @endif
            window.location.href = link;
        });
        $('#eDate').datetimepicker().on('dp.change',function(e){
            e.preventDefault();
            var sDate = $('#sDate').val();
            var link = '{{ url('/report/user-incomes') }}';
            @if($emp != null)
            link = link+'?emp={{ $emp }}&eDate='+$(this).val()+'&sDate='+sDate;
            @else
            link = link+'?eDate='+$(this).val()+'&sDate='+sDate;
            @endif
            window.location.href = link;
        });
    });
</script>