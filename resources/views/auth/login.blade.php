@extends('layouts.master')

@section('content')
    <h2>Giriş Yap</h2>


    <form action="/login" method="POST">
        @csrf
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" class="form-control" id="email" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" name="password" class="form-control" id="password" required>
        </div>
        <button type="submit" class="btn btn-primary cursor:pointer">Giriş Yap</button>
        @if ($errors)
            <ul>
                @foreach($errors->all() as $error)
                    <li class="text-danger">{{$error}}</li>
                @endforeach
            </ul>
            <span class="text-danger">{{session()->get("error")}}</span>
        @endif
    </form>
@endsection
