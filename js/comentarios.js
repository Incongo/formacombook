document.addEventListener('DOMContentLoaded', () => {

    // Nuevo comentario
    const formComentario = document.getElementById('form-comentario');
    if (formComentario) {
        formComentario.addEventListener('submit', async e => {
            e.preventDefault();

            const formData = new FormData(formComentario);

            const res = await fetch(formComentario.action, {
                method: 'POST',
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
                body: formData
            });

            const data = await res.json();
            if (!data.success) return alert(data.message);

            // Insertar comentario arriba
            const contenedor = document.getElementById('comentarios');
            contenedor.insertAdjacentHTML('afterbegin', `
                <div class="comentario mb-3">
                    <strong>${data.comentario.autor}</strong>
                    <p>${data.comentario.texto}</p>
                    <small class="text-muted">${data.comentario.fecha}</small>
                </div>
            `);

            formComentario.reset();
        });
    }

    // Respuestas
    document.querySelectorAll('.form-respuesta').forEach(form => {
        form.addEventListener('submit', async e => {
            e.preventDefault();

            const formData = new FormData(form);

            const res = await fetch(form.action, {
                method: 'POST',
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
                body: formData
            });

            const data = await res.json();
            if (!data.success) return alert(data.message);

            const respuestas = form.closest('.comentario').querySelector('.respuestas');
            respuestas.insertAdjacentHTML('beforeend', `
                <div class="respuesta mb-2">
                    <strong>${data.respuesta.autor}</strong>
                    <p>${data.respuesta.texto}</p>
                </div>
            `);

            form.reset();
        });
    });

});
