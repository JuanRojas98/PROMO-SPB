<x-game-layout>
    <div>
        <h1>Juego</h1>

        <p>Factura ID {{ $invoice_id }} del usuario ID {{ Auth::user()->id }}</p>

        <input type="hidden" id="invoice_id" value="{{ $invoice_id }}">
    </div>

    <script>
        async function finishGame(final_score) {
            const invoice_id = document.getElementById('invoice_id').value;

            try {
                const response = await fetch('{{ route('participants.game.score') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document
                            .querySelector('meta[name="csrf-token"]')
                            .content
                    },
                    body: JSON.stringify({
                        invoice_id: invoice_id,
                        score: final_score
                    })
                });

                if (! response.ok) {
                    Swal.fire({
                        title: '¡Oops!',
                        text: 'Error al guardar el puntaje.',
                        icon: 'error',
                        cancelButtonText: 'Cerrar',
                        allowOutsideClick: false
                    });
                }

                const data = await response.json()

                if (data.success) {
                    Swal.fire({
                        title: '¡Listo!',
                        text: data.message,
                        icon: 'success',
                        confirmButtonText: 'Continuar',
                        allowOutsideClick: false
                    });

                    setTimeout(function () {
                        window.location.href = '{{ route('participants.ranking') }}';
                    }, 3000)
                }
            } catch (error) {
                Swal.fire({
                    title: '¡Oops!',
                    text: 'Error al guardar el puntaje.',
                    icon: 'error',
                    cancelButtonText: 'Cerrar',
                    allowOutsideClick: false
                });
            }
        }
    </script>
</x-game-layout>
