/**
 * Menu.js
 * Lógica del carrito para la vista de menú del cliente.
 * Requiere: meta[name="csrf-token"] en el <head> del layout.
 */

async function actualizarCarrito() {
    const response = await fetch(window.ROUTES.carritoParcial);
    const html = await response.text();
    document.getElementById('contenido-carrito').innerHTML = html;

    // ✅ FIX: Actualizar el contador leyendo las cantidades del partial recargado
    const cantidades = document.querySelectorAll('#contenido-carrito [data-cantidad]');
    let total = 0;
    cantidades.forEach(el => total += parseInt(el.dataset.cantidad || 0));
    document.getElementById('contador-carrito').innerText = total;

    inicializarEventosCarrito();
}

function inicializarEventosCarrito() {
    document.querySelectorAll('.aumentar-form').forEach(form => {
        form.addEventListener('submit', async function (e) {
            e.preventDefault();
            await fetch('/carrito/aumentar/' + this.dataset.id, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken(),
                    'Accept': 'application/json'
                }
            });
            await actualizarCarrito();
        });
    });

    document.querySelectorAll('.disminuir-form').forEach(form => {
        form.addEventListener('submit', async function (e) {
            e.preventDefault();
            await fetch('/carrito/disminuir/' + this.dataset.id, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken(),
                    'Accept': 'application/json'
                }
            });
            await actualizarCarrito();
        });
    });

    document.querySelectorAll('.eliminar-form').forEach(form => {
        form.addEventListener('submit', async function (e) {
            e.preventDefault();
            await fetch('/carrito/eliminar/' + this.dataset.id, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken(),
                    'Accept': 'application/json'
                }
            });
            await actualizarCarrito();
        });
    });
}

function mostrarToast(mensaje, tipo = 'success') {
    const toastEl = document.getElementById('mensaje-toast');
    const toastMsg = document.getElementById('toast-mensaje');

    toastEl.className = `toast align-items-center text-white border-0 bg-${tipo}`;
    toastMsg.textContent = mensaje;

    const toast = new bootstrap.Toast(toastEl, { delay: 3000 });
    toast.show();
}

function csrfToken() {
    return document.querySelector('meta[name="csrf-token"]').content;
}

document.addEventListener('DOMContentLoaded', function () {
    actualizarCarrito();

    document.querySelectorAll('.agregar-carrito-form').forEach(form => {
        form.addEventListener('submit', async function (e) {
            e.preventDefault();
            try {
                const response = await fetch(window.ROUTES.agregarCarrito, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken(),
                        'Accept': 'application/json'
                    },
                    body: new FormData(this)
                });

                const data = await response.json();

                if (data.success) {
                    // actualizarCarrito() ya recalcula el contador, no necesitamos data.items
                    await actualizarCarrito();
                    mostrarToast(data.message, 'success');
                }
            } catch (error) {
                console.error(error);
                mostrarToast('Error al agregar producto', 'danger');
            }
        });
    });
});