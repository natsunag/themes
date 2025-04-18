<?php
/*
Template Name:PAGE05-ログイン専用
*/
$st_is_ex    = st_is_ver_ex();
$st_is_ex_af = st_is_ver_ex_af();

$post_id            = get_queried_object_id();
$show_ikkatu_widget = false;
$show_post_info     = ( get_post_meta( $post_id, 'post_data_updatewidget_set', true ) === 'yes' );    // ヘッダーに記事データ挿入
if ( $st_is_ex ):
	$show_youtube_id    = get_post_meta( $post_id, 'st_youtube_eyecatch', true );                         // YouTubeサムネイルを使用（動画ID）
	$show_youtube_thum  = ( get_post_meta( $post_id, 'st_youtube_eyecatch', true ) === 'yes' );           // アイキャッチを動画に変更
	// YouTubeサムネイルを使用（動画ID）+ アイキャッチを動画に変更の場合はヘッダーに記事データ挿入時もサムネイル動画を表示
	if ( $show_youtube_id && $show_youtube_thum ):
		$show_youtube_display = 'yes';
	else:
		$show_youtube_display = '';
	endif;
else:
	$show_youtube_display = '';
endif;
?>
<?php get_header(); ?>

<div id="content" class="clearfix">
	<div id="contentInner">
		<main>
			<article>

				<div id="st-page" <?php post_class( 'post' ); ?>>

					<?php if ( ! is_front_page() ): ?>

						<?php
						if ( is_single() || is_page() ) {
							$show_ikkatu_widget = ( get_post_meta( $post_id, 'ikkatuwidget_set', true ) !== 'yes' );    // 一括挿入ウィジェットの表示確認

							if ( trim( $GLOBALS['stdata423'] ) !== '' ) {    // 「記事ごとのヘッダーデザイン」一括設定が有効
								$show_post_info = true;
							}
						} elseif ( st_is_home_check() ) { // 投稿ページ（メインページ）
          						$post_id = get_option( 'page_for_posts' );
								$show_ikkatu_widget = ( get_post_meta( $post_id, 'ikkatuwidget_set', true ) !== 'yes' );    // 一括挿入ウィジェットの表示確認
						}
						?>

						<?php if ( ! $show_post_info && ( trim( $GLOBALS['stdata423'] ) === '' && trim( $GLOBALS['stdata217'] ) === '' ) ): ?>
							<?php get_template_part( 'st-eyecatch' );    // アイキャッチ画像を挿入 ?>
						<?php endif; ?>

						<?php if ( $show_ikkatu_widget && is_active_sidebar( 17 ) ): ?>
							<?php if ( function_exists( 'dynamic_sidebar' ) ): ?>
								<?php dynamic_sidebar( 17 );    // 固定ページ上一括ウィジェット ?>
							<?php endif; ?>
						<?php endif; ?>

						<!--ぱんくず -->
						<div id="breadcrumb"<?php if ( $show_post_info ): ?> class="st-post-data-breadcrumb"<?php endif; ?>>
							<ol itemscope itemtype="http://schema.org/BreadcrumbList">
								<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
									<a href="<?php echo esc_url( home_url() ); ?>" itemprop="item">
										<span itemprop="name"><?php echo esc_html( $GLOBALS['stdata141'] ); ?></span>
									</a>
									&gt;
									<meta itemprop="position" content="1"/>
								</li>
								<?php $i = 2; ?>
								<?php foreach ( array_reverse( get_post_ancestors( $post->ID ) ) as $parid ): ?>
									<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
										<a href="<?php echo get_page_link( $parid ); ?>"
										   title="<?php echo get_the_title(); ?>" itemprop="item">
											<span itemprop="name"><?php echo get_page( $parid )->post_title; ?></span>
										</a>
										&gt;
										<meta itemprop="position" content="<?php echo $i; ?>"/>
									</li>
									<?php $i ++; ?>
								<?php endforeach; ?>
							</ol>

							<?php if ( $show_post_info ):    // ヘッダーに記事データ挿入時はhetry用に出力 ?>
								<h1 class="entry-title st-css-no"><?php if ( $st_is_ex ): st_the_title(); else: the_title(); endif;    // タイトル ?></h1>
								<?php if( isset($GLOBALS['stdata646']) && $GLOBALS['stdata646'] === 'yes' ) : get_template_part( 'itiran-date-singular' ); endif; ?>
							<?php endif; ?>
						</div>
						<!--/ ぱんくず -->

					<?php else:    // フロントページの場合

					$show_post_info     = '';
					$show_ikkatu_widget = ''; ?>

						<?php if ( ( $show_youtube_display || ! $show_post_info ) && ( trim( $GLOBALS['stdata423'] ) === '' && trim( $GLOBALS['stdata217'] ) === '' ) ): ?>
							<?php get_template_part( 'st-eyecatch' );    // アイキャッチ画像を挿入 ?>
						<?php endif; ?>

						<div class="nowhits <?php st_noheader_class(); ?>">
							<?php get_template_part( 'popular-thumbnail' );    // 任意のエントリ ?>
						</div>

						<?php if ( is_active_sidebar( 12 ) ): ?>
							<?php if ( function_exists( 'dynamic_sidebar' ) ): ?>
								<?php dynamic_sidebar( 12 );    // トップ上部のウィジェット ?>
							<?php endif; ?>
						<?php endif; ?>

						<?php if ( is_front_page() ): get_template_part( 'news-st' ); endif; //お知らせ ?>
					<?php endif; ?>

					<!--ループ開始 -->
					<?php if ( have_posts() ): ?>
						<?php while ( have_posts() ): the_post(); ?>

							<?php if ( ! $show_post_info ):    // 記事情報を表示が無効 ?>
								<?php if ( ! is_front_page() && ( trim( $GLOBALS['stdata234'] ) === '' ) ): ?>
									<h1 class="entry-title"><?php if ( $st_is_ex ): st_the_title(); else: the_title(); endif; ?></h1>
									<?php if( isset($GLOBALS['stdata646']) && $GLOBALS['stdata646'] === 'yes' ) : get_template_part( 'itiran-date-singular' ); endif; // 投稿日 ?>
								<?php endif; ?>
							<?php endif; ?>

							<?php if ( isset( $GLOBALS['stdata231'] ) && $GLOBALS['stdata231'] === 'yes' ): ?>
								<div class="st-sns-top">		
									<?php if ( is_front_page() ): ?>				
										<?php get_template_part( 'sns-top' );    // ソーシャルボタン読み込み ?>
									<?php else: ?>						
										<?php get_template_part( 'sns' );    // ソーシャルボタン読み込み ?>
									<?php endif; ?>
								</div>
							<?php endif; ?>

							<?php if ( ! is_front_page() && $st_is_ex_af ): get_template_part( 'st-author-top' ); endif; // ライター情報を表示する ?>

							<div class="mainbox">
								<div id="nocopy" <?php st_text_copyck(); ?>><!-- コピー禁止エリアここから -->
									<?php if ( $show_youtube_display && trim( $GLOBALS['stdata217'] ) !== '' // YouTube動画アイキャッチ + アイキャッチ画像をタイトル下表示に変更する
										  || ( ! $show_post_info && ( trim( $GLOBALS['stdata423'] ) === '' && trim( $GLOBALS['stdata217'] ) !== '' ) ) ): ?>
										<?php get_template_part( 'st-eyecatch-under' ); ?>
									<?php endif;    // アイキャッチ画像を挿入 ?>

									<div class="entry-content">
										<?php if ( is_user_logged_in() ):    // ログインチェック ?>
											<?php st_the_content( array( 'page', 'main' ) );    // 本文 ?>
											<?php if ( is_front_page() ): get_template_part( 'st-tab-category' ); endif; // タブ記事一覧 ?>
										<?php else: ?>
											<p>ログイン専用ページです。ログインして下さい。</p>
										<?php endif; ?>
									</div>
								</div><!-- コピー禁止エリアここまで -->

								<?php get_template_part( 'st-kai-page' );    // 改ページ ?>
								<?php get_template_part( 'st-ad-on' );    // 広告 ?>

								<?php if ( $show_ikkatu_widget && is_active_sidebar( 6 ) ): ?>
									<?php if ( function_exists( 'dynamic_sidebar' ) ): ?>
										<?php dynamic_sidebar( 6 );    // 固定ページ一括ウィジェット ?>
									<?php endif; ?>
								<?php endif; ?>
							</div>

							<?php if ( isset( $GLOBALS['stplus'] ) && $GLOBALS['stplus'] === 'yes' ): ?>
								<?php get_template_part( 'st-rank' );    // ランキング ?>
							<?php endif; ?>

							<?php if ( $show_ikkatu_widget && st_is_st_reaction_buttons_enabled() ):    // 評価ボタンプラグイン ?>
								<?php echo do_shortcode( '[st-reaction-buttons]' ); ?>
							<?php endif; ?>

							<?php if ( is_front_page() ): ?>
								<?php get_template_part( 'sns-top' );    // トップ用ソーシャルボタン読み込み ?>
							<?php else: ?>
								<?php get_template_part( 'sns' );    // ページ用ソーシャルボタン読み込み ?>
							<?php endif; ?>

							<?php if ( $st_is_ex_af ): get_template_part( 'st-author' ); endif;    // 記事を書いた人 ?>

							<?php // 任意のエントリ ?>
							<?php if ( ( ! is_front_page() && is_page() ) && ( isset( $GLOBALS['stdata41'] ) && $GLOBALS['stdata41'] === 'yes' ) ):    // 固定記事の場合 ?>
								<?php if ( isset( $GLOBALS['stdata5'] ) && $GLOBALS['stdata5'] === 'yes' ): ?>
									<?php get_template_part( 'popular-thumbnail-off' ); ?>
								<?php else: ?>
									<?php get_template_part( 'popular-thumbnail-on' ); ?>
								<?php endif; ?>
							<?php elseif ( ( is_home() || is_front_page() ) && ( isset( $GLOBALS['stdata59'] ) && $GLOBALS['stdata59'] === 'yes' ) ):    // トップ記事の場合 ?>
								<?php if ( isset( $GLOBALS['stdata5'] ) && $GLOBALS['stdata5'] === 'yes' ): ?>
									<?php get_template_part( 'popular-thumbnail-off' ); ?>
								<?php else: ?>
									<?php get_template_part( 'popular-thumbnail-on' ); ?>
								<?php endif; ?>
							<?php endif; ?>

							<?php get_template_part( 'st-childlink' );    // 子ページへのリンク ?>

							<?php if( trim($GLOBALS['stdata646']) === '' ) : get_template_part( 'itiran-date-singular' ); endif; // 投稿日 ?>

							<?php st_author();    // 著者リンク ?>

						<?php endwhile; ?>
					<?php else: ?>
						<p>記事がありません</p>
					<?php endif; ?>
					<!--ループ終了 -->

					<?php if ( $GLOBALS['stdata6'] === '' ):    // コメント ?>
						<?php if ( comments_open() || get_comments_number() ): ?>
							<?php comments_template(); ?>
						<?php endif; ?>
					<?php endif; ?>

				</div>
				<!--/post-->

				<?php if ( is_front_page() && ! is_home() && ! is_paged() && $GLOBALS['stdata92'] !== '' ): ?>
					<aside>
						<?php get_template_part( 'newpost-page' );    // 最近のエントリ ?>
					</aside>
				<?php endif; ?>

				<?php if ( is_front_page() && is_active_sidebar( 13 ) ): ?>
					<?php if ( function_exists( 'dynamic_sidebar' ) ): ?>
						<?php dynamic_sidebar( 13 );    // トップ下部のウィジェット ?>
					<?php endif; ?>
				<?php endif; ?>

			</article>
		</main>
	</div>
	<!-- /#contentInner -->
	<?php get_sidebar(); ?>
</div>
<!--/#content -->
<?php get_footer(); ?>
