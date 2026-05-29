<x-game-layout>
    @vite(['resources/css/game.css', 'resources/js/game/app.js'])
    <div>
        <div style="font-family: font1; position: absolute; left:-1000px; visibility:hidden;">.</div>
        <div id="game-container"></div>
        <input type="hidden" id="invoice_id" value="{{ $invoice_id }}">
    </div>

    <script src="//cdn.jsdelivr.net/npm/phaser@3.70.0/dist/phaser.js"></script>
    <script>
        window.gameRoutes = {
            score: "{{ route('participants.game.score') }}",
            ranking: "{{ route('participants.ranking') }}"
        };

        {{--async function finishGame(final_score) {--}}
        {{--    const invoice_id = document.getElementById('invoice_id').value;--}}

        {{--    try {--}}
        {{--        const response = await fetch('{{ route('participants.game.score') }}', {--}}
        {{--            method: 'POST',--}}
        {{--            headers: {--}}
        {{--                'Content-Type': 'application/json',--}}
        {{--                'X-CSRF-TOKEN': document--}}
        {{--                    .querySelector('meta[name="csrf-token"]')--}}
        {{--                    .content--}}
        {{--            },--}}
        {{--            body: JSON.stringify({--}}
        {{--                invoice_id: invoice_id,--}}
        {{--                score: final_score--}}
        {{--            })--}}
        {{--        });--}}

        {{--        if (! response.ok) {--}}
        {{--            Swal.fire({--}}
        {{--                title: '¡Oops!',--}}
        {{--                text: 'Error al guardar el puntaje.',--}}
        {{--                icon: 'error',--}}
        {{--                cancelButtonText: 'Cerrar',--}}
        {{--                allowOutsideClick: false--}}
        {{--            });--}}
        {{--        }--}}

        {{--        const data = await response.json()--}}

        {{--        if (data.success) {--}}
        {{--            Swal.fire({--}}
        {{--                title: '¡Listo!',--}}
        {{--                text: data.message,--}}
        {{--                icon: 'success',--}}
        {{--                confirmButtonText: 'Continuar',--}}
        {{--                allowOutsideClick: false--}}
        {{--            });--}}

        {{--            setTimeout(function () {--}}
        {{--                window.location.href = '{{ route('participants.ranking') }}';--}}
        {{--            }, 3000)--}}
        {{--        }--}}
        {{--    } catch (error) {--}}
        {{--        Swal.fire({--}}
        {{--            title: '¡Oops!',--}}
        {{--            text: 'Error al guardar el puntaje.',--}}
        {{--            icon: 'error',--}}
        {{--            cancelButtonText: 'Cerrar',--}}
        {{--            allowOutsideClick: false--}}
        {{--        });--}}
        {{--    }--}}
        {{--}--}}
    </script>
</x-game-layout>
