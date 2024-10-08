@extends("layouts.master")

@section('content')
    <h2>Kayıt Ol</h2>
    <form action="/register" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Name Surname:</label>
            <input type="text" name="name" class="form-control" id="name" >
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" class="form-control" id="email" >
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" name="password" class="form-control" id="password" >
        </div>
        <div class="form-group">
            <label for="password_confirmation">Confirm Password:</label>
            <input type="password" name="password_confirmation" class="form-control" id="password_confirmation">
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary cursor:pointer">Kayıt Ol</button>
        </div>
        @if ($errors)
            <ul>
                @foreach($errors->all() as $error)
                    <li class="text-danger">{{$error}}</li>
                @endforeach
            </ul>
            <span>{{session()->get("error")}}</span>
        @endif
    </form>
@endsection
