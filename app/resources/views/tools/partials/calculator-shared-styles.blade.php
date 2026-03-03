@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.min.css">
<style>
/* Shared calculator styles (derived from EMI design) */
.calc-calc-wrap { max-width: 100%; }
.emi-calc-wrap, .sip-calc-wrap, .calc-calc-wrap { max-width: 100%; }
.emi-slider-group, .sip-slider-group, .gst-slider-group, .age-slider-group, .mtd-slider-group { margin-bottom: 1.5rem; }
.emi-slider-group label, .sip-slider-group label, .gst-slider-group label, .age-slider-group label, .mtd-slider-group label { font-weight: 600; color: #374151; margin-bottom: 0.5rem; display: block; }
.emi-value-box, .sip-value-box, .gst-value-box, .age-value-box, .mtd-value-box {
    display: inline-block;
    min-width: 4.5rem;
    padding: 0.3rem 0.45rem;
    background: #dbeafe;
    border: 1px solid #93c5fd;
    border-radius: 8px;
    font-weight: 600;
    color: #1e40af;
    text-align: right;
}
.emi-slider, .sip-slider, .gst-slider, .age-slider, .mtd-slider {
    -webkit-appearance: none;
    width: 100%;
    height: 12px;
    border-radius: 6px;
    background: linear-gradient(to right, #2563eb 0%, #2563eb var(--progress, 0%), #e5e7eb var(--progress, 0%), #e5e7eb 100%);
    outline: none;
}
.emi-slider-labels, .sip-slider-labels, .gst-slider-labels, .age-slider-labels, .mtd-slider-labels {
    position: absolute;
    top: 100%;
    width: 100%;
    font-size: 0.75rem;
    color: #64748b;
    margin-top: 0.25rem;
}
.emi-slider-labels .emi-min-label, .emi-slider-labels .emi-max-label,
.sip-slider-labels .sip-min-label, .sip-slider-labels .sip-max-label { user-select: none; }
.emi-slider::-moz-range-progress, .sip-slider::-moz-range-progress { height: 12px; border-radius: 6px; background: #2563eb; }
.emi-slider::-webkit-slider-thumb, .sip-slider::-webkit-slider-thumb {
    -webkit-appearance: none;
    width: 26px;
    height: 26px;
    border-radius: 50%;
    background: #2563eb;
    cursor: pointer;
    box-shadow: 0 2px 4px rgba(37,99,235,0.4);
}
.emi-summary-card, .sip-summary-card, .gst-summary-card, .age-summary-card, .mtd-summary-card {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 0.6rem 0.75rem;
    margin-bottom: 0.75rem;
}
#calcSummary, #emiSummary, #sipSummary, #gstSummary, #fdSummary, #rdSummary {
    display: flex;
    flex-wrap: wrap;
    gap: 0.75rem;
    justify-content: flex-start;
    align-items: center;
    overflow-x: visible;
}
.emi-summary-card, .sip-summary-card { flex: 1 1 20%; min-width: 8rem; margin-bottom: 0; }
.emi-summary-card .label, .sip-summary-card .label { font-size: 0.875rem; color: #64748b; margin-bottom: 0.25rem; }
.emi-summary-card .value, .sip-summary-card .value { font-size: 1.25rem; font-weight: 700; color: #0f172a; }
.emi-legend-item, .sip-legend-item { display: inline-flex; align-items: center; gap: 0.5rem; margin-right: 1rem; font-size: 0.875rem; color: #475569; }
.emi-legend-dot, .sip-legend-dot { width: 12px; height: 12px; border-radius: 2px; }
.emi-amort-header, .calc-amort-header { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 0.5rem; margin-bottom: 1rem; }
.emi-year-row { padding: 0.45rem 0.6rem; border: 1px solid #e2e8f0; border-radius: 8px; margin-bottom: 0.3rem; background: #fff; cursor: pointer; display: flex; align-items: center; justify-content: space-between; gap: 0.3rem; transition: background 0.2s; }
.emi-year-row:hover { background: #f8fafc; }
.emi-year-row.expanded { border-color: #2563eb; background: #eff6ff; }
.emi-year-detail { margin-bottom: 0.5rem; overflow-x: auto; }
.emi-amort-table { width: 100%; font-size: 0.875rem; border-collapse: collapse; margin-top: 0.5rem; }
.emi-amort-table th { text-align: left; padding: 0.3rem 0.45rem; color: #64748b; font-weight: 600; border-bottom: 1px solid #e2e8f0; }
.emi-amort-table td { padding: 0.3rem 0.45rem; border-bottom: 0.6px solid #f1f5f9; }
.emi-amort-table tr:nth-child(even) td { background: #f8fafc; }
.emi-load-more { margin-top: 1rem; }
/* EMI: doughnut & bar charts side by side with doughnut on left and bar on right */
.emi-charts-row {
    display: flex;
    justify-content: space-between; /* push charts to opposite sides */
    align-items: center;
    gap: 1rem;
    margin-bottom: 0.5rem;
}
.emi-doughnut-wrap {
    flex-shrink: 0;
    width: 45%;
    max-width: 160px;
}
.emi-bar-wrap {
    flex: 1;
    width: 45%;
    height: 120px;
    max-width: none;
}
.emi-doughnut-wrap {
    flex-shrink: 0;
    width: 140px;
    height: 140px;
    position: relative;
}
.emi-doughnut-wrap canvas {
    width: 140px !important;
    height: 140px !important;
    max-width: 140px;
    max-height: 140px;
}
.emi-bar-wrap {
    flex: 1;
    min-width: 200px;
    height: 120px;
}
.emi-bar-wrap canvas {
    width: 100% !important;
    height: 120px !important;
}
.emi-doughnut-wrap #emiDonutChart { width: 140px; height: 140px; max-width: 140px; }
#calcDonutChart { max-height: 280px; max-width: 140px; height: auto; }
</style>
@endpush
