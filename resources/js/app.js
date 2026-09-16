

import Alpine from 'alpinejs';
import intersect from '@alpinejs/intersect';
import Chart from 'chart.js/auto';

Alpine.plugin(intersect);
window.Alpine = Alpine;
window.Chart = Chart;

Alpine.start();
