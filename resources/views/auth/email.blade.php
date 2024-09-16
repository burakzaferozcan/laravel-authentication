@extends("layouts.master")

@section("content")
    <h2>Şifremi Unuttum</h2>
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

    <form method="POST" action="{{route("password.email")}}">
        @csrf
        <input type="email" name="email" class="form-control" required>
        <button type="submit" class="btn btn-success">Şifremi Sıfırla Bağlantısı Gönder</button>
    </form>
@endsection
