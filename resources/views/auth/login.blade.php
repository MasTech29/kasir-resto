<!DOCTYPE html>
<html>
<head>
    <title>Login Kasir Resto</title>
    <style>
        body{background:#f4f4f4;display:flex;justify-content:center;align-items:center;height:100vh;font-family:Arial;margin:0}
        .card{background:white;padding:30px;border-radius:10px;box-shadow:0 5px 15px rgba(0,0,0,0.1);width:350px}
        h2{text-align:center;margin-bottom:20px}
        input{width:100%;padding:12px;margin:8px 0;border:1px solid #ddd;border-radius:6px;box-sizing:border-box}
        button{width:100%;padding:12px;background:blue;color:white;border:none;border-radius:6px;cursor:pointer;font-size:16px;margin-top:10px}
        button:hover{background:darkblue}
        .error{background:#ffdddd;color:red;padding:10px;border-radius:5px;margin-bottom:10px;text-align:center}
        .info{text-align:center;margin-top:15px;color:#666;font-size:13px}
    </style>
</head>
<body>
<div class="card">
    <h2>🔐 Login Kasir</h2>
    @if(session('error'))<div class="error">{{ session('error') }}</div>@endif
    @if(session('success'))<div class="error" style="background:#ddffdd;color:green">{{ session('success') }}</div>@endif

    <form method="POST" action="/login">
        @csrf
        <label>Username</label>
        <input type="text" name="username" placeholder="....." required>
        <label>Password</label>
        <input type="password" name="password" placeholder="....." required>
        <button type="submit">Login</button>
    </form>
</div>
</body>
</html>
