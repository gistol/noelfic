<template>
  <div class="sidebar" :data-color="activeColor" :data-image="backgroundImage" :style="sidebarStyle">
    <div class="logo text-center">
      <a v-if="imgLogo" href="#" class="simple-text logo-mini">
        <div class="logo-img">
            <img :src="imgLogo" alt="">
        </div>
      </a>
      <a :href="$routing.generate('homepage')" class="simple-text logo-normal">
        {{title}}
      </a>
    </div>
    <div class="sidebar-wrapper">
      <slot name="content"></slot>
      <md-list class="nav">
        <slot>
          <sidebar-link v-for="(link,index) in sidebarLinks"
                        :active="link.active"
                        :href="link.path"
                        :key="link.name + index"
                        :to="link.path"
                        :link="link">
          </sidebar-link>
        </slot>
      </md-list>
      <footer v-if="$slots.footer" class="navigation-footer text-center">
        <slot name="footer"></slot>
      </footer>
    </div>
  </div>
</template>
<script>
import SidebarLink from './SidebarLink.vue'

export default{
  components: {
    SidebarLink,
  },
  props: {
    footerContent: {
        type: String,
        default: ''
    },
    title: {
      type: String,
      default: 'Vue MD'
    },
    backgroundImage: {
      type: String,
      default: 'https://demos.creative-tim.com/vue-material-dashboard/img/sidebar-2.32103624.jpg'
    },
    imgLogo: {
      type: String,
      default: ''
    },
    activeColor: {
      type: String,
      default: 'green',
      validator: (value) => {
        let acceptedValues = ['', 'purple', 'blue', 'green', 'orange', 'red']
        return acceptedValues.indexOf(value) !== -1
      }
    },
    sidebarLinks: {
      type: Array,
      default: () => []
    },
    autoClose: {
      type: Boolean,
      default: true
    }
  },
  provide () {
    return {
      autoClose: this.autoClose
    }
  },
  computed: {
    sidebarStyle () {
      return {
        backgroundImage: `url(${this.backgroundImage})`
      }
    }
  }
}
</script>
<style lang="scss">
  .navigation-footer {
    position: absolute;
    width: 100%;
    bottom: 10px;
    color: whitesmoke;
  }
  @include breakpoint(mobile){
    .nav-mobile-menu{
      display: none;
    }
  }
</style>
