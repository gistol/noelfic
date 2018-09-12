import Vue from "vue";
import moment from "moment"
import vueMoment from "vue-moment";
import fr from '../../translations/messages.fr.json'
import en from '../../translations/messages.en.json'

import VueI18n from "vue-i18n";

const locale = window.location.pathname.split('/').filter(Boolean).shift()
moment.locale(locale)
moment.defaultFormat = 'LLL'

Vue.use(VueI18n)
Vue.use(vueMoment, {moment});

export default new VueI18n({
    locale: locale,
    fallbackLocale: 'en',
    messages: Object.assign(fr, en)
})

// import(`../../translations/messages.${locale}.json`).then(messages => {
//     i18n.setLocaleMessage(locale, messages)
// })