<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <div class="login-signup-page">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="login-signup-img">
                        <img src="img/l_01.jpg">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="login-box">
                    	<span class="flag-info">welcome</span>
                        <h2>Create End Credits Now</h2>
                         <div class="options">
                            <p><a href="#">Forget password?</a></p>
                        </div>
                        <form action="register" method="POST">
                            @csrf
                            <div class="input-group">
                                <label for="name"><i class="fas fa-envelope"></i></label>
                                <input type="text" id="name" name="name" class="formfield" placeholder="name" required>
                            </div>
                            <div class="input-group">
                                <label for="email"><i class="fas fa-envelope"></i></label>
                                <input type="email" id="email" name="email" class="formfield" placeholder="Email Address" required>
                            </div>
                            <div class="input-group">
                                <label for="password"><i class="fas fa-lock"></i></label>
                                <input type="password" id="password" name="password" class="formfield" placeholder="Password" required>
                            </div>
                            <div class="input-group">
                                <label for="password"><i class="fas fa-lock"></i></label>
                                <input type="password" id="password" name="password_confirmation" class="formfield" placeholder="Confirm Password" required>
                            </div>
                            <button type="submit">Sign Up</button>
                        </form>
                        <div class="login-options">
                            <p>Not a member Register now or log in with Google</p>
                        </div>
                        <div class="d-flex justify-content-between align-items-center login-options-inner">
                        	<div class="redirect-btns">
                        		<a href="#" class="loginbtn"><svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" class="LgbsSe-Bz112c"><g><path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"></path><path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"></path><path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"></path><path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"></path><path fill="none" d="M0 0h48v48H0z"></path></g></svg>google</a>
                        	</div>
                        	<div class="redirect-btns">
                        		<a href="#" class="loginbtn">sign up now</a>
                        	</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="js/bootstrap.bundle.min.js"></script>

</body>
</html>