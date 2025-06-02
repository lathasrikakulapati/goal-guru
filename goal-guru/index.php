<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>GOALGURU</title>
  <style>
    body, html {
  height: 100%;
  margin: 0;
  font-family: 'Georgia', serif;
  background-color: #f8f5f1;
}

.container {
  position: relative;
  z-index: 1;
  height: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
  flex-direction: column;
  text-align: center;
}

#particles-js {
  position: absolute;
  width: 100%;
  height: 100%;
  z-index: 0;
}

.title {
  font-size: 3rem;
  font-weight: bold;
  color: #000;
}

.subtitle {
  font-size: 1.2rem;
  color: #b07c7c;
}

.button-group .btn {
  padding: 12px 30px;
  margin: 10px;
  border-radius: 20px;
  cursor: pointer;
  font-size: 1rem;
}

.form {
  width: 300px;
  margin: 50px auto;
  display: flex;
  flex-direction: column;
  gap: 15px;
}

input {
  padding: 10px;
  font-size: 1rem;
}

button {
  padding: 10px;
  font-size: 1rem;
  background: #2b2bd6;
  color: #fff;
  border: none;
  border-radius: 5px;
}
  </style>
</head>
<body>
  <div id="particles-js"></div>
  <div class="container">
    <h1 class="title">GOALGURU</h1>
    <p class="subtitle">GAMIFY YOUR LEARNING PROCESS</p>
    <div class="button-group">
      <!-- ✅ Updated links to match routes configured in server.js -->
      <button class="btn login" onclick="location.href='login.php'">Login</button>
      <button class="btn register" onclick="location.href='register.php'">Register</button>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
  <script src="/js/main.js"></script>
</body>
</html>
