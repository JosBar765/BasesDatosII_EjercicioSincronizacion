const tableBody = document.getElementById("empleadosTableBody");

const searchInput = document.getElementById("searchInput");

let empleados = [];


//
// CARGAR EMPLEADOS
//

async function cargarEmpleados() {

    try {

        const response = await fetch(
            "backend/accion/listar.php"
        );

        const result = await response.json();

        if (!result.success) {

            toast("warning", result.message);

            return;

        }

        empleados = result.data || [];

        renderTabla(empleados);

    } catch (error) {

        console.error(error);

    }

}


//
// RENDER TABLA
//

function renderTabla(data) {

    tableBody.innerHTML = "";

    data.forEach(emp => {

        const tr = document.createElement("tr");

        tr.innerHTML = `

        <td>${emp.dpi}</td>

        <td>${emp.primer_nombre} ${emp.segundo_nombre}</td>

        <td>${emp.primer_apellido} ${emp.segundo_apellido}</td>

        <td>${emp.telefono_movil}</td>

        <td>Q${emp.salario_base}</td>

    `;

        tr.addEventListener("click", () => {

            document.getElementById("dpi").value = emp.dpi;
            document.getElementById("dpi").disabled = true;

            document.getElementById("primer_nombre").value = emp.primer_nombre;

            document.getElementById("segundo_nombre").value = emp.segundo_nombre;

            document.getElementById("primer_apellido").value = emp.primer_apellido;

            document.getElementById("segundo_apellido").value = emp.segundo_apellido;

            document.getElementById("direccion").value = emp.direccion;

            document.getElementById("telefono_casa").value = emp.telefono_casa;

            document.getElementById("telefono_movil").value = emp.telefono_movil;

            document.getElementById("salario_base").value = emp.salario_base;

            document.getElementById("bonificacion").value = emp.bonificacion;

        });

        tableBody.appendChild(tr);

    });

}


//
// BUSCADOR
//

searchInput.addEventListener("input", () => {

    const value = searchInput.value
        .toLowerCase()
        .trim();

    const filtrados = empleados.filter(emp => {

        const dpi = String(emp.dpi || "")
            .toLowerCase();

        const nombre = String(emp.primer_nombre || "")
            .toLowerCase();

        const apellido = String(emp.primer_apellido || "")
            .toLowerCase();

        return (

            dpi.includes(value) ||
            nombre.includes(value) ||
            apellido.includes(value)

        );

    });

    renderTabla(filtrados);

});
