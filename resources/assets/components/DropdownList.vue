<template lang="html">
  <div class="dropdown">
    <input id="{{ inputId }}" type="checkbox" checked />
    <label for="{{ inputId }}" @click.stop="doOpen">
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
    }

    // Флаг "список открыт"
    // checked: {
    //   type: String,
    //   default () {
    //     return 'disabled'
    //   }
    // }
  },

  computed: {
    // Состояние
    opened() {
      return !this.$el.querySelector('#' + this.inputId).checked
    },
    // Проверка на фильтр месяцев
    isMonth() {
      return this.inputId === 'month'
    },
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
    }
  },

  methods: {
    /**
     * Клик по элементу открытого списка
     * @param  {String} value Значение нажатого элемента
     */
    handleOptionClick(value) {
      // this.$el.querySelector('#' + this.inputId).setAttribute('checked', 'checked')
      if (this.isMonth) {
        this.$set('textValue', value)
        this.$set('value', this.list.indexOf(value))
        return
      }
      this.$set('value', value)
      this.$set('opened', false)
    },

    doOpen() {
      // this.$el.querySelector('#' + this.inputId).removeAttribute('checked')
      this.$set('opened', true)
    },
    handleClick() {
      /* eslint-disable no-console */
      console.log()
      /* eslint-enable no-console */
      // let dd = false
      if (this.$get('opened')) {
        this.$el.querySelector('#' + this.inputId).setAttribute('checked', 'checked')
        this.$set('opened', false)
        // dd = e.path.find((el) => {
        //   return el.class == 'dropdown'
        // })
      }
    }
  },

  ready() {
    this.$root.$el.removeEventListener('click', this.handleClick)
    this.$root.$el.addEventListener('click', this.handleClick)
  }

}
</script>
<style lang="sass">
.dropdown ul {
  overflow-y: auto;
}
</style>
