<?php

define("SLACK_ENDPOINT", "https://hooks.slack.com/services/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");
/**
 * Slackに投稿する
 *
 * @param string $content Slackに投稿する文字列
 * @param array $attachment 添付がある場合は、連想配列を渡す
 * @param string $channel 初期値は '#general'
 * @return bool
 */
function builds_slack($content, $attachment = [], $channel = '#2-1-jobshot事業部bot')
{
    // wp-config.phpとかに、上で取得したWebhook URLを定義しておく
    if (!defined('SLACK_ENDPOINT')) {
        return false;
    }
    $payload = [
        'channel' => $channel,
    ];
    if (WP_DEBUG) {
        // デバッグモードならテストをつける
        $content = "【テスト投稿】 {$content}";
    }
    $payload['text'] = $content;
    $payload['username'] = "JobShot巡回bot";
    $payload['icon_url'] = "https://jobshot.jp/wp-content/uploads/2019/07/IMG_5901.png";
    // attachmentsについては
    // @see https://api.slack.com/docs/attachments
    if ($attachment) {
        $payload['attachments'] = [$attachment];
    }
    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => SLACK_ENDPOINT,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => 'payload=' . json_encode($payload),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_TIMEOUT => 5,
    ]);
    $result = curl_exec($ch);
    curl_close($ch);
    return false !== $result;
}
/**
 * 投稿が公開されたときにSlack
 *
 * @param string $new_status
 * @param string $old_status
 * @param object $post
 */
// テスト
add_action('transition_post_status', function ($new_status, $old_status, $post) {
    if ('internship' === $post->post_type && 'publish' === $new_status) {
        $string = sprintf('インターンが公開されました: <%s|%s>', get_permalink($post), get_the_title($post));
        builds_slack($string, [], '#2-1-jobshot事業部bot');
    } elseif ('column' === $post->post_type && 'publish' === $new_status) {
        $string = sprintf('就活記事が公開されました: <%s|%s>', get_permalink($post), get_the_title($post));
        builds_slack($string, [], '#2-1-jobshot事業部bot');
    } elseif ('job' === $post->post_type && 'publish' === $new_status) {
        $string = sprintf('新卒情報が公開されました: <%s|%s>', get_permalink($post), get_the_title($post));
        builds_slack($string, [], '#2-1-jobshot事業部bot');
    } elseif ('event' === $post->post_type && 'publish' === $new_status) {
        $string = sprintf('イベントが公開されました: <%s|%s>', get_permalink($post), get_the_title($post));
        builds_slack($string, [], '#2-1-jobshot事業部bot');
    }
}, 10, 3);

/**
 * インターン応募があった時にSlack
 */
add_action('wpcf7_mail_sent', function ($contact_form) {
    $submission = WPCF7_Submission::get_instance();

    if ($submission) {
        $data = $submission->get_posted_data();
        $post_id = $data["job-id"];
        $post = get_post($post_id);
        $post_type = get_post_type($post_id);
        $user_name = $data["your-name"];
        if ('internship' === $post_type) {
            $string = sprintf($user_name.'さんよりインターンの応募がありました: <%s|%s>', get_permalink($post), get_the_title($post));
            builds_slack($string, [], '#2-1-jobshot事業部bot');
        }
    }
});
