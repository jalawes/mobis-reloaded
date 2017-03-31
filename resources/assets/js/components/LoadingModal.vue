<template>
<div class="modal" v-if="this.loading">
  <div class="modal-background"></div>
  <div class="modal-content">
    <span><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></span>
  </div>
  <button class="modal-close"></button>
</div>
</template>

<script>
export default {
    name: 'LoadingModal',
    props: {
        loading: {
            type: Boolean,
            required: true
        }
    }
}
</script>
