<!-- footer-area-->
<div class="footer-content dashboard-footer text-center">
    <p>A Product of <a target="_blank" href="https://www.dexhub.org/">DexHub</a></p>
    <p>Powered by <a target="_blank" href="http://www.eunoiaits.com/">Eunoia I.T Solutions</a></p>
</div>
</div>

<div class="modal fade" id="logout-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div  class="modal-dialog" role="document">
        <div class="modal-content modal-form">
            <form method="post" action="{{ url('/logout') }}">
                {{ csrf_field() }}
                <div class="modal-body text-center modal-padding">
                    <div class="icon-delete text-center"><i class="fas fa-sign-out-alt"></i></div>
                    <p>Are you sure you want to logout?</p>
                    <button type="submit" class="btn btn-default">Yes</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                </div>
            </form>
        </div>
    </div>
</div>

@if(isset($modal))
    @include($modal)
    @endif


<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<!-- main js file -->
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script>window.jQuery || document.write('<script src="{{ asset('public/assets/') }}js/vendor/jquery-3.2.1.min.js"><\/script>')</script>
<!-- bootstrap css -->
<script src="{{ asset('public/assets/js/bootstrap.min.js') }}"></script>
<!-- dataTables js -->
<script src="{{ asset('public/assets/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('public/assets/js/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('public/assets/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('public/assets/js/responsive.bootstrap.min.js') }}"></script>
<!-- QrCode Js -->
<script src="{{ asset('public/assets/js/jquery.qrcode.min.js') }}"></script>
<!-- pic chart -->
<script src="{{ asset('public/assets/js/Chart.bundle.js') }}"></script>
<script src="{{ asset('public/assets/js/index.js') }}"></script>
<!-- bootstrap select -->
<script src="{{ asset('public/assets/js/bootstrap-select.js') }}"></script>
<!-- bootstrap date time picker -->
<script src="{{ asset('public/assets/js/moment.js') }}"></script>
<script src="{{ asset('public/assets/js/bootstrap-datetimepicker.min.js') }}"></script>
<script src="{{ asset('public/assets/js/plugins.js') }}"></script>
<script src="{{ asset('public/assets/js/niceScroll.min.js') }}"></script>
<!-- main js file -->
<script src="{{ asset('public/assets/js/custom.js') }}"></script>
@if(isset($js))
    @include($js)
    @endif
</body>
</html>
