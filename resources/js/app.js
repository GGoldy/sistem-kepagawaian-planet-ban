// AdminLTE Core
import 'admin-lte/dist/css/adminlte.min.css';
import 'admin-lte/dist/js/adminlte.min.js';

// Bootstrap 5
import 'bootstrap/dist/js/bootstrap.bundle.min.js';

// jQuery (needed globally)
import 'admin-lte/plugins/jquery/jquery.min.js';
import './bootstrap';
import $ from 'jquery';
window.$ = window.jQuery = $;

// Leaflet & OverlayScrollbars
import 'leaflet/dist/leaflet.js';
import 'admin-lte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js';

// ✅ DataTables with Bootstrap 5 + Export Buttons
import 'datatables.net-bs5';
import 'datatables.net-buttons-bs5';

// Export Buttons functionality
import 'datatables.net-buttons/js/buttons.html5.min.js';
import 'datatables.net-buttons/js/buttons.print.min.js';

// Dependencies for export
import JSZip from 'jszip';
window.JSZip = JSZip;

import pdfMake from 'pdfmake/build/pdfmake';
import * as pdfFonts from 'pdfmake/build/vfs_fonts';

pdfMake.vfs = pdfFonts.vfs;

// ✅ CSS Imports (Bootstrap 5 versions for DataTables)
import 'datatables.net-bs5/css/dataTables.bootstrap5.min.css';
import 'datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css';

import 'admin-lte/plugins/icheck-bootstrap/icheck-bootstrap.min.css';
import 'admin-lte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css';
import 'leaflet/dist/leaflet.css';

// Vite asset support
import.meta.glob(["../images/**"]);
