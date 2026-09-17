

import Alpine from 'alpinejs';
import intersect from '@alpinejs/intersect';

Alpine.plugin(intersect);
window.Alpine = Alpine;

// Chart.js is only needed by the admin dashboard. Keep it out of the shared
// public/admin bundle and load its split chunk only on pages that render charts.
window.__rkChartReady = document.getElementById('activityChart')
    ? import('chart.js/auto').then(({ default: Chart }) => {
        window.Chart = Chart;
        return Chart;
    })
    : Promise.resolve(null);

Alpine.start();
