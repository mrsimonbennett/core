<!-- Mainly scripts -->
<script src="/assets/js/jquery-2.1.1.js"></script>
<script src="/assets/js/bootstrap.min.js"></script>
<script src="/assets/js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="/assets/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

<!-- Flot -->
<script src="/assets/js/plugins/flot/jquery.flot.js"></script>
<script src="/assets/js/plugins/flot/jquery.flot.tooltip.min.js"></script>
<script src="/assets/js/plugins/flot/jquery.flot.spline.js"></script>
<script src="/assets/js/plugins/flot/jquery.flot.resize.js"></script>
<script src="/assets/js/plugins/flot/jquery.flot.pie.js"></script>

<!-- Peity -->
<script src="/assets/js/plugins/peity/jquery.peity.min.js"></script>
<script src="/assets/js/demo/peity-demo.js"></script>

<!-- Custom and plugin javascript -->
<script src="/assets/js/inspinia.js"></script>
<script src="/assets/js/plugins/pace/pace.min.js"></script>

<!-- jQuery UI -->
<script src="/assets/js/plugins/jquery-ui/jquery-ui.min.js"></script>

<!-- GITTER -->
<script src="/assets/js/plugins/gritter/jquery.gritter.min.js"></script>

<!-- Sparkline -->
<script src="/assets/js/plugins/sparkline/jquery.sparkline.min.js"></script>

<!-- Sparkline demo data  -->
<script src="/assets/js/demo/sparkline-demo.js"></script>

<!-- ChartJS-->
<script src="/assets/js/plugins/chartJs/Chart.min.js"></script>

<!-- Toastr -->
<script src="/assets/js/plugins/toastr/toastr.min.js"></script>

@yield('scripts')
<script>
    var colours = ["#1abc9c", "#2ecc71", "#3498db", "#9b59b6", "#34495e", "#16a085", "#27ae60", "#2980b9", "#8e44ad", "#2c3e50", "#f1c40f", "#e67e22", "#e74c3c", "#95a5a6", "#f39c12", "#d35400", "#c0392b", "#bdc3c7", "#7f8c8d"];

    var name = "{{$currentUser->known_as}}",
            nameSplit = name.split(" "),
            initials = nameSplit[0].charAt(0).toUpperCase() + nameSplit[1].charAt(0).toUpperCase();

    var charIndex = initials.charCodeAt(0) - 65,
            colourIndex = charIndex % 19;

    var canvas = document.getElementById("user-icon");
    var context = canvas.getContext("2d");

    var canvasWidth = $(canvas).attr("width"),
            canvasHeight = $(canvas).attr("height"),
            canvasCssWidth = canvasWidth,
            canvasCssHeight = canvasHeight;

    if (window.devicePixelRatio) {
        $(canvas).attr("width", canvasWidth * window.devicePixelRatio);
        $(canvas).attr("height", canvasHeight * window.devicePixelRatio);
        $(canvas).css("width", canvasCssWidth);
        $(canvas).css("height", canvasCssHeight);
        context.scale(window.devicePixelRatio, window.devicePixelRatio);
    }

    context.fillStyle = colours[colourIndex];
    context.fillRect(0, 0, canvas.width, canvas.height);
    context.font = "20px Arial";
    context.textAlign = "center";
    context.fillStyle = "#FFF";
    context.fillText(initials, canvasCssWidth / 2, canvasCssHeight / 1.5);
</script>