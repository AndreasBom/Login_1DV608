<?php

namespace view;

class LayoutView {


  private static $registerLink = "Register";

  public function render($isLoggedIn, IView $v, DateTimeView $dtv) {
    echo '<!DOCTYPE html>
      <html>
        <head>
          <meta charset="utf-8">
          <title>Login Example</title>
          <link rel="stylesheet" href="css/stylesheet.css">
        </head>
        <body>

          <h1>Assignment 2</h1>
          '. $this->renderRegistrationLink($isLoggedIn, $v) .'
          ' . $this->renderIsLoggedIn($isLoggedIn) . '
          
          <div class="container">
              ' . $v->response() . '
              
              ' . $dtv->show() . '
          </div>
         </body>
      </html>
    ';
  }
  
  private function renderIsLoggedIn($isLoggedIn) {
    if ($isLoggedIn) {
      return '<h2>Logged in</h2>';
    }
    else {
      return '<h2>Not logged in</h2>';
    }
  }

  private function renderRegistrationLink($isLoggedIn, $v)
  {
    if($isLoggedIn == false)
    {
      if($v instanceof LoginView)
      {
        return "<a href='?". self::$registerLink ."'>Register a new user</a>";
      }
      if($v instanceof RegisterView)
      {
        return "<a href='?'>Back to login</a>";
      }
    }

    return null;

  }

  public function didUserPressRegistrationLink()
  {
    return isset($_GET[self::$registerLink]);
  }
}
