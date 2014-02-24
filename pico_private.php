<?php

/**
 * A plugin that let you create a private Pico with authentication form
 *
 * @author Johan BLEUZEN
 * @link http://www.johanbleuzen.fr
 * @license http://opensource.org/licenses/MIT
 */
class Pico_Private {

   private $users;

   private $theme;

   private $base_url;

   public function __construct() {
      $plugin_path = dirname(__FILE__);

      if(file_exists($plugin_path .'/pico_private_conf.php')){
         global $pico_private_conf;
         include_once($plugin_path .'/pico_private_conf.php');
         $this->users = $pico_private_conf['users'];

         session_start();
      }
   }

   public function config_loaded(&$settings) {
      $this->theme = $settings['theme'];
      $this->base_url = $settings['base_url'];
   }

   public function request_url(&$url) {
      if($url == 'login') {
         if(! isset($_SESSION['authed']) || $_SESSION['authed'] == false) {
            return;
         } else {
            $this->redirect('/');
            exit;
         }
      }

      if($url == 'logout') {
         session_destroy();
         $this->redirect('/login');
      }
      if(!isset($_SESSION['authed']) || $_SESSION['authed'] == false) {
         $this->redirect('/login');
      }
   }

   public function before_render(&$twig_vars, &$twig) {
      if(!isset($_SESSION['authed']) || $_SESSION['authed'] == false) {
         if(isset($_POST['username'])) {
            $postUsername = $_POST['username'];
         }
         if(isset($_POST['password'])) {
            $postPassword = $_POST['password'];
         }

         if(!empty($postUsername) && !empty($postPassword)) {
            if(isset($this->users[$postUsername]) == true && $this->users[$postUsername] == sha1($postPassword)) {
               $_SESSION['authed'] = true;
               $_SESSION['username'] = $postUsername;
               $this->redirect('/');
            } else {
               $twig_vars['login_error'] = 'Invalid login';
               $twig_vars['username'] = $postUsername;
            }
         }

         header($_SERVER['SERVER_PROTOCOL'].' 200 OK');
         $loader = new Twig_Loader_Filesystem(THEMES_DIR . $this->theme);
         $twig_login = new Twig_Environment($loader, $twig_vars);   
         $twig_vars['meta']['title'] = "Login";
         echo $twig_login->render('login.html', $twig_vars);
         exit;
      }

      $twig_vars['authed'] = $_SESSION['authed'];
      $twig_vars['username'] =  $_SESSION['username'];
   }

   private function redirect($url) {
      header('Location: '. $this->base_url . $url); 
      exit;
   }

}
