import moment from 'moment'

let d = moment(),

  archive = {
    event_type: 'Все события',
    month: d.month(),
    year: d.year(),
    program: 'Все программы'
  },

  schedule = {
    event_type: 'Все события',
    month: 'Все месяцы',
    program_type: 'Все программы',
    place_type: 'Все площадки'
  },

  state = { archive, schedule },

  action = (store) => {
    /**
     * The store callback pass some value
     * @param {Mixed} arg -> passing new data
     * @param {Object} old -> still bring the old state
     * The old state will be readable, you can use it if neccessary
     */
    store.on('archive:update_filter', function(arg) {
      store.get().archive.set(arg)
    })
    store.on('schedule:update_filter', function(arg/*, old*/) {
      store.get().schedule.set(arg)
    })
  }



export default {
  state,
  action,
}
