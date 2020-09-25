<?php

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
    if ($content) {
        $payload['text'] = $content;
    }
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
add_action('transition_post_status', function ($new_status, $old_status, $post) {
    if ('internship' === $post->post_type && 'publish' === $new_status) {
        $company = get_userdata($post->post_author);
        $company_name = $company->data->display_name;
        $string = sprintf($company_name . 'のインターンが公開されました: <%s|%s>', get_permalink($post), get_the_title($post));
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
        $interview_practice = $data["interview_practice"][0];
        if ('internship' === $post_type) {
            $string = sprintf($user_name . 'さんよりインターンの応募がありました: <%s|%s>', get_permalink($post), get_the_title($post));
            if(!empty($interview_practice)){
                $string .= "\n".$user_name."さんは面接対策を希望しています";
            }
            builds_slack($string, [], '#2-1-jobshot事業部bot');
        }
    }
});

/**
 * 毎日のレポートの報告
 */
add_action('jobshot_bot_daily_report_cron', function () {
    $yesterday = date('Y/m/d', strtotime('-1 day'));
    // 新規ユーザーの取得
    $args = [
        'role'         => 'student',
        'date_query' => [
            ['before' => date('Y/m/d', strtotime('today'))],
            ['after'  => date('Y/m/d', strtotime('yesterday')), 'inclusive' => true],
        ]
    ];
    $users = get_users($args);
    $new_user_num = count($users);
    // インターン応募数
    $formname = 'インターン応募';
    $month = date("m");
    $first_date = date("Y-m-01");
    $intern_apply_num = do_shortcode(' [cfdb-count form="/' . $formname . '.*/" filter="submit_time>' . $first_date . '"] ');
    $string = $yesterday . 'のレポートを報告します';
    $string .= "\n\n";
    $string .= sprintf(' 新規登録者数：%d人', $new_user_num);
    $string .= sprintf("\n " . $month . '月のインターン応募数：%d', $intern_apply_num);
    $attachment = array(
        "text"  =>  $string
    );
    builds_slack('', $attachment, '#2-1-jobshot事業部bot');
});

// cron登録処理
if (!wp_next_scheduled('jobshot_bot_daily_report_cron')) {  // 何度も同じcronが登録されないように
    date_default_timezone_set('Asia/Tokyo');  // タイムゾーンの設定
    wp_schedule_event(strtotime('2017-06-29 17:00:00'), 'daily', 'jobshot_bot_daily_report_cron');
}
