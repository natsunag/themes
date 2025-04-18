<?php
/**
 * 遅延読み込みプラグイン
 */

add_filter(
	'st_lazy_load_lazysizes_settings',
	/** lazysizes の設定 */
	function ( array $settings ) {
		// $settings['expand'] = -32;    // 読み込み開始 (スクロール) 位置 (デフォルト: -32)

		$maintain_aspect_raito   = ( get_option( 'st-data402', 'yes' ) === 'yes' );

		if ( ! $maintain_aspect_raito && isset( $settings['plugins'] ) ) {
			unset( $settings['plugins']['aspectratio'] );
		}

		return $settings;
	}
);

add_filter(
	'st_lazy_load_image_replacer_settings',
	/** 画像の設定 */
	function ( array $settings ) {
		// $settings['classes'] = array_merge(
		// 	$settings['classes'],
		// 	array( 'foo' )    // img に追加するクラス名
		// );

		// 遅延読み込みから除外する width, height の組み合わせ
		// 例: 以下の場合は 1 x 1 **以下** の画像は除外される
		//
		// $settings['threshold']['width']  = 1;    // width (デフォルト: 1)
		// $settings['threshold']['height'] = 1;    // height (デフォルト: 1)

		$maintain_aspect_raito   = ( get_option( 'st-data402', 'yes' ) === 'yes' );
		$settings['aspectratio'] = $maintain_aspect_raito;

		return $settings;
	}
);

add_filter(
	'st_lazy_load_iframe_replacer_settings',
	/** iframe の設定 */
	function ( array $settings ) {
		// $settings['classes'] = array_merge(
		// 	$settings['classes'],
		// 	array( 'foo' )    // iframe に追加するクラス名
		// );

		// 遅延読み込みから除外する width, height の組み合わせ
		// 例: 以下の場合は 1 x 1 **以下** の iframe は除外される
		//
		// $settings['threshold']['width']  = 1;    // width (デフォルト: 1)
		// $settings['threshold']['height'] = 1;    // height (デフォルト: 1)

		return $settings;
	}
);

add_filter(
	'st_lazy_load_script_replacer_settings',
	/** script の設定 */
	function ( array $settings ) {
		// $settings['classes'] = array_merge(
		// 	$settings['classes'],
		// 	array( 'foo' )    // script に追加するクラス名
		// );

		$settings['exclude'] = array_merge(
			$settings['exclude'],
			// 遅延実行から除外するスクリプト (handle 名)
			[ 'jquery' ]
		);

		return $settings;
	}
);

add_filter(
	'st_lazy_load_enable_image_fade',
	/**
	 * 画像のフェードインの有効/無効化: (デフォルト: true)
	 *
	 * @deprecated Deprecated at ST_LAZY_LOAD_API_VERSION 1.1.0. Use `st_lazy_load_global_settings` instead.
	 *             互換性のためのコードのため非推奨。代わりに `st_lazy_load_global_settings` を使用する。
	 */
	function ( $is_enabled ) {
		$image_effect = get_option( 'st-data78', '' );

		return in_array( $image_effect, array( 'postopacity', 'allopacity' ), true );
	}
);

add_filter(
	'st_lazy_load_enable_iframe_fade',
	/**
	 * iframe のフェードインの有効/無効化: (デフォルト: true)
	 *
	 * @deprecated Deprecated at ST_LAZY_LOAD_API_VERSION 1.1.0. Use `st_lazy_load_global_settings` instead.
	 *             互換性のためのコードのため非推奨。代わりに `st_lazy_load_global_settings` を使用する。
	 */
	function ( $is_enabled ) {
		$image_effect = get_option( 'st-data78', '' );

		return in_array( $image_effect, array( 'postopacity', 'allopacity' ), true );
	}
);

add_filter(
	'st_lazy_load_handle_template',
	/**
	 * テンプレート処理の有効/無効化 (デフォルト: true)
	 *
	 * @deprecated Deprecated at ST_LAZY_LOAD_API_VERSION 1.1.0. Use `st_lazy_load_global_settings` instead.
	 *             互換性のためのコードのため非推奨。代わりに `st_lazy_load_global_settings` を使用する。
	 */
	function ( $is_enabled ) {
		if ( amp_is_amp() ) {
			return false;
		}

		$is_enabled = (bool) get_option( 'st-data326', '' );

		return $is_enabled;
	}
);

add_filter(
	'st_lazy_load_template_handlers',
	/**
	 * テンプレート処理のハンドラー
	 *
	 * @deprecated Deprecated at ST_LAZY_LOAD_API_VERSION 1.1.0. Use `st_lazy_load_global_settings` instead.
	 *             互換性のためのコードのため非推奨。代わりに `st_lazy_load_global_settings` を使用する。
	 */
	function ( $handlers ) {
		$type              = get_option( 'st-data327', 'all' );
		$enable_for_script = (bool) get_option( 'st-data330', '' );

		if ( $type !== 'all' && $type !== 'image' ) {
			unset( $handlers['image_replacer'] );
		}

		if ( $type !== 'all' && $type !== 'iframe' ) {
			unset( $handlers['iframe_replacer'] );
		}

		if ( ! $enable_for_script ) {
			unset( $handlers['script_replacer'] );
		}

		return $handlers;
	}
);

add_filter( 'st_lazy_load_add_settings_page', '__return_false' );

add_filter(
	'st_lazy_load_queried_post',
	function ( $post ) {
		$show_on_front                = get_option( 'show_on_front' );
		$page_id_on_front             = (int) get_option( 'page_on_front' );
		$page_id_for_posts            = (int) get_option( 'page_for_posts' );
		$show_page_on_front_for_posts = ( $show_on_front === 'page' && $page_id_on_front <= 0 && $page_id_for_posts > 0 );
		$show_posts_on_front          = ( $show_on_front === 'posts' || $show_page_on_front_for_posts );
		$st_page_id_for_posts         = (int) get_option( 'st-data9' );    // トップページにを挿入する固定ページ

		if ( $show_posts_on_front && $st_page_id_for_posts > 0 ) {
			$post = get_post( $st_page_id_for_posts );
		}

		return $post;
	}
);

add_filter(
	'st_lazy_load_global_settings',
	function ( $settings ) {
		// 全体設定
		if ( amp_is_amp() ) {
			$settings['enable'] = false;
		} else {
			$settings['enable'] = (bool) get_option( 'st-data326', '' );
		}

		// image, iframe, script 設定
		$type               = get_option( 'st-data327', 'all' );
		$enable_for_script  = (bool) get_option( 'st-data330', '' );
		$lazily_load_script = (bool) get_option( 'st-data656', 'yes' );

		if ( $type === 'image' ) {
			$settings['enable_for_image']  = true;
			$settings['enable_for_iframe'] = false;
		} elseif ( $type === 'iframe' ) {
			$settings['enable_for_image']  = false;
			$settings['enable_for_iframe'] = true;
		} else {
			$settings['enable_for_image']  = true;
			$settings['enable_for_iframe'] = true;
		}

		if ( $type !== 'all' && $type !== 'iframe' ) {
			$settings['enable_for_iframe'] = false;
		}

		$settings['enable_for_script'] = $enable_for_script;

		// `<script>` の遅延読込
		$settings['lazily_load_script'] = $lazily_load_script;

		// フェードイン
		$image_effect    = get_option( 'st-data78', '' );
		$is_fade_enabled = in_array( $image_effect, array( 'postopacity', 'allopacity' ), true );

		$settings['enable_image_fade']  = $is_fade_enabled;
		$settings['enable_iframe_fade'] = $is_fade_enabled;

		return $settings;
	}
);
