<template lang="html">
  <div class="dropdown">
    <input id="{{ inputId }}" type="checkbox" :checked="checked" />
    <label for="{{ inputId }}">
      <div v-if="isMonth" class="drop-ttl month">{{ textValue }}</div>
      <div v-else class="drop-ttl no-month">{{ value }}</div>
      <ul>
        <li v-for="item in list" @click.stop="handleOptionClick(item)">
          {{ item }}
        </li>
      </ul>
    </label>
  </div>
</template>
<script>
export default {

  props: {
    // ID фильтра
    inputId: {
      type: String,
      default () {
        return ''
      }
    },
    // Рабочее значение
    value: {
      default () {
        return 'Выбрать'
      }
    },
    // Список возможных значений
    list: {
      type: Array,
      default () {
        return []
      }
    },
    // Флаг "список открыт"
    checked: {
      type: String,
      default () {
        return 'disabled'
      }
    }
  },

  computed: {
    // Значение для подмены номера месяца на слово
    textValue: {
      get() {
        if (!this.isMonth) {
          return this.value
        }
        if (typeof this.value === 'string') {
          this.$set('value', this.list.indexOf(this.value))
        }
        return this.list[this.value]
      },
      set(v) {
        this.$set('value', this.list.indexOf(v))
      }
    },
    // Проверка на фильтр месяцев
    isMonth() {
      return this.inputId === 'month'
    }
  },

  methods: {
    /**
     * Клик по элементу открытого списка
     * @param  {String} value Значение нажатого элемента
     */
    handleOptionClick(value) {
      if (this.isMonth) {
        this.$set('textValue', value)
        this.$set('value', this.list.indexOf(value))
        return
      }
      this.$set('value', value)
    },

    // handleClick() {
      // let checked = document.querySelector('input[type="checkbox"]:not(:checked)')
      // if (checked) {
      //   checked.checked = 'checked'
      // }
    // }
  },

  ready() {
    // this.$el.removeEventListener('click', this.handleClick)
    // this.$el.addEventListener('click', this.handleClick)
  }

}
</script>
<style lang="css">
</style>
