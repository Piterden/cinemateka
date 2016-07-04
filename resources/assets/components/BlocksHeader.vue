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
/**
 * VueJS Component
 * Компонент шапки для блока на странице
 * Содержит заголовок блока и слот для доп HTML (например фильтров)
 */
export default {

  props: {
    // Заголовок блока
    title: {
      type: String,
      required: true
    }
  }

}
</script>
