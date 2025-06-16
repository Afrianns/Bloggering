import axios from "axios";
window.axios = axios;

// window.Swal = require("sweetalert2");

window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
