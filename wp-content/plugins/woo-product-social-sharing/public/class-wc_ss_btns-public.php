<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://defthemes.com
 * @since      1.0.0
 *
 * @package    Wc_ss_btns
 * @subpackage Wc_ss_btns/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wc_ss_btns
 * @subpackage Wc_ss_btns/public
 * @author     DefThemes <defthemes@gmail.com>
 */
class Wc_ss_btns_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;


	private $options;

	private $product_title;
	private $product_url;
	private $product_img;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name 	= $plugin_name;
		$this->version 		= $version;
		$this->options 		= json_decode( get_option( 'wc_ss_btns_options' ), true);
		$this->showHider 	= false;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wc_ss_btns_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wc_ss_btns_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */


		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wc_ss_btns-public.css', array(), $this->version, 'all' );

		// Modern Theme
		wp_enqueue_style( $this->plugin_name . '-si', plugin_dir_url( __FILE__ ) . 'css/icons/socicon.css', array(), $this->version, 'all' );

		wp_enqueue_style( $this->plugin_name . '-fa', plugin_dir_url( __FILE__ ) . 'css/fa/css/font-awesome.min.css', array(), $this->version, 'all' );
		
		if ( !empty( $this->options['display']['values']['theme'] ) && $this->options['display']['values']['theme'] != 'default-theme' )
			wp_enqueue_style( $this->plugin_name . '-' . $this->options['display']['values']['theme'], plugin_dir_url( __FILE__ ) . 'css/wc_ss_btns-' . $this->options['display']['values']['theme'] . '.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wc_ss_btns_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wc_ss_btns_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wc_ss_btns-public.js', array( 'jquery' ), $this->version, false );

	}


	public function display_ss_btns()
	{
		$theme = ( $this->options['display']['values']['theme'] ) ? $this->options['display']['values']['theme'] : 'default-theme';

		$this->theme = $theme;

		$this->product_title 	= get_the_title();
		$this->product_url		= get_permalink();
		$this->product_img		= wp_get_attachment_url( get_post_thumbnail_id() );

		$current_action 		= current_filter();
		$class 					= $theme;

		$this->links = array();


		// Check if WC is activated
		$this->wc_active 		= false;

		if ( $this->check_wc() )
			$this->wc_active 	= true;

		// 1. Facebook
		if ( isset( $this->options['networks']['values']['facebook'] ) )
			$this->links[]['facebook']['url'] 	= 'https://www.facebook.com/sharer/sharer.php?u=' . rawurlencode($this->product_url);

		// 2. Twitter
		if ( isset( $this->options['networks']['values']['twitter'] ) )
			$this->links[]['twitter']['url']		= 'http://twitter.com/intent/tweet?status=' . rawurlencode( $this->product_title ) . '+' . $this->product_url;

		// 3. Google
		if ( isset( $this->options['networks']['values']['google'] ) )
			$this->links[]['google']['url']		= 'https://plus.google.com/share?url=' . $this->product_url;

		// 4. LinkedIn
		if ( isset( $this->options['networks']['values']['linkedin'] ) )
			$this->links[]['linkedin']['url']		= 'https://www.linkedin.com/shareArticle?mini=true&url=' . $this->product_url;

		// 5. Pinterest
		if ( isset( $this->options['networks']['values']['pinterest'] ) )
			$this->links[]['pinterest']['url']	= 'http://pinterest.com/pin/create/bookmarklet/?media=' . $this->product_img . '&url=' . $this->product_url . '&is_video=false&description=' . rawurlencode( $this->product_title );

		// 6. Email
		if ( isset( $this->options['networks']['values']['email'] ) )
			$this->links[]['email']['url']		= 'mailto:?subject=' . rawurlencode( $this->product_title ) . '&body=' . $this->product_url;

		// 7. Reddit
		if ( isset( $this->options['networks']['values']['reddit'] ) )
			$this->links[]['reddit']['url']		= 'http://www.reddit.com/submit?url=' . rawurlencode( $this->product_url ) . '&title=' . rawurlencode( $this->product_title );

		// 8. Delicious
		if ( isset( $this->options['networks']['values']['delicious'] ) )
			$this->links[]['delicious']['url']		= 'https://delicious.com/save?url=' . rawurlencode( $this->product_url ) . '&title=' . rawurlencode( $this->product_title );

		// 9. Buffer
		if ( isset( $this->options['networks']['values']['buffer'] ) )
			$this->links[]['buffer']['url']		= 'http://digg.com/submit?title=' . rawurlencode( $this->product_title ) . '&url=' . rawurlencode( $this->product_url );

		// 10. Digg
		if ( isset( $this->options['networks']['values']['digg'] ) )
			$this->links[]['digg']['url']		= 'https://buffer.com/add?text=' . rawurlencode( $this->product_title ) . '&url=' . rawurlencode( $this->product_url );

		// 11. Tumblr
		if ( isset( $this->options['networks']['values']['tumblr'] ) )
			$this->links[]['tumblr']['url']		= 'https://www.tumblr.com/widgets/share/tool?title=' . rawurlencode( $this->product_title ) . '&canonicalUrl=' . rawurlencode( $this->product_url );

		// 12. StumbleUpon
		if ( isset( $this->options['networks']['values']['stumbleupon'] ) )
			$this->links[]['stumbleupon']['url']		= 'http://www.stumbleupon.com/submit?title=' . rawurlencode( $this->product_title ) . '&url=' . rawurlencode( $this->product_url );

		// 13. Blogger
		if ( isset( $this->options['networks']['values']['blogger'] ) )
			$this->links[]['blogger']['url']		= 'https://www.blogger.com/blog-this.g?n=' . rawurlencode( $this->product_title ) . '&u=' . rawurlencode( $this->product_url );

		// 14. LiveJournal
		if ( isset( $this->options['networks']['values']['livejournal'] ) )
			$this->buffer_url		= 'http://www.livejournal.com/update.bml?subject=' . rawurlencode( $this->product_title ) . '&event=' . rawurlencode( $this->product_url );

		//15.  MySpace
		if ( isset( $this->options['networks']['values']['myspace'] ) )
			$this->buffer_url		= 'https://myspace.com/post?u=' . rawurlencode( $this->product_url ) . '&t=' . rawurlencode( $this->product_title );

		// 16. Yahoo
		if ( isset( $this->options['networks']['values']['yahoo'] ) )
			$this->links[]['yahoo']['url']		= 'http://compose.mail.yahoo.com/?body=' . rawurlencode( $this->product_url );

		// 17. FriendFeed
		if ( isset( $this->options['networks']['values']['friendfeed'] ) )
			$this->buffer_url		= 'http://friendfeed.com/?url=' . rawurlencode( $this->product_url );

		// 18. NewsVine
		if ( isset( $this->options['networks']['values']['newvine'] ) )
			$this->buffer_url		= 'http://www.newsvine.com/_tools/seed&save?u=' . rawurlencode( $this->product_url );

		// 19. EverNote
		if ( isset( $this->options['networks']['values']['evernote'] ) )
			$this->buffer_url		= 'http://www.evernote.com/clip.action?url=' . rawurlencode( $this->product_url );

		// 20. GetPocket
		if ( isset( $this->options['networks']['values']['getpocket'] ) )
			$this->buffer_url		= 'https://getpocket.com/save?url=' . rawurlencode( $this->product_url );

		// 21. FlipBoard
		if ( isset( $this->options['networks']['values']['flipboard'] ) )
			$this->buffer_url		= 'https://share.flipboard.com/bookmarklet/popout?v=2&title=' . rawurlencode( $this->product_title ) . '&url=' . rawurlencode( $this->product_url );

		// 22. InstaPaper
		if ( isset( $this->options['networks']['values']['instapaper'] ) )
			$this->buffer_url		= 'http://www.instapaper.com/edit?url=' . rawurlencode( $this->product_url ) . '&title=' . rawurlencode( $this->product_title );

		// 23. Line.me
		if ( isset( $this->options['networks']['values']['lineme'] ) )
			$this->buffer_url		= 'https://lineit.line.me/share/ui?url=' . rawurlencode( $this->product_url );

		// 24. Skype
		if ( isset( $this->options['networks']['values']['skype'] ) )
			$this->links[]['skype']['url']		= 'https://web.skype.com/share?url=' . rawurlencode( $this->product_url );

		// 25. Viber
		if ( isset( $this->options['networks']['values']['viber'] ) )
			$this->links[]['viber']['url']		= 'viber://forward?text=' . rawurlencode( $this->product_url );

		// 26. WhatsApp
		if ( isset( $this->options['networks']['values']['whatsapp'] ) )
			$this->links[]['whatsapp']['url']		= 'https://api.whatsapp.com/send?text=' . rawurlencode( $this->product_url );


		// 27. VK
		if ( isset( $this->options['networks']['values']['vk'] ) )
			$this->buffer_url		= 'http://vk.com/share.php?url=' . rawurlencode( $this->product_url );

		// 28. OKru
		if ( isset( $this->options['networks']['values']['okru'] ) )
			$this->buffer_url		= 'https://connect.ok.ru/dk?st.cmd=WidgetSharePreview&st.shareUrl=' . rawurlencode( $this->product_url ) . '&title=' . rawurlencode( $this->product_title );

		// 29. Baidu
		if ( isset( $this->options['networks']['values']['baidu'] ) )
			$this->buffer_url		= 'http://cang.baidu.com/do/add?it=' . rawurlencode( $this->product_title ) . '&iu=' . rawurlencode( $this->product_url );

		// 30. Weibo
		if ( isset( $this->options['networks']['values']['weibo'] ) )
			$this->buffer_url		= 'https://buffer.com/add?text=' . rawurlencode( $this->product_title ) . '&url=' . rawurlencode( $this->product_url );

		// 31. Renren
		if ( isset( $this->options['networks']['values']['renren'] ) )
			$this->buffer_url		= 'http://widget.renren.com/dialog/share?title=' . rawurlencode( $this->product_title ) . '&resourceUrl=' . rawurlencode( $this->product_url ) . '&srcUrl=' . rawurlencode( $this->product_url );

		// 32. Xing
		if ( isset( $this->options['networks']['values']['xing'] ) )
			$this->buffer_url		= 'https://www.xing.com/app/user?op=share&url=' . rawurlencode( $this->product_url );

		// 33. QZone
		if ( isset( $this->options['networks']['values']['qzone'] ) )
			$this->buffer_url		= 'http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?url=' . rawurlencode( $this->product_url );

		// 34. Douban
		if ( isset( $this->options['networks']['values']['douban'] ) )
			$this->buffer_url		= 'http://www.douban.com/recommend/?title=' . rawurlencode( $this->product_title ) . '&url=' . rawurlencode( $this->product_url );

		// 35. Telegram.me
		if ( isset( $this->options['networks']['values']['telegramme'] ) )
			$this->buffer_url		= 'https://telegram.me/share/url?text=' . rawurlencode( $this->product_title ) . '&url=' . rawurlencode( $this->product_url );
		
		// Based on theme selected display the HTML
		if ( !is_front_page() || is_singular('post') || is_singular('page') || is_archive() )
		{
			if ( $current_action == 'wp_footer' && !is_singular('product') )
			{
				// Default hide icons
				$this->showHider 	= true;
				$this->hideIcon 	= 'left';
				$this->showIcon 	= 'right';
				
				$class .= ' wc_ss_btns_float';
				if ( $this->options['general_settings']['floating_mode']['positions']['enabled_positions'] == 'right' )
				{
					$this->hideIcon 	= 'right';
					$this->showIcon 	= 'left';
					$class .= ' wc_ss_btns_float_right';
				}
			}

			if ( is_singular('product') )
				remove_action( 'wp_footer', array( $this, 'display_ss_btns') );


			echo $this->ss_btns_display_btns($class);

			// if ( 'default-theme' == $theme )
			// 	echo $this->wc_ss_btn_default_theme($class);
			// elseif ( 'default-theme' != $theme )
		}
	}

	public function wc_ss_btn_default_theme($class)
	{
		?>
		<div class="wc_ss_btns <?php echo $class; ?>">
			<ul>

				<?php if ( isset( $this->options['networks']['values']['facebook'] ) ): ?>
				<li>
					<a class="facebook" target="_blank" href="<?php echo esc_url( $this->facebook_url ); ?>" title="<?php echo __('Share ' . $this->product_title . ' on Facebook') ?>">
						<i class="socicon-facebook"></i>
					</a>
				</li>
				<?php endif; ?>

				<?php if ( isset( $this->options['networks']['values']['twitter'] ) ): ?>
				<li>
					<a class="twitter" target="_blank" href="<?php echo esc_url( $this->twitter_url ); ?>" title="<?php echo __('Share ' . $this->product_title . ' on Twitter') ?>">
						<i class="socicon-twitter"></i>
					</a>
				</li>
				<?php endif; ?>

				<?php if ( isset( $this->options['networks']['values']['google'] ) ): ?>
				<li>
					<a class="google" target="_blank" href="<?php echo esc_url( $this->google_url ); ?>" title="<?php echo __('Share ' . $this->product_title . ' on Google+') ?>">
						<i class="socicon-google"></i>
					</a>
				</li>
				<?php endif; ?>

				<?php if ( isset( $this->options['networks']['values']['linkedin'] ) ): ?>
				<li>
					<a class="linkedin" target="_blank" href="<?php echo esc_url( $this->linkedin_url ); ?>" title="<?php echo __('Share ' . $this->product_title . ' on LinkedIn') ?>">
						<i class="socicon-linkedin"></i>
					</a>
				</li>
				<?php endif; ?>

				<?php if ( isset( $this->options['networks']['values']['pinterest'] ) ): ?>
				<li>
					<a class="pinterest" target="_blank" href="<?php echo esc_url( $this->pinterest_url ); ?>" title="<?php echo __('Pin ' . $this->product_title . ' on Pinterest') ?>">
						<i class="socicon-pinterest"></i>
					</a>
				</li>
				<?php endif; ?>

				<!-- Reddit -->
				<?php if ( isset( $this->options['networks']['values']['reddit'] ) ): ?>
				<li>
					<a class="reddit" target="_blank" href="<?php echo esc_url( $this->reddit_url ); ?>" title="<?php echo __('Pin ' . $this->product_title . ' on reddit') ?>">
						<i class="socicon-reddit"></i>
					</a>
				</li>
				<?php endif; ?>

				<?php if ( isset( $this->options['networks']['values']['delicious'] ) ): ?>
				<li>
					<a class="delicious" target="_blank" href="<?php echo esc_url( $this->delicious_url ); ?>" title="<?php echo __('Reddit ' . $this->product_title . ' on Pinterest') ?>">
						<i class="fa fa-delicious"></i>
					</a>
				</li>
				<?php endif; ?>

				<?php if ( isset( $this->options['networks']['values']['email'] ) ): ?>
				<li>
					<a class="email" target="_blank" href="<?php echo esc_url( $this->email_url ); ?>" title="<?php echo __('Send ' . $this->product_title . ' via Email'); ?>">
						<i class="fa fa-envelope"></i>
					</a>
				</li>
				<?php endif; ?>
			</ul>

			<span class="wc_ss_btns_flex"></span>

			<?php if ( $this->options['display']['values']['display_share_message'] ): ?>
				<span><?php echo $this->options['display']['values']['share_message_text']; ?></span>
			<?php endif; ?>

		</div>
		<?php
	}

	public function ss_btns_display_btns($class)
	{

		$break = ( $this->theme == 'modern-theme' ) ? 3 : 5;
		if ( $this->showHider )
			$break 	= 5;
		
		$count = 0;

		?>
		<div class="wc_ss_btns <?php echo $class; ?>">
			<ul>
				<?php
				foreach ( $this->links as $network )
				{
					if ( isset( $this->options['networks']['values'][key($network)] ) ):
						$count++;
						?>
						<li class="<?php echo key($network); ?>">
							<a target="_blank" href="javascript:void(0);" data-href="<?php echo esc_url( $network[key($network)]['url'] ); ?>" title="<?php echo __('Share ' . $this->product_title . ' on ' . ucwords(key($network)) ) ?>">
								<?php do_action( 'ss_btns_before_' . key($network) . '_button' ); ?>
					
								<?php if ( key($network) != 'email' ): ?>
									<i class="socicon-<?php echo key($network); ?>"></i>
									<span>Share</span>
								<?php else: ?>
									<i class="fa fa-envelope"></i>
									<span>Mail</span>
								<?php endif; ?>
								


								<?php do_action( 'ss_btns_after_' . key($network) . '_button' ); ?>
							</a>
						</li>
						<?php
						if ( $count == $break ):
							?>
							<li class="more">
								<a href="javascript:void(0);" class="wc_ss_btns-open" title="<?php echo __( 'More...' ) ?>">
									<i class="fa fa-plus"></i>
								</a>
								<div class="wc_ss_btns_more_buttons">
									<div class="wc_ss_btns_more_buttons-heading">
										<?php echo apply_filters( 'ss_btns_heading', $this->options['display']['values']['wc_ss_btns_heading'] ); ?>
										<button class="wc_ss_btns-close">
											<i class="fa fa-close"></i>
										</button>
									</div>
									<div class="wc_ss_btns_more_buttons-content">
										<ul>
										<?php
										foreach ( $this->links as $network )
										{
											if ( isset( $this->options['networks']['values'][key($network)] ) ):
												?>
												<li class="<?php echo key($network); ?>">
													<a target="_blank" href="javascript:void(0);" data-href="<?php echo esc_url( $network[key($network)]['url'] ); ?>" title="<?php echo __('Share ' . $this->product_title . ' on ' . ucwords(key($network)) ) ?>">
														<?php do_action( 'ss_btns_before_' . key($network) . '_button' ); ?>

														<?php if ( key( $network ) != 'email' ): ?>
															<i class="socicon-<?php echo key($network); ?>"></i>
														<?php else: ?>
															<i class="fa fa-envelope"></i>
														<?php endif; ?>

														<?php do_action( 'ss_btns_after_' . key($network) . '_button' ); ?>
													</a>
												</li>
												<?php
											endif;
										}
										?>
										</ul>
									</div>
								</div>
							</li>
							<?php
							break;
						endif;
					endif;
				}
				?>
				<?php
				if ( $this->showHider ):
				?>
				<li class="wc_ss_btns_hide"><a href="javascript:void(0)" class="wc_ss_btns_float_hide"><i class="fa fa-angle-<?php echo $this->hideIcon; ?>"></i></a></li>
				<li class="wc_ss_btns_show"><a href="javascript:void(0)" class="wc_ss_btns_float_show"><i class="fa fa-angle-<?php echo $this->showIcon; ?>"></i></a></li>
				<?php endif; ?>
			</ul>
			
			<span class="wc_ss_btns_flex"></span>

			<?php if ( isset( $this->options['display']['values']['display_share_message'] ) ): ?>
				<span><?php echo apply_filters( 'ss_btns_message', $this->options['display']['values']['share_message_text'] ); ?></span>
			<?php endif; ?>

		</div>
		<?php
	}

	public function display_ss_btns_float()
	{
		$break = 4;
		$count = 0;
		$total = count($this->options['networks']['values']);
		?>
		<div class="wc_ss_btns <?php echo $this->options['display']['values']['theme']; ?> wc_ss_btns_float">
			<ul>
				<?php
				foreach ( $this->options['networks']['values'] as $network => $value ) 
				{
					?>
					<li class="<?php echo $network; ?>">
						<a target="_blank" href="<?php echo esc_url( $this->facebook_url ); ?>" title="<?php echo __('Share ' . $this->product_title . ' on ' . ucwords($network)) ?>">
							<i class="socicon-<?php echo $network; ?>"></i>
						</a>
					</li>
					<?php
					$count++;

					if ( $count == $break )
					{
						?>
						<li class="wc_ss_btns_more">
							<a target="_blank" href="<?php echo esc_url( $this->facebook_url ); ?>" title="<?php echo __('Share ' . $this->product_title . ' on ' . ucwords($network)) ?>">
								<i class="fa fa-plus"></i>
							</a>
						</li>
						<?php
						break;
					}
				}
				?>
				
			</ul>

		</div>
		<?php
	}

	private function check_wc()
	{
		if (
			in_array( 
				'woocommerce/woocommerce.php', 
				apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) 
			) 
		)
			return true;
		else
			return false;
	}

	private function debug( $what )
	{
		echo '<pre>';
		var_dump( $what );
		echo '</pre>';
	}
}
