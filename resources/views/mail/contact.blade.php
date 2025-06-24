<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Email responsive</title>

  <style>
    /* Reset de base */
    body {
      margin: 0;
      padding: 0;
      background-color: #e1e1e1;
      font-family: Arial, sans-serif;
    }

    .email-container {
      max-width: 700px;
      margin: 20px auto;
      background-color: #ffffff;
      border-radius: 8px;
      overflow: hidden;
      box-shadow: 0 0 10px rgba(0,0,0,0.05);
    }

    .email-header {
      background-color: #FFFFFF;
      color: #3A3A3A;
      text-align: center;
      padding: 20px;
      font-size: 24px;
       box-shadow: 0 5px 10px rgba(0, 0, 0, .3);
    }

    .email-body {
      padding: 30px;
      color: #333333;
      font-size: 16px;
      line-height: 1.5;
    }

    .email-button {
      text-align: center;
      padding: 20px;
    }

    .email-button a {
      background-color: #3A3A3A;
      color: #ffffff;
      text-decoration: none;
      padding: 12px 24px;
      border-radius: 5px;
      display: inline-block;
      font-weight: bold;
    }

    .email-footer {
      padding: 20px;
      font-size: 12px;
      color: #999999;
      text-align: center;
    }

    .email-footer a {
      color: #999999;
      text-decoration: underline;
    }

    /* Responsive */
    @media screen and (max-width: 600px) {
      .email-body {
        padding: 20px;
        font-size: 15px;
      }

      .email-button a {
        padding: 10px 20px;
        font-size: 15px;
      }

      .email-header {
        font-size: 20px;
        padding: 16px;
      }
    }
  </style>
</head>

<body>
  <div class="email-container">

    <!-- En-tête -->
    <div class="email-header">
      <div class="image">
        <img src="https://fungifornature.com/assets/images/logo.png" alt="">
      </div>
    </div>

    <!-- Corps -->
    <div class="email-body">

      Hi, <br><br>
      {{$data['message']}}<br><br>
      <strong>{{$data['name']}}</strong><br>
      <strong>Email: </strong><a href="mailto:{{$data['email']}}"> {{$data['email']}} </a> <br>

    </div>

    <!-- Pied de page -->
    <div class="email-footer">
      © 2025 Itumo Institute. Tous droits réservés.<br>
    </div>

  </div>
</body>
</html>
