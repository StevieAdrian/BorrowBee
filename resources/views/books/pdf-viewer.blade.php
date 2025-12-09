<!DOCTYPE html>
<html>
<head>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
    <script>
        pdfjsLib.GlobalWorkerOptions.workerSrc =
            "https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js";
    </script>

    <style>
        body {
            margin: 0;
            background: #f2f2f2;
        }

        #viewer {
            width: 100%;
            height: 100vh;
            overflow-y: scroll;
            padding: 20px;
            box-sizing: border-box;
        }

        canvas {
            display: block;
            margin: 0 auto 20px auto;
            background: white;
            box-shadow: 0 0 8px rgba(0,0,0,.2);
        }
    </style>
</head>
<body>

<div id="viewer"></div>

<script>
    async function renderPDF(url) {
        const pdf = await pdfjsLib.getDocument(url).promise;
        const viewer = document.getElementById('viewer');

        for (let i = 1; i <= pdf.numPages; i++) {
            const page = await pdf.getPage(i);
            const viewport = page.getViewport({ scale: 1.2 });

            const canvas = document.createElement("canvas");
            const context = canvas.getContext("2d");

            canvas.width = viewport.width;
            canvas.height = viewport.height;

            viewer.appendChild(canvas);

            await page.render({
                canvasContext: context,
                viewport: viewport
            }).promise;
        }
    }
    renderPDF("{{ $pdfUrl }}");
</script>

</body>
</html>
