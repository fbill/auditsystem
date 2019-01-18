<template>
  <div class="app">
    <AppHeader/>
    <div class="app-body">
      <Sidebar :navItems="nav"/>
      <main class="main">
        <!--<breadcrumb :list="list"/>-->
        <div class="container-fluid">
          <router-view></router-view>
        </div>
      </main>
      <AppAside/>
    </div>
    <AppFooter/>
  </div>
</template>

<script>
import nav from '../_nav'
import { HeaderTop as AppHeader, Sidebar, AsideApp as AppAside, FooterApp as AppFooter, Breadcrumb } from '../components/'

export default {
  name: 'full',
  components: {
    AppHeader,
    Sidebar,
    AppAside,
    AppFooter,
    Breadcrumb
  },
  data() {
    return {
      nav: [],
      study_id:17,
    }
  },
  mounted(){
    this.getMenus()
  },
  methods:{
        getMenus(){
            let urlCombo = '/api/getMenus/' + this.study_id ;
            axios.get(urlCombo)
                .then((response) => {
                    this.nav = response.data
                    //console.log(this.nav)
                })
                .catch((response) => {
                    console.log('Error', error);
                })
        },

    },
  computed: {
    name () {
      return  this.$route.name
    },
    list () {
      return this.$route.matched
    }
  }
}
</script>
