<template>
  <ul class="repeater-wrap">
    <li v-for="item in strValue" :id="$key" v-if="item !== undefined">
      <label>{{ $key | capitalize }}</label>
      <input type="text"
        v-model="item"
        class="form-control"
      >
      <div class="btn-group"
        role="group"
        aria-label="..."
        style="margin-top: 3px;"
      >
        <button type="button"
          class="btn btn-default"
          @click.prevent="clearField($key)"
        ><i class="fa fa-eraser"></i> Очистить
        <button class="btn btn-error"
          @click.prevent="deleteItem($key)">
          Удалить <i class="fa fa-times"></i>
        </button>
        </button>
      </div>
    </li>
    <button class="btn btn-success" @click.prevent="addItem()">
      Добавить <i class="fa fa-plus"></i>
    </button>
    <input class="form-control"
      :name="fieldName"
      v-model="strValue"
      type="hidden">
  </ul>
</template>
<script>
export default {

  props: {
    fieldName: {
      type: String,
      default: ''
    },
    strValue: {
      type: Array,
      default: []
    },
    oldFun: Function,
  },

  methods: {
    addItem() {
      let name = this.fieldName,
        size = this.size,
        key = name + size
      if (!size) key = 'main' + name.substring(0, name.length - 1)
      this.$set('strValue.' + key, '')
    },
    clearField(key) {
      this.$set('strValue.' + key, '')
    },
    deleteItem(key) {
      this.strValue.$remove(key)
    }
  }
}
</script>
<style lang="css" scoped>
</style>
