

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>{{ config('app.name') }} - {{ $title }}</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="{{ asset ('blog') }}/assets/write.png" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="{{ asset ('blog') }}/css/styles.css" rel="stylesheet" />
        <link rel="stylesheet" href="{{ asset('mystyle.css') }}">
        {{-- Font Awesome --}}
        <link rel="stylesheet" 
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    </head>
    <body>
        <div class="row justify-content-center mt-5 mb-3">
            <div class="col-lg-4">
                <form action="/login" method="post">
                    @csrf
                    <div class="px-2 text-center">
                        <img src="{{ asset('blog') }}/assets/write.png" alt="" class="mt-2">
                        <h3 class="mt-2">{{ config('app.name') }}</h3>
                        @if (session()->has('Gagal'))
                        <div class="alert alert-danger text-start mt-3">
                            {{ session('Gagal') }}
                        </div>
                        @endif
                        <input type="email" name="email" class="form-control rounded py-2 px-3 mt-4 @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="masukkan email anda">
                        @error('email')
                        <div class="invalid-feedback text-start ps-3">
                            {{ $message }}
                        </div>
                        @enderror
                        <input type="password" name="password" class="form-control rounded py-2 px-3 mt-4 @error('password') is-invalid @enderror" placeholder="masukkan password anda">
                        @error('password')
                        <div class="invalid-feedback text-start ps-3">
                            {{ $message }}
                        </div>
                        @enderror
                        <div class="d-grid mb-3">
                            <button type="submit" name="submit" class="btn btn-primary rounded mt-4"> Login</button>
                        </div>
                        <hr class="mb-5">
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>

