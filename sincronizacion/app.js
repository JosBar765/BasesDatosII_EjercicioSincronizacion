//
// CONEXIONES
//

document.getElementById("btnMysql").addEventListener("click", async () => {

    await fetch("backend/conexion/mysql.php");

});

document.getElementById("btnPostgres").addEventListener("click", async () => {

    await fetch("backend/conexion/postgres.php");

});


//
// SINCRONIZACIÓN
//

document.getElementById("btnSync").addEventListener("click", async () => {

    await fetch("backend/sync/sincronizar.php");

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

    await fetch("backend/accion/insertar.php", {

        method: "POST",

        headers: {
            "Content-Type": "application/json"
        },

        body: JSON.stringify(data)

    });

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

    await fetch("backend/accion/actualizar.php", {

        method: "PUT",

        headers: {
            "Content-Type": "application/json"
        },

        body: JSON.stringify(data)

    });

});


//
// ELIMINAR
//

document.getElementById("btnEliminar").addEventListener("click", async () => {

    const dpi = document.getElementById("dpi").value;

    await fetch("backend/accion/eliminar.php", {

        method: "DELETE",

        headers: {
            "Content-Type": "application/json"
        },

        body: JSON.stringify({ dpi })

    });

});