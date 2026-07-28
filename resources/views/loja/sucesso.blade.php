@extends('layouts.app')

@section('content')
<div class="container my-5 text-center py-5">
    <div class="card shadow border-0 p-5 mx-auto" style="max-width: 600px;">
        <h1 class="text-success mb-3">✓ Compra Realizada!</h1>
        <p class="fs-5 text-secondary">
            {{ $mensagem ?? 'Obrigado pela sua compra! Os seus produtos já foram liberados.' }}
        </p>
        <div class="mt-4">
            <a href="{{ url('/') }}" class="btn btn-primary">Voltar para a Home</a>
        </div>
    </div>
</div>
@endsection