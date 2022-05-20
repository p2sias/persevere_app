import Vue from 'vue'
import '@mdi/font/css/materialdesignicons.min.css'

import Vuetify, {
    VDataTable,
    VSlider,
    VContent,
    VProgressCircular,
    VMain,
    VSpacer,
    VApp,
    VCard,
    VCardText,
    VCardTitle,
    VCardActions,
    VForm,
    VTextField,
    VTextarea,
    VBtn,
    VAppBar,
    VAppBarNavIcon,
    VContainer,
    VNavigationDrawer,
    VDivider,
    VList,
    VListItem,
    VListItemIcon,
    VListItemTitle,
    VListItemGroup,
    VIcon,
    VListItemAvatar,
    VImg,
    VListItemContent,
    VListItemSubtitle,
    VListItemAction,
    VToolbar,
    VToolbarTitle,
    VMenu,
    VSimpleTable,
    VPagination,
    VSelect,
    VSwitch,
    VProgressLinear,
    VFlex,
    VLayout,
    VCheckbox,
    VExpansionPanels,
    VExpansionPanel,
    VExpansionPanelHeader,
    VExpansionPanelContent,
    VDialog,
    VAlert,
    VRadio,
    VRadioGroup,
    VCombobox,
    VAutocomplete,
    VTabs,
    VTab,
    VTabItem,
    VTabsItems,
    VTabsSlider,
    VCol,
    VRow,
    VListGroup,
    VSnackbar,
    VFileInput,
    VAvatar,
    VDatePicker,
    VFooter,
    VToolbarItems,
} from "vuetify/lib"

Vue.use(Vuetify, {
    components: {
        VDataTable,
        VToolbarItems,
        VFooter,
        VDatePicker,
        VAvatar,
        VFileInput,
        VSlider,
        VContent,
        VProgressCircular,
        VMain,
        VSpacer,
        VApp,
        VDialog,
        VAlert,
        VListGroup,
        VCol,
        VRow,
        VTabs,
        VTab,
        VTabItem,
        VTabsItems,
        VTabsSlider,
        VRadio,
        VAutocomplete,
        VCombobox,
        VRadioGroup,
        VExpansionPanels,
        VExpansionPanel,
        VExpansionPanelHeader,
        VExpansionPanelContent,
        VLayout,
        VFlex,
        VCheckbox,
        VCard,
        VCardText,
        VCardTitle,
        VCardActions,
        VForm,
        VTextField,
        VTextarea,
        VBtn,
        VAppBar,
        VAppBarNavIcon,
        VContainer,
        VNavigationDrawer,
        VDivider,
        VList,
        VListItem,
        VListItemIcon,
        VListItemTitle,
        VListItemGroup,
        VIcon,
        VListItemAvatar,
        VImg,
        VListItemContent,
        VListItemSubtitle,
        VListItemAction,
        VToolbar,
        VToolbarTitle,
        VMenu,
        VSimpleTable,
        VPagination,
        VSelect,
        VSwitch,
        VProgressLinear,
        VSnackbar
    }
})

export default new Vuetify({
    icons: {
        iconfont: 'mdi'
    },
    theme: {
        dark: false,
    },
    themes: {
        light: {
            primary: "#ed4b3f",
            secondary: "#b0bec5",
            accent: "#8c9eff",
            error: "#b71c1c",
        },
    },
})