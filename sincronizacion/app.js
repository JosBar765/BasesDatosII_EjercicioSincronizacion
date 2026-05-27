const badge = document.getElementById("connectionBadge");


//
// TOAST
//

function toast(icon, title) {

    Swal.fire({

        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 2500,
        timerProgressBar: true,

        icon,
        title

    });

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

        const result = await response.json();

        if (result.success) {

            setConnection("mysql");

            toast(
                "success",
                "Conexión exitosa a MySQL"
            );

        }

    } catch (error) {

        toast(
            "error",
            "Error conectando a MySQL"
        );

    }

});



document.getElementById("btnPostgres").addEventListener("click", async () => {

    try {

        const response = await fetch("backend/conexion/postgres.php");

        const result = await response.json();

        if (result.success) {

            setConnection("postgres");

            toast(
                "success",
                "Conexión exitosa a PostgreSQL"
            );

        }

    } catch (error) {

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

        const result = await response.json();

        if (result.success) {

            toast(
                "success",
                "Bases de datos sincronizadas"
            );

        }

    } catch (error) {

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

    try {

        const response = await fetch("backend/accion/insertar.php", {

            method: "POST",

            headers: {
                "Content-Type": "application/json"
            },

            body: JSON.stringify(data)

        });

        const result = await response.json();

        if (result.success) {

            toast(
                "success",
                "Empleado insertado y bitácora actualizada"
            );

        }

    } catch (error) {

        toast(
            "error",
            "Error al insertar"
        );

        console.error(error);

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

    try {

        const response = await fetch("backend/accion/actualizar.php", {

            method: "PUT",

            headers: {
                "Content-Type": "application/json"
            },

            body: JSON.stringify(data)

        });

        const result = await response.json();

        if (result.success) {

            toast(
                "success",
                "Empleado actualizado y bitácora actualizada"
            );

        }

    } catch (error) {

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

    try {

        const response = await fetch("backend/accion/eliminar.php", {

            method: "DELETE",

            headers: {
                "Content-Type": "application/json"
            },

            body: JSON.stringify({ dpi })

        });

        const result = await response.json();

        if (result.success) {

            toast(
                "success",
                "Empleado eliminado y bitácora actualizada"
            );

        }

    } catch (error) {

        toast(
            "error",
            "Error al eliminar"
        );

    }

});