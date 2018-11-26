<template>
  <router-link :to="url" class="nav-link" @click.native="changeCategories(id)">
    <i :class="icon"></i> {{name}}
    <b-badge :variant="badge.variant">{{badge.text}}</b-badge>
  </router-link>
</template>

<script>
    import EventBus from '../bus'
export default {
  name: 'sidebar-nav-link',
    methods: {
        changeCategories() {
            //console.log(this.id);
            EventBus.$emit('changeCategories', this.id);
        }
    },
  props: {
    name: {
      type: String,
      default: ''
    },
    url: {
      type: String,
      default: ''
    },
    icon: {
      type: String,
      default: ''
    },
    badge: {
      default: ''
    },
    id: {
        type: Number,
    }
  }
}
</script>
