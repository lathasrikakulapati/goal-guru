<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Campus Network</title>
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background-color: #f3e5d5; /* light brown */
      overflow-x: hidden;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }

    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 20px 40px;
      border-bottom: 1px solid #d2b48c;
      background-color: #fff8f0;
      position: sticky;
      top: 0;
      z-index: 10;
    }

    .header nav ul {
      list-style: none;
      margin: 0;
      padding: 0;
      display: flex;
      gap: 20px;
    }

    .header nav ul li a {
      text-decoration: none;
      color: #5c3317;
      font-size: 16px;
      padding: 8px 16px;
      border: 1px solid transparent;
      border-radius: 4px;
      transition: all 0.3s;
    }

    .header nav ul li a:hover {
      color: white;
      background-color: #8B4513;
      border-color: #8B4513;
    }

    .header .logo {
      font-size: 24px;
      font-weight: bold;
      color: #8B4513;
      transition: color 0.3s;
    }

    .main {
      display: flex;
      flex-direction: row;
      align-items: center;
      justify-content: center;
      text-align: center;
      height: 80vh;
      background-color: #f6e1c3;
      position: relative;
      overflow: hidden;
    }

    .main .image-container img {
      max-width: 80%;
      height: auto;
      border-radius: 10px;
      box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
      animation: slideInImage 1s ease-out forwards;
    }

    .main .content {
      flex: 1;
      background: white;
      padding: 20px;
      border: 1px solid #d2b48c;
      box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
      animation: slideInText 1.5s ease-out forwards;
    }

    @keyframes slideInImage {
      from {
        transform: translateX(100%);
        opacity: 0;
      }
      to {
        transform: translateX(0);
        opacity: 1;
      }
    }

    @keyframes slideInText {
      from {
        transform: translateX(-100%);
        opacity: 0;
      }
      to {
        transform: translateX(0);
        opacity: 1;
      }
    }

    .role-dropdown {
      position: relative;
      margin-right: 60px;
    }

    .role-button {
      background: #8B4513;
      color: white;
      border: none;
      padding: 10px 15px;
      font-size: 16px;
      cursor: pointer;
      border-radius: 5px;
    }

    .role-button:hover {
      background: #5c3317;
    }

    .role-options {
      display: none;
      position: absolute;
      top: 100%;
      right: 0;
      background: white;
      border: 1px solid #ddd;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
      border-radius: 5px;
      z-index: 1000;
    }

    .role-options > div {
      position: relative;
    }

    .role-options button {
      display: block;
      background: none;
      border: none;
      width: 100%;
      padding: 10px;
      text-align: left;
      cursor: pointer;
      font-size: 16px;
    }

    .role-options button:hover {
      background: #f0e6db;
    }

    .sub-options {
      display: none;
      position: absolute;
      left: 100%;
      top: 0;
      background: white;
      border: 1px solid #ddd;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
      border-radius: 5px;
      z-index: 1000;
    }

    .role-options > div:hover .sub-options {
      display: block;
    }

    .video-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 20px;
      padding: 40px;
      background-color: #f9f3eb;
    }

    .video-grid iframe {
      width: 100%;
      height: 200px;
      border: none;
      border-radius: 10px;
      box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
    }

    .footer {
      background-color: #5c3317;
      color: white;
      padding: 20px 40px;
      font-size: 14px;
      margin-top: auto;
    }

    .footer .footer-columns {
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;
    }

    .footer .footer-column {
      flex: 1;
      min-width: 200px;
      margin: 10px;
    }

    .footer .footer-column h3 {
      font-size: 16px;
      margin-bottom: 10px;
      color: #f3f3f3;
    }

    .footer .footer-column ul {
      list-style: none;
      padding: 0;
    }

    .footer .footer-column ul li {
      margin-bottom: 8px;
    }

    .footer .footer-column ul li a {
      text-decoration: none;
      color: #ddd;
      transition: color 0.3s;
    }

    .footer .footer-column ul li a:hover {
      color: #deb887;
    }

    .footer-bottom {
      text-align: center;
      margin-top: 20px;
      color: #ddd;
      font-size: 12px;
    }
  </style>
</head>
<body>
  <header class="header">
    <div class="logo">goal guru</div>
    <nav>
      <ul>
        <li><a href="dashboard.php" class="active">Home</a></li>
        <li><a href="learn.php">learn</a></li>
        <li><a href="connect.php">connect</a></li>
        <li><a href="profile.php">profile</a></li>
       
        <li><a href="logout.php">logout</a></li>
      </ul>
    </nav>
  </header>

  <div class="main">
    <div class="image-container">
      <img src="background image.jpg" alt="Campus">
    </div>
    <div class="content">
      <h1>Welcome to goal guru!</h1>
      <p>Level Up Your Life, <strong>One Skill at a Time.</strong></p>
    </div>
  </div>

  <footer class="footer">
    <div class="footer-columns">
      <div class="footer-column">
        <h3>Get to Know Us</h3>
        <ul>
          <li><a href="#">About Campus Network</a></li>
          <li><a href="#">Careers</a></li>
          <li><a href="#">Press Releases</a></li>
        </ul>
      </div>
      <div class="footer-column">
        <h3>Let Us Help You</h3>
        <ul>
          <li><a href="#">Your Account</a></li>
          <li><a href="#">Help Center</a></li>
        </ul>
      </div>
    </div>
    <div class="footer-bottom">
      &copy; goal guru. All rights reserved.
    </div>
  </footer>

  <script>
    function toggleRoleOptions() {
      const roleOptions = document.getElementById('roleOptions');
      if (roleOptions.style.display === 'block') {
        roleOptions.style.display = 'none';
      } else {
        roleOptions.style.display = 'block';
      }
    }

    window.addEventListener('click', function (event) {
      const roleDropdown = document.querySelector('.role-dropdown');
      if (!roleDropdown.contains(event.target)) {
        const roleOptions = document.getElementById('roleOptions');
        if (roleOptions) roleOptions.style.display = 'none';
      }
    });
  </script>
</body>
</html>
