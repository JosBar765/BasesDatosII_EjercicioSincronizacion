const badge = document.getElementById("connectionBadge");


//
// TOAST
//

function toast(icon, title) {

    Swal.fire({

        toast: true,
        position: "bottom-end",
        showConfirmButton: false,
        timer: 1000,
        timerProgressBar: true,

        icon,
        title

    });

}

//
// LIMPIAR CAMPOS
//

function limpiarCampos() {

    document.getElementById("dpi").value = "";

    document.getElementById("primer_nombre").value = "";

    document.getElementById("segundo_nombre").value = "";

    document.getElementById("primer_apellido").value = "";

    document.getElementById("segundo_apellido").value = "";

    document.getElementById("direccion").value = "";

    document.getElementById("telefono_casa").value = "";

    document.getElementById("telefono_movil").value = "";

    document.getElementById("salario_base").value = "";

    document.getElementById("bonificacion").value = "";

}


//
// VALIDACIONES
//

function camposVacios(data) {

    for (const key in data) {

        if (String(data[key]).trim() === "") {
            return true;
        }

    }

    return false;

}


function numerosInvalidos(data) {

    if (
        Number(data.telefono_casa) < 0 ||
        Number(data.telefono_movil) < 0 ||
        Number(data.salario_base) < 0 ||
        Number(data.bonificacion) < 0
    ) {

        return true;

    }

    return false;

}


function telefonosInvalidos(data) {

    const regex = /^[0-9]{8}$/;

    return (
        !regex.test(data.telefono_casa) ||
        !regex.test(data.telefono_movil)
    );

}


function dpiInvalido(dpi) {

    return !/^[0-9]{13}$/.test(dpi);

}



//
// ACTUALIZAR BADGE
//

function setConnection(name) {

    badge.classList.remove("mysql");
    badge.classList.remove("postgres");

    if (name === "mysql") {

        badge.classList.add("mysql");
        badge.innerText = "Conectado a MySQL";

    } else if (name === "postgres") {

        badge.classList.add("postgres");
        badge.innerText = "Conectado a PostgreSQL";

    } else {

        badge.innerText = "Sin conexión";

    }

}



//
// CONEXIONES
//

document.getElementById("btnMysql").addEventListener("click", async () => {

    try {

        const response = await fetch("backend/conexion/mysql.php");

        const text = await response.text();

        console.log(text);

        const result = JSON.parse(text);

        if (result.success) {

            setConnection("mysql");

            cargarEmpleados();
            limpiarCampos();

            toast(
                "success",
                result.message
            );

        } else {

            toast(
                "error",
                result.message
            );

        }

    } catch (error) {

        console.error(error);

        toast(
            "error",
            "Error conectando a MySQL"
        );

    }

});



document.getElementById("btnPostgres").addEventListener("click", async () => {

    try {

        const response = await fetch("backend/conexion/postgres.php");

        const text = await response.text();

        console.log(text);

        const result = JSON.parse(text);

        if (result.success) {

            setConnection("postgres");

            cargarEmpleados();
            limpiarCampos();

            toast(
                "success",
                result.message
            );

        } else {

            toast(
                "error",
                result.message
            );

        }

    } catch (error) {

        console.error(error);

        toast(
            "error",
            "Error conectando a PostgreSQL"
        );

    }

});



//
// SINCRONIZACIÓN
//

document.getElementById("btnSync").addEventListener("click", async () => {

    try {

        const response = await fetch("backend/sync/sincronizar.php");

        const text = await response.text();

        console.log(text);

        const result = JSON.parse(text);

        if (result.success) {

            toast(
                "success",
                "Bases de datos sincronizadas"
            );

            cargarEmpleados();
            limpiarCampos();

        } else {

            toast(
                "error",
                result.message
            );

        }

    } catch (error) {

        console.error(error);

        toast(
            "error",
            "Error al sincronizar"
        );

    }

});



//
// INSERTAR
//

document.getElementById("empleadoForm").addEventListener("submit", async (e) => {

    e.preventDefault();

    const data = {

        dpi: document.getElementById("dpi").value,
        primer_nombre: document.getElementById("primer_nombre").value,
        segundo_nombre: document.getElementById("segundo_nombre").value,
        primer_apellido: document.getElementById("primer_apellido").value,
        segundo_apellido: document.getElementById("segundo_apellido").value,
        direccion: document.getElementById("direccion").value,
        telefono_casa: document.getElementById("telefono_casa").value,
        telefono_movil: document.getElementById("telefono_movil").value,
        salario_base: document.getElementById("salario_base").value,
        bonificacion: document.getElementById("bonificacion").value

    };

    if (camposVacios(data)) {

        toast(
            "warning",
            "Todos los campos son obligatorios"
        );

        return;

    }

    if (dpiInvalido(data.dpi)) {

        toast(
            "warning",
            "El DPI debe tener 13 dígitos"
        );

        return;

    }

    if (numerosInvalidos(data)) {

        toast(
            "warning",
            "No se permiten números negativos"
        );

        return;

    }

    if (telefonosInvalidos(data)) {

        toast(
            "warning",
            "Los teléfonos deben tener 8 dígitos"
        );

        return;

    }

    try {

        const response = await fetch("backend/accion/insertar.php", {

            method: "POST",

            headers: {
                "Content-Type": "application/json"
            },

            body: JSON.stringify(data)

        });

        const text = await response.text();

        console.log(text);

        const result = JSON.parse(text);

        if (result.success) {
            cargarEmpleados();
            limpiarCampos();

            toast(
                "success",
                result.message
            );

        } else {

            toast(
                "error",
                result.message
            );

        }

    } catch (error) {

        console.error(error);

        toast(
            "error",
            "Error al insertar"
        );

    }

});



//
// ACTUALIZAR
//

document.getElementById("btnActualizar").addEventListener("click", async () => {

    const data = {

        dpi: document.getElementById("dpi").value,
        primer_nombre: document.getElementById("primer_nombre").value,
        segundo_nombre: document.getElementById("segundo_nombre").value,
        primer_apellido: document.getElementById("primer_apellido").value,
        segundo_apellido: document.getElementById("segundo_apellido").value,
        direccion: document.getElementById("direccion").value,
        telefono_casa: document.getElementById("telefono_casa").value,
        telefono_movil: document.getElementById("telefono_movil").value,
        salario_base: document.getElementById("salario_base").value,
        bonificacion: document.getElementById("bonificacion").value

    };

    if (camposVacios(data)) {

        toast(
            "warning",
            "Todos los campos son obligatorios"
        );

        return;

    }

    if (dpiInvalido(data.dpi)) {

        toast(
            "warning",
            "El DPI debe tener 13 dígitos"
        );

        return;

    }

    if (numerosInvalidos(data)) {

        toast(
            "warning",
            "No se permiten números negativos"
        );

        return;

    }

    if (telefonosInvalidos(data)) {

        toast(
            "warning",
            "Los teléfonos deben tener 8 dígitos"
        );

        return;

    }

    try {

        const response = await fetch("backend/accion/actualizar.php", {

            method: "PUT",

            headers: {
                "Content-Type": "application/json"
            },

            body: JSON.stringify(data)

        });

        const text = await response.text();

        console.log(text);

        const result = JSON.parse(text);

        if (result.success) {
            limpiarCampos();
            toast(
                "success",
                result.message
            );

            cargarEmpleados();

        } else {

            toast(
                "error",
                result.message
            );

        }

    } catch (error) {

        console.error(error);

        toast(
            "error",
            "Error al actualizar"
        );

    }

});



//
// ELIMINAR
//

document.getElementById("btnEliminar").addEventListener("click", async () => {

    const dpi = document.getElementById("dpi").value;

    if (dpi.trim() === "") {

        toast(
            "warning",
            "Debe ingresar un DPI"
        );

        return;

    }

    if (dpiInvalido(dpi)) {

        toast(
            "warning",
            "El DPI debe tener 13 dígitos"
        );

        return;

    }

    try {

        const response = await fetch("backend/accion/eliminar.php", {

            method: "DELETE",

            headers: {
                "Content-Type": "application/json"
            },

            body: JSON.stringify({ dpi })

        });

        const text = await response.text();

        console.log(text);

        const result = JSON.parse(text);

        if (result.success) {

            toast(
                "success",
                result.message
            );

            cargarEmpleados();
            limpiarCampos();

        } else {

            toast(
                "error",
                result.message
            );

        }

    } catch (error) {

        console.error(error);

        toast(
            "error",
            "Error al eliminar"
        );

    }

});

//
// DESCONECTAR AL RECARGAR
//

window.addEventListener("beforeunload", () => {

    navigator.sendBeacon(
        "backend/conexion/desconectar.php"
    );

});