@extends("layouts.master")

@section("content")
    <h2>Şifre Sıfırla</h2>
    @if(session()->get("success"))
        <li>{{session()->get("success")}}</li>
    @endif
    @if(isset($errors))
        <ul>
            @foreach($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </ul>
    @endif

    <form method="POST" action="{{route("password.update")}}">
        @csrf
        <input type="hidden" name="token" class="form-control" value="{{$token}}">
        <input type="email" name="email" class="form-control" value="{{$email}}" required>
        <input type="password" name="password" class="form-control" required>
        <input type="password" name="password_confirmation" class="form-control" required>
        <button type="submit" class="btn btn-success">Şifreyi Sıfırla</button>
    </form>
@endsection
