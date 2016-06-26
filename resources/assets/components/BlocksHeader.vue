<style lang="css" scoped>
</style>

<template>

<div class="mdl-grid blocks-header">
  <div class="mdl-cell mdl-cell--6-col block-title">
    <h2>{{ title }}</h2>
  </div>
  <div class="mdl-cell mdl-cell--6-col block-title block-tabs">
    <slot></slot>
  </div>
</div>

</template>

<script>

export default {

  props: {
    /**
     * Заголовок
     */
    title: {
      type: String,
      required: true
    }
  }

};

</script>
