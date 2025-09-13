@extends('layoutsAdmin.layoutAdmin', ['title' => 'Редагування промокоду'])
@section('content')
    <style>
        .container {
            max-width: 600px;
            margin-top: 30px;
            min-height: 50px;
        }
    </style>

    <div class="container">
        <blockquote class="blockquote text-center">
            <p class="h1">Редагування промокоду</p>
        </blockquote>

        {{-- Форма оновлення промокоду --}}
        <form action="{{ route('promoCode.update', ['promoCode'=>$promoCode->idPromoCode]) }}" method="POST">
            @csrf
            @method('PATCH')
            {{-- Промокод (не редагується) --}}
            <div class="mb-3">
                <label for="promoCode" class="form-label">Промокод</label>
                <input type="text" class="form-control" id="promoCode" name="promoCode"
                       value="{{ $promoCode->code }}" required>
            </div>

            {{-- Кількість використань --}}
            <div class="mb-3">
                <label for="usageLimit" class="form-label">Кількість використань</label>
                <input type="number" class="form-control" id="usageLimit" name="codeAmount" min="1"
                       value="{{ old('usageLimit', $promoCode->codeAmount) }}" required>
            </div>

            {{-- Знижка (%) --}}
            <div class="mb-3">
                <label for="discount" class="form-label">Знижка (%)</label>
                <input type="number" class="form-control" id="discount" name="discountValue" min="1" max="100"
                       value="{{ old('discount', $promoCode->discountValue) }}" required>
            </div>

            {{-- Дата початку --}}
            <div class="mb-3">
                <label for="startDate" class="form-label">Дата початку дії</label>
                <input type="date" class="form-control" id="startDate" name="dateStart"
                       value="{{ old('startDate', \Carbon\Carbon::parse($promoCode->dateStart)->toDateString())}}"
                       required>
            </div>

            {{-- Дата завершення --}}
            <div class="mb-4">
                <label for="endDate" class="form-label">Дата завершення дії</label>
                <input type="date" class="form-control" id="endDate" name="dateEnd"
                       value="{{ old('endDate', \Carbon\Carbon::parse($promoCode->dateEnd)->toDateString())}}"
                       required>
            </div>

            {{-- Кнопка оновити --}}
            <div class="text-center">
                <input type="submit" class="btn btn-outline-primary" name="knopka" value="Редагувати">
            </div>
            <br>
        </form>
    </div>
@endsection

