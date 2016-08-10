import moment from 'moment'

let d = moment()

export default {

  archive: {
    event_type: 'Все события',
    month: d.month(),
    year: d.year(),
    program: 'Все программы'
  },

  schedule: {
    event_type: 'Все события',
    month: 'Все месяцы',
    program_type: 'Все программы',
    place_type: 'Все площадки'
  }

}

