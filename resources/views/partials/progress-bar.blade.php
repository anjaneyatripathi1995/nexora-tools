<div id="page-progress" class="page-progress" aria-hidden="true">
    <div class="page-progress__bar"></div>
</div>

<style>
    .page-progress {
        position: fixed;
        inset: 0 0 auto 0;
        height: 3px;
        width: 100%;
        z-index: 1200;
        pointer-events: none;
        opacity: 0;
        transition: opacity 0.25s ease;
    }
    .page-progress.is-active {
        opacity: 1;
    }
    .page-progress__bar {
        height: 100%;
        width: 0;
        background: linear-gradient(90deg, #10b981, #3b82f6);
        box-shadow: 0 0 12px rgba(59, 130, 246, 0.45);
        transition: width 0.25s ease;
    }
</style>

<script>
    (function () {
        const wrap = document.getElementById('page-progress');
        const bar = wrap ? wrap.querySelector('.page-progress__bar') : null;
        if (!wrap || !bar) return;

        let timer;

        function setWidth(val) {
            bar.style.width = val + '%';
        }

        function startProgress() {
            clearInterval(timer);
            wrap.classList.add('is-active');
            setWidth(8);
            requestAnimationFrame(() => setWidth(55));

            timer = setInterval(() => {
                const current = parseFloat(bar.style.width) || 0;
                setWidth(Math.min(current + (8 + Math.random() * 10), 92));
            }, 600);
        }

        function endProgress() {
            clearInterval(timer);
            if (!wrap.classList.contains('is-active')) return;
            setWidth(100);
            setTimeout(() => {
                wrap.classList.remove('is-active');
                setWidth(0);
            }, 250);
        }

        function shouldIgnoreLink(link) {
            if (!link) return true;
            const href = link.getAttribute('href') || '';
            return (
                link.target === '_blank' ||
                link.hasAttribute('download') ||
                href.startsWith('#') ||
                href.startsWith('mailto:') ||
                href.startsWith('tel:') ||
                href.startsWith('javascript:')
            );
        }

        document.addEventListener('readystatechange', () => {
            if (document.readyState === 'interactive') startProgress();
            if (document.readyState === 'complete') endProgress();
        });

        window.addEventListener('beforeunload', startProgress);
        window.addEventListener('pageshow', endProgress);
        window.addEventListener('load', endProgress);

        document.addEventListener('click', (e) => {
            const link = e.target.closest('a');
            if (!link || shouldIgnoreLink(link)) return;
            if (e.metaKey || e.ctrlKey || e.shiftKey || e.altKey || e.button !== 0) return;
            startProgress();
        });
    })();
</script>
