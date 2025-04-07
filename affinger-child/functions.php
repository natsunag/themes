<?php
//目次機能実装（20240623）
function generate_toc_shortcode() {
    ob_start();
    global $post;
    $content = $post->post_content;

    // 既に目次が生成されているか確認
    if (strpos($content, 'id="toc_container_test"') !== false) {
        return '';
    }

    $pattern_h2 = '/<h2[^>]*>(.*?)<\/h2>/is';
    $pattern_h3 = '/<h3[^>]*>(.*?)<\/h3>/is';
    preg_match_all($pattern_h2, $content, $matches_h2, PREG_SET_ORDER);
    preg_match_all($pattern_h3, $content, $matches_h3, PREG_SET_ORDER);

    // マッチしたh2とh3を一つの配列に格納
    $matches = array();
    foreach ($matches_h2 as $match) {
        $matches[] = array('tag' => 'h2', 'match' => $match);
    }
    foreach ($matches_h3 as $match) {
        $matches[] = array('tag' => 'h3', 'match' => $match);
    }

    // 元の順番を保つために位置を比較してソート
    usort($matches, function($a, $b) use ($content) {
        return strpos($content, $a['match'][0]) - strpos($content, $b['match'][0]);
    });

    if ($matches) {
        $toc_output = '<div id="toc_container">
                        <div class="toc_title">目次</div>
                        <ul class="toc_list">';
        
        foreach ($matches as $item) {
            $title = strip_tags($item['match'][1]);
            $id = sanitize_title_with_dashes($title);
            $toc_output .= '<li class="toc_' . $item['tag'] . '"><a href="#' . $id . '"><span class="toc_marker">';
            if ($item['tag'] === 'h2') {
                $toc_output .= '✔';
            } elseif ($item['tag'] === 'h3') {
                $toc_output .= '・';
            }
            $toc_output .= '</span> ' . $title . '</a></li>';

            // 元のコンテンツ内の見出しにIDを追加
            $content = str_replace($item['match'][0], '<' . $item['tag'] . ' id="' . $id . '">' . $title . '</' . $item['tag'] . '>', $content);
        }

        $toc_output .= '</ul>
                    </div>';

        // 更新されたコンテンツで投稿を更新
        $update_result = wp_update_post(array('ID' => $post->ID, 'post_content' => $content));
        if (is_wp_error($update_result)) {
            // エラーハンドリング
            error_log('Failed to update post with TOC: ' . $update_result->get_error_message());
        }

        echo $toc_output;
    }

    return ob_get_clean();
}
add_shortcode('generate_toc', 'generate_toc_shortcode');
//目次実装機能終わり
?>