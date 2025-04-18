<?php if ( ( is_single() && ( trim( $GLOBALS['stdata12'] ) === '' ) ) || ( is_page() && ( trim( $GLOBALS['stdata69'] ) ) !== '' ) ) : ?>

	<?php $st_is_ex    = st_is_ver_ex();

	if( $st_is_ex ){ // EXの場合
		$post_id = get_queried_object_id();
		$post_twitter_tag = get_post_meta( $post_id, 'st_twitter_tag', true ); // 投稿ごとのTwitterハッシュタグ
	} else {
		$post_twitter_tag = '';
	} ?>

	<?php
	if ( trim( $GLOBALS['stdata25'] ) !== '' ) { //Twitterアカウント
		$twitter_name = esc_attr( $GLOBALS['stdata25'] );
	} else {
		$twitter_name = '';
	}

	if ( $post_twitter_tag ) { // 投稿ごとのTwitterハッシュタグ（EX）
		$twitter_tag = esc_attr( $post_twitter_tag );
	} elseif ( trim( $GLOBALS["stdata118"] ) !== '' ) { // Twitterハッシュタグ
		$twitter_tag = esc_attr( $GLOBALS['stdata118'] );
	}else{
		$twitter_tag = '';
	}

	$url_encode   = urlencode( get_permalink() );
	$title        = get_the_title();
	$title        = str_replace( '&', '&#038;', $title );                                   // 1. 文字参照の & をエンコードして保護する
	$title        = html_entity_decode( $title, ENT_QUOTES, get_bloginfo( 'charset' ) );    // 2. 文字参照をデコード
	$title        = preg_replace( '#</?[a-zA-Z][a-zA-Z0-9]*?>|<![^>]*>#', '', $title );     // 3. HTML タグを削除
	$title        = html_entity_decode( $title, ENT_QUOTES, get_bloginfo( 'charset' ) );    // 4. 文字参照を元に戻す
	$title_encode = urlencode( $title );
	$app_id       = esc_attr( $GLOBALS['stdata123'] );
	?>

	<div class="sns">
		<ul class="clearfix">
			<?php if ( trim( $GLOBALS['stdata410'] ) === '' ): ?>
				<!--ツイートボタン-->
				<li class="twitter">
					<amp-social-share type="twitter"
									  width="44"
									  height="44"
									  layout="fixed"
									  data-param-text="<?php the_title_attribute(); ?>"
									  data-param-url="<?php the_permalink(); ?>"
									  data-param-via="<?php echo $twitter_name ?>"
									  data-param-hashtags="<?php echo $twitter_tag ?>">
						<?php if ( false ) : // [未対応] デザイン ?>
							<?php if ( function_exists( 'scc_get_share_twitter' ) ) : ?>
								<?php echo ( scc_get_share_twitter() == 0 ) ? '<span class="snstext pcnone" >Twitter</span>' : '<span class="snscount">' . scc_get_share_twitter() . '</span>'; ?>
							<?php endif; ?>
						<?php endif; ?>
					</amp-social-share>
				</li>
			<?php endif; ?>
			<?php if ( trim( $GLOBALS['stdata411'] ) === '' ): ?>
				<!--シェアボタン-->
				<li class="facebook">
					<amp-social-share type="facebook"
									  width="44"
									  height="44"
									  layout="fixed"
									  data-param-text="<?php the_title_attribute(); ?>"
									  data-param-url="<?php the_permalink(); ?>"
									  data-param-app_id="<?php echo $app_id; ?>"></amp-social-share>
					<?php if ( false ) : // [未対応] デザイン ?>
						<?php if ( function_exists( 'scc_get_share_facebook' ) ) : ?>
							<?php echo ( scc_get_share_facebook() == 0 ) ? '<span class="snstext pcnone" >シェア</span>' : '<span class="snscount">' . scc_get_share_facebook() . '</span>'; ?>
						<?php endif; ?>
					<?php endif; ?>
				</li>
			<?php endif; ?>
			<?php if ( trim( $GLOBALS['stdata412'] ) === '' ): ?>
				<!--ポケットボタン-->
				<li class="pocket">
					<amp-social-share type="pocket"
									  width="44"
									  height="44"
									  layout="fixed"
									  data-share-endpoint="https://getpocket.com/edit"
									  data-param-url="<?php the_permalink(); ?>"
									  data-param-title="<?php the_title_attribute(); ?>">
						<i class="st-fa st-svg-get-pocket" aria-hidden="true"></i>
						<?php if ( false ) : // [未対応] デザイン ?>
							<?php if ( function_exists( 'scc_get_share_pocket' ) ): ?>
								<?php echo ( scc_get_share_pocket() == 0 ) ? '<span class="snstext pcnone" >Pocket</span>' : '<span class="snscount">' . scc_get_share_pocket() . '</span>'; ?>
							<?php endif; ?>
						<?php endif; ?>
					</amp-social-share>
				</li>
			<?php endif; ?>
			<?php if ( trim( $GLOBALS['stdata413'] ) === '' ): ?>
				<!--はてブボタン-->
				<li class="hatebu">
					<amp-social-share type="hatena"
									  width="44"
									  height="44"
									  layout="fixed"
									  data-share-endpoint="https://b.hatena.ne.jp/entry/<?php the_permalink(); ?>">B!
						<?php if ( false ) : // [未対応] デザイン ?>
							<?php if ( function_exists( 'scc_get_share_hatebu' ) ) : ?>
								<?php echo ( scc_get_share_hatebu() == 0 ) ? '<span class="snstext pcnone" >はてブ</span>' : '<span class="snscount"><span class="hatebno">' . scc_get_share_hatebu() . '</span></span>'; ?>
							<?php endif; ?>
						<?php endif; ?>
					</amp-social-share>
				</li>
			<?php endif; ?>
			<?php if ( trim( $GLOBALS['stdata414'] ) === '' ): ?>
				<!--LINEボタン-->
				<li class="line">
					<amp-social-share type="line"
									  width="44"
									  height="44"
									  layout="fixed"
									  data-share-endpoint="https://line.me/R/msg/text/?<?php echo $title_encode . '%0A' . $url_encode; ?>">
						<i class="st-fa st-svg-line" aria-hidden="true"></i></amp-social-share>
				</li>
			<?php endif; ?>
		</ul>
	</div>

<?php endif; ?>
