<template>
  <div v-if="url != ''">
    <router-link :to="url" class="nav-link" v-bind="$attrs">
      <div
        class="icon icon-shape icon-sm text-center d-flex align-items-center justify-content-center"
      >
        <slot name="icon"></slot>
      </div>
      <span
        @click="action"
        class="nav-link-text"
        :class="'ms-1'"
        >{{ navText }}</span
      >
    </router-link>
  </div>
  <div v-else>
    <div class="nav-link">
      <div
        class="icon icon-shape icon-sm text-center d-flex align-items-center justify-content-center"
      >
        <slot name="icon"></slot>
      </div>
      <v-btn variant="plain" v-on:click="action">
        <span
          class="nav-link-text"
          :class="'ms-1'"
          >{{ navText }}</span
        >
      </v-btn>
    </div>
  </div>
</template>
<script>
export default {
  name: "sidenav-item",
  props: {
    url: {
      type: String,
      required: false,
      default:''
    },
    navText: {
      type: String,
      required: true
    }
  },
  methods: {
    action(){
      this.$emit('action');
    }
  },
};
</script>
