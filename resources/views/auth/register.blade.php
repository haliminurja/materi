<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="{{ asset('assets/bootstrap/bootstrap.min.css') }}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
                <div class="card shadow-lg rounded-3">
                    <div class="card-header bg-primary text-white text-center py-4">
                        <h4>Register</h4>
                    </div>
                    <div class="card-body">
                        <form id="registerForm">
                            @csrf
                            <div class="mb-3">
                                <label for="company" class="form-label">Company</label>
                                <input type="text" id="company" name="company" class="form-control" required>
                                <div id="nameError" class="text-danger"></div>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" id="email" name="email" class="form-control" required>
                                <div id="emailError" class="text-danger"></div>
                            </div>
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
                            <div class="mb-3">
                                <label for="telepon" class="form-label">Nomor Telepon</label>
                                <input type="text" id="telepon" name="telepon" class="form-control" required>
                                <div id="teleponError" class="text-danger"></div>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Daftar</button>
                        </form>
                    </div>
                    <div class="card-footer text-center">
                        <p class="mb-0">Sudah memiliki akun? <a href="{{ route('login') }}" class="text-decoration-none">Login Sekarang</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/bootstrap/bootstrap.min.js') }}"></script>
    <script>
        $('#registerForm').submit(function(e) {
            e.preventDefault();

            // Reset error messages
            $('#companyError').text('');
            $('#emailError').text('');
            $('#usernameError').text('');
            $('#passwordError').text('');
            $('#teleponError').text('');

            let formData = $(this).serialize();

            $.ajax({
                url: "{{ route('registerdb') }}",
                type: 'POST',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        alert(response.message);
                        window.location.href = "{{ route('login') }}";
                    }
                },
                error: function(xhr) {
                    let code = xhr.status;
                    let response = xhr.responseJSON;

                    if (code === 422) {
                        if (response && response.errors) {
                            if (response.errors.name) {
                                $('#companyError').text(response.errors.name);
                            }
                            if (response.errors.email) {
                                $('#emailError').text(response.errors.email);
                            }
                            if (response.errors.username) {
                                $('#usernameError').text(response.errors.username);
                            }
                            if (response.errors.password) {
                                $('#passwordError').text(response.errors.password);
                            }
                            if (response.errors.telepon) {
                                $('#teleponError').text(response.errors.telepon);
                            }
                        }
                    } else if(code === 419){
                        alert("csrf token tidak ada");
                    }
                }
            });
        });
    </script>
</body>

</html>
