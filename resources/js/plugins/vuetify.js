
import Vue from 'vue'
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'
import '@mdi/font/css/materialdesignicons.css' 
import 'material-design-icons-iconfont/dist/material-design-icons.css'
import colors from 'vuetify/lib/util/colors'
//  import '@fortawesome/fontawesome-free/css/all.css' 
Vue.use(Vuetify)

export default new Vuetify({ 
  icons: {
      iconfont: 'mdi' || 'mdiSvg' || 'md' || 'fa' 
    },
    theme: {
      themes: {
        light: {
          primary: colors.red.darken4,
          secondary: colors.grey.darken1,
          accent: colors.shades.black,
          error: colors.red.accent3,
        },
      },
    },
})