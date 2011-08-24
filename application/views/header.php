
	<div id="login_logout">
		<?php
			$auth = Auth::instance();
			$logged_in = ($auth->logged_in() OR $auth->auto_login());
			if($logged_in)
			{
				$user_name = ORM::factory('user',$auth->get_user())->username;
				echo '<span class="user_info"><a href="'.url::base().'home">'.__('welcome')." ".$user_name .'</a></span>';
				echo '<span class="user_action"><a href="'.url::base().'logout">'.__('logout').'</a></span>';
			}
			else
			{
				echo '<span class="user_action">';
				echo '<a href="'.url::base().'login">'.__('login').'</a>';
				echo ' '.__("or"). ' ';
				echo '<a href="'.url::base().'register">'.__('register').'</a>';
				echo '</span>';
			}
		?>
	</div>
	<h1>
		<a href="<?php echo url::base(); ?>">
			<?php echo __('site name'); ?>
		</a>
	</h1>
	<p>
		<a href="<?php echo url::base(); ?>">
			<?php echo __('tagline'); ?>
		</a>
	</p>
<div id="mainMenu"><?php echo Helper_Mainmenu::make_menu($menu_page, $user);?></div>