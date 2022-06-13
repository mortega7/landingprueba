<template>
    <div class="container-fluid">
        <div class="row justify-content-center fila-form">
            <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-xs-12">
                <div class="d-flex align-items-center justify-content-center">
                    <img class="mt-3" src="../assets/logo_ssangyong.png">
                </div>
            </div>
            <div class="col-xl-1 col-lg-1 col-md-12 col-sm-12 col-xs-12"></div>
            <div class="col-xl-4 col-lg-7 col-md-12 col-sm-12 col-xs-12">
                <div class="bg-light contenedor-form">
                    <form class="row" @submit.prevent="enviarForm">
                        <p class="titulo-form fw-bold">¡Cotiza la tuya!</p>
                        <div v-if="mensaje" class="alert alert-dismissible fade show alert-form" :class="[tipoMensaje == 'success' ? 'alert-success' : tipoMensaje == 'warning' ? 'alert-warning' : 'alert-danger']" @click="cerrarMensaje()">
                            {{ mensaje }}
                            <button type="button" class="btn-close"></button>
                        </div>
                        <div class="col-md-12 mt-2">
                            <label for="modelo" class="form-label">Selecciona un modelo</label>
                            <select v-model="datosForm.modelo" class="form-select campo-form">
                                <option v-for="mod in modelos" :key="mod.id" v-bind:value="mod.nombre">
                                    {{ mod.nombre }}
                                </option>
                            </select>
                            <div v-if="errores.modelo" class="text-danger error-form">{{ errores.modelo }}</div>
                        </div>
                        <div class="col-md-12 mt-2">
                            <label for="nombre" class="form-label">Nombre completo</label>
                            <input type="text" class="form-control campo-form" maxlength="200" v-model="datosForm.nombre" />
                            <div v-if="errores.nombre" class="text-danger error-form">{{ errores.nombre }}</div>
                        </div>
                        <div class="col-md-12 mt-2">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control campo-form" maxlength="200" v-model="datosForm.email" />
                            <div v-if="errores.email" class="text-danger error-form">{{ errores.email }}</div>
                        </div>
                        <div class="col-md-12 mt-2">
                            <label for="celular" class="form-label">Teléfono</label>
                            <input type="number" class="form-control campo-form" maxlength="10" min="0" v-model="datosForm.celular" />
                            <div v-if="errores.celular" class="text-danger error-form">{{ errores.celular }}</div>
                        </div>
                        <div class="col-md-6 mt-2">
                            <label for="departamento" class="form-label">Departamento</label>
                            <select v-model="datosForm.departamento" class="form-select campo-form" @change="changeDepartamento()">
                                <option v-for="dpto in departamentos" :key="dpto.id" v-bind:value="dpto.id">
                                    {{ dpto.nombre }}
                                </option>
                            </select>
                            <div v-if="errores.departamento" class="text-danger error-form">{{ errores.departamento }}</div>
                        </div>
                        <div class="col-md-6 mt-2">
                            <label for="ciudad" class="form-label">Ciudad</label>
                            <select v-model="datosForm.ciudad" class="form-select campo-form">
                                <option v-for="ciu in ciudades" :key="ciu.id" v-bind:value="ciu.id">
                                    {{ ciu.nombre }}
                                </option>
                            </select>
                            <div v-if="errores.ciudad" class="text-danger error-form">{{ errores.ciudad }}</div>
                        </div>
                        <div class="col-md-12 mt-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" v-model="datosForm.tratamiento" />
                                <label class="form-check-label tratamiento-form" for="tratamiento" @click="toggleTratamiento()">Acepto la política de <a class="enlace-form" href="http://google.com" target="_blank">Tratamiento de Datos Personales</a></label>
                            </div>
                            <div v-if="errores.tratamiento" class="text-danger error-form">{{ errores.tratamiento }}</div>
                        </div>
                        <div class="col-md-12 mt-4">
                            <button type="submit" class="btn btn-dark boton-form" :disabled="datosForm.disabled">Enviar datos</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapState, mapActions } from 'vuex'

export default {
    data () {
        return {
            valido: true,
            errores: {}
        }
    },
    mounted () {
        this.getModelos()
        this.getDepartamentos()
    },
    computed: {
        ...mapState('moduleForm', ['datosForm', 'modelos', 'departamentos', 'ciudades', 'tipoMensaje', 'mensaje'])
    },
    methods: {
        ...mapActions('moduleForm', ['getModelos', 'getDepartamentos', 'getCiudades', 'setCotizacion', 'setMensaje']),
        changeDepartamento: function() {
            this.getCiudades(this.datosForm.departamento)
        },
        enviarForm() {
            this.errores = {}
            
            const valModelo = validarObligatorio(this.datosForm.modelo)
            const valNombre = validarNombre(this.datosForm.nombre)
            const valEmail = validarEmail(this.datosForm.email)
            const valCelular = validarCelular(this.datosForm.celular)
            const valDepartamento = validarObligatorio(this.datosForm.departamento)
            const valCiudad = validarObligatorio(this.datosForm.ciudad)
            const valTratamiento = validarObligatorio(this.datosForm.tratamiento)

            this.valido = valModelo.valido && valNombre.valido && valEmail.valido && valCelular.valido && valDepartamento.valido && valCiudad.valido && valTratamiento.valido

            if (this.valido) {
                this.datosForm.disabled = true
                const cotizacion = {
                    modelo: this.datosForm.modelo,
                    nombre_cliente: this.datosForm.nombre,
                    email: this.datosForm.email,
                    celular: this.datosForm.celular,
                    ciudad_id: this.datosForm.ciudad
                }

                this.setCotizacion(cotizacion)
            } else {
                this.errores = {
                    modelo: valModelo.error,
                    nombre: valNombre.error,
                    email: valEmail.error,
                    celular: valCelular.error,
                    departamento: valDepartamento.error,
                    ciudad: valCiudad.error,
                    tratamiento: valTratamiento.error
                }
            }
        },
        toggleTratamiento() {
            this.datosForm.tratamiento = this.datosForm.tratamiento == '' ? true : ''
        },
        cerrarMensaje() {
            this.setMensaje('')
        }
    }
}

const validarObligatorio = (valor) => {
  if (valor == "") {
    return { valido: false, error: "Este campo es obligatorio." }
  }
  return { valido: true, error: null }
}

const validarNombre = (valor) => {
  if (valor == "") {
    return { valido: false, error: 'Este campo es obligatorio.' }
  }
  if (valor.length < 3) {
    return { valido: false, error: 'Por favor ingrese el nombre completo.' }
  }
  return { valido: true, error: null }
}

const validarEmail = (valor) => {
  if (valor == "") {
    return { valido: false, error: "Este campo es obligatorio." }
  }
  if (!valor.match(/^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/)) {
    return { valido: false, error: "Por favor ingrese un correo electrónico válido." }
  }
  return { valido: true, error: null }
}

const validarCelular = (valor) => {
  if (valor.toString() == "") {
    return { valido: false, error: 'Este campo es obligatorio.' }
  }
  if (valor < 0) {
    return { valido: false, error: 'Por favor ingrese un valor numérico válido.' }
  }
  if (valor.toString().length < 7 || valor.toString().length > 10) {
    return { valido: false, error: 'Por favor ingrese un valor numérico entre 7 y 10 dígitos.' }
  }
  return { valido: true, error: null }
}
</script>

<style scoped>
.fila-form {
    margin-top: 40px;
    background: url('../assets/fondo.png') 50% 0% no-repeat;
}
.titulo-form {
    font-size: 30pt;
}
.contenedor-form {
    margin: 20px 30px;
    padding: 30px 40px;
    -webkit-border-radius: 20px;
    -moz-border-radius: 20px;
    border-radius: 20px;
}
.campo-form {
    border: 1px solid #CDCDCD;
    -webkit-border-radius: 20px;
    -moz-border-radius: 20px;
    border-radius: 20px;
}
.boton-form {
    -webkit-border-radius: 20px;
    -moz-border-radius: 20px;
    border-radius: 20px;
    padding: 8px 24px;
    font-weight: bold;
}
.enlace-form {
    text-decoration: none;
}
.tratamiento-form {
    font-size: 11pt;
}
.error-form {
    font-size: 9pt;
}
@media (max-width: 1268px) {
    .fila-form {
        margin-top: 0px;
    }
    .titulo-form {
        font-size: 20pt;
    }
    .contenedor-form {
        margin: 10px 30px;
        padding: 20px 40px;
    }
    .alert-form, .form-label, .campo-form {
        font-size: 10pt;
    }
    .tratamiento-form {
        font-size: 10pt;
    }
    .error-form {
        font-size: 8pt;
    }
    .boton-form {
        font-size: 10pt;
        padding: 4px 12px;
    }
}
</style>