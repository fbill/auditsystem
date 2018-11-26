<template>
    <div class="app">
        <AppHeader/>
        <div class="app-body">
            <Sidebar :navItems="nav"/>
            <main class="main">
                <breadcrumb :list="list"/>
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
    import {
        HeaderTop as AppHeader,
        Sidebar,
        AsideApp as AppAside,
        FooterApp as AppFooter,
        Breadcrumb
    } from '../components/'

    export default {
        name: 'full',
        components: {
            AppHeader,
            Sidebar,
            AppAside,
            AppFooter,
            Breadcrumb
        },
        data () {
            return {
                nav: nav.items
            }
        },
        computed: {
            name () {
                return this.$route.name
            },
            list () {
                return this.$route.matched
            }
        }
    }
</script>
