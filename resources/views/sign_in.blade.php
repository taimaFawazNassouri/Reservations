
        <!DOCTYPE html>
        <html lang="en">
            <style>
            * {
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Montserrat', sans-serif;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: -20px 0 50px;
        }
        
        h1 {
            font-weight: bold;
            margin: 0;
        }
        
        p {
            font-size: 14px;
            font-weight: 100;
            line-height: 20px;
            letter-spacing: 0.5px;
            margin: 20px 0 30px;
        }
        
        span {
            font-size: 12px;
        }
        
        a {
            color: #333;
            font-size: 14px;
            text-decoration: none;
            margin: 15px 0;
        }
        
        .container {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 14px 28px rgba(0, 0, 0, 00.25), 0 10px 10px rgba(0, 0, 0, 0.22);
            position: relative;
            width: 768px;
            max-width: 100%;
            min-height: 480px;
            overflow: hidden;
        }
        
        .form-container form {
            background: #fff;
            display: flex;
            flex-direction: column;
            padding: 0 50px;
            height: 100%;
            justify-content: center;
            text-align: center;
            align-items: center;
        }
        
        .social-container {
            margin: 20px 0;
        }
        
        .social-container a {
            border: 1px solid #ddd;
            border-radius: 50%;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            margin: 0 5px;
            height: 40px;
            width: 40px;
        }
        
        .form-container input {
            background: #eee;
            border: none;
            padding: 12px 15px;
            width: 100%;
            margin: 8px 0;
        }
        
        button {
            border-radius: 20px;
            border: 1px solid #ff4b2b;
            background: #ff4b2b;
            font-size: 12px;
            font-weight: bold;
            padding: 12px 45px;
            color: #fff;
            letter-spacing: 1px;
            text-transform: uppercase;
            transition: transform 80ms ease-in;
        }
        
        button:active {
            transform: scale(0.95);
        }
        
        button.ghost {
            background: transparent;
            border-color: #fff;
        }
        
        .form-container {
            position: absolute;
            height: 100%;
            top: 0;
            transition: all 0.6s ease-in-out;
        }
        
        .sign-in-container {
            left: 0;
            width: 50%;
            z-index: 2;
        }
        
        .sign-up-container {
            left: 0;
            width: 50%;
            z-index: 1;
            opacity: 0;
        }
        
        .overlay-container {
            left: 50%;
            width: 50%;
            height: 100%;
            overflow: hidden;
            position: absolute;
            transition: transform 0.6s ease-in-out;
            z-index: 100;
        }
        
        .overlay {
            background: #ff4b2b;
            background: linear-gradient(to right, #ff4b3b, #ff4b3c) no-repeat 0 0 / cover;
            color: #fff;
            position: relative;
            left: -100%;
            height: 100%;
            width: 200%;
            transform: translateX(0);
        }
        
        .overlay-panel {
            position: absolute;
            top: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 0 40px;
            height: 100%;
            transform: translateX(0);
            transition: transform 0.6s ease-in-out;
            width: 50%;
        }
        
        .overlay-right {
            right: 0;
            transform: translateX(0);
        }
        
        .overlay-left {
            transform: translateX(-20px);
        }
        
        
        /* animation */
        
        .container.right-panel-active .sign-in-container {
            transform: translateX(100%);
        }
        
        .container.right-panel-active .overlay-container {
            transform: translateX(-100%);
        }
        
        .container.right-panel-active .sign-up-container {
            transform: translateX(100%);
            opacity: 1;
            z-index: 5;
        }
        
        .container.right-panel-active .overlay {
            transform: translateX(50%);
        }</style>
        
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta http-equiv="X-UA-Compatible" content="ie=edge">
            <link rel="stylesheet" href="style.css">
            <title>Document</title>
        </head>
        
        <body>
            <div class="container" id=container>
                <div class="form-container sign-up-container">
                    <form method="POST" action="{{ route('register_user') }}">
                        @csrf
                        
                        <h1>Creat Account</h1>
                        <div class="social-container">
        
                        </div>
                        <span>or usenyour email for registration</span>
                        <input type="text" placeholder="Name" name="name" required>
                        <input type="email" placeholder="Email" name="email" required>
                        <input type="password" placeholder="Password" name="password" required>
                        <input type="password" placeholder="Confirm Password" name="password_confirmation" required>

                        <button type="submit">Sign Up</button>
                    </form>
                </div>
                <div class="form-container sign-in-container">
                    <form method="POST" action="{{ route('login_user') }}">
                                @csrf
                        
                        <h1>Sign in</h1>
                        <div class="social-container">
        
                        </div>
                        <span>or use your accont</span>
        
                        <input type="email" placeholder="Email" name="email" required>
                        <input type="password" placeholder="Password" name="password" required>
                        <a href="#">Forget your password?</a>
                        <button type="submit">Sign In</button>
                    </form>
                </div>
        
                <div class="overlay-container">
                    <div class="overlay">
                        <div class="overlay-panel overlay-left">
                            <h1>Welcom Back!</h1>
                            <p>To keep connected with us please login with your personal info</p>
                            <button class="ghost" id="signIn">Sign In</button>
                        </div>
                        <div class="overlay-panel overlay-right">
                            <h1>Hello, Friend!</h1>
                            <p>enter your personal details and start joutney with us</p>
                            <button class="ghost" id="signUp">Sign Up</button>
                        </div>
        
                    </div>
                </div>
            </div>
    
        </body>
        
        </html>
        <script>
        const signUpButton = document.getElementById('signUp');
        const signInButton = document.getElementById('signIn');
        const container = document.getElementById('container');
        
        signUpButton.addEventListener("click", () => container.classList.add("right-panel-active"));
        signInButton.addEventListener("click", () => container.classList.remove("right-panel-active"));
        </script>
     