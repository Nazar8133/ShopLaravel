@extends('layoutsAdmin.layoutAdmin', ['title'=>'Генерація промокодів'])
@section('content')
    <style>
        .container {
            min-height: 150px;
            max-width: 600px;
        }
    </style>

    <blockquote class="blockquote text-center">
        <p class="h1">Генерація промокодів</p>
    </blockquote>

    <form action="{{ route('promoCode.generate') }}" method="post" class="mb-4">
        @csrf
        <label for="promoCode" class="form-label">Промокод</label>
        <div class="input-group">
            <input class="btn btn-primary" type="submit" name="update" value="Зберегти">
            <input type="text" class="form-control" id="promoCode" placeholder="Введіть або згенеруйте промокод" name="promoCode"
                   value="{{ old('promoCode') ?? session('code') ?? '' }}">
            <input class="btn btn-primary" type="submit" name="generate" value="Згенерувати">
        </div>
    </form>

    <form action="{{ route('promoCode.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="usageLimit" class="form-label">Кількість використань</label>
            <input type="number" class="form-control" id="usageLimit" name="codeAmount" min="1"
                   value="{{ old('codeAmount') }}" required>
        </div>

        <div class="mb-3">
            <label for="discount" class="form-label">Знижка (%)</label>
            <input type="number" class="form-control" id="discount" name="discountValue" min="1" max="100"
                   value="{{ old('discountValue') }}" required>
        </div>

        <div class="mb-3">
            <label for="startDate" class="form-label">Дата початку дії</label>
            <input type="date" class="form-control" id="startDate" name="dateStart"
                   value="{{ old('dateStart') }}" required>
        </div>

        <div class="mb-4">
            <label for="endDate" class="form-label">Дата завершення дії</label>
            <input type="date" class="form-control" id="endDate" name="dateEnd"
                   value="{{ old('dateEnd') }}" required>
        </div>

        <div class="text-center">
            <input class="btn btn-outline-primary" type="submit" name="generate" value="Додати">
        </div>
        <br>
    </form>
@endsection

