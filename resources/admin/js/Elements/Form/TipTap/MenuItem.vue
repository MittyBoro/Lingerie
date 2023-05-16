<template>
  <div
    class="menu-item"
    :class="[
      { 'is-active': isActive ? isActive() : null, disabled: disabled },
      classes,
    ]"
    @click="action"
    :title="title"
  >
    <Icon :icon="icon" />
  </div>
</template>

<script>
  export default {
    props: {
      icon: {
        type: String,
        required: true,
      },
      classes: {
        type: String,
      },

      title: {
        type: String,
        required: true,
      },

      action: {
        type: Function,
        required: true,
      },

      disabled: {
        type: Boolean,
        default: false,
      },

      isActive: {
        type: Function,
        default: null,
      },
    },

    data() {
      return {}
    },
  }
</script>
