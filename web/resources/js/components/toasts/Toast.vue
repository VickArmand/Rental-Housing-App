<template>
  <div class="toast" data-bs-delay="10000">
    <div class="toast-header">
      {{ title }}
      <button class="btn-close" data-bs-dismiss="toast"></button>
    </div>
    <div class="toast-body">{{ message }}</div>
  </div>
</template>
<script>
export default {
  name: "ToastComponent",
  data() {
    return {};
  },
  // props: [title, message],
  props: {
    title: String,
    message: String,
  },
};
</script>
