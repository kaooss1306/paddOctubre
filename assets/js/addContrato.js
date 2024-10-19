document.addEventListener('DOMContentLoaded', function() {
    const btnAddContrato = document.getElementById('btn-add-contrato');
    const formAddContrato = document.getElementById('form-add-contrato');
    const selectCliente = document.getElementById('IdCliente');
    const selectProducto = document.getElementById('idProducto');
    const selectProveedor = document.getElementById('IdProveedor');
    const selectMedio = document.getElementById('IdMedios');
    const inputValorNeto = document.getElementById('ValorNeto');
    const inputValorBruto = document.getElementById('ValorBruto');
    const inputDescuento = document.getElementById('Descuento1');
    const inputValorTotal = document.getElementById('ValorTotal');
    const inputNumContrato = document.getElementById('num_contrato');

    if (btnAddContrato) {
        btnAddContrato.addEventListener('click', function(event) {
            event.preventDefault();
            if (formAddContrato.checkValidity()) {
                submitForm();
            } else {
                formAddContrato.reportValidity();
            }
        });
    } else {
        console.error("Error: No se pudo encontrar el botón de añadir contrato");
    }

    // Agregar un event listener para cuando se abra el modal
    $('#modalAddContrato').on('show.bs.modal', function (e) {
        getNextContractNumber();
    });

    if (selectCliente) {
        selectCliente.addEventListener('change', function() {
            cargarProductoCliente(this.value);
        });
    }

    if (selectProveedor) {
        selectProveedor.addEventListener('change', function() {
            filtrarMediosProveedor(this.value);
        });
    }

    if (inputValorNeto) {
        inputValorNeto.addEventListener('input', calcularValores);
    } else {
        console.error("Error: No se pudo encontrar el input de Valor Neto");
    }

    if (inputDescuento) {
        inputDescuento.addEventListener('input', calcularValores);
    } else {
        console.error("Error: No se pudo encontrar el input de Descuento");
    }

    function calcularValores() {
        const valorNeto = parseFloat(inputValorNeto.value) || 0;
        const valorBruto = Math.round(valorNeto * 1.19);
        const descuento = parseFloat(inputDescuento.value) || 0;
        const valorTotal = Math.max(0, valorBruto - descuento);

        inputValorBruto.value = valorBruto;
        inputValorTotal.value = valorTotal;
    }

    function getNextContractNumber() {
        fetch("https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Contratos?select=num_contrato&order=num_contrato.desc&limit=1", {
            headers: {
                "apikey": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImVreWp4emp3aHhvdHBkZnpjcGZxIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MjAyNzEwOTMsImV4cCI6MjAzNTg0NzA5M30.Vh4XAp1X6eJlEtqNNzYIoIuTPEweat14VQc9-InHhXc",
                "Authorization": "Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImVreWp4emp3aHhvdHBkZnpjcGZxIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MjAyNzEwOTMsImV4cCI6MjAzNTg0NzA5M30.Vh4XAp1X6eJlEtqNNzYIoIuTPEweat14VQc9-InHhXc"
            }
        })
        .then(response => response.json())
        .then(data => {
            let nextNumber = 1;
            if (data.length > 0 && data[0].num_contrato) {
                nextNumber = parseInt(data[0].num_contrato) + 1;
            }
            inputNumContrato.value = nextNumber;
        })
        .catch(error => {
            console.error("Error al obtener el siguiente número de contrato:", error);
            inputNumContrato.value = 1; // Valor por defecto en caso de error
        });
    }

    function cargarProductoCliente(idCliente) {
        if (!selectProducto) {
            console.error("Error: El elemento select de productos no está disponible");
            return;
        }
        selectProducto.innerHTML = '<option value="">Cargando productos del cliente...</option>';

        if (!idCliente) {
            selectProducto.innerHTML = '<option value="">Seleccione un cliente primero</option>';
            return;
        }

        fetch(`https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Productos?Id_Cliente=eq.${idCliente}&select=*`, {
            headers: {
                "apikey": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImVreWp4emp3aHhvdHBkZnpjcGZxIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MjAyNzEwOTMsImV4cCI6MjAzNTg0NzA5M30.Vh4XAp1X6eJlEtqNNzYIoIuTPEweat14VQc9-InHhXc",
                "Authorization": "Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImVreWp4emp3aHhvdHBkZnpjcGZxIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MjAyNzEwOTMsImV4cCI6MjAzNTg0NzA5M30.Vh4XAp1X6eJlEtqNNzYIoIuTPEweat14VQc9-InHhXc"
            }
        })
        .then(response => response.json())
        .then(productos => {
            selectProducto.innerHTML = '';

            if (productos.length > 0) {
                productos.forEach(producto => {
                    const option = document.createElement('option');
                    option.value = producto.NombreDelProducto;
                    option.textContent = producto.NombreDelProducto;
                    selectProducto.appendChild(option);
                });
                
                selectProducto.value = productos[0].NombreDelProducto;
                selectProducto.dispatchEvent(new Event('change'));
            } else {
                const option = document.createElement('option');
                option.value = "";
                option.textContent = "No hay productos para este cliente";
                selectProducto.appendChild(option);
            }
        })
        .catch(error => {
            console.error("Error al cargar productos:", error);
            selectProducto.innerHTML = '<option value="">Error al cargar productos</option>';
        });
    }

    function filtrarMediosProveedor(idProveedor) {
        if (!selectMedio) {
            console.error("Error: El elemento select de medios no está disponible");
            return;
        }
        
        selectMedio.innerHTML = '<option value="">Cargando medios del proveedor...</option>';
        selectMedio.disabled = true;

        if (!idProveedor) {
            selectMedio.innerHTML = '<option value="">Seleccione un proveedor primero</option>';
            selectMedio.disabled = false;
            return;
        }

        fetch(`https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/proveedor_medios?id_proveedor=eq.${idProveedor}&select=id_medio`, {
            headers: {
                "apikey": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImVreWp4emp3aHhvdHBkZnpjcGZxIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MjAyNzEwOTMsImV4cCI6MjAzNTg0NzA5M30.Vh4XAp1X6eJlEtqNNzYIoIuTPEweat14VQc9-InHhXc",
                "Authorization": "Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImVreWp4emp3aHhvdHBkZnpjcGZxIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MjAyNzEwOTMsImV4cCI6MjAzNTg0NzA5M30.Vh4XAp1X6eJlEtqNNzYIoIuTPEweat14VQc9-InHhXc"
            }
        })
        .then(response => response.json())
        .then(relaciones => {
            if (relaciones.length > 0) {
                const idMedios = relaciones.map(rel => rel.id_medio);
                return fetch(`https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Medios?id=in.(${idMedios.join(',')})&select=*`, {
                    headers: {
                        "apikey": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImVreWp4emp3aHhvdHBkZnpjcGZxIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MjAyNzEwOTMsImV4cCI6MjAzNTg0NzA5M30.Vh4XAp1X6eJlEtqNNzYIoIuTPEweat14VQc9-InHhXc",
                        "Authorization": "Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImVreWp4emp3aHhvdHBkZnpjcGZxIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MjAyNzEwOTMsImV4cCI6MjAzNTg0NzA5M30.Vh4XAp1X6eJlEtqNNzYIoIuTPEweat14VQc9-InHhXc"
                    }
                });
            } else {
                throw new Error("No hay medios asociados a este proveedor");
            }
        })
        .then(response => response.json())
        .then(medios => {
            selectMedio.innerHTML = '';
            if (medios.length > 0) {
                medios.forEach(medio => {
                    const option = document.createElement('option');
                    option.value = medio.id; // Cambiado de NombredelMedio a id
                    option.textContent = medio.NombredelMedio;
                    selectMedio.appendChild(option);
                });
                selectMedio.value = medios[0].id; // Cambiado de NombredelMedio a id
                selectMedio.dispatchEvent(new Event('change'));
            } else {
                const option = document.createElement('option');
                option.value = "";
                option.textContent = "No hay medios disponibles para este proveedor";
                selectMedio.appendChild(option);
            }
            selectMedio.disabled = false;
        })
        .catch(error => {
            console.error("Error al cargar medios:", error);
            selectMedio.innerHTML = '<option value="">Error al cargar medios</option>';
            selectMedio.disabled = false;
        });
    }

    function getFormData() {
        const formData = new FormData(formAddContrato);
        const dataObject = {};
        formData.forEach((value, key) => {
            if (key === 'Estado') {
                dataObject[key] = value === "1";
            } else if (['IdCliente', 'IdProveedor', 'id_FormadePago', 'ValorNeto', 'ValorBruto', 'Descuento1', 'ValorTotal', 'IdMedios', 'id_Mes', 'id_Anio', 'IdTipoDePublicidad', 'id_GeneraracionOrdenTipo', 'num_contrato'].includes(key)) {
                dataObject[key] = value !== "" ? parseInt(value, 10) : null;
            } else if (key === 'idProducto') {
                dataObject['nombreProducto'] = value;
            } else {
                dataObject[key] = value;
            }
        });
        return dataObject;
    }
    function submitForm() {
        let bodyContent = JSON.stringify(getFormData());
        console.log("Datos a enviar:", bodyContent);

        let headersList = {
            "Content-Type": "application/json",
            "apikey": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImVreWp4emp3aHhvdHBkZnpjcGZxIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MjAyNzEwOTMsImV4cCI6MjAzNTg0NzA5M30.Vh4XAp1X6eJlEtqNNzYIoIuTPEweat14VQc9-InHhXc",
            "Authorization": "Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImVreWp4emp3aHhvdHBkZnpjcGZxIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MjAyNzEwOTMsImV4cCI6MjAzNTg0NzA5M30.Vh4XAp1X6eJlEtqNNzYIoIuTPEweat14VQc9-InHhXc",
            "Prefer": "return=representation"
        };

        fetch("https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Contratos", {
            method: "POST",
            body: bodyContent,
            headers: headersList
        })
        .then(response => {
            console.log("Status:", response.status);
            console.log("Status Text:", response.statusText);
            return response.text().then(text => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}, body: ${text}`);
                }
                return text;
            });
        })
        .then(data => {
            console.log("Respuesta del servidor:", data);
            if (data) {
                try {
                    let jsonData = JSON.parse(data);
                    console.log("Contrato agregado correctamente:", jsonData);
                    Swal.fire({
                        title: '¡Éxito!',
                        text: 'El contrato ha sido agregado correctamente.',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.reload();
                        }
                    });
                    const modal = bootstrap.Modal.getInstance(document.getElementById('modalAddContrato'));
                    modal.hide();
                } catch (e) {
                    console.error("Error al procesar la respuesta JSON:", e);
                    throw new Error(`Respuesta no válida: ${data}`);
                }
            } else {
                throw new Error("La respuesta del servidor está vacía");
            }
        })
        .catch(error => {
            console.error("Error al agregar el contrato:", error);
            Swal.fire({
                title: 'Error',
                text: `Hubo un problema al agregar el contrato: ${error.message}`,
                icon: 'error',
                confirmButtonText: 'OK'
            });
        });
    }
});