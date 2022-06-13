import axios from 'axios'

export default {
  namespaced: true,
  state: {
    datosForm: {
      modelo: '',
      nombre: '',
      email: '',
      celular: '',
      departamento: '',
      ciudad: '',
      tratamiento: '',
      disabled: false
    },
    modelos: [],
    departamentos: [],
    ciudades: [],
    tipoMensaje: 'success',
    mensaje: ''
  },
  mutations: {
    setModelos (state, payload) {
      state.modelos = payload
    },
    setDepartamentos (state, payload) {
      state.departamentos = payload
    },
    setCiudades (state, payload) {
      state.ciudades = payload
    },
    setTipoMensaje (state, payload) {
      state.tipoMensaje = payload
    },
    setMensaje (state, payload) {
      state.mensaje = payload
    },
    limpiarDatosFormulario (state) {
      state.datosForm = {
        modelo: '',
        nombre: '',
        email: '',
        celular: '',
        departamento: '',
        ciudad: '',
        tratamiento: '',
        disabled: false
      }
    },
    setEstadoBoton (state, payload) {
      state.datosForm.disabled = payload
    }
  },
  actions: {
    async getModelos ({ commit }) {
      try {
        const url = process.env.VUE_APP_BACKEND_SERVER + '/modelos'
        const data = await axios.get(url)
        commit('setModelos', data.data)
      } catch (error) {
        commit('setModelos', [])
        console.log('Error in getModelos', error)
      }
    },
    async getDepartamentos ({ commit }) {
      try {
        const url = process.env.VUE_APP_BACKEND_SERVER + '/departamentos'
        const data = await axios.get(url)
        commit('setDepartamentos', data.data)
      } catch (error) {
        commit('setDepartamentos', [])
        console.log('Error in getDepartamentos', error)
      }
    },
    async getCiudades ({ commit }, departamento_id) {
      try {
        const url = process.env.VUE_APP_BACKEND_SERVER + '/ciudades/departamento/' + departamento_id
        const data = await axios.get(url)
        commit('setCiudades', data.data)
      } catch (error) {
        commit('setCiudades', [])
        console.log('Error in getCiudades', error)
      }
    },
    async setCotizacion ({ commit }, payload) {
      try {
        const url = process.env.VUE_APP_BACKEND_SERVER + '/cotizaciones'
        await axios.post(url, payload).then((data) => {
          commit('setTipoMensaje', data.data.tipo)
          commit('setMensaje', data.data.mensaje)
          commit('setEstadoBoton', false)
          if (data.data.tipo == 'success') {
            commit('limpiarDatosFormulario')
          }
        }).catch((err) => {
          let msj = ''
          let tipoMsj = 'error'
          if(typeof err.request.response !== 'undefined'){
            const obj = JSON.parse(err.request.response)
            msj = obj.mensaje
            tipoMsj = obj.tipo
          }
          commit('setTipoMensaje', tipoMsj)
          commit('setMensaje', msj)
          commit('setEstadoBoton', false)
        })
      } catch (error) {
        commit('setTipoMensaje', 'error')
        commit('setMensaje', '')
        commit('setEstadoBoton', false)
        console.log('Error in setCotizacion', error)
      }
    },
    setMensaje({ commit }, payload) {
      commit('setMensaje', payload)
    }
  }
}
