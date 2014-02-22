<?php

/**
 * A plugin that let you create a private Pico with authentication form
 *
 * @author Johan BLEUZEN
 * @link http://www.johanbleuzen.fr
 * @license http://opensource.org/licenses/MIT
 */
class Pico_Private {

  private $theme;

  public function __construct() {
    $plugin_path = dirname(__FILE__);
    session_start();

    if(file_exists($plugin_path .'/pico_private_pass.php')){
      global $pico_private_passwords;
      include_once($plugin_path .'/pico_private_pass.php');
      $this->passwords = $pico_private_passwords;
    }
  }

  public function config_loaded(&$settings) {
    $this->theme = $settings['theme'];
  }

  public function request_url(&$url) {
    if($url == 'login') {
      if($_SESSION['authed'] == false) {
        return;
      } else {
        //$this->redirect_target($url);
        exit;
      }
    }

    if($url == 'logout') {
      session_destroy();
      $this->redirect_home();
    }
    /*if(!isset($_SESSION['authed']) || $_SESSION['authed'] == false) {
      $this->redirect_login();
    }*/
  }

  public function before_render(&$twig_vars, &$twig) {
    if(!isset($_SESSION['authed']) || $_SESSION['authed'] == false) {
      // shortHand $_POST variables
      $postUsername = $_POST['username'];
      $postPassword = $_POST['password'];
      if(isset($postUsername) && isset($postPassword)) {
        if(isset($this->passwords[$postUsername]) == true && $this->passwords[$postUsername] == sha1($postPassword)) {
          $_SESSION['authed'] = true;
          $_SESSION['username'] = $postUsername;
        } else {
          $twig_vars['login_error'] = 'Invalid login';
          $twig_vars['username'] = $postUsername;
        }
      }
    }

    $twig_vars['authed'] = $_SESSION['authed'];
    $twig_vars['username'] =  $_SESSION['username'];
  }

  private function redirect_home() {
    header('Location: /pico/'); 
    exit;
  }

  private function redirect_login() {
    header('Location: /pico/login'); 
    exit;
  }

  private function redirect_target(&$url) {
    header('Location: /pico/'.$url);
    exit;
  }

}