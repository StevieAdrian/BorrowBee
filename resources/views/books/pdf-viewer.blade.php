<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/turn.js/4.1.0/turn.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
    <script>
        pdfjsLib.GlobalWorkerOptions.workerSrc = "https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js";
    </script>
    <link rel="stylesheet" href="{{ asset('css/pdfViewer.css') }}">
</head>
<body>
    <div class="viewer-wrap">
        <div id="viewer-status" style="position:fixed;top:12px;right:12px;background:rgba(0,0,0,0.6);color:#fff;padding:8px 10px;border-radius:6px;font-size:12px;z-index:9999">Loading...</div>
        <div class="book-viewport">
            <div id="flipbook"></div>
        </div>

        <div class="controls">
            <span id="prev" class="btn">‹ Prev</span>
            <span id="next" class="btn">Next ›</span>
        </div>
    </div>

    <script>
        window.pdfUrl = "{{ $pdfUrl }}";
    </script>
    <script src="{{ asset('js/pdfViewer.js') }}"></script>
</body>
</html>
