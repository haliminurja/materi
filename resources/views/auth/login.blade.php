<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="{{ asset('assets/bootstrap/bootstrap.min.css') }}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
                <div class="card shadow-lg rounded-3">
                    <div class="card-header bg-primary text-white text-center py-4">
                        <h4>Login</h4>
                    </div>
                    <div class="card-body">
                        <form id="loginForm">
                            @csrf
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" id="username" name="username" class="form-control" required>
                                <div id="usernameError" class="text-danger"></div>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" id="password" name="password" class="form-control" required>
                                <div id="passwordError" class="text-danger"></div>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Login</button>
                        </form>
                    </div>
                    <div class="card-footer text-center">
                        <p class="mb-0">Tidak memiliki akun? <a href="{{ route('register') }}"
                                class="text-decoration-none">Daftar Sekarang</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/bootstrap/bootstrap.min.js') }}"></script>
    <script>
        $('#loginForm').submit(function(e) {
            e.preventDefault();

            $('#usernameError').text('');
            $('#passwordError').text('');

            let formData = $(this).serialize();

            $.ajax({
                url: "{{ route('logindb') }}",
                type: 'POST',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        alert(response.message);
                        window.location.href = "{{ route('dashboard') }}";
                    }
                },
                error: function(xhr) {
                    let code = xhr.status;
                    let response = xhr.responseJSON;
                    if (code === 401) {
                        alert('Username & password salah');
                    } else if (code === 422) {
                        if (response && response.errors) {
                            if (response.errors.username) {
                                $('#usernameError').text(response.errors.username);
                            }
                            if (response.errors.password) {
                                $('#passwordError').text(response.errors.password);
                            }
                        }
                    } else if (code === 419) {
                        alert("csrf token tidak ada");
                    }
                }
            });
        });
    </script>
</body>

</html>
