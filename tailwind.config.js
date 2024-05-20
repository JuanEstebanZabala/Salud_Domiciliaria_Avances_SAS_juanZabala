/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/views/app.blade.php",
  "./resources/app.js",
  "./resources/js/modules/auth/login/login.vue","./resources/js/modules/menu/menu.vue",
  "./resources/js/components/layout.vue","./resources/js/modules/inicio/tablaHistorias.vue"
  ,"./resources/js/modules/configuracion/configuracion.vue"],
  theme: {
    extend: {},
  },
  plugins: [],
}

