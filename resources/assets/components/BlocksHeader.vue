<style lang="css" scoped>

.blocks-header {

}
.blocks-header {
  border-bottom: 2px solid #000;
  width: 100%;
  margin: -6px 2px 0;
}
.block-title {
  margin: 49px -3px -25px;
}
h3 {
  font-size: 20px;
}

</style>

<template>

<div class="mdl-grid blocks-header">
  <!-- <div class="inner-wrapper"> -->
    <div class="mdl-cell mdl-cell--6-col block-title">
      <h2>{{ title }}</h2>
    </div>
    <div class="mdl-cell mdl-cell--6-col block-tabs">
      <slot></slot>
    </div>
  <!-- </div> -->
</div>

</template>

<script type="text/ecmascript-6">

export default {
  name: 'blocks-header',
  props: {
    title: {
      type: String,
      required: true
    }
  }
}

</script>
