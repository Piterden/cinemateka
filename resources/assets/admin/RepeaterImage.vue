<template>
  <ul class="repeater-wrap">
    <li v-for="item in sorted" :id="item.key" v-if="item.val !== undefined">
      <label>{{ item.key | capitalize }}</label>
      <input type="text"
        v-model="item.val"
        class="form-control"
        :id="uniqueId(item.key)"
        disabled>
      <img v-show="item.val" :src="'/' + item.val" style="width:260px">
      <div class="btn-group" role="group" aria-label="..." style="margin-top: 3px;">
        <button type="button"
          class="btn btn-default"
          @click.prevent="openElFinder(item.key)"
        ><i class="fa fa-cloud-upload"></i>
        <span v-if="item.val">Изменить файл</span>
        <span v-else>Добавить файл</span>
        </button>
        <button type="button"
          class="btn btn-default"
          @click.prevent="clearField(item.key)"
        ><i class="fa fa-eraser"></i> Очистить
        <button class="btn btn-error"
          @click.prevent="deleteItem(item.key, $index)">
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
      type: Object,
      default: {}
    },
    oldFun: Function,
  },

  computed: {
    size() {
      return this.sorted.length
    },
    sorted() {
      return this.getSorted(this.strValue)
    }
  },

  methods: {
    uniqueId(key) {
      return this.fieldName + '-' + key + '-filemanager'
    },
    addItem() {
      let name = this.fieldName,
        size = this.size,
        key = name + size
      if (!size) key = 'main' + name.substring(0, name.length - 1)
      this.$set('strValue.' + key, '')
      this.openElFinder(key)
    },
    openElFinder(key) {
      let unique = this.fieldName + '-' + key + '-filemanager',
        url = '/admin/elfinder/popup/',
        oldFun = window.processSelectedFile
      window.$.colorbox({
        href: url + unique,
        fastIframe: true,
        iframe: true,
        width: '70%',
        height: '70%'
      })
      window.processSelectedFile = (path) => {
        this.addValueToItem(key, path, oldFun)
      }
    },
    addValueToItem(key, path, oldFun) {
      this.$set('strValue.' + key, path)
      window.processSelectedFile = oldFun
      return
    },
    clearField(key) {
      this.$set('strValue.' + key, '')
    },
    deleteItem(key) {
      this.$set('strValue.' + key, undefined)
      this.$set('size', this.size--)
    },
    getSorted(obj) {
      let arr = [], key
      for (key in obj) {
        if (obj.hasOwnProperty(key) && obj[key] !== undefined) {
          arr.push({
            key: key,
            val: obj[key]
          })
        }
      }
      return arr
    }
  }
}
</script>
<style lang="css" scoped>
</style>
