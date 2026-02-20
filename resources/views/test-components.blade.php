@extends('layouts.app')

@section('title', 'Komponentlarni test qilish')

@section('content')
    <div class="container">
        <h1 class="mb-4">Blade Komponentlarini Test Qilish</h1>

        <!-- Alert Success -->
        <h3>Alert Success:</h3>
        <x-alert type="success" msg="Muvaffaqiyatli saqlandi!" />

        <!-- Alert Danger -->
        <h3>Alert Danger:</h3>
        <x-alert type="danger" msg="Xatolik yuz berdi!" />

        <hr class="my-4">

        <!-- Form Inputs Demo -->
        <h3>Form Input Komponentlari:</h3>
        <form>
            <x-form-input name="name" label="Hayvon nomi" type="text" value="Mushuk" />

            <x-form-input name="price" label="Narxi (so'm)" type="number" value="1500000" />

            <x-form-input name="image" label="Rasm yuklash" type="file" />

            <button type="submit" class="btn btn-primary">Yuborish</button>
        </form>
    </div>
@endsection