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

            // Insertar comentario arriba con estilo Semantic UI
            const contenedor = document.getElementById('comentarios');
            contenedor.insertAdjacentHTML('afterbegin', `
                <div class="comment">
                    <div class="content">
                        <a class="author">${data.comentario.autor}</a>
                        <div class="metadata">
                            <span class="date">${data.comentario.fecha}</span>
                        </div>
                        <div class="text">
                            ${data.comentario.texto}
                        </div>
                    </div>
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

            const respuestas = form.closest('.comment').querySelector('.comments');
            respuestas.insertAdjacentHTML('beforeend', `
                <div class="comment">
                    <div class="content">
                        <a class="author">${data.respuesta.autor}</a>
                        <div class="text">${data.respuesta.texto}</div>
                    </div>
                </div>
            `);

            form.reset();
        });
    });

});
