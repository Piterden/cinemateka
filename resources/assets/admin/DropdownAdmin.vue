<template lang="html">
  <div class="dropdown">
    <input type="hidden" :name="inputName" :value="value">
    <input id="{{ inputName }}" type="checkbox"
      :checked="checked"
      :disabled="disabled"
    />
    <label for="{{ inputName }}">
      <div class="drop-ttl">{{ valueText }}</div>
      <ul>
        <li v-for="item in list" @click.stop="handleOptionClick(item.id)">
          {{ item.title }}
        </li>
      </ul>
    </label>
  </div>
</template>
<script>
export default {

  data() {
    return {
      checked: 'disabled' // Флаг "список открыт"
    }
  },

  props: {
    disabled: {
      default() {
        return false
      }
    },
    inputName: {
      type: String,
      default () {
        return ''
      }
    },
    // Рабочее значение
    value: {
      default () {
        return 0
      }
    },
    // Список возможных значений
    list: {
      type: Array,
      default () {
        return []
      }
    }
  },

  computed: {
    valueText() {
      let ev = this.$root.getById(this.list, this.value)
      return !this.value ? 'Выбрать' : ev && ev.title
    }
  },

  methods: {
    /**
     * Клик по элементу открытого списка
     * @param  {String} value Значение нажатого элемента
     */
    handleOptionClick(value) {
      this.$set('value', value)
    }
  }

}
</script>
<style lang="sass" scoped>
.dropdown {
  position: relative;
  display: inline-block;
  margin: 0 5px;
  width: 72.5%;
  border: 2px solid;
  color: #000;
  &:hover {
    &:after {
      border-color: red;
    }
  }
  &:focus {
    &:after {
      transform: rotate(-45deg);
    }
  }
  &:after {
    content: '';
    z-index: -1;
    width: 12px;
    height: 12px;
    position: absolute;
    top: 11px;
    right: 16px;;
    border-bottom: 2px solid black;
    border-right: 2px solid black;
    transform: rotate(45deg);
  }
  > input[type="checkbox"]:checked ~ label > ul {
    display: none;
  }
  > input {
    position: fixed;
    z-index: -2;
    display: none;
  }
  > label {
    display: inline-block;
    padding: 6px 0;
    width: 100%;
    text-transform: lowercase;
    font-weight: 400;
    font-size: 16px;
  }
  .drop-ttl {
    padding: 5px 10px;
    font-weight: 400;
  }
  ul {
    position: absolute;
    top: 100%;
    left: -2px;
    z-index: 10;
    margin: 0;
    width: 100%;
    border: 2px solid;
    background: #FFF;
    max-height: 600%;
    overflow-y: scroll;
    &:after {
      content: '';
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: -1;
    }
    > li {
      padding: 10px;
      cursor: pointer;
      > a {
        outline: 0;
        color: inherit;
        text-decoration: none;
        cursor: pointer;
      }
      &:hover {
        background: #DEDEDE;
      }
    }
  }
}
</style>
