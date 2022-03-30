
import "./bootstrap";
import { createApp } from 'vue';


import RepositoryAffect from './components/RepositoryAffect.vue';
import InitRepository from './pages/InitRepository.vue';
import ShowAudio from "./components/ShowAudio";
import EditAudio from "./components/EditAudio";
import UploadDownload from "./components/UploadDownload";

import 'xe-utils';
import VXETable from 'vxe-table';
import 'vxe-table/lib/style.css';
import './helper.js';

import { ZiggyVue } from 'ziggy';
import { Ziggy } from './ziggy';

// import vSelect from 'vue-select';
// import 'vue-select/dist/vue-select.css';


VXETable.setup({
    icon: {
        // table
        // TABLE_SORT_ASC: 'vxe-icon--caret-top',
        TABLE_SORT_ASC: 'fa fa-caret-up',
        // TABLE_SORT_DESC: 'vxe-icon--caret-bottom',
        TABLE_SORT_DESC: 'fa fa-caret-down',

        //   TABLE_FILTER_NONE: 'vxe-icon--funnel',
        TABLE_FILTER_NONE: 'fa fa-filter',
        //   TABLE_FILTER_MATCH: 'vxe-icon--funnel',
        TABLE_FILTER_MATCH: 'fa fa-filter',
        //   TABLE_EDIT: 'vxe-icon--edit-outline',
        TABLE_EDIT: 'fa fa-edit',
        TABLE_TREE_LOADED: 'vxe-icon--refresh roll',
        TABLE_TREE_OPEN: 'vxe-icon--caret-right rotate90',
        TABLE_TREE_CLOSE: 'vxe-icon--caret-right',
        TABLE_EXPAND_LOADED: 'vxe-icon--refresh roll',
        TABLE_EXPAND_OPEN: 'vxe-icon--arrow-right rotate90',
        TABLE_EXPAND_CLOSE: 'vxe-icon--arrow-right',

        TABLE_QUESTION: 'fas fa-question-circle',

        // button
        BUTTON_DROPDOWN: 'vxe-icon--arrow-bottom',
        BUTTON_LOADING: 'vxe-icon--refresh roll',

        // select
        SELECT_OPEN: 'vxe-icon--caret-bottom rotate180',
        SELECT_CLOSE: 'vxe-icon--caret-bottom',

        // pager
        PAGER_JUMP_PREV: 'vxe-icon--d-arrow-left',
        PAGER_JUMP_NEXT: 'vxe-icon--d-arrow-right',
        PAGER_PREV_PAGE: 'vxe-icon--arrow-left',
        PAGER_NEXT_PAGE: 'vxe-icon--arrow-right',
        PAGER_JUMP_MORE: 'vxe-icon--more',

        // input
        INPUT_CLEAR: 'vxe-icon--close',
        INPUT_PWD: 'vxe-icon--eye-slash',
        INPUT_SHOW_PWD: 'vxe-icon--eye',
        INPUT_PREV_NUM: 'vxe-icon--caret-top',
        INPUT_NEXT_NUM: 'vxe-icon--caret-bottom',
        INPUT_DATE: 'vxe-icon--calendar',
        INPUT_SEARCH: 'vxe-icon--search',

        // modal
        MODAL_ZOOM_IN: 'vxe-icon--square',
        MODAL_ZOOM_OUT: 'vxe-icon--zoomout',
        MODAL_CLOSE: 'vxe-icon--close',
        MODAL_INFO: 'vxe-icon--info',
        MODAL_SUCCESS: 'vxe-icon--success',
        // MODAL_WARNING: 'vxe-icon--warning',
        MODAL_WARNING: 'fas fa-exclamation-circle',
        MODAL_ERROR: 'vxe-icon--error',
        // MODAL_QUESTION: 'vxe-icon--question',
        MODAL_QUESTION: 'fas fa-question-circle',
        MODAL_LOADING: 'vxe-icon--refresh roll',

        // toolbar
        // TOOLBAR_TOOLS_REFRESH: 'vxe-icon--refresh',
        TOOLBAR_TOOLS_REFRESH: 'fas fa-sync-alt',
        TOOLBAR_TOOLS_REFRESH_LOADING: 'vxe-icon--refresh roll',
        TOOLBAR_TOOLS_IMPORT: 'vxe-icon--upload',
        TOOLBAR_TOOLS_EXPORT: 'vxe-icon--download',
        TOOLBAR_TOOLS_ZOOM_IN: 'vxe-icon--zoomin',
        TOOLBAR_TOOLS_ZOOM_OUT: 'vxe-icon--zoomout',
        TOOLBAR_TOOLS_CUSTOM: 'vxe-icon--menu',

        // form
        FORM_PREFIX: 'vxe-icon--info',
        FORM_SUFFIX: 'vxe-icon--info',
        FORM_FOLDING: 'vxe-icon--arrow-top rotate180',
        FORM_UNFOLDING: 'vxe-icon--arrow-top'
    }
})

function useTable(app) {
    app.use(VXETable)

    // 给 vue 实例挂载内部对象，例如：
    // app.config.globalProperties.$XModal = VXETable.modal
    // app.config.globalProperties.$XPrint = VXETable.print
    // app.config.globalProperties.$XSaveFile = VXETable.saveFile
    // app.config.globalProperties.$XReadFile = VXETable.readFile
}

createApp({
    components: {
        InitRepository,
        RepositoryAffect,
        ShowAudio,
        EditAudio,
        UploadDownload,
        // vSelect,
    }
})
    .use(useTable)
    .use(ZiggyVue, Ziggy)
    .mount("#app")
