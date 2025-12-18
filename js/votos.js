document.addEventListener('DOMContentLoaded', () => {

    document.querySelectorAll('.form-voto').forEach(form => {

        form.addEventListener('submit', async (e) => {
            e.preventDefault();

            const formData = new FormData(form);
            const fotoId = formData.get('foto_id');

            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    headers: { 'X-Requested-With': 'XMLHttpRequest' },
                    body: formData
                });

                const data = await response.json();

                if (!data.success) {
                    alert(data.message);
                    return;
                }

                // Actualizar contador con Semantic UI label
                const contador = document.querySelector(
                    `.votos-contador[data-id="${fotoId}"]`
                );
                if (contador) {
                    contador.innerHTML = `<div class="ui label">❤️ ${data.votos}</div>`;
                }

                // Cambiar botón por texto estilizado
                form.innerHTML = `<div class="ui tiny label">Votado</div>`;

            } catch (error) {
                console.error(error);
                alert('Error al votar. Inténtalo de nuevo.');
            }
        });

    });

});
