    pdfjsLib.GlobalWorkerOptions.workerSrc = "https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js";


(async function () {
    const url = "{{ $pdfUrl }}";
    // console.log("debug url: ", url);
    // const url = window.pdfUrl;
    const pdf = await pdfjsLib.getDocument(url).promise;
    const flipbookEl = document.getElementById('flipbook');

    // console.log("dbug masuk: ", pdf);
    const firstPage = await pdf.getPage(1);
    const firstViewport = firstPage.getViewport({ scale: 1 });

    // for (let i = 1; i <= pdf.numPages; i++) {
    //     console.log("debug page ", i);
    // }
    const maxHeight = Math.max(420, window.innerHeight - 180);
    let scale = Math.min(2.0, maxHeight / firstViewport.height) * 4;

    const pageOrigWidth = firstViewport.width;
    const pageOrigHeight = firstViewport.height;

    const pageWidth = Math.round(pageOrigWidth * scale);
    const pageHeight = Math.round(pageOrigHeight * scale);

    for (let i = 1; i <= pdf.numPages; i++) {
        const pageWrapper = document.createElement('div');
        pageWrapper.className = 'page';
        pageWrapper.dataset.page = i;
        pageWrapper.dataset.rendered = '0';
        pageWrapper.style.width = pageWidth + 'px';
        pageWrapper.style.height = pageHeight + 'px';
        pageWrapper.innerHTML = '';
        flipbookEl.appendChild(pageWrapper);
    }

    if (pdf.numPages % 2 === 1) {
        const blank = document.createElement('div');
        blank.className = 'page';
        blank.dataset.page = pdf.numPages + 1;
        blank.dataset.rendered = '1';
        blank.style.width = pageWidth + 'px';
        blank.style.height = pageHeight + 'px';
        flipbookEl.appendChild(blank);
    }

    const rendered = {};
    const renderedCanvases = {};
    async function renderPage(num) {
        if (!num || num < 1 || num > pdf.numPages) return;
        if (rendered[num]) return;
        rendered[num] = true;

        const page = await pdf.getPage(num);
        // console.log("debug1: ", page);
        const viewport = page.getViewport({ scale: scale });

        const canvas = document.createElement('canvas');
        canvas.width = Math.round(viewport.width);
        canvas.height = Math.round(viewport.height);
        const ctx = canvas.getContext('2d');

        await page.render({ canvasContext: ctx, viewport: viewport }).promise;

        renderedCanvases[num] = canvas;

        const pageWrapper = flipbookEl.querySelector('.page[data-page="' + num + '"]');
        if (pageWrapper) {
            pageWrapper.innerHTML = '';
            pageWrapper.appendChild(canvas);
            pageWrapper.dataset.rendered = '1';
        }
    }

    function initTurn() {
        const viewportWidth = Math.max(320, window.innerWidth - 48);
        const wantDouble = viewportWidth >= (pageWidth * 2 + 80);
        const displayMode = wantDouble ? 'double' : 'single';
        const requiredWidth = wantDouble ? pageWidth * 2 : pageWidth;

        if ($('#flipbook').data('turn')) {
            try { $('#flipbook').turn('destroy').removeData('turn'); } catch (e) { }
        }

        $('#flipbook').css({ width: requiredWidth + 'px', height: pageHeight + 'px', transform: '' });

        $('#flipbook').turn({
            width: requiredWidth,
            height: pageHeight,
            autoCenter: true,
            display: displayMode,
            acceleration: true,
            elevation: 50,
            gradients: true
        });

        const available = Math.max(280, window.innerWidth - 48);
        const scaleX = Math.min(1, available / requiredWidth);
        if (scaleX < 1) {
            console.log('masuk sini');
            $('#flipbook').css({ transform: 'scale(' + scaleX + ')', 'transform-origin': 'top center' });
            $('#flipbook').parent().css({ height: Math.round(pageHeight * scaleX) + 'px' });
        } else {
            // console.log('masuk situ');
            $('#flipbook').parent().css({ height: '' });
        }
    }

    console.log('dbug ttl pg: ', pdf.numPages);
    console.log('turn js tes: ', typeof $.fn.turn === 'function');

    const statusEl = document.getElementById('viewer-status');
    if (typeof $.fn.turn === 'function') {
        initTurn();
        const current = $('#flipbook').turn('page') || 1;
        statusEl.textContent = 'turn.js active — page ' + current + ' / ' + pdf.numPages;

        renderPage(current);
        renderPage(current + 1);
        renderPage(current - 1);
        renderPage(current + 2);

        $('#flipbook').on('turned', function (e, page, view) {
            renderPage(page);
            renderPage(page + 1);
            renderPage(page - 1);
            renderPage(page + 2);

            // renderPage(page - 1);
            renderPage(page + 3);
            renderPage(page - 2);
            statusEl.textContent = 'page ' + page + ' / ' + pdf.numPages;
        });

    } else {
        console.warn('tes fallback');
        statusEl.textContent = 'fallback view';

        const bookWrap = document.createElement('div');
        bookWrap.className = 'book-fallback';
        const sheet = document.createElement('div');
        sheet.className = 'sheet';
        const left = document.createElement('div');
        left.className = 'leaf left';
        left.dataset.page = 1;
        const right = document.createElement('div');
        right.className = 'leaf right';
        right.dataset.page = 2;

        sheet.appendChild(left);
        sheet.appendChild(right);
        bookWrap.appendChild(sheet);

        const viewport = document.querySelector('.book-viewport');
        viewport.innerHTML = '';
        viewport.appendChild(bookWrap);

        let current = 1;

        async function showSpread(page) {
            console.log("debug page: ", page);
            if (page % 2 === 0) page = page - 1;

            current = Math.max(1, Math.min(page, pdf.numPages));
            const leftNum = current;
            const rightNum = current + 1;

            left.dataset.page = leftNum;
            right.dataset.page = rightNum;

            left.innerHTML = '';
            right.innerHTML = '';

            await renderPage(leftNum);
            await renderPage(rightNum);

            renderPage(leftNum + 2);
            renderPage(leftNum + 3);
            renderPage(leftNum - 2);

            const leftCanvas = flipbookEl.querySelector('.page[data-page="' + leftNum + '"] canvas');
            const rightCanvas = flipbookEl.querySelector('.page[data-page="' + rightNum + '"] canvas');

            if (leftCanvas || renderedCanvases[leftNum]) {
                console.log("masuk sini left");
                const src = leftCanvas || renderedCanvases[leftNum];
                const copy = document.createElement('canvas');
                copy.width = src.width;
                copy.height = src.height;
                copy.getContext('2d').drawImage(src, 0, 0);
                left.appendChild(copy);
            }
            if (rightCanvas || renderedCanvases[rightNum]) {
                // console.log("masuk sini right");
                const src = rightCanvas || renderedCanvases[rightNum];
                const copy = document.createElement('canvas');
                copy.width = src.width;
                copy.height = src.height;
                copy.getContext('2d').drawImage(src, 0, 0);
                right.appendChild(copy);
            }

            statusEl.textContent = 'page ' + leftNum + ' - ' + (rightNum <= pdf.numPages ? rightNum : '-') + ' / ' + pdf.numPages;
        }

        async function flipNext() {
            if (current + 2 > pdf.numPages + (pdf.numPages % 2 === 0 ? 0 : 1)) return;

            const rightNum = current + 1;
            const nextLeftNum = current + 2;
            const nextRightNum = current + 3;
            const srcCanvas = flipbookEl.querySelector('.page[data-page="' + rightNum + '"] canvas') || renderedCanvases[rightNum];
            if (srcCanvas) {
                const overlay = document.createElement('div');
                overlay.className = 'flip-overlay right';
                const copy = document.createElement('canvas');
                copy.width = srcCanvas.width;
                copy.height = srcCanvas.height;
                copy.getContext('2d').drawImage(srcCanvas, 0, 0);
                overlay.appendChild(copy);
                sheet.appendChild(overlay);

                requestAnimationFrame(function () { overlay.classList.add('animate', 'right'); });
                
                await renderPage(nextLeftNum);
                await renderPage(nextRightNum);
                
                current = Math.max(1, Math.min(nextLeftNum, pdf.numPages));
                left.innerHTML = '';
                right.innerHTML = '';
                left.dataset.page = current;
                right.dataset.page = current + 1;
                
                const leftCanvas = renderedCanvases[current];
                const rightCanvas = renderedCanvases[current + 1];
                if (leftCanvas) {
                    const leftCopy = document.createElement('canvas');
                    leftCopy.width = leftCanvas.width;
                    leftCopy.height = leftCanvas.height;
                    leftCopy.getContext('2d').drawImage(leftCanvas, 0, 0);
                    left.appendChild(leftCopy);
                }
                if (rightCanvas) {
                    const rightCopy = document.createElement('canvas');
                    rightCopy.width = rightCanvas.width;
                    rightCopy.height = rightCanvas.height;
                    rightCopy.getContext('2d').drawImage(rightCanvas, 0, 0);
                    right.appendChild(rightCopy);
                }
                
                statusEl.textContent = 'page ' + current + ' - ' + (current + 1 <= pdf.numPages ? current + 1 : '-') + ' / ' + pdf.numPages;
                
                // renderPage(nextLeftNum + 2);
                // renderPage(nextRightNum + 1);
                setTimeout(function () {
                    overlay.remove();

                    renderPage(nextLeftNum + 2);
                    renderPage(nextRightNum + 1);
                }, 1000);
            } else {
                // console.log("debug flaback");
                sheet.classList.add('flip-next');
                setTimeout(async function () {
                    sheet.classList.remove('flip-next');
                    await showSpread(current + 2);
                }, 700);
            }
        }

        async function flipPrev() {
            if (current - 2 < 1) return;

            const leftNum = current;
            const nextLeftNum = current - 2;
            const nextRightNum = current - 1;
            const srcCanvas = flipbookEl.querySelector('.page[data-page="' + leftNum + '"] canvas') || renderedCanvases[leftNum];
            if (srcCanvas) {
                const overlay = document.createElement('div');
                overlay.className = 'flip-overlay left';
                const copy = document.createElement('canvas');
                copy.width = srcCanvas.width;
                copy.height = srcCanvas.height;
                copy.getContext('2d').drawImage(srcCanvas, 0, 0);
                overlay.appendChild(copy);
                sheet.appendChild(overlay);
                requestAnimationFrame(function () { overlay.classList.add('animate', 'left'); });
                
                await renderPage(nextLeftNum);
                await renderPage(nextRightNum);
                
                current = Math.max(1, Math.min(nextLeftNum, pdf.numPages));
                left.innerHTML = '';
                right.innerHTML = '';
                left.dataset.page = current;
                right.dataset.page = current + 1;
                
                const leftCanvas = renderedCanvases[current];
                const rightCanvas = renderedCanvases[current + 1];
                if (leftCanvas) {
                    const leftCopy = document.createElement('canvas');
                    leftCopy.width = leftCanvas.width;
                    leftCopy.height = leftCanvas.height;
                    leftCopy.getContext('2d').drawImage(leftCanvas, 0, 0);
                    left.appendChild(leftCopy);
                }
                if (rightCanvas) {
                    const rightCopy = document.createElement('canvas');
                    rightCopy.width = rightCanvas.width;
                    rightCopy.height = rightCanvas.height;
                    rightCopy.getContext('2d').drawImage(rightCanvas, 0, 0);
                    right.appendChild(rightCopy);
                }
                
                statusEl.textContent = 'page ' + current + ' - ' + (current + 1 <= pdf.numPages ? current + 1 : '-') + ' / ' + pdf.numPages;
                
                // console.log("test don");
                setTimeout(function () {
                    overlay.remove();

                    renderPage(nextLeftNum - 2);
                    renderPage(nextLeftNum - 1);
                }, 1000);
            } else {
                sheet.classList.add('flip-prev');
                setTimeout(async function () {
                    sheet.classList.remove('flip-prev');
                    await showSpread(current - 2);
                }, 700);
            }
        }

        document.getElementById('prev').addEventListener('click', function () { flipPrev(); });
        document.getElementById('next').addEventListener('click', function () { flipNext(); });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'ArrowRight') flipNext();
            if (e.key === 'ArrowLeft') flipPrev();
        });

        await showSpread(1);
        const renderBatch = async (start, end) => {
            const promises = [];
            for (let p = start; p <= end && p <= pdf.numPages; p++) {
                promises.push(renderPage(p));
            }
            await Promise.all(promises);
        };

        (async function preRenderAll() {
            for (let batch = 2; batch <= pdf.numPages; batch += 3) {
                await renderBatch(batch, batch + 2);
            }
        })();
    }

    document.getElementById('prev').addEventListener('click', function () {
        if (typeof $.fn.turn === 'function') $('#flipbook').turn('previous');
    });

    document.getElementById('next').addEventListener('click', function () {
        if (typeof $.fn.turn === 'function') $('#flipbook').turn('next');
    });

    document.addEventListener('keydown', function (e) {
        // console.log("debug tmbol: ", e.key);

        if (typeof $.fn.turn !== 'function') return;
        if (e.key === 'ArrowRight') $('#flipbook').turn('next');
        if (e.key === 'ArrowLeft') $('#flipbook').turn('previous');
    });

    let resizeTimer = null;
    window.addEventListener('resize', function () {
        console.log("debug debounce");
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function () { initTurn(); }, 200);
    });


    
})();