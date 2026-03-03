<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Bootstrap 5.3.3 -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<title>Signup UI</title>

<style>

body{
    background:#ffffff;
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    font-family: 'Segoe UI', sans-serif;
}

/* Main Card */
.signup-box{
    width:900px;
    background:#ffffff;
    border-radius:15px;
    overflow:hidden;
    position:relative;
    box-shadow:0 0 20px #8eabfc;
}

/* Left Welcome Section */
.welcome-side{
    background:linear-gradient(135deg,#1E3A8A,#8eabfc);
    color:white;
    padding:60px 40px;
    clip-path:polygon(0 0, 85% 0, 60% 100%, 0% 100%);
}

.welcome-side h1{
    font-weight:bold;
}

/* Right Form Section */
.form-side{
    padding:50px;
    color:#000;
}

/* Input Styling */
.custom-input{
    background:transparent;
    border:none;
    border-bottom:2px solid #2cd4e5;
    border-radius:0;
    color:#000;
}

.custom-input::placeholder{
    color:rgba(0,0,0,0.5);
}

.custom-input:focus{
    background:transparent;
    box-shadow:none;
    border-bottom:2px solid #00f7ff;
    color:#000;
}

/* Button */
.register-btn{
    background:linear-gradient(to right,#1dd3e8,#1e3a8a);
    border:none;
    border-radius:30px;
    padding:10px;
    font-weight:600;
    transition:0.3s;
}

.register-btn:hover{
    background:linear-gradient(to right,#1e3a8a,#1dd3e8);
}

/* Login link */
.login-link{
    color:#000000;
    text-decoration:none;
}

</style>

</head>

<body>

<div class="signup-box row g-0">

    <!-- Welcome Section -->
    <div class="col-md-6 welcome-side d-flex flex-column justify-content-center">
        <h1>WELCOME!</h1>
        <p>Hope, You and <br> your Family have a Great Day</p>
    </div>

    <!-- Form Section -->
    <div class="col-md-6 form-side">

        <h2 class="mb-4 fw-bold text-dark">Login</h2>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Username -->
            <div class="mb-4 position-relative">
                <input type="text" name="username" class="form-control custom-input" placeholder="Username">
                <i class="bi bi-envelope position-absolute end-0 top-50 translate-middle-y text-dark"></i>
            </div>

            <!-- Password -->
            <div class="mb-4 position-relative">
                <input type="password" name="password" class="form-control custom-input" placeholder="Password">
                <i class="bi bi-lock position-absolute end-0 top-50 translate-middle-y text-dark"></i>
            </div>

            <!-- Button -->
            <button type="submit" class="btn register-btn w-100 mb-5">Login</button>

        </form>

    </div>

</div>

</body>
</html>