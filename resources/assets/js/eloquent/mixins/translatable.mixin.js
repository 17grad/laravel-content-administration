
import Bus from './../../common/event.bus'
import EloquentCollection from './../collection'
import EloquentModel from './../model'
import store from './../../store'

let TranslatableMixin = Base => class extends Base
{
    constructor(config)
    {
        let proxy = super(config)

        if(proxy.constructor == EloquentCollection) {
            return
        }

        this.translatable = config.translatable
        this.translation = null
        this.translations = null

        let self = this
        Bus.$on('languageChanged', () => {
            self.setCurrentLanguageAttributes()
        })

        this.setAttributes(this.attributes)
    }

    setAttributes(attributes)
    {
        // like parent::setAttributes in PHP
        EloquentModel.prototype.setAttributes.call(this, attributes)

        this.setLanguageAttributes()

        this.setOriginalAttributes()
    }

    setLanguageAttributes()
    {

        if(!this.translatable) {
            return
        }

        if('translation' in this.attributes) {
            this.translation = this.attributes.translation
            delete this.attributes.translation
        } else {
            return
        }

        if('translations' in this.attributes) {
            this.translations = this.attributes.translations
            delete this.attributes.translations
        }

        for(let i=0;i<store.state.config.languages.length;i++) {

            let locale = store.state.config.languages[i]

            this.attributes[locale] = this.translation[locale]
        }

        this.setCurrentLanguageAttributes()
    }

    setCurrentLanguageAttributes() {
        if(!(store.state.config.language in this.attributes)) {
            return
        }

        for(let key in this.attributes[store.state.config.language]) {
            this.attributes[key] = this.attributes[store.state.config.language][key]
        }
    }

};

export default TranslatableMixin