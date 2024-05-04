<!DOCTYPE html>
<html lang="ja">
<style>
    svg.w-5.h-5 {
    /*paginateメソッドの矢印の大きさ調整のために追加*/
    width: 30px;
    height: 20px;
    }
</style>
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Rese</title>
  <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
  <link rel="stylesheet" href="{{ asset('css/common.css') }}">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous" />
  @yield('css')
</head>
<body class="body">
  <header class="header">
    <div class="header__inner">
      <div>
        <div class="hamburger-menu">
          <input type="checkbox" id="menu-btn-check">
          <label for="menu-btn-check" class="menu-btn"><span></span></label>
          <?php
          if(empty($favorite)){
            $favorite = 1;
          }
          ?>
          @if (Auth::check())
          <div class="menu-content">
            <ul>
                <li>
                    <a href="/">Home</a>
                </li>
                <li>
                    <form class="menu-logout" action="/logout" method="post">
                    @csrf
                        <button class="menu-logout">Logout</button>
                    </form>
                </li>
                <li>
                    <a href="/mypage">Mypage</a>
                </li>
            </ul>
          </div>
          @else
          <div class="menu-content">
            <ul>
              <li>
                <a href="/">Home</a>
              </li>
              <li>
                  <a href="/register">Registration</a>
              </li>
              <li>
                  <a href="/login">Login</a>
              </li>
            </ul>
          </div>
          @endif
        </div>
        <div class="header__logo">
          <p class="header__logo">Rese</p>
        </div>
      </div>
    @yield('title')
    </div>
  </header>
  <main>
    <div class="main" >
    @yield('content')
    </div>
  </main>
</body>
</html>